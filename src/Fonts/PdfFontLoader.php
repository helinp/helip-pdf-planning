<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Fonts;

use TCPDF_FONTS;

class PdfFontLoader
{
    private function __construct()
    {
    }

    public static function loadFonts(string $fontDir, array $fonts): array
    {
        $loadedFonts = [];
        foreach ($fonts as $fontname => $filename) {
            if (!pathinfo($filename, PATHINFO_EXTENSION)) {
                $loadedFonts[$fontname] = $filename;
                continue;
            }

            $fontPath = $fontDir . $filename;
            if (file_exists($fontPath)) {
                $loadedFonts[$fontname] = TCPDF_FONTS::addTTFfont($fontPath);
            } else {
                throw new \Exception("Le fichier de police est introuvable à l'adresse : " . $fontPath);
            }
        }
        return $loadedFonts;
    }
}
