<?php
namespace App\Classes;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Document {

    const DOC_TYPES = [
        4 => 'okd',
        5 => 'okd',
        8 => 'okd',
    ];

    public $registrationNumber;
    public $original;
    public $addons;
    public $documentType;


    private $documentUrl;
    private $cacheDestination;
    private $lang;

    public function __construct(string $registrationNumber){
        $this->lang = app()->getLocale();
        $this->registrationNumber = $registrationNumber;
        $this->documentUrl = Str::finish(config('nrat.documents_endpoint'), '/') . $this->registrationNumber;
        $this->cacheDestination = $this->makeCacheDestination();
        $this->documentType = self::DOC_TYPES[ (int)Helpers::getRegistrationNumberType($this->registrationNumber) ] ?? 'undefined';

        $this->original = $this->getDocument();

        if (empty($this->original)){
            abort(404);
        }

        $this->original['descriptions'] = Helpers::descriptionsByTypes($this->original['descriptions'] ?? []);



        $addons = [
            'documentYear' => $this->getRegistrationYear( $this->original['registration_date'] ?? '' ),
        ];
        $this->addons = array_merge($addons, $this->getAddons());
    }

    private function getAddonsOkd(){
        $addons = [
            'author' => [
                'full_name' => Helpers::fullNameByLanguage($this->original['author']['names'] ?? []),
                'short_name' => Helpers::shortNameByLanguage($this->original['author']['names'] ?? [])
            ]
        ];

        $addons['title'] = ($addons['author']['short_name'][$this->lang] ?? '') . ' ' . $this->original['descriptions']['theme_' . $this->lang];
        return $addons;
    }

    private function getAddons(){
        $addonsMethod = 'getAddons' . Str::ucfirst($this->documentType);
        if (method_exists($this, $addonsMethod)){
            return $this->$addonsMethod();
        }
    }

    private function makeCacheDestination(){
        return implode(DIRECTORY_SEPARATOR,
                    [
                        Helpers::getRegistrationNumberType($this->registrationNumber),
                        Helpers::getRegistrationNumberYear($this->registrationNumber)
                    ]);
    }




    private function getDocument(){
        $document = $this->getFromCache();
        if ($this->validationDoument($document)){
            return $document;
        } else {
            return $this->getRemote();
        }
    }

    private function setToCache(string $src){
        Storage::put('/cache/documents/' . $this->cacheDestination . '/' . $this->registrationNumber, $src);
    }

    private function getFromCache(){
        return Storage::json('/cache/documents/' . $this->cacheDestination . '/' . $this->registrationNumber);
    }

    private function getRemote(){
        $src = Helpers::getUrl($this->documentUrl);
        $document = json_decode($src, true);
        if ($this->validationDoument($document)){
            $this->setToCache($src);
            return $document;
        }
        return null;
    }

    private function getRegistrationYear(string $registrationDate){
        try {
            $year = Carbon::parse($registrationDate)->format('Y');
        } catch(\Exception) {
            $year = '20' . Helpers::getRegistrationNumberYear($this->registrationNumber);
        }
        return $year;
    }

    private function validationDoument(mixed $document){
        return !empty($document['registration_number']);
    }

}
