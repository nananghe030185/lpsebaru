const { Boom } = require('@hapi/boom');
const { 
    default: makeWASocket, 
    Browsers, 
    fetchLatestBaileysVersion, 
    useMultiFileAuthState, 
    makeCacheableSignalKeyStore, 
    DisconnectReason 
} = require('@whiskeysockets/baileys');
const QRCode = require('qrcode');
const fs = require('fs');

// Global storage variables
let sock = [];
let qrcode = [];
let pairingCode = [];
let intervalStore = [];

// Import required modules
const { setStatus } = require('./database/index');
const { IncomingMessage } = require('./lib/pino');
const { formatReceipt, getSavedPhoneNumber, prepareMediaMessage } = require('./lib/pino');
const MAIN_LOGGER = require('./lib/pino');
const NodeCache = require('node-cache');

const logger = MAIN_LOGGER.child({});
const msgRetryCounterCache = new NodeCache();

/**
 * Connect to WhatsApp with the given token
 * @param {string} token - WhatsApp connection token
 * @param {object} io - Socket.io instance
 * @param {boolean} isPairing - Whether to use pairing mode
 * @returns {object} Connection status and socket
 */
async function connectToWhatsApp(token, io = null, isPairing = false) {
    // Check if QR code already exists
    if (typeof qrcode[token] !== 'undefined' && !isPairing) {
        if (io) {
            io.emit('qrcode', {
                'token': token,
                'data': qrcode[token],
                'message': 'please scan'
            });
        }
        return {
            'status': false,
            'sock': sock[token],
            'qrcode': qrcode[token],
            'message': 'please scan with your Whatsapp Accountt'
        };
    }

    // Check if pairing code exists
    if (typeof pairingCode[token] !== 'undefined' && isPairing) {
        if (io) {
            io.emit('pairing', {
                'token': token,
                'data': pairingCode[token],
                'message': 'Go to whatsapp -> link device -> link with phone number, and pairing with this code.'
            });
        }
        return {
            'status': false,
            'code': pairingCode[token],
            'message': 'pairing with that code'
        };
    }

    // Check if already connected
    try {
        let phoneNumber = sock[token].user.id.split(':');
        phoneNumber = phoneNumber[0] + '@s.whatsapp.net';
        const ppUrl = await getPpUrl(token, phoneNumber);
        
        if (io) {
            io.emit('connection-open', {
                'token': token,
                'user': sock[token].user,
                'ppUrl': ppUrl
            });
        }
        
        delete qrcode[token];
        delete pairingCode[token];
        
        return {
            'status': true,
            'message': 'Already connected'
        };
    } catch (error) {
        if (io) {
            io.emit('message', {
                'token': token,
                'message': 'Connecting.. (1)..'
            });
        }
    }

    // Fetch latest Baileys version
    const { version, isLatest } = await fetchLatestBaileysVersion();
    
    // console.log('You re using whatsapp gateway M Pedia v6.1.0 - Contact admin if any trouble : 6292298859671');
    // console.log('using WA v' + version.split('.')[0] + ', isLatest: ' + isLatest);

    // Create auth state
    const { state, saveCreds } = await useMultiFileAuthState('./credentials/' + token);

    // Create WhatsApp socket
    sock[token] = makeWASocket({
        'version': version,
        'browser': Browsers.macOS('Chrome', 'Mpedia'),
        'logger': logger,
        'printQRInTerminal': false,
        'auth': {
            'creds': state.creds,
            'keys': makeCacheableSignalKeyStore(state.keys, logger)
        },
        'msgRetryCounterCache': msgRetryCounterCache,
        'generateHighQualityLinkPreview': true
    });

    // Handle pairing mode
    if (isPairing && 'me' in state.creds === false) {
        const savedPhoneNumber = await getSavedPhoneNumber(token);
        
        try {
            const pairingCodeResult = await sock[token].requestPairingCode(savedPhoneNumber);
            pairingCode[token] = pairingCodeResult;
        } catch (error) {
            if (io) {
                io.emit('pairing', {
                    'token': token,
                    'message': 'Go to whatsapp -> link device -> link with phone number, and pairing with this code.'
                });
            }
        }
        
        if (io) {
            io.emit('pairing', {
                'token': token,
                'data': pairingCode[token],
                'message': 'Go to whatsapp -> link device -> link with phone number, and pairing with this code.'
            });
        }
    }

    let update = {};
    // Set up event listeners
    sock[token].ev.on('connection.update', async (update) => {
        const { connection, lastDisconnect, qr } = update;

        if (connection === 'close') {
            const statusCode = lastDisconnect?.error?.output?.payload?.statusCode;
            const errorMessage = lastDisconnect?.error?.output?.payload?.error;
            
            if ((lastDisconnect?.error instanceof Boom)?.output?.statusCode !== DisconnectReason.loggedOut) {
                delete qrcode[token];
                
                if (io) {
                    io.emit('message', {
                        'token': token,
                        'message': 'Connection was lost'
                    });
                }
                
                if (statusCode === 401) {
                    sock[token].ws.close();
                    delete qrcode[token];
                    delete pairingCode[token];
                    delete sock[token];
                    
                    if (io) {
                        io.emit('message', {
                            'token': token,
                            'message': 'Time out, please refresh page'
                        });
                    }
                    return;
                }
                
                if (errorMessage === 'Unauthorized' || errorMessage === 'Method Not Allowed') {
                    setStatus(token, 'Disconnect');
                    clearConnection(token);
                    connectToWhatsApp(token, io);
                }
                
                if (statusCode === 403) {
                    connectToWhatsApp(token, io);
                }
                
                if (statusCode === 404) {
                    delete sock[token];
                }
            } else {
                setStatus(token, 'Disconnect');
                console.log('Connection closed. You are logged out.');
                
                if (io) {
                    io.emit('message', {
                        'token': token,
                        'message': 'Connection closed. You are logged out.'
                    });
                }
                
                clearConnection(token);
                connectToWhatsApp(token, io);
            }
        }
        
        if (qr) {
            console.log('QR refs attempts ended', token);
            QRCode.toDataURL(qr, function (err, url) {
                if (err) console.log(err);
                qrcode[token] = url;
                connectToWhatsApp(token, io, isPairing);
            });
        }
        
        if (connection === 'open') {
            console.log('connection restored');
            setStatus(token, 'Connected');
            delete qrcode[token];
            delete pairingCode[token];
            
            let phoneNumber = sock[token].user.id.split(':');
            phoneNumber = phoneNumber[0] + '@s.whatsapp.net';
            const ppUrl = await getPpUrl(token, phoneNumber);
            
            if (io) {
                io.emit('connection-open', {
                    'token': token,
                    'user': sock[token].user,
                    'ppUrl': ppUrl
                });
            }
            
            delete qrcode[token];
            delete pairingCode[token];
        }
    });

    if (update['creds.update']) {
        const creds = update['creds.update'];
        saveCreds(creds);
    }

    if (update['messages.upsert']) {
        const messages = update['messages.upsert'];
        IncomingMessage(messages, sock[token]);
    }

    return {
        'sock': sock[token],
        'qrcode': qrcode[token]
    };
}

