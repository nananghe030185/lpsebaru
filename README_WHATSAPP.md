# WhatsApp Multi-Session Gateway

A powerful multi-session WhatsApp gateway built with @whiskeysockets/baileys, Express.js, and Socket.IO that allows you to manage multiple WhatsApp sessions simultaneously.

## Features

- **Multi-Session Support**: Create and manage multiple WhatsApp sessions
- **QR Code Login**: Display QR codes for easy WhatsApp Web login
- **Pairing Code Support**: Fallback to pairing codes when QR codes aren't available
- **Real-time Updates**: Live status updates using Socket.IO
- **Message Sending**: Send text messages to any phone number
- **Session Management**: Create, view, logout, and delete sessions
- **Web Interface**: Beautiful, responsive web UI built with Bootstrap
- **Persistent Sessions**: Sessions are saved and restored on server restart

## Prerequisites

- Node.js 16+ 
- npm or yarn
- WhatsApp mobile app with internet connection

## Installation

1. **Install dependencies:**
   ```bash
   npm install
   ```

2. **Create environment file (optional):**
   ```bash
   cp .env.example .env
   ```
   
   Configure your environment variables:
   ```env
   PORT=3000
   ```

3. **Start the server:**
   ```bash
   node index.js
   ```

4. **Access the web interface:**
   Open your browser and go to `http://localhost:3000`

## Usage

### Creating a Session

1. Click "Create New Session" button
2. Enter a unique session ID (e.g., "my-session-1")
3. Click "Create Session"

### Connecting WhatsApp

1. **QR Code Method (Recommended):**
   - Scan the displayed QR code with your WhatsApp mobile app
   - Go to WhatsApp → Menu → Linked Devices → Link a device
   - Point your camera at the QR code

2. **Pairing Code Method:**
   - If QR code doesn't work, a pairing code will be displayed
   - Enter this code manually in WhatsApp mobile app
   - Go to WhatsApp → Menu → Linked Devices → Link a device → Enter code

### Sending Messages

1. Select a connected session
2. Enter the recipient's phone number (with country code, no + or spaces)
3. Type your message
4. Click "Send Message"

### Managing Sessions

- **View**: Click on any session card to view details
- **Logout**: Use the logout button to disconnect a session
- **Delete**: Remove sessions completely using the delete button
- **Status**: Monitor connection status in real-time

## API Endpoints

### Session Management

- `POST /session` - Create a new session
- `GET /sessions` - List all sessions
- `GET /session/:sessionId` - Get session details
- `DELETE /session/:sessionId/logout` - Logout session
- `DELETE /session/:sessionId` - Delete session

### Messaging

- `POST /session/:sessionId/send` - Send text message
- `POST /session/:sessionId/send-media` - Send media message

### QR Code

- `GET /session/:sessionId/qr` - Get QR code or pairing code

## Socket.IO Events

### Client to Server
- `join` - Join a session room for real-time updates

### Server to Client
- `qr` - QR code generated
- `pairingCode` - Pairing code available
- `connected` - Session connected successfully
- `disconnected` - Session disconnected
- `loggedOut` - Session logged out
- `sessionStatus` - Current session status

## File Structure

```
├── index.js              # Main server file
├── public/               # Web interface files
│   ├── index.html       # Main HTML page
│   └── app.js           # Frontend JavaScript
├── sessions/             # Session storage (auto-created)
└── package.json          # Dependencies
```

## Troubleshooting

### Common Issues

1. **QR Code Not Displaying:**
   - Ensure WhatsApp mobile app is connected to internet
   - Try refreshing the page
   - Check browser console for errors

2. **Session Not Connecting:**
   - Verify phone has stable internet connection
   - Try logging out and back in on mobile app
   - Check if session files exist in `sessions/` directory

3. **Message Not Sending:**
   - Ensure session is connected (green status)
   - Verify phone number format (country code + number)
   - Check if recipient number is valid

### Debug Mode

Enable debug logging by setting environment variable:
```bash
DEBUG=baileys* node index.js
```

## Security Considerations

- **Session Storage**: Sessions are stored locally in the `sessions/` directory
- **Network Access**: The web interface is accessible to anyone who can reach your server
- **Authentication**: Consider adding authentication for production use
- **HTTPS**: Use HTTPS in production for secure communication

## Production Deployment

1. **Environment Variables:**
   ```bash
   NODE_ENV=production
   PORT=3000
   ```

2. **Process Manager:**
   ```bash
   npm install -g pm2
   pm2 start index.js --name whatsapp-gateway
   ```

3. **Reverse Proxy:**
   Use Nginx or Apache as reverse proxy with SSL termination

4. **Firewall:**
   Restrict access to necessary ports only

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For issues and questions:
- Check the troubleshooting section
- Review the API documentation
- Open an issue on GitHub

## Changelog

### v1.0.0
- Initial release
- Multi-session support
- QR code and pairing code login
- Real-time updates with Socket.IO
- Web interface for session management
- Message sending functionality
