<?php
namespace utils;

class Utils
{
    public static function base_path($path)
    {
        return $_SERVER['DOCUMENT_ROOT'] . "/" .$path;
    }

    public static function abort($code = 404)
    {
        http_response_code($code);
        echo "Status Code: {$code}";
    }

    public static function generateUUID()
    {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $uuid = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));

        return $uuid;
    }

}