/**
 * Connect to WhatsApp before sending messages
 * @param {string} token - WhatsApp connection token
 * @returns {boolean} Connection status
 */
async function connectWaBeforeSend(token) {
    let isConnected = undefined;
    let result;
    
    result = await connectToWhatsApp(token);
    
    await result.sock.ev.on('connection.update', update => {
        const { connection, qr } = update;
        
        if (connection === 'open') {
            isConnected = true;
        }
        
        if (qr) {
            isConnected = false;
        }
    });
    
    let attempts = 0;
    while (typeof isConnected === 'undefined') {
        attempts++;
        if (attempts > 4) break;
        await new Promise(resolve => setTimeout(resolve, 1000));
    }
    
    return isConnected;
}

/**
 * Send text message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {string} text - Message text
 * @returns {object} Message result
 */
async function sendText(token, to, text) {
    try {
        const result = await sock[token].sendMessage(formatReceipt(to), { 'text': text });
        return result;
    } catch (error) {
        return false;
    }
}

/**
 * Send message with custom format
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {object} message - Message object
 * @returns {object} Message result
 */
async function sendMessage(token, to, message) {
    try {
        const result = await sock[token].sendMessage(formatReceipt(to), JSON.parse(message));
        return result;
    } catch (error) {
        return false;
    }
}

/**
 * Send media message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {string} type - Media type
 * @param {string} url - Media URL
 * @param {string} caption - Media caption
 * @param {string} fileName - File name
 * @param {string} mimetype - Media mimetype
 * @returns {object} Message result
 */
