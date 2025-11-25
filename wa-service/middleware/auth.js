const logger = require('../logger');

function authenticateAPI(req, res, next) {
    const apiKey = req.headers['x-api-key'];
    
    console.log('Auth Debug:', {
        received: apiKey,
        expected: process.env.API_KEY,
        match: apiKey === process.env.API_KEY
    });
    
    if (!apiKey) {
        logger.warn('Missing API key in request');
        return res.status(401).json({ success: false, error: 'API key required' });
    }
    
    if (apiKey !== process.env.API_KEY) {
        logger.warn(`Invalid API key attempt. Received: ${apiKey}`);
        return res.status(403).json({ success: false, error: 'Invalid API key' });
    }
    
    next();
}

module.exports = { authenticateAPI };
