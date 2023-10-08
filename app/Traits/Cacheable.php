<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait Cacheable {


    private function setToCache(string $src, string $data){
        Storage::put($src, $data);
    }

    private function getFromCache(string $src){
        return Storage::json($src);
    }


}
