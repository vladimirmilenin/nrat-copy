<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;

class FileDownloadController extends Controller
{

    const CARD_DOWNLOAD_URL = [
        'okd' => 'https://dir.ukrintei.ua/view/okd/',
    ];


    public function downloadCard(Request $request){
        $pdf = Helpers::getFile( self::CARD_DOWNLOAD_URL[$request->dir_type] . $request->hash);
        if (!empty($pdf)){
            $headers = [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment',
            ];
            return response()->streamDownload(function() use ($pdf){
                echo $pdf;
            }, ($request->filename ?? 'unknown.pdf'), $headers);
        }
        return back()->with('download_error', __('app.message_download_error'));
    }


    public function __invoke(Request $request){
        // $source = self::CARD_OKD_URL . $request->filename;
/*
        $pdf = Helpers::getUrl( self::CARD_OKD_URL . $request->filename );
        $headers = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment;filename="666.pdf"',
        ];
        return response()->stream(function () use ($pdf)  {
            echo $pdf;
        }, 200, $headers);

        /*
        return response()->streamDownload(function() use ($pdf){
            echo $pdf;
        }, 'ololo.pdf', $headers);
        */
        /*
        $callback = function() use ($rows){
            $handle = fopen('php://output', 'w');
            fputcsv($handle, [
                'Name',
                'Address',
            ]);
            $faker = Faker\Factory::create();
            for ($i=0; $i < $rows ; $i++) {
                $row = [
                    $faker->name,
                    $faker->address,
                ];
                fputcsv($handle, $row);
            }
            fclose($handle);
            */

            // return response()->streamDownload($callback, 'download.csv', $headers);
        // }
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $source);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_SSLVERSION,3);
        // $data = curl_exec ($ch);
        // dd($data);
        // $error = curl_error($ch);
        // curl_close ($ch);

        // $destination = "D:/test.pdf";
        // $file = fopen($destination, "w+");
        // fputs($file, $data);
        // fclose($file);
        /*
        if ($request->filetype == 'card.okd'){
            $pdf = Helpers::getUrl( self::CARD_OKD_URL . $request->filename );
        }
        dd($request->filetype, $request->filename);
        */
    }

}
