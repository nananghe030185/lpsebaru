// import { wa } from "./server/whatsapp.js";

// import fs from "fs";
const fs = require("fs");
// import dotenv from "dotenv";
const dotenv = require("dotenv");
const express = require("express");

// import express from "express";
// import { createServer } from "http";
const { createServer } = require("http");
// import { Server } from "socket.io";
const { Server } = require("socket.io");
// import bodyParser from "body-parser";
const bodyParser = require("body-parser");

dotenv.config();

/**
 * EXPRESS FOR ROUTING
 */
const wa = require("./server/whatsapp.js");
const app = express();
const server = createServer(app);
const io = new Server(server);
const port = process.env.PORT_NODE;

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

io.on("connection", (socket) => {
    socket.on("StartConnection", (data) => {
        console.log("StartConnection ===========", data);
        wa.connectToWhatsApp(data, io);
    });
    socket.on("ConnectViaCode", (data) => {
        console.log("ConnectViaCode", data);
        wa.connectToWhatsApp(data, io, true);
    });
    socket.on("LogoutDevice", (device) => {
        console.log("LogoutDevice", data);
        wa.deleteCredentials(device, io);
    });
});

server.listen(port, console.log(`Server run and listening port: ${port}`));
