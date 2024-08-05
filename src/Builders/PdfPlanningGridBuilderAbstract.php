<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;

abstract class PdfPlanningGridBuilderAbstract extends PdfPlanningBuilderAbstract
{
    protected float $slotTimeLength;
    protected array $headerTitles;
    protected array $lineHeaders;
    protected float $slotHeight;


    public function addGrid(): void
    {
        $this->addCols();
        $this->addRows();
    }

    abstract protected function addRows(): void;
    abstract protected function addLineHeaders(float $h, float $y, float $x, string $text): void;

    protected function setSlotHeight(): void
    {
        $this->slotHeight = $this->gridHeight / $this->config->slotsNumber;
    }

    private function addCols(): void
    {
        $y1 = $this->config->marginTopGrid;
        $y2 = $this->gridHeight + $y1;

        $leftMargin = $this->config->marginX + $this->config->firstColWidth;

        $this->pdf->setFont($this->fonts->regular, '', 12, '', true);

        for ($n = 0; $n <= $this->colsNumber; ++$n) {
            $x1 = $leftMargin + ($n * $this->colWidth);
            $this->pdf->Line($x1, $y1, $x1, $y2, PdfPlanningBorderStyle::STROKE_THIN);

            // Dessine la dernière ligne
            if ($n === $this->colsNumber) {
                break;
            }

            $this->addColHeaders(5, $x1, $n);
        }
    }

    private function addColHeaders(float $h, float $x1, int $n): void
    {
        $this->pdf->setTextColor(0, 0, 0);
        $this->pdf->Multicell(
            $this->colWidth,
            $h,
            mb_strtoupper($this->headerTitles[$n]),
            '',
            'C',
            false,
            true,
            $x1,
            $this->config->marginTopGrid - $h,
            true,
            0,
            false,
            true,
            0,
            'T',
            true
        );
    }
}
