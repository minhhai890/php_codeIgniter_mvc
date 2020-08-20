<?php
namespace libs;
class Token
{
    public static function tokenRandom() {
        $token = '';
        $strlen = \random_int(3,5);
        for ($i = 0; $i < $strlen; $i++) {
            $strRandom = \random_bytes(20);
            $token .= \rtrim(strtr(base64_encode($strRandom), '+/', '-_'), '=');
        }
        return $token;
    }
}