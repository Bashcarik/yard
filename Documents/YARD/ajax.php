<?php
// Токен телеграм бота
$tg_bot_token = "6035741677:AAFQ1kYQBdTZIziGLEDNpUYH3LzlT8UW3vQ";
// ID Чата
$chat_id = "988470525";

$text = '';

foreach ($_POST as $key => $val) {
    $text .= $key . ": " . $val . "\n";
}

$text .= "\n" . $_SERVER['REMOTE_ADDR'];
$text .= "\n" . date('d.m.y H:i:s');

$param = [
    "chat_id" => $chat_id,
    "text" => $text
];

$url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendMessage?" . http_build_query($param);

file_get_contents($url);

foreach ($_FILES as $file) {
    $url = "https://api.telegram.org/bot" . $tg_bot_token . "/sendDocument";

    $document = new CURLFile($file['tmp_name'], $file['type'], $file['name']);

    $post_fields = [
        "chat_id" => $chat_id,
        "document" => $document
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type:multipart/form-data"]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $out = curl_exec($ch);

    curl_close($ch);
}

die('1');
?>
