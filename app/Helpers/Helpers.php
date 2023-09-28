<?php

namespace App\Helpers;


class Helpers{

    public static function checkRegistrationNumber(string $registrationNumber){
        $pattern = '/0[458]\d{2}U\d{6}/';
        return (bool)preg_match($pattern, $registrationNumber);
    }

    public static function getUrl(string $url){
        $url = trim(preg_replace_callback('/[^\x20-\x7f]/', function($match) { return urlencode($match[0]);}, $url));
        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }

}
