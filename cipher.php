<?php
header('Content-Type: text/plain; charset=UTF-8');

$secret_key = 'secretangou';
$iv = '1234567890123456'; // 16 bytes IV for AES-256-CBC

function encrypt($text, $secret_key, $iv) {
    return openssl_encrypt($text, 'AES-256-CBC', $secret_key, 0, $iv);
}

function decrypt($text, $secret_key, $iv) {
    return openssl_decrypt($text, 'AES-256-CBC', $secret_key, 0, $iv);
}

$text = $_POST['text'];
$operation = $_POST['operation'];

if ($operation === 'encrypt') {
    echo encrypt($text, $secret_key, $iv);
} else if ($operation === 'decrypt') {
    echo decrypt($text, $secret_key, $iv);
} else {
    echo 'Invalid operation';
}
?>