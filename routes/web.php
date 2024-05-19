<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

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

Route::get('pdf', function() {
    $defaultConfig = (new ConfigVariables())->getDefaults();
    $fontDirs = $defaultConfig['fontDir'];

    $defaultFontConfig = (new FontVariables())->getDefaults();
    $fontData = $defaultFontConfig['fontdata'];

    $path = public_path() . "/fonts";
    $mpdf = new Mpdf([
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

    $html = view('pdf')->render();
    $mpdf->WriteHTML($html);
    $mpdf->Output('test.pdf', 'I');
});


Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);