<?php

declare(strict_types=1);

namespace Helip\PdfPlanning;

use TCPDF;

class PdfFileSaver
{
    /**
     * Saves the PDF to the specified path.
     *
     * @param TCPDF $pdf
     * @param string $path
     * @param string $filename
     * @return string The path to the saved PDF.
     */
    public static function save(TCPDF $pdf, string $path, string $filename): string
    {
        $path = rtrim($path, '/') . '/';

        if (!file_exists($path)) {
            if (!mkdir($path, 0755, true) && !is_dir($path)) {
                throw new \RuntimeException(sprintf('Unable to create directory: %s', $path));
            }
        }

        $tempPath = sys_get_temp_dir() . '/' . uniqid('pdf_', true) . '.pdf';
        $pdf->Output($tempPath, 'F');
        rename($tempPath, $path . $filename);

        return '/' . ltrim($path, '/') . $filename;
    }
}
