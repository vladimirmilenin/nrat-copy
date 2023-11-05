<?php

namespace App\Classes;

use App\Helpers\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

final class Latest {

    const CACHE_PATH = ['cache', 'latest'];


    private $latest = null;
    private $count;
    private $cacheDestination;
    private $cacheFile;

    public function __construct(int $count = 10){
        $this->count = $count;
        $this->cacheDestination = $this->makeCacheDestination();
        $this->cacheFile = Carbon::today()->format('Y-m-d') . '.json';
        $this->latest = $this->getLatestDocuments();
    }

    public function getLatestOkd(){
        return $this->latest['Okd'] ?? null;
    }
    public function getLatestOk(){
        return $this->latest['Ok'] ?? null;
    }

    private function getLatestDocuments(){
        $latestUrl = Str::finish( config('nrat.endpoints.latests') , '/') . $this->count;
        $cacheSource = $this->cacheDestination . $this->cacheFile;
        if (!($data = Helpers::getFromCache($cacheSource)) || (empty($data['Okd']))){
            Storage::deleteDirectory($this->cacheDestination);
            if ($data = Helpers::getUrl($latestUrl)){
                Helpers::setToCache($cacheSource, $data);
            }
            $data = json_decode($data, true);
        }
        return $data;
    }

    private function makeCacheDestination(){
        return DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, self::CACHE_PATH)
            . DIRECTORY_SEPARATOR;
    }

}
