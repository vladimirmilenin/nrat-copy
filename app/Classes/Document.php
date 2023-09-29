<?php
namespace App\Classes;

use App\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Expr\Cast\Object_;

class Document {

    const DOC_TYPES = [
        4 => 'OKD',
        5 => 'OKD',
        8 => 'OKD',
    ];

    public $registrationNumber;
    public $documentType;
    public $document;

    private $documentUrl;
    private $yearFolder;

    public function __construct(string $registrationNumber){
        $this->registrationNumber = $registrationNumber;
        $this->documentUrl = Str::finish(config('nrat.documents_endpoint'), '/') . $this->registrationNumber;
        $this->yearFolder = $this->getYearFolder();

        $this->document = $this->getDocument();
        dd($this->document);
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
        Storage::put('/cache/documents/' . $this->yearFolder . '/' . $this->registrationNumber, $src);
    }

    private function getFromCache(){
        return Storage::json('/cache/documents/' . $this->yearFolder . '/' . $this->registrationNumber);
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

    private function validationDoument(mixed $document){
        return !empty($document['registration_number']);
    }

    private function getYearFolder(){
        return Str::substr($this->registrationNumber, 2, 2);
    }


}
