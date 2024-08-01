<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Fonts;

class PdfPlanningFonts
{
    public readonly string $regular;
    public readonly string $bold;
    public readonly string $italic;
    public readonly string $boldItalic;

    public function __construct(
        string $fontDirectory = '',
        string $fontRegular = 'dejavusanscondensed',
        string $fontBold = 'dejavusanscondensedb',
        string $fontItalic = 'dejavusanscondensedi',
        string $fontBoldItalic = 'dejavusanscondensedbi'
    ) {
        $this->regular = $fontRegular;
        $this->bold = $fontBold;
        $this->italic = $fontItalic;
        $this->boldItalic = $fontBoldItalic;

        PdfFontLoader::loadFonts($fontDirectory, [
            'fontRegular' => $fontRegular,
            'fontBold' => $fontBold,
            'fontItalic' => $fontItalic,
            'fontBoldItalic' => $fontBoldItalic
        ]);
    }
}
