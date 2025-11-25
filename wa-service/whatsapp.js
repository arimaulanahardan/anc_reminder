const { makeWASocket, useMultiFileAuthState, DisconnectReason } = require('@whiskeysockets/baileys');
const qrcode = require('qrcode');
const logger = require('./logger');
const fs = require('fs');
const path = require('path');

let sock;
let qrCodeData = null;
let connectionStatus = 'disconnected'; // disconnected, connecting, connected

async function initializeWhatsApp() {
    // Prevent multiple connection attempts
    if (connectionStatus === 'connecting' && !sock) {
        logger.warn('Already connecting, ignoring new request');
        return; 
    }

    // If socket exists, ensure it's closed before creating a new one
    if (sock) {
        logger.info('Closing existing socket before re-initializing');
        try {
            sock.end(undefined);
            sock = null;
        } catch (error) {
            logger.error('Error closing existing socket:', error);
        }
    }

    connectionStatus = 'connecting';
    
    const { state, saveCreds } = await useMultiFileAuthState('sessions');

    sock = makeWASocket({
        printQRInTerminal: true,
        auth: state,
        logger: logger.child({ module: 'baileys' }),
        browser: ['ANC Reminder', 'Chrome', '1.0.0'],
        connectTimeoutMs: 60000, // Increase timeout
        defaultQueryTimeoutMs: 60000,
        keepAliveIntervalMs: 10000,
        emitOwnEvents: true,
        retryRequestDelayMs: 5000
    });

    return new Promise((resolve, reject) => {
        sock.ev.on('connection.update', async (update) => {
            const { connection, lastDisconnect, qr } = update;

            if (qr) {
                qrCodeData = await qrcode.toDataURL(qr);
                logger.info('QR Code generated');
                resolve(qrCodeData);
            }

            if (connection === 'close') {
                const statusCode = (lastDisconnect.error)?.output?.statusCode;
                const shouldReconnect = statusCode !== DisconnectReason.loggedOut && statusCode !== 401;
                
                logger.warn('Connection closed due to ', lastDisconnect.error, ', reconnecting ', shouldReconnect);
                
                if (statusCode === DisconnectReason.loggedOut || statusCode === 401) {
                    logger.info('Session invalid or logged out. Clearing session...');
                    try {
                        fs.rmSync('sessions', { recursive: true, force: true });
                        logger.info('Session cleared.');
                    } catch (err) {
                        logger.error('Failed to clear session:', err);
                    }
                    
                    // Reject the promise so the API doesn't hang
                    reject(new Error('Connection failed: Unauthorized or Logged Out'));
                    return;
                }

                connectionStatus = 'disconnected';
                qrCodeData = null;

                if (shouldReconnect) {
                    // We can't recursively call initializeWhatsApp here and expect the original promise to resolve
                    // unless we handle it carefully. But for now, let's just let the reconnection logic happen.
                    // Ideally, we should probably not resolve/reject here if it's reconnecting, 
                    // but if it's the *initial* connection attempt that fails and retries, we might want to wait.
                    // However, Baileys handles reconnection internally usually, but here we are manually calling it.
                    
                    // If we are in the middle of "connecting", we might want to keep waiting.
                    initializeWhatsApp().then(resolve).catch(reject);
                }
            } else if (connection === 'open') {
                logger.info('Opened connection');
                connectionStatus = 'connected';
                qrCodeData = null;
                resolve(null);
            }
        });

        sock.ev.on('creds.update', saveCreds);
    });
}

function getConnectionStatus() {
    return {
        status: connectionStatus,
        qr_code: connectionStatus === 'connected' ? null : qrCodeData,
        timestamp: new Date().toISOString()
    };
}

async function sendMessage(phone, text, reminderId) {
    if (connectionStatus !== 'connected' || !sock) {
        return { success: false, error: 'WhatsApp not connected' };
    }

    try {
        // Format phone number: remove leading 0 or +, ensure 62 prefix
        let formattedPhone = phone.replace(/\D/g, '');
        if (formattedPhone.startsWith('0')) {
            formattedPhone = '62' + formattedPhone.slice(1);
        }
        if (!formattedPhone.endsWith('@s.whatsapp.net')) {
            formattedPhone += '@s.whatsapp.net';
        }

        const sentMsg = await sock.sendMessage(formattedPhone, { text: text });
        logger.info(`Message sent to ${formattedPhone} (Reminder ID: ${reminderId})`);
        
        return { success: true, messageId: sentMsg.key.id };
    } catch (error) {
        logger.error('Error sending message:', error);
        return { success: false, error: error.message };
    }
}

async function disconnect() {
    try {
        // Set status immediately to prevent reconnection logic in event listeners
        connectionStatus = 'disconnected';
        qrCodeData = null;

        if (sock) {
            try {
                // Remove listeners to prevent events from firing during shutdown
                sock.ev.removeAllListeners('connection.update');
                sock.ev.removeAllListeners('creds.update');
            } catch (err) {
                logger.warn('Error removing listeners:', err.message);
            }

            try {
                await sock.logout();
            } catch (err) {
                logger.warn('Logout failed (might be already logged out):', err.message);
            }
            
            try {
                sock.end(undefined);
            } catch (err) {
                logger.warn('Socket end failed:', err.message);
            }
            
            sock = null;
        }
        
        // Give a small delay for file handles to be released
        await new Promise(resolve => setTimeout(resolve, 1000));

        // Clear session files to ensure fresh login next time
        try {
            if (fs.existsSync('sessions')) {
                fs.rmSync('sessions', { recursive: true, force: true });
                logger.info('Session files cleared');
            }
        } catch (err) {
            logger.error('Error clearing session files:', err);
        }
        
        logger.info('Disconnected from WhatsApp');
        return { success: true };
    } catch (error) {
        logger.error('Error in disconnect:', error);
        return { success: false, error: error.message };
    }
}

// Initialize on startup if session exists
// (async () => {
//     const sessionExists = fs.existsSync(path.join('sessions', 'creds.json'));
//     if (sessionExists) {
//         logger.info('Found existing session, attempting to connect...');
//         await initializeWhatsApp();
//     }
// })();

module.exports = {
    initializeWhatsApp,
    getConnectionStatus,
    sendMessage,
    disconnect
};
