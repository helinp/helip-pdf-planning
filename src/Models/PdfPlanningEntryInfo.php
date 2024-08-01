<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Models;

class PdfPlanningEntryInfo
{
    private const VALIGN_OPTIONS = ['T', 'M', 'B'];
    private const HALIGN_OPTIONS = ['L', 'C', 'R'];

    private string $vAlign;
    private string $hAlign;
    private string $text;

    public function __construct(string $vAlign, string $hAlign, string $text)
    {
        if (!in_array($vAlign, self::VALIGN_OPTIONS)) {
            throw new \InvalidArgumentException("Invalid vertical alignment: $vAlign");
        }

        if (!in_array($hAlign, self::HALIGN_OPTIONS)) {
            throw new \InvalidArgumentException("Invalid horizontal alignment: $hAlign");
        }

        $this->vAlign = $vAlign;
        $this->hAlign = $hAlign;
        $this->text = $text;
    }

    public function getVAlign(): string
    {
        return $this->vAlign;
    }

    public function getHAlign(): string
    {
        return $this->hAlign;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
