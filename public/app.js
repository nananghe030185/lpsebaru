// WhatsApp Gateway Frontend Application
class WhatsAppGateway {
    constructor() {
        this.socket = io();
        this.currentSession = null;
        this.sessions = {};
        this.init();
    }

    init() {
        this.setupSocketListeners();
        this.loadSessions();
        this.setupEventListeners();
    }

    setupSocketListeners() {
        this.socket.on('connect', () => {
            console.log('Connected to server');
            this.showToast('Connected to server', 'success');
        });

        this.socket.on('disconnect', () => {
            console.log('Disconnected from server');
            this.showToast('Disconnected from server', 'warning');
        });

        // Session-specific events
        this.socket.on('qr', (data) => {
            if (data.sessionId === this.currentSession) {
                this.displayQRCode(data.qr);
            }
        });

        this.socket.on('pairingCode', (data) => {
            if (data.sessionId === this.currentSession) {
                this.displayPairingCode(data.pairingCode);
            }
        });

        this.socket.on('connected', (data) => {
            if (data.sessionId === this.currentSession) {
                this.onSessionConnected(data.info);
            }
        });

        this.socket.on('disconnected', (data) => {
            if (data.sessionId === this.currentSession) {
                this.onSessionDisconnected();
            }
        });

        this.socket.on('loggedOut', (data) => {
            if (data.sessionId === this.currentSession) {
                this.onSessionLoggedOut();
            }
        });

        this.socket.on('sessionStatus', (data) => {
            this.updateSessionStatus(data);
        });
    }

    setupEventListeners() {
        // Auto-refresh sessions every 10 seconds
        setInterval(() => {
            this.loadSessions();
        }, 10000);
    }

