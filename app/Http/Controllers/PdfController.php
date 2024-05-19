<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mpdf\Mpdf;

class PdfController extends Controller
{
    public function generatePdf()
    {
        // Define the font data
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
    
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
    
        // Initialize mPDF with additional font directories and font data
        $mpdf = new \Mpdf\Mpdf([
            'fontDir' => array_merge($fontDirs, [
                public_path('fonts'), // Ensure this path is correct
            ]),
            'fontdata' => $fontData + [
                'kalpurush' => [
                    'R' => 'SolaimanLipi_20-04-07.ttf', // Regular font file
                    'useOTL' => 0xFF,
                    // 'I' => 'NikoshItalic.ttf', // Uncomment if you have an italic version
                ],
            ],
            'default_font' => 'kalpurush' // Set the default font to 'nikosh'
        ]);
    
        // HTML content with inline CSS to specify font family
        // $html = '<h1 style="font-family: kalpurush;">বাংলা ভাষা - পাঠ্য</h1>';
        $html = '<h1 >বাংলা ভাষা - পাঠ্য</h1>';
        $html .= '<p style="font-family: kalpurush;">এটি একটি উদাহরণ পাঠ্য যা এমপিডিএফ লাইব্রেরি ব্যবহার করে তৈরি করা হয়েছে।</p>';
    
        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);
    
        // Output the PDF to the browser
        $mpdf->Output();
    
        // If you want to download the PDF file, use the following line instead:
        // $mpdf->Output('filename.pdf', 'D');
    }
}
