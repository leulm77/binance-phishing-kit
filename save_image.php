<?php
if (!file_exists('logs')) mkdir('logs');
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['image'])) {
    $image = base64_decode(explode(',', $data['image'])[1]);
    $filename = 'logs/cam_' . time() . '.jpg';
    file_put_contents($filename, $image);
}
?>
