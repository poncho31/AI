<?php

// TEST

exec("taskkill /f /im nginx.exe");
exec("taskkill /f /im ./packages/nginx/nginx1.25.3/nginx.exe");

error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: text/html; charset=UTF-8");
ob_start();

function sendResponseHeader($status = 200, $contentType = 'text/html') {
    header($_SERVER['SERVER_PROTOCOL'] . ' ' . $status);
    header("Content-Type: " . $contentType);
}

if (
    isset($_SERVER['REQUEST_URI'])
    && $_SERVER['REQUEST_METHOD'] === 'GET'
    && pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION) === 'php'
) {
    // Execute PHP file when requesting its URL
    include_once __DIR__ . '/' . $_SERVER['REQUEST_URI'];
    exit();
} else if (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
    // Serve static files
    if (file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI']) &&  $_SERVER['REQUEST_URI'] != '/') {
        sendResponseHeader(200, 'text/html');
        readfile(__DIR__ . '/' . $_SERVER['REQUEST_URI']);
        exit();
    }

    // Serve default index page if the requested file is not found
    sendResponseHeader(200, 'text/html');
    readfile(__DIR__ . '/index.php');
    exit();
} else {
    sendResponseHeader(405, 'text/plain');
    echo "Method Not Allowed";
}

ob_end_flush();
