<?php

namespace App\Http\Controllers;

use App\Models\Direction;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DirectionController extends Controller
{

    private $lang;

    public function __construct(){
        $this->lang = app()->getLocale();
    }

    public function __invoke(Request $request){
        $lang = $this->lang;
        $code = $request->code ?? null;
        if (empty($code)){
            $directions = $this->getAllDirections();
            return view('pages.directions', compact('directions', 'lang'));
        } else {
            $direction = Direction::where('code', $request->code)->first();
            if (!empty($direction['id'])){
                $records = Record::where('direction_id', $direction['id'])->where('trash', 0)->orderBy('registration_number', 'desc')->paginate(100)->withPath('')->withQueryString();
                return view('pages.directions', compact('direction', 'records', 'lang'));
            }
        }

        return abort(404);

    }

    private function getAllDirections(){
        $all = Direction::where('nti', 0)->where('trash', 0)->orderBy('name_' . $this->lang)->get();
        $phD = $all->filter(function($val){
            if (Str::length($val['code']) == 3) return trim($val);
        });
        $vak = $all->filter(function($val){
            if (Str::length($val['code']) == 2) return trim($val);
        });
        return compact('phD', 'vak');
    }
}
