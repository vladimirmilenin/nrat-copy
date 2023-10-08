<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileDownloadController extends Controller
{

    public function __invoke(Request $request){
        dd($request->filetype, $request->filename);
    }

}
