#!/bin/bash

echo "[+] Starting PHP server on 127.0.0.1:3333"
php -S 127.0.0.1:3333 > /dev/null 2>&1 &
sleep 2

echo "[+] developed by koleul..."
ngrok http 3333
