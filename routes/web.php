<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('pdf', function(){
    $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontData'];

    $path = public_path() . "/fonts";
    $mpdf = new \Mpdf\Mpdf([
        'format' => 'A4',
        'orientation' => 'P',
        'fontDir' => array_merge($fontDirs, [$path]),
        'fontData' => $fontData + [
            'solaimanlipi' => [
                'R' => 'SolaimanLipi_20-04-07.ttf',
                'useOTL' => 0xFF,
            ],
        ],
        'default_font' => 'solaimanlipi'
    ]);

    $mpdf->WriteHTML(view('pdf'));
    $mpdf->Output('BracApproveDocument.pdf', 'I');

});
