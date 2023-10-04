<?php

namespace App\Http\Controllers\Document;

use App\Classes\Document;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __invoke(Request $request){
        $lang = app()->getLocale();
        $document = new Document($request->registrationNumber);
        return view('pages.documents.' . $document->documentType, compact('document', 'lang'));
    }

}
