<?php

use Dompdf\Dompdf;

if (!function_exists('format_money')) {
    function pdf_create($html, $setPaper = "portrait", $filename = '', $stream = true)
    {
        //require_once (APPPATH . "/helpers/dompdf/dompdf_config.inc.php");
        $dompdf = new DOMPDF();
        $dompdf->set_option('defaultFont', 'helvetica');
        $dompdf->set_option('isPhpEnabled', 'true');
        $dompdf->set_option('isJavascriptEnabled', 'true');
        $dompdf->set_option('isRemoteEnabled', 'true');
        //var_dump($dompdf); exit;
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $dompdf->load_html($html);
        $dompdf->setPaper("A4", $setPaper);
        $dompdf->render();
        //echo $setPaper; exit;
        /*$canvas = $dompdf->get_canvas();*/
        //var_dump($dompdf); exit;

        /*$font = Font_Metrics::get_font("helvetica", "bold");*/
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
        } else {
            return $dompdf->output();
        }
    }
}


if (!function_exists('format_money')) {

    function format_money(float $amount, string $currency): string
    {

        if (empty($currency)) {
            return false;
        }

        switch (strtolower($currency)) {
            case 5:
                return "$" . number_format($amount, 2, ".", ",");
                break;
            case 3:
                return number_format($amount, 2, ",", " ") . " €";
                break;
            case 2:
                return number_format($amount, 2, ",", " ") . " €";
                break;
            default:
                return number_format($amount, 2, ",", " ") . " €";
        }
    }
}