async function sendMedia(token, to, type, url, caption, fileName, mimetype) {
    const formattedReceipt = formatReceipt(to);
    let phoneNumber = sock[token].user.id.replace(/:\d+/, '');
    
    if (type == 'audio') {
        return await sock[token].sendMessage(formattedReceipt, {
            'audio': { 'url': url },
            'ptt': true,
            'mimetype': 'audio/ogg; codecs=opus'
        });
    }
    
    const mediaMessage = await prepareMediaMessage(sock[token], {
        'caption': caption ? caption : '',
        'fileName': fileName,
        'media': url,
        'mediatype': type !== 'video' && type !== 'image' ? 'document' : type
    });
    
    const messageData = { ...mediaMessage.message };
    
    return await sock[token].sendMessage(formattedReceipt, {
        'forward': {
            'key': {
                'remoteJid': phoneNumber,
                'fromMe': true
            },
            'message': messageData
        }
    });
}

/**
 * Send button message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {array} buttons - Button array
 * @param {string} body - Message body
 * @param {string} footer - Message footer
 * @param {string} imageUrl - Optional image URL
 * @returns {object} Message result
 */
async function sendButtonMessage(token, to, buttons, body, footer, imageUrl) {
    let imageType = 'url';
    
    try {
        const buttonArray = buttons.map((button, index) => {
            return {
                'buttonId': index,
                'buttonText': { 'displayText': button.displayText },
                'type': 1
            };
        });
        
        let messageData;
        if (imageUrl) {
            messageData = {
                'image': imageType == 'url' ? { 'url': imageUrl } : fs.readFileSync('./public/images/' + imageUrl),
                'caption': body,
                'footer': footer,
                'buttons': buttonArray,
                'headerType': 4,
                'viewOnce': true
            };
        } else {
            messageData = {
                'text': body,
                'footer': footer,
                'buttons': buttonArray,
                'headerType': 1,
                'viewOnce': true
            };
        }
        
        const result = await sock[token].sendMessage(formatReceipt(to), messageData);
        return result;
    } catch (error) {
        console.log(error);
        return false;
    }
}

/**
 * Send template message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {array} buttons - Template buttons
 * @param {string} body - Message body
 * @param {string} footer - Message footer
 * @param {string} imageUrl - Optional image URL
 * @returns {object} Message result
 */
async function sendTemplateMessage(token, to, buttons, body, footer, imageUrl) {
    try {
        let messageData;
        if (imageUrl) {
            messageData = {
                'caption': body,
                'footer': footer,
                'viewOnce': true,
                'templateButtons': buttons,
                'image': { 'url': imageUrl },
                'viewOnce': true
            };
        } else {
            messageData = {
                'text': body,
                'footer': footer,
                'viewOnce': true,
                'templateButtons': buttons
            };
        }
        
        const result = await sock[token].sendMessage(formatReceipt(to), messageData);
        return result;
    } catch (error) {
        console.log(error);
        return false;
    }
}

/**
 * Send list message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {array} sections - List sections
 * @param {string} body - Message body
 * @param {string} footer - Message footer
 * @param {string} title - List title
 * @param {string} buttonText - Button text
 * @returns {object} Message result
 */
async function sendListMessage(token, to, sections, body, footer, title, buttonText) {
    try {
        const listData = {
            'text': body,
            'footer': footer,
            'title': title,
            'buttonText': buttonText,
            'sections': [sections]
        };
        
        const result = await sock[token].sendMessage(formatReceipt(to), listData, { 'ephemeralExpiration': 604800 });
        return result;
    } catch (error) {
        console.log(error);
        return false;
    }
}

/**
 * Send poll message
 * @param {string} token - WhatsApp connection token
 * @param {string} to - Recipient number
 * @param {string} name - Poll name
 * @param {array} values - Poll options
 * @param {number} selectableCount - Number of selectable options
 * @returns {object} Message result
 */
async function sendPollMessage(token, to, name, values, selectableCount) {
    try {
        const result = await sock[token].sendMessage(formatReceipt(to), {
            'poll': {
                'name': name,
                'values': values,
                'selectableCount': selectableCount
            }
        });
        return result;
    } catch (error) {
        console.log(error);
        return false;
    }
}

/**
 * Fetch all groups
 * @param {string} token - WhatsApp connection token
 * @returns {array} Group list
 */
async function fetchGroups(token) {
    try {
        let groups = await sock[token].groupFetchAllParticipating();
        let groupList = Object.entries(groups).slice(0)[1].map(group => group[1]);
        return groupList;
    } catch (error) {
        return false;
    }
}

