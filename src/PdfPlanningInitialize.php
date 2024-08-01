<?php

declare(strict_types=1);

namespace Helip\PdfPlanning;

use Helip\PdfPlanning\Fonts\PdfPlanningFonts;
use TCPDF;

class PdfPlanningInitialize
{
    public static function initialize(
        PdfPlanningConfig $config,
        PdfPlanningFonts $fonts,
        string $title,
    ): TCPDF {
        $pdf = new TCPDF($config->pageOrientation, PDF_UNIT, $config->pageFormat, true, 'UTF-8', false);
        $pdf->setTitle($title);
        $pdf->setSubject('');
        $pdf->setKeywords('');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->setFont($fonts->regular, '', 17, '', true);
        $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->setMargins($config->marginX, $config->marginY, $config->marginX);
        $pdf->setAutoPageBreak(true);
        $pdf->setFontSubsetting(true);

        return $pdf;
    }
}
