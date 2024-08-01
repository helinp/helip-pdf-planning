<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use Helip\PdfPlanning\Fonts\PdfPlanningFonts;
use Helip\PdfPlanning\PdfPlanningConfig;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;
use Helip\PdfPlanning\Utils\DateTimeUtils;
use TCPDF;

abstract class PdfPlanningGridBuilderAbstract
{
    protected float $gridWidth;
    protected float $gridHeigth;
    protected int $colsNumber;
    protected float $colWidth;
    protected float $slotHeight;
    protected float $slotTimeLength;
    protected array $headerTitles;

    public function __construct(
        protected TCPDF $pdf,
        protected PdfPlanningConfig $config,
        protected PdfPlanningFonts $fonts
    ) {
        $this->calculateVars();
    }

    public function addGrid(): void
    {
        $this->addCols();
        $this->addRows();
    }

    abstract protected function addRows(): void;
    abstract protected function addLineHeaders(float $h, float $y, float $x, string $text): void;

    private function calculateVars(): void
    {
        $differenceMinute = DateTimeUtils::getDifferenceInMinutes($this->config->startTime, $this->config->endTime);
        $this->gridWidth = $this->config->pageWidth - ($this->config->marginX * 2) - $this->config->firstColWidth;
        $this->gridHeigth = $this->config->pageHeight - $this->config->marginTopGrid - $this->config->marginBottomGrid;
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
        $this->colsNumber = count($this->headerTitles);
        $this->colWidth = $this->gridWidth / $this->colsNumber;
        $this->slotHeight = $this->gridHeigth / $this->config->slotsNumber;
        $this->slotTimeLength = $differenceMinute / $this->config->slotsNumber;
    }

    private function addCols(): void
    {
        $y1 = $this->config->marginTopGrid;
        $y2 = $this->gridHeigth + $y1;

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
            strtoupper($this->headerTitles[$n]),
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
