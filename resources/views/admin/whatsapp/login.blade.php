@extends('layouts.admin.master')

@section('title', 'Login WhatsApp Session')

@section('css')
@endsection

@section('main_content')
    <x-breadcrumb>Whatsapp</x-breadcrumb>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Login WhatsApp Session : {{ $sessionId }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="card-title">
                            <div class="card-text">
                                <div class="alert alert-warning">
                                    <strong>Note:</strong> Ensure that your WhatsApp mobile app is connected to the internet for the session to work.
                                </div>
                                <div class="alert alert-info mb-3">
                                    <p>Scan QR code below with your WhatsApp mobile app to log in.</p>
                                    <p>If you have already scanned the QR code, please wait a moment for the connection to be established.</p>
                                    <p>If a pairing code is shown, you can enter it manually in WhatsApp (Menu > Linked Devices > Link a device > Enter code).</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button id="fetch-qr-btn" class="btn btn-primary" onclick="fetchQr()">Fetch QR/Pairing Code</button>
                        <a href="{{route('admin.whatsapp.index')}}" class="btn btn-danger">Batal</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>QR/Pairing Code</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <div id="qr-box" class="mb-3">
                                <p>Status: <span id="status-text">Loading...</span></p>
                                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6b/WhatsApp.svg/1200px-WhatsApp.svg.png" alt="" class="img-fluid" style="max-width: 150px;">
                            </div>
                           
                            <div id="pairing-box" class="mb-3"></div>
                            <div id="message"></div>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-danger" id="logout">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/qrious/dist/qrious.min.js"></script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script> --}}
    <script src="https://cdn.socket.io/4.6.0/socket.io.min.js"
    integrity="sha384-c79GN5VsunZvi+Q/WObgk2in0CbZsHnjEqvFxC5DxHn9lTfNce2WW6h2pH6u/kF+" crossorigin="anonymous"></script>
    <script>
    let sessionId = '{{ $sessionId }}';
    let socket;
    socket = io('http://localhost:3000', {
        transports: ['websocket', 'polling'],
        reconnection: true,
        reconnectionAttempts: Infinity,
        reconnectionDelay: 2000,
        reconnectionDelayMax: 5000,
        randomizationFactor: 0.5,
        autoConnect: true,
    });
    socket.on('connect', function() {
        console.log('Connected to server');
        document.getElementById('status-text').innerText = 'Connected to server. Waiting for QR code...';
    });
    socket.on('disconnect', function() {
        console.log('Disconnected from server');
        document.getElementById('status-text').innerText = 'Disconnected from server. Please refresh the page.';
    });
    socket.emit('StartConnection', sessionId)

    socket.on('message', function(data){
        console.log('Message received:', data);
        document.getElementById('message').innerText = data.message;
    })

    socket.on('open', function(data){
        console.log('Connection opened:', data);
        document.getElementById('status-text').innerText = 'WhatsApp session is active.';
        if (data.ppUrl) {
            console.log('Profile Picture URL:', data.ppUrl);
            // let pairingBox = document.getElementById('qr-box');
            // pairingBox.innerHTML = '';
            // let img = document.createElement('img');
            // img.src =  data.ppUrl.;
            // img.alt = 'Profile Picture';
            // img.classList.add('img-fluid', 'rounded-circle');
            // img.style.width = '100px';
            // pairingBox.appendChild(img);
            // let p = document.createElement('p');
            // p.innerText = 'Connected as: ' + data.device;
            // pairingBox.appendChild(p);
        }
    })
    
    // Listen for QR code events
    socket.on('qr', function(data){
        // console.log('QR Code received:', data);
        document.getElementById('message').innerText = 'QR Code received. Please scan it with your WhatsApp app.';

        // // Display QR code
        let qrBox = document.getElementById('qr-box');
        qrBox.innerHTML = '';
        let img = document.createElement('img');
        img.src =  data.qr;
        img.alt = 'QR Code';
        img.classList.add('img-fluid');
        qrBox.appendChild(img);
    })

    document.getElementById('logout').addEventListener('click', function() {
        if (confirm('Are you sure you want to logout?')) {
            socket.emit('LogoutDevice', sessionId);
            document.getElementById('status-text').innerText = 'Logged out. Please refresh the page to start a new session.';
            document.getElementById('qr-box').innerHTML = '';
            document.getElementById('pairing-box').innerHTML = '';
            document.getElementById('message').innerText = 'You have logged out.';
        }
    });
    
    </script>
@endsection