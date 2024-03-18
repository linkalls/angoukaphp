<?php
header('Content-Type: text/plain; charset=UTF-8');

$secret_key = 'secretphpscriptqaqaqsaaaaaaaaa'; // 32 bytes key for AES-256-CBC
$iv = '1234567890123456'; // 16 bytes IV for AES-256-CBC

function encrypt($text, $secret_key, $iv) {
    $encrypted = openssl_encrypt($text, 'AES-256-CBC', $secret_key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encrypted);
}

function decrypt($text, $secret_key, $iv) {
    $decrypted = openssl_decrypt(base64_decode($text), 'AES-256-CBC', $secret_key, OPENSSL_RAW_DATA, $iv);
    return $decrypted;
}

// @index.phpからのリクエストを受け取る
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