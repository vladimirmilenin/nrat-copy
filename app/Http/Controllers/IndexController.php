<?php

namespace App\Http\Controllers;

use App\Classes\Latest;
use Illuminate\Http\Request;

class IndexController extends Controller
{


    public function __invoke(Request $request){
        $lang = app()->getLocale();
        $latest = new Latest(10);
        $latestOkd = $latest->getLatestOkd();
        // dd($latestOkd);
        return view('index', compact('latestOkd', 'lang'));
    }


}
