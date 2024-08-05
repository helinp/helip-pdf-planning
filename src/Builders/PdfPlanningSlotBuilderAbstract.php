<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use Helip\PdfPlanning\Models\PdfPlanningEntry;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;

abstract class PdfPlanningSlotBuilderAbstract extends PdfPlanningBuilderAbstract
{
    protected array $headerTitles;
    protected float $minuteHeight;
    protected float $slotHeight;

    abstract protected function calculatePositioning(PdfPlanningEntry $entry): array;
    abstract protected function addEntriesSlots(): void;

    protected function drawCell(string $text, float $x, float $y, float $h): void
    {
        $this->pdf->Multicell(
            $this->colWidth,
            $h,
            $text,
            PdfPlanningBorderStyle::STROKE_THIN,
            'C',
            true,
            true,
            $x,
            $y,
            true,
            0,
            false,
            true,
            0,
            'M',
            true
        );
    }
}
