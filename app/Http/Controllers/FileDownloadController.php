<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Classes\Document;

class FileDownloadController extends Controller
{

    const CARD_DOWNLOAD_URL = [
        'okd' => 'https://dir.ukrintei.ua/view/okd/',
        'okd.file' => 'https://nrat.ukrintei.ua/uacademic/',
    ];


    public function downloadCard(Request $request){
        $document = new Document($request->registrationNumber);

        $url = self::CARD_DOWNLOAD_URL[ $document->documentType ?? '-' ] . ($document->documentVersionHash ?? '-');
        $pdf = Helpers::getFile($url);
        $fileName = ($document->registrationNumber ?? 'unknown') . '.pdf';
        if (!empty($pdf)){
            $headers = [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment',
            ];
            return response()->streamDownload(function() use ($pdf){
                echo $pdf;
            }, $fileName, $headers);
        }

        return back()->with('download_error', __('app.message_download_error'));
    }

    public function downloadFile(Request $request){
        $document = new Document($request->registrationNumber);
        $url = self::CARD_DOWNLOAD_URL[ ($document->documentType ?? '-') . '.file' ] . ($request->registrationNumber ?? '-') . '/?file=' . ($request->filename ?? '-');

        $url = Helpers::urlEncode($url);

        // dd($url);
        $headers = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment;filename="666.pdf"',
            // 'Content-Disposition' => 'attachment;filename="' . rawurlencode($request->filename ?? '-'). '"',
            'Expires'             => '0',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma'              => 'public',
        ];
        $chunksize = 20 * 1024;
        $handle = fopen($url, 'rb');
        $buffer = '';
        while (!feof($handle)){
            $buffer = fread($handle, $chunksize);
            echo $buffer;
            flush();
        }
        fclose($handle);


        return response()->stream(function () use ($handle)  {
            echo $handle;
        }, 200, $headers);

        /*
        return response()->streamDownload(function() use ($url) {
            $chunksize = 20 * 1024;
            $handle = fopen($url, 'rb');
            $buffer = '';
            while (!feof($handle)){
                $buffer = fread($handle, $chunksize);
                echo $buffer;
                flush();
            }
            fclose($handle);
        }, '666.pdf', $headers);
        */




        /*
        $url = Helpers::urlEncode($url);
        $headers = [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment;filename="' . rawurlencode($request->filename ?? '-'). '"',
            // 'Expires'             => '0',
            // 'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            // 'Pragma'              => 'public',
        ];

        $chunksize = 20 * 1024;
        */



        // return response()->stream(function () use ($pdf)  {
        //     echo $pdf;
        // }, 200, $headers);

        // $pdf = Helpers::getFile($url);
        // dd($pdf);
        // dd($url);
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