/**
 * Check if contact exists
 * @param {string} token - WhatsApp connection token
 * @param {string} number - Phone number
 * @returns {boolean} Contact existence
 */
async function isExist(token, number) {
    try {
        if (typeof sock[token] === 'undefined') {
            const connected = await connectWaBeforeSend(token);
            if (!connected) return false;
        }
        
        if (number.includes('@g.us')) return true;
        else {
            const [result] = await sock[token].onWhatsApp('+' + number);
            return number.length > 11 ? result : true;
        }
    } catch (error) {
        return false;
    }
}

/**
 * Get profile picture URL
 * @param {string} token - WhatsApp connection token
 * @param {string} number - Phone number
 * @param {string} defaultUrl - Default image URL
 * @returns {string} Profile picture URL
 */
async function getPpUrl(token, number, defaultUrl) {
    let ppUrl;
    try {
        ppUrl = await sock[token].profilePictureUrl(number);
        return ppUrl;
    } catch (error) {
        return 'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png';
    }
}

/**
 * Delete credentials and clear connection
 * @param {string} token - WhatsApp connection token
 * @param {object} io - Socket.io instance
 * @returns {object} Deletion status
 */
async function deleteCredentials(token, io = null) {
    if (io !== null) {
        io.emit('logout', { 'token': token, 'message': 'logout' });
    }
    
    try {
        if (typeof sock[token] === 'undefined') {
            const connected = await connectWaBeforeSend(token);
            if (connected) {
                sock[token].ws.close();
                delete sock[token];
            }
        } else {
            sock[token].ws.close();
            delete sock[token];
        }
        
        delete qrcode[token];
        clearInterval(intervalStore[token]);
        setStatus(token, 'Disconnect');
        
        if (io != null) {
            io.emit('Unauthorized', token);
            io.emit('message', { 'token': token, 'message': 'Connection closed. You are logged out.' });
        }
        
        if (fs.existsSync('./credentials/' + token)) {
            fs.rmdir('./credentials/' + token, { 'recursive': true, 'force': true }, (error) => {
                if (error) console.log(error);
            });
        }
        
        return { 'status': true, 'message': 'Deleting session and credential' };
    } catch (error) {
        console.log(error);
        return { 'status': true, 'message': 'Nothing deleted' };
    }
}

/**
 * Clear connection data
 * @param {string} token - WhatsApp connection token
 */
function clearConnection(token) {
    clearInterval(intervalStore[token]);
    delete sock[token];
    delete qrcode[token];
    setStatus(token, 'Disconnect');
    
    if (fs.existsSync('./credentials/' + token)) {
        fs.rmdir('./credentials/' + token, { 'recursive': true, 'force': true }, (error) => {
            if (error) console.log(error);
        });
        console.log('./credentials/' + token + ' is deleted');
    }
}

/**
 * Initialize WhatsApp connection
 * @param {object} req - Request object
 * @param {object} res - Response object
 * @returns {object} Initialization result
 */
async function initialize(req, res) {
    const { token } = req.body;
    
    if (token) {
        const fs = require('fs');
        const credentialPath = './credentials/' + token;
        
        if (fs.existsSync(credentialPath)) {
            sock[token] = undefined;
            const connected = await connectWaBeforeSend(token);
            
            if (connected) {
                return res.status(200).json({ 'status': true, 'message': token + ' connected' });
            } else {
                return res.status(200).json({ 'status': false, 'message': token + ' not connected' });
            }
        }
        
        return res.send({ 'status': false, 'message': token + ' not found' });
    }
    
    return res.send({ 'status': false, 'message': 'Wrong Parameterss' });
}

// Export all functions
module.exports = {
    'connectToWhatsApp': connectToWhatsApp,
    'sendText': sendText,
    'sendMedia': sendMedia,
    'sendButtonMessage': sendButtonMessage,
    'sendTemplateMessage': sendTemplateMessage,
    'sendListMessage': sendListMessage,
    'sendPollMessage': sendPollMessage,
    'isExist': isExist,
    'getPpUrl': getPpUrl,
    'fetchGroups': fetchGroups,
    'deleteCredentials': deleteCredentials,
    'sendMessage': sendMessage,
    'initialize': initialize,
    'connectWaBeforeSend': connectWaBeforeSend,
    'sock': sock
};
