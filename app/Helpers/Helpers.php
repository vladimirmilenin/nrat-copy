<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helpers{

    public static function descriptionsByTypes(array $descriptions){
        return array_column($descriptions, 'description', 'description_field');
    }
    public static function fullNameByLanguage(array $names){
        return array_column($names, 'full_name', 'language_code');
    }
    public static function shortNameByLanguage(array $names){
        $result = [];
        foreach ($names as $name){
            $arr = [
                $name['last_name']
            ];
            if (!empty($name['first_name'])){
                $arr[] = Str::upper(Str::substr($name['first_name'], 0, 1)) . '.';
            }
            if ($name['language_code'] == 'ua' && !empty($name['first_name'])){
                $arr[] = Str::upper(Str::substr($name['co_name'], 0, 1)) . '.';
            }
            $result[$name['language_code']] = implode(' ', $arr);
        }
        return $result;
    }


    public static function getRegistrationNumberType(string $registrationNumber){
        return Str::substr($registrationNumber, 0, 2);
    }
    public static function getRegistrationNumberYear(string $registrationNumber){
        return Str::substr($registrationNumber, 2, 2);
    }

    /**
     * Checking registration number for valid pattern
     *
     * @param string $registrationNumber
     * @return void
     */
    public static function checkRegistrationNumber(string $registrationNumber){
        $pattern = config('nrat.registration_number_pattern');
        return (bool)preg_match($pattern, $registrationNumber);
    }

    public static function getUrl(string $url){
        $url = trim(preg_replace_callback('/[^\x20-\x7f]/', function($match){
            return urlencode($match[0]);
        }, $url));
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
