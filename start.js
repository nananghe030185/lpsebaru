#!/usr/bin/env node

/**
 * WhatsApp Gateway Startup Script
 * 
 * This script provides an easy way to start the WhatsApp gateway
 * with proper environment configuration.
 */

import { spawn } from 'child_process';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';

const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);

// Default configuration
const config = {
    port: process.env.PORT || 3000,
    env: process.env.NODE_ENV || 'development'
};

console.log('🚀 Starting WhatsApp Multi-Session Gateway...');
console.log(`📍 Port: ${config.port}`);
console.log(`🌍 Environment: ${config.env}`);
console.log('');

// Set environment variables
process.env.PORT = config.port;
process.env.NODE_ENV = config.env;

// Start the main application
const child = spawn('node', ['index.js'], {
    stdio: 'inherit',
    cwd: __dirname,
    env: process.env
});

child.on('error', (error) => {
    console.error('❌ Failed to start WhatsApp Gateway:', error.message);
    process.exit(1);
});

child.on('exit', (code) => {
    if (code !== 0) {
        console.error(`❌ WhatsApp Gateway exited with code ${code}`);
        process.exit(code);
    }
});

// Handle graceful shutdown
process.on('SIGINT', () => {
    console.log('\n🛑 Shutting down WhatsApp Gateway...');
    child.kill('SIGINT');
});

process.on('SIGTERM', () => {
    console.log('\n🛑 Shutting down WhatsApp Gateway...');
    child.kill('SIGTERM');
});
