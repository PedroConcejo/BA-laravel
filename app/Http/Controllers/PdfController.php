<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use PhpParser\Node\Expr\FuncCall;

class PdfController extends Controller
{
    static public function generatePDF($data){
        $dompdf = new DOMPDF();
        $dompdf->getPaperSize("A4", "portrait");
        $dompdf->loadHTML(utf8_decode(
            '<html>
            <head>
            <title>This is your ID license</title>
            </head>
            <body>
                <h1>This is your ID license</h1>
                <table>
                    <tr>
                        <td>
                            <p class="izq">
                            Email
                            </p>
                        </td>
                        <td>
                        <p class="page">
                            License
                        </p>
                        </td>
                    </tr>
                    <tr>
                    <td>
                        <p class="izq">
                        '.$data['email'].'
                        </p>
                    </td>
                    <td>
                    <p class="page">
                    '.$data['license'].'
                    </p>
                    </td>
                </tr>
                </table>
            </body>
            </html>'
        ));
        $dompdf->render();
        $output = $dompdf->output();
        $file = '../public/license'.$data['license'].'.pdf';
        file_put_contents($file, $output);
        return $file;
    }
}
