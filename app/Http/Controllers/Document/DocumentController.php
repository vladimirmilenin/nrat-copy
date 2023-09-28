<?php

namespace App\Http\Controllers\Document;

use App\Classes\Document;
use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __invoke(Request $request){
        $document = new Document($request->registrationNumber);
        // $content = Helpers::getUrl('https://nrat.ukrintei.ua/uacademic/0423U100155');
        // dd($content);
    }

}
