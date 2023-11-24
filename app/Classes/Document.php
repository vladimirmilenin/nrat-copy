<?php
namespace App\Classes;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Document {

    const DOC_TYPES = [
        4 => 'okd',
        5 => 'okd',
        8 => 'okd',
    ];

    const CACHE_PATH = ['cache', 'documents'];

    public $registrationNumber;
    public $document;
    public $documentType;
    public $documentVersionHash;


    private $documentUrl;
    private $cacheDestination;
    private $lang;

    public function __construct(string $registrationNumber){
        $this->lang = app()->getLocale();
        $this->registrationNumber = $registrationNumber;

        $this->documentUrl = Str::finish( config('nrat.endpoints.documents') , '/') . $this->registrationNumber;
        $this->cacheDestination = $this->makeCacheDestination();
        $this->documentType = self::DOC_TYPES[ (int)Helpers::getRegistrationNumberType($this->registrationNumber) ] ?? 'undefined';

        $this->document = $this->getDocument();

        if (empty($this->document['version'])){
            abort(404);
        }

        $this->getNddkrData();
    }

    private function prepareOkdData(){
        $this->documentVersionHash = $this->document['version']['okd_hash'];

        $this->document['addons'] = [
            'descriptions' => Helpers::descriptionsByTypes($this->document['version']['descriptions'] ?? []),
            'documentYear' => $this->getRegistrationYear($this->document['version']['registration_date'] ?? 0),
            'author' => Helpers::preparePersonData($this->document['version']['author'] ?? []),
            'specialty' => Helpers::prepareSpecialtyData($this->document['version']['okd_specialty'] ?? []),
            'user_firm' => Helpers::prepareFirmName($this->document['version']['user']['firm'] ?? []),
            'heads' => Helpers::preparePersonData($this->document['version']['heads'] ?? []),
            'opponents' => Helpers::preparePersonData($this->document['version']['opponents'] ?? []),
            'reviewers' => Helpers::preparePersonData($this->document['version']['reviews'] ?? []),
            'advisors' => Helpers::preparePersonData($this->document['version']['advisors'] ?? []),
            'theme_relations' => Helpers::prepareThemeRelations($this->document['version']['total']['okdTotal']['theme_relations'] ?? ''),
        ];
        $this->document['addons']['title'] = Helpers::strClean(($this->document['addons']['author'][0]['short_name'][$this->lang] ?? '') . ' ' . $this->document['addons']['descriptions']['theme_' . $this->lang]);
    }

    private function getNddkrData(){
        $addonsMethod = 'prepare' . Str::ucfirst($this->documentType) . 'Data';
        if (method_exists($this, $addonsMethod)){
            return $this->$addonsMethod();
        }
    }

    private function makeCacheDestination(){
        return DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, self::CACHE_PATH)
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR,
                    [
                        Helpers::getRegistrationNumberType($this->registrationNumber),
                        Helpers::getRegistrationNumberYear($this->registrationNumber)
                    ]);
    }




    private function getDocument(){
        $document = Helpers::getFromCache($this->cacheDestination . DIRECTORY_SEPARATOR . $this->registrationNumber);
        if ($this->validationDocument($document)){
            return $document;
        } else {
            return $this->getRemote();
        }
    }

    private function getRemote(){
        $data = Helpers::getUrl($this->documentUrl);
        $document = json_decode($data, true);
        if ($this->validationDocument($document)){
            Helpers::setToCache($this->cacheDestination . DIRECTORY_SEPARATOR . $this->registrationNumber, $data);
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

    private function validationDocument(mixed $document){
        return !empty($document['version']['registration_number'] ?? null);
    }

}
