<?php

namespace App\Helpers;

class CryptoHelper
{
    public static function decrypt($encrypted)
    {
        $key = config('app.encrypt_key');
        $data = base64_decode($encrypted);

        $iv = substr($data, 0, 16);
        $cipherText = substr($data, 16);

        return openssl_decrypt(
            $cipherText,
            'AES-256-CBC',
            $key,
            OPENSSL_RAW_DATA,
            $iv
        );
    }
}
