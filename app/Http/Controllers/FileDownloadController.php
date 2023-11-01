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
        $filename = $request->filename ?? '-';
        $url = self::CARD_DOWNLOAD_URL[ ($document->documentType ?? '-') . '.file' ] . ($request->registrationNumber ?? '-') . '/?file=' . $filename;

        $url = Helpers::urlEncode($url);

        $headers = [
            'Content-Type'        => 'application/pdf',
            'Expires'             => '0',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Pragma'              => 'public',
        ];

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
        }, $filename . '.pdf', $headers);

    }



}
