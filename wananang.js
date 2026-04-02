"use strict";

import express from "express";
import { createServer } from "http";
import { Server } from "socket.io";
import bodyParser from "body-parser";
import fs from "fs";
import dotenv from "dotenv";
dotenv.config();

import qrcode from "qrcode";
// import qrcodeterminal from "qrcode-terminal";

const app = express();
const server = createServer(app);
const io = new Server(server);
const port = process.env.PORT_NODE || 3000;

import routers from "./server/routers/index.js";
import wa from "./server/wa.js";

/**
 * EXPRESS FOR ROUTING
 */
app.use((req, res, next) => {
    res.set("Cache-Control", "no-store");
    req.io = io;
    next();
});
// parse application/x-www-form-urlencoded
app.use(
    bodyParser.urlencoded({
        extended: false,
        limit: "50mb",
        parameterLimit: 100000,
    })
);

// parse application/json
app.use(bodyParser.json());
app.use(express.static("src/public"));

// Routes
app.use("/wa", routers);

server.listen(port, () => {
    console.log(`Server running on port ${port}`);
});

io.on("connection", (socket) => {
    socket.on("StartConnection", (token) => {
        console.log("StartConnection ===========", token);
        wa.connectToWhatsApp(token, io);
    });
    socket.on("ConnectViaCode", (token) => {
        console.log("ConnectViaCode", token);
        wa.connectToWhatsApp(token, io, true);
    });
    socket.on("LogoutDevice", (device) => {
        console.log("LogoutDevice", device);
        wa.deleteCredentials(device, io);
    });
});
