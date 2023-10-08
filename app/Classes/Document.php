<?php
namespace App\Classes;

use App\Helpers\Helpers;
use App\Traits\Cacheable;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Document {

    use Cacheable;

    const DOC_TYPES = [
        4 => 'okd',
        5 => 'okd',
        8 => 'okd',
    ];

    const DOCUMENTS_CACHE_PATH = ['cache', 'documents'];

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

        $this->getNddkrData();
    }

    private function prepareOkdData(){
        $this->original['descriptions'] = Helpers::descriptionsByTypes($this->original['descriptions'] ?? []);
        $this->addons['documentYear'] = $this->getRegistrationYear( $this->original['registration_date'] ?? 0 );
        $this->addons = [
            'documentYear' => $this->getRegistrationYear( $this->original['registration_date'] ?? 0 ),
            'title' => ($addons['author']['short_name'][$this->lang] ?? '') . ' ' . $this->original['descriptions']['theme_' . $this->lang],
            'author' => Helpers::preparePersonData($this->original['author'] ?? []),
            'specialty' => Helpers::prepareSpecialtyData($this->original['okd_specialty'] ?? []),
            'user_firm' => Helpers::prepareFirmName($this->original['user']['firm'] ?? []),
            'heads' => Helpers::preparePersonData($this->original['heads'] ?? []),
            'opponents' => Helpers::preparePersonData($this->original['opponents'] ?? []),
            'reviewers' => Helpers::preparePersonData($this->original['reviews'] ?? []),
            'advisors' => Helpers::preparePersonData($this->original['advisors'] ?? []),
            // 'theme_relations' => Helpers::prepareThemeRelations($this->original['total']['okdTotal']['theme_relations'] ?? ''),
        ];

    }

    private function getNddkrData(){
        $addonsMethod = 'prepare' . Str::ucfirst($this->documentType) . 'Data';
        if (method_exists($this, $addonsMethod)){
            return $this->$addonsMethod();
        }
    }

    private function makeCacheDestination(){
        return DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, self::DOCUMENTS_CACHE_PATH)
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR,
                    [
                        Helpers::getRegistrationNumberType($this->registrationNumber),
                        Helpers::getRegistrationNumberYear($this->registrationNumber)
                    ]);
    }




    private function getDocument(){
        $document = $this->getFromCache($this->cacheDestination . DIRECTORY_SEPARATOR . $this->registrationNumber);
        if ($this->validationDoument($document)){
            return $document;
        } else {
            return $this->getRemote();
        }
    }

    private function getRemote(){
        $data = Helpers::getUrl($this->documentUrl);
        $document = json_decode($data, true);
        if ($this->validationDoument($document)){
            $this->setToCache($this->cacheDestination . DIRECTORY_SEPARATOR . $this->registrationNumber, $data);
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
