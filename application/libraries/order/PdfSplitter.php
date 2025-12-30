<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/fpdf/fpdf.php';
require_once APPPATH . 'third_party/fpdi/src/autoload.php';

use setasign\Fpdi\Fpdi;

class PdfSplitter
{
  
    public function splitByRange($inputPdf, $start, $end, $outputPdf)
    {
        $pdf = new FPDI();

        $totalPages = $pdf->setSourceFile($inputPdf);
        $end = min($end, $totalPages);

        for ($page = $start; $page <= $end; $page++) {
            $tplId = $pdf->importPage($page);
            $size  = $pdf->getTemplateSize($tplId);

            $pdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
            $pdf->useTemplate($tplId);
        }

        $pdf->Output($outputPdf, 'F');
    }
}