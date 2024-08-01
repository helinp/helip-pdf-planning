<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use TCPDF;
use Symfony\Component\HttpFoundation\Response;

class SymfonyResponseBuilder
{
    public static function buildResponse(TCPDF $pdf, string $filename): Response
    {
        $response = new Response();
        $response->setContent($pdf->Output($filename, 'S'));
        $response->headers->set('Content-Type', 'application/pdf');
        return $response;
    }
}
