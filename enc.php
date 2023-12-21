<?php
// function encryptID($id, $key) {
//     $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-256-CBC'));
//     $encrypted = openssl_encrypt($id, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
//     $encrypted = $iv . str_replace('+', 'A', $encrypted);
//     return base64_encode($encrypted);
// }

// function decryptID($encryptedID, $key) {
//     $encryptedID = base64_decode($encryptedID);
//     $iv = substr($encryptedID, 0, openssl_cipher_iv_length('AES-256-CBC'));
//     $encrypted = str_replace('A', '+', substr($encryptedID, openssl_cipher_iv_length('AES-256-CBC')));
//     $decrypted = openssl_decrypt($encrypted, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
//     return $decrypted;
// }

function encryptID($id, $key) {
    $encrypted = base64_encode($id);
    $encrypted = urlencode($encrypted);
    return $encrypted;
}

function decryptID($encryptedID, $key) {
    $encryptedID = urldecode($encryptedID);
    $decrypted = base64_decode($encryptedID);
    return $decrypted;
}

?>
