<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helpers {


    public static function prepareThemeRelations(string $relations){
        if (empty($relations)) return [];
        foreach ($connections = explode("\n", $relations) as $key => &$item){
            if (!empty($item = trim($item))){
                $item = substr($item, 0, 11);
            }
            $connections[$key] = $item;
        }
        return $connections;
    }

    public static function preparePersonData(array $persons){
        if (empty($persons)) return [];

        $result = [];
        if (!is_array($persons[array_key_first($persons)])){
            $persons = [$persons];
        }
        foreach ($persons as $person){
            $arr = [
                'person_id' => $person['person_id'],
                'full_name' => self::fullNameByLanguage($person['names'] ?? []),
                'short_name' => self::shortNameByLanguage($person['names'] ?? []),
            ];
            array_push($result, $arr);
        }
        return $result;
    }

    public static function prepareFirmName(array $firm){
        $edrpou = !empty($firm['edrpou']) ? $firm['edrpou'] . ' ' : '';
        $edrpou = '';
        return [
            'ua' => $edrpou . ($firm['firm_name'] ?? ''),
            'en' => $edrpou . ($firm['firm_name_en'] ?? '')
        ];
    }
    public static function prepareSpecialtyData(array $specialties){
        return array_column($specialties, 'specialty_name', 'specialty_code');
    }
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
        $url = self::urlEncode($url);

        $agent= 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, $agent);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING , "gzip");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');

        $content = curl_exec($ch);
        if (!curl_errno($ch)) {
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($http_code != 200){
                $content = null;
            }
        }

        curl_close($ch);
        return $content;
    }

    public static function getFile(string $url){
        return self::getUrl($url);
    }

    public static function urlEncode(string $url){
        return trim(preg_replace_callback('/[^\x21-\x7f]/', function($match){
            return urlencode($match[0]);
        }, $url));
    }

}
