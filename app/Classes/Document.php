<?php
namespace App\Classes;

use App\Helpers\Helpers;
use Doctrine\Inflector\Rules\Pattern;
use Illuminate\Support\Str;

class Document {

    const DOC_TYPES = [
        4 => 'OKD',
        5 => 'OKD',
        8 => 'OKD',
    ];

    public $registrationNumber;
    public $documentType;
    public $attributes;

    private $documentUrl;

    public function __construct(string $registrationNumber){
        $this->registrationNumber = $registrationNumber;
        $this->documentUrl = Str::finish(config('nrat.documents_endpoint'), '/') . $this->registrationNumber;
        $this->getRemote();
        dd($this->documentUrl);
        dd($this->registrationNumber);
    }

    private function getRemote(){
        $doc = Helpers::getUrl($this->documentUrl);
        dd(json_decode($doc));

        // if (empty($doc = Helpers::getUrl($this->documentUrl))){
        //     abort(404);
        // }
        // dd($foo);
    }

}
