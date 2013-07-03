<?php

class URLEncrypter {

    public static function Encrypt($url) {
        $encrypted = self::mybase64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(GlobalVars::$SITEKEY), $url, MCRYPT_MODE_CBC, md5(md5(GlobalVars::$SITEKEY))));

        return $encrypted;
    }

    public static function Decrypt($url) {

        $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(GlobalVars::$SITEKEY), self::mybase64_decode($url), MCRYPT_MODE_CBC, md5(md5(GlobalVars::$SITEKEY))), "\0");
        return $decrypted;
    }

    private static function mybase64_encode($s) {
        return bin2hex($s);
    }

    private static function mybase64_decode($s) {
        return hex2bin($s);
    }

}

?>
