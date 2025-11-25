const express = require('express');
const cors = require('cors');
const dotenv = require('dotenv');
const { initializeWhatsApp, getConnectionStatus, sendMessage, disconnect } = require('./whatsapp');
const { authenticateAPI } = require('./middleware/auth');
const logger = require('./logger');

dotenv.config();

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(express.json());

// Routes
app.get('/api/health', (req, res) => {
    res.json({ status: 'OK', timestamp: new Date().toISOString() });
});

app.post('/api/connect', authenticateAPI, async (req, res) => {
    try {
        logger.info('Connection request received');
        const qrCode = await initializeWhatsApp();
        
        if (qrCode) {
            res.json({ 
                success: true, 
                qr_code: qrCode,
                message: 'Scan QR code dengan WhatsApp Anda' 
            });
        } else {
            res.json({ 
                success: true, 
                message: 'Already connected' 
            });
        }
    } catch (error) {
        logger.error('Connection error:', error);
        res.status(500).json({ success: false, error: error.message });
    }
});

app.get('/api/status', authenticateAPI, (req, res) => {
    const status = getConnectionStatus();
    res.json(status);
});

app.post('/api/send', authenticateAPI, async (req, res) => {
    try {
        const { phone, message, reminderId } = req.body;
        
        if (!phone || !message) {
            return res.status(400).json({ 
                success: false, 
                error: 'Phone and message are required' 
            });
        }

        logger.info(`Sending message to ${phone} for reminder ${reminderId}`);
        
        const result = await sendMessage(phone, message, reminderId);
        
        if (result.success) {
            res.json({ 
                success: true, 
                message: 'Message sent successfully',
                reminderId 
            });
        } else {
            res.status(500).json({ 
                success: false, 
                error: result.error 
            });
        }
    } catch (error) {
        logger.error('Send message error:', error);
        res.status(500).json({ success: false, error: error.message });
    }
});

app.post('/api/disconnect', authenticateAPI, async (req, res) => {
    try {
        await disconnect();
        res.json({ success: true, message: 'Disconnected successfully' });
    } catch (error) {
        logger.error('Disconnect error:', error);
        res.status(500).json({ success: false, error: error.message });
    }
});

// Start server
app.listen(PORT, () => {
    logger.info(`WhatsApp Service running on port ${PORT}`);
    console.log(`🚀 WhatsApp Service running on http://localhost:${PORT}`);
});

// Handle graceful shutdown
process.on('SIGINT', async () => {
    logger.info('Shutting down gracefully...');
    await disconnect();
    process.exit(0);
});
