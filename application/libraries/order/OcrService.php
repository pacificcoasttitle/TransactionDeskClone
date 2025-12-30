<?php defined('BASEPATH') OR exit('No direct script access allowed');

class OcrService
{
    private $isWindows;
    private $tmpDir;
    private $tesseract;
    private $pdftoppm;
    private $magick;
    private $popplerBin;

    // Holds page-wise OCR after processing
    private $pageTexts = [];

    public function __construct()
    {
        $this->isWindows = (PHP_OS_FAMILY === 'Windows');

        $this->tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ocr_pages';
        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir, 0777, true);
        }

        if ($this->isWindows) {
            $this->popplerBin = "C:\\tools\\poppler\\Library\\bin\\";
            $this->pdftoppm   = '"' . $this->popplerBin . 'pdftoppm.exe"';
            $this->tesseract  = '"C:\Program Files\Tesseract-OCR\tesseract.exe"';
            $this->magick     = 'magick';
        } else {
            $this->pdftoppm  = 'pdftoppm';
            $this->tesseract = 'tesseract';
            $this->magick    = 'convert';
        }
    }

    /**
     * MAIN OCR – run ONCE per PDF
     * PDF → images → rotation → OCR
     * Stores page-wise OCR internally
     */
    public function process_pdf($pdfPath)
    {
        // Cleanup old images
        array_map('unlink', glob($this->tmpDir . '/*'));
        $this->pageTexts = [];

        // 1. PDF → PNG
        $prefix = $this->tmpDir . DIRECTORY_SEPARATOR . 'page';
        shell_exec($this->pdftoppm . ' -png -r 300 "' . $pdfPath . '" "' . $prefix . '"');

        $images = glob($this->tmpDir . '/page-*.png');
        natsort($images);

        foreach ($images as $img) {

            if (!preg_match('/page-(\d+)\.png$/', $img, $m)) {
                continue;
            }
            $pageNo = (int)$m[1];

            // 2. Detect rotation
            $rotate = $this->detectRotation($img);

            $finalImg = $img;
            if ($rotate > 0) {
                $finalImg = $img . '_rot.png';
                shell_exec(
                    $this->magick . ' "' . $img . '" -rotate ' . $rotate . ' "' . $finalImg . '"'
                );
            }

            // 3. OCR
            $text = shell_exec(
                $this->tesseract . ' "' . $finalImg . '" stdout -l eng --psm 6'
            );

            $text = $text . '\n actual pdf page number' . $pageNo . '\n';
            $this->pageTexts[$pageNo] = trim($text);
        }

        ksort($this->pageTexts);
        return $this->pageTexts;
    }

    /**
     * Return FULL OCR text (all pages combined)
     */
    public function pdf_to_text($pdfPath)
    {
        $pages = $this->process_pdf($pdfPath);
        return trim(implode("\n", $pages));
    }

    /**
     * Return ONLY FIRST PAGE text
     * Uses already-OCRed result
     */
    public function first_page_text($pdfPath)
    {
        if (empty($this->pageTexts)) {
            $this->process_pdf($pdfPath);
        }

        return $this->pageTexts[1] ?? '';
    }

    /**
     * Return page-wise OCR (for lender parsing)
     */
    public function get_page_texts()
    {
        return $this->pageTexts;
    }

    /**
     * Rotation detection
     */
    private function detectRotation($image)
    {
        $output = shell_exec(
            $this->tesseract . ' "' . $image . '" stdout --psm 0 2>&1'
        );

        if (preg_match('/Rotate:\s+(\d+)/', $output, $m)) {
            return (int)$m[1];
        }
        return 0;
    }
}



// class OcrService {

//     private $isWindows;
//     private $tmpDir;
//     private $tesseract;
//     private $pdftoppm;
//     private $magick;
//     private $popplerBin;

//     public function __construct()
//     {
//         $this->isWindows = (PHP_OS_FAMILY === 'Windows');

//         $this->tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ocr_pages';
//         if (!is_dir($this->tmpDir)) {
//             mkdir($this->tmpDir, 0777, true);
//         }

//         if ($this->isWindows) {
//             // Windows paths
//             $this->tesseract = '"C:\Program Files\Tesseract-OCR\tesseract.exe"';
//             // $this->pdftoppm  = 'pdftoppm';   // available via PATH
//             $this->pdftoppm   = '"' . $this->popplerBin . 'pdftoppm.exe"';
//             $this->magick    = 'magick';     // available via PATH
//             $this->popplerBin    = "C:\\tools\\poppler\\Library\\bin\\";
//         } else {
//             // Ubuntu paths
//             $this->tesseract = 'tesseract';
//             $this->pdftoppm  = 'pdftoppm';
//             $this->magick    = 'convert';    // ImageMagick
//             $this->popplerBin    = "/usr/bin/";
//         }
//     }

//     public function pdf_to_text($pdfPath)
//     {
//         // Cleanup old files
//         array_map('unlink', glob($this->tmpDir . '/*'));

//         $prefix = $this->tmpDir . DIRECTORY_SEPARATOR . 'page';

//         // 1️⃣ PDF → PNG @ 300 DPI
//         $cmdPdf = $this->pdftoppm . ' -png -r 300 "' . $pdfPath . '" "' . $prefix . '" 2>&1';
//         shell_exec($cmdPdf);

//         $finalText = '';

//         foreach (glob($this->tmpDir . '/page-*.png') as $img) {
//             $rotate = $this->detectRotation($img);

//             $fixed = $img;
//             if ($rotate > 0) {
//                 $fixed = $img . '_rot.png';
//                 $cmdRotate = $this->magick . ' "' . $img . '" -rotate ' . $rotate . ' "' . $fixed . '"';
//                 shell_exec($cmdRotate);
//             }

//             // 2️⃣ OCR readable text
//             $cmdOcr = $this->tesseract . ' "' . $fixed . '" stdout -l eng --psm 6';
//             $text = shell_exec($cmdOcr);

//             $finalText .= "\n" . $text;
//             // $oriented = $img . '_ok.png';

//             // // 2️⃣ Auto-orient image (handles rotation)
//             // $cmdRotate = $this->magick . ' "' . $img . '" -auto-orient "' . $oriented . '" 2>&1';
//             // shell_exec($cmdRotate);

//             // // 3️⃣ OCR (English, no OSD)
//             // $cmdOcr = $this->tesseract . ' "' . $oriented . '" stdout -l eng --psm 6 2>&1';
//             // $text = shell_exec($cmdOcr);

//             // $finalText .= "\n" . $text;
//         }
//         print_r($finalText);die;

//         return trim($finalText);
//     }

//     private function detectRotation($image)
//     {
//         $cmd = $this->tesseract . ' "' . $image . '" stdout --psm 0 2>&1';
//         $output = shell_exec($cmd);

//         if (preg_match('/Rotate:\s+(\d+)/', $output, $m)) {
//             return (int)$m[1];
//         }
//         return 0;
//     }

//     // -----------------------------------------
//     // Extract only first page (Manifest Classifier Input)
//     // -----------------------------------------
//     // public function first_page_text($pdfPath)
//     // {
//     //     if ($this->isWindows) {

//     //         $pdftotext = $this->popplerBin . "pdftotext.exe";
//     //         $cmd = "\"$pdftotext\" -f 1 -l 1 \"" . $pdfPath . "\" - 2>&1";

//     //     } else {

//     //         $cmd = "pdftotext -f 1 -l 1 " . escapeshellarg($pdfPath) . " - 2>&1";
//     //     }

//     //     return shell_exec($cmd);
//     // }
// }