    async createSession() {
        const sessionId = document.getElementById('sessionId').value.trim();
        if (!sessionId) {
            this.showToast('Please enter a session ID', 'error');
            return;
        }

        try {
            const response = await fetch('/session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ sessionId }),
            });

            const data = await response.json();
            if (data.success) {
                this.showToast(`Session "${sessionId}" created successfully`, 'success');
                this.loadSessions();
                this.selectSession(sessionId);
                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('createSessionModal'));
                modal.hide();
                document.getElementById('sessionId').value = '';
            } else {
                this.showToast(data.error || 'Failed to create session', 'error');
            }
        } catch (error) {
            console.error('Error creating session:', error);
            this.showToast('Failed to create session', 'error');
        }
    }

    async loadSessions() {
        try {
            const response = await fetch('/sessions');
            const sessions = await response.json();
            this.sessions = sessions.reduce((acc, session) => {
                acc[session.sessionId] = session;
                return acc;
            }, {});
            this.renderSessionsList();
        } catch (error) {
            console.error('Error loading sessions:', error);
        }
    }

    renderSessionsList() {
        const container = document.getElementById('sessionsList');
        if (Object.keys(this.sessions).length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center text-muted py-4">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p>No sessions created yet. Create your first session to get started.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = Object.values(this.sessions).map(session => `
            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                <div class="card session-card h-100 ${this.currentSession === session.sessionId ? 'border-primary' : ''}" 
                     onclick="whatsappGateway.selectSession('${session.sessionId}')" style="cursor: pointer;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">${session.sessionId}</h6>
                            <span class="badge ${this.getStatusBadgeClass(session.status)} status-badge">
                                ${session.status}
                            </span>
                        </div>
                        <p class="card-text small text-muted">
                            Created: ${new Date(session.createdAt).toLocaleString()}
                        </p>
                        ${session.info ? `
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="fas fa-user me-1"></i>
                                    ${session.info.name || session.info.verifiedName || 'Unknown'}
                                </small>
                            </div>
                        ` : ''}
                    </div>
                    <div class="card-footer p-2">
                        <div class="btn-group btn-group-sm w-100">
                            <button class="btn btn-outline-primary btn-sm" 
                                    onclick="event.stopPropagation(); whatsappGateway.selectSession('${session.sessionId}')">
                                <i class="fas fa-eye me-1"></i>View
                            </button>
                            <button class="btn btn-outline-danger btn-sm" 
                                    onclick="event.stopPropagation(); whatsappGateway.deleteSession('${session.sessionId}')">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    getStatusBadgeClass(status) {
        switch (status) {
            case 'connected': return 'bg-success';
            case 'qr': return 'bg-warning';
            case 'pairing': return 'bg-info';
            case 'disconnected': return 'bg-secondary';
            default: return 'bg-secondary';
        }
    }

    async selectSession(sessionId) {
        this.currentSession = sessionId;
        this.socket.emit('join', sessionId);
        
        // Update UI
        document.getElementById('currentSessionId').textContent = sessionId;
        document.getElementById('sessionDetails').style.display = 'block';
        
        // Highlight selected session
        this.renderSessionsList();
        
        // Load session details
        await this.loadSessionDetails(sessionId);
    }

    async loadSessionDetails(sessionId) {
        try {
            const response = await fetch(`/session/${sessionId}`);
            const session = await response.json();
            this.updateSessionStatus(session);
        } catch (error) {
            console.error('Error loading session details:', error);
        }
    }

    updateSessionStatus(data) {
        const statusElement = document.getElementById('connectionStatus');
        const qrContainer = document.getElementById('qrCodeContainer');
        const pairingContainer = document.getElementById('pairingCodeContainer');
        const userInfoContainer = document.getElementById('userInfoContainer');
        const sendBtn = document.getElementById('sendBtn');

        // Update status badge
        statusElement.innerHTML = `<span class="badge ${this.getStatusBadgeClass(data.status)}">${data.status}</span>`;

        // Clear containers
        qrContainer.innerHTML = '';
        pairingContainer.innerHTML = '';
        userInfoContainer.innerHTML = '';

        // Handle different statuses
        switch (data.status) {
            case 'qr':
                if (data.qrDataUrl) {
                    this.displayQRCode(data.qr, data.qrDataUrl);
                }
                break;
            case 'pairing':
                if (data.pairingCode) {
                    this.displayPairingCode(data.pairingCode);
                }
                break;
            case 'connected':
                this.onSessionConnected(data.info);
                break;
            case 'disconnected':
                this.onSessionDisconnected();
                break;
        }
    }

    displayQRCode(qr, qrDataUrl = null) {
        const qrContainer = document.getElementById('qrCodeContainer');
        if (qrDataUrl) {
            qrContainer.innerHTML = `
                <img src="${qrDataUrl}" alt="QR Code" class="img-fluid" style="max-width: 250px;">
                <p class="mt-2 text-muted small">Scan this QR code with WhatsApp mobile app</p>
            `;
        } else {
            // Fallback: generate QR code using a library
            qrContainer.innerHTML = `
                <div id="qrcode"></div>
                <p class="mt-2 text-muted small">Scan this QR code with WhatsApp mobile app</p>
            `;
            // You can add a QR code library here if needed
        }
    }

    displayPairingCode(code) {
        const pairingContainer = document.getElementById('pairingCodeContainer');
        pairingContainer.innerHTML = `
            <div class="alert alert-info">
                <h6>Pairing Code</h6>
                <div class="display-4 text-center text-primary fw-bold" style="letter-spacing: 0.2em;">
                    ${code}
                </div>
                <p class="mb-0 small">
                    Enter this code in WhatsApp:<br>
                    Menu → Linked Devices → Link a device → Enter code
                </p>
            </div>
        `;
    }

    onSessionConnected(userInfo) {
        const userInfoContainer = document.getElementById('userInfoContainer');
        const sendBtn = document.getElementById('sendBtn');
        
        userInfoContainer.innerHTML = `
            <div class="alert alert-success">
                <h6><i class="fas fa-check-circle me-2"></i>Connected Successfully!</h6>
                ${userInfo ? `
                    <p class="mb-1"><strong>Name:</strong> ${userInfo.name || userInfo.verifiedName || 'Unknown'}</p>
                    <p class="mb-1"><strong>Phone:</strong> ${userInfo.id || 'Unknown'}</p>
                ` : '<p class="mb-0">WhatsApp session is now active</p>'}
            </div>
        `;
        
        sendBtn.disabled = false;
        this.showToast('WhatsApp session connected successfully!', 'success');
    }

    onSessionDisconnected() {
        const userInfoContainer = document.getElementById('userInfoContainer');
        const sendBtn = document.getElementById('sendBtn');
        
        userInfoContainer.innerHTML = `
            <div class="alert alert-warning">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Disconnected</h6>
                <p class="mb-0">WhatsApp session has been disconnected. Please refresh to try again.</p>
            </div>
        `;
        
        sendBtn.disabled = true;
        this.showToast('WhatsApp session disconnected', 'warning');
    }

    onSessionLoggedOut() {
        const userInfoContainer = document.getElementById('userInfoContainer');
        const sendBtn = document.getElementById('sendBtn');
        
        userInfoContainer.innerHTML = `
            <div class="alert alert-danger">
                <h6><i class="fas fa-sign-out-alt me-2"></i>Logged Out</h6>
                <p class="mb-0">WhatsApp session has been logged out.</p>
            </div>
        `;
        
        sendBtn.disabled = true;
        this.showToast('WhatsApp session logged out', 'info');
        
        // Remove from sessions list
        delete this.sessions[this.currentSession];
        this.renderSessionsList();
    }

    async sendMessage(event) {
        event.preventDefault();
        
        if (!this.currentSession) {
            this.showToast('No session selected', 'error');
            return;
        }

        const phone = document.getElementById('phoneNumber').value.trim();
        const message = document.getElementById('messageText').value.trim();

        if (!phone || !message) {
            this.showToast('Please fill in all fields', 'error');
            return;
        }

        try {
            const response = await fetch(`/session/${this.currentSession}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ phone, message }),
            });

            const data = await response.json();
            if (data.success) {
                this.showToast('Message sent successfully!', 'success');
                document.getElementById('messageText').value = '';
            } else {
                this.showToast(data.error || 'Failed to send message', 'error');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            this.showToast('Failed to send message', 'error');
        }
    }

    async logoutSession() {
        if (!this.currentSession) return;

        if (confirm('Are you sure you want to logout this session?')) {
            try {
                const response = await fetch(`/session/${this.currentSession}/logout`, {
                    method: 'DELETE',
                });

                const data = await response.json();
                if (data.success) {
                    this.showToast('Session logged out successfully', 'success');
                    this.currentSession = null;
                    document.getElementById('sessionDetails').style.display = 'none';
                    this.loadSessions();
                } else {
                    this.showToast(data.error || 'Failed to logout session', 'error');
                }
            } catch (error) {
                console.error('Error logging out session:', error);
                this.showToast('Failed to logout session', 'error');
            }
        }
    }

    async deleteSession(sessionId) {
        if (confirm(`Are you sure you want to delete session "${sessionId}"?`)) {
            try {
                const response = await fetch(`/session/${sessionId}`, {
                    method: 'DELETE',
                });

                const data = await response.json();
                if (data.success) {
                    this.showToast('Session deleted successfully', 'success');
                    if (this.currentSession === sessionId) {
                        this.currentSession = null;
                        document.getElementById('sessionDetails').style.display = 'none';
                    }
                    this.loadSessions();
                } else {
                    this.showToast(data.error || 'Failed to delete session', 'error');
                }
            } catch (error) {
                console.error('Error deleting session:', error);
                this.showToast('Failed to delete session', 'error');
            }
        }
    }

    showToast(message, type = 'info') {
        const toast = document.getElementById('toast');
        const toastTitle = document.getElementById('toastTitle');
        const toastBody = document.getElementById('toastBody');

        // Set toast content
        toastTitle.textContent = type.charAt(0).toUpperCase() + type.slice(1);
        toastBody.textContent = message;

        // Set toast classes based on type
        toast.className = `toast ${type === 'error' ? 'bg-danger text-white' : ''}`;

        // Show toast
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
    }
}

// Initialize the application when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.whatsappGateway = new WhatsAppGateway();
});

// Global functions for onclick handlers
function createSession() {
    window.whatsappGateway.createSession();
}

function logoutSession() {
    window.whatsappGateway.logoutSession();
}
