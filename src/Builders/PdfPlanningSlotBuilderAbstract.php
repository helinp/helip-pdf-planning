<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use Helip\PdfPlanning\Fonts\PdfPlanningFonts;
use Helip\PdfPlanning\Models\PdfPlanningEntry;
use Helip\PdfPlanning\PdfPlanningConfig;
use Helip\PdfPlanning\Utils\DateTimeUtils;
use TCPDF;

abstract class PdfPlanningSlotBuilderAbstract
{
    protected float $gridWidth;
    protected float $gridHeight;
    protected int $colsNumber;
    protected float $colWidth;
    protected array $headerTitles;
    protected float $minuteHeight;
    protected float $rowHeight;

    public function __construct(
        protected TCPDF $pdf,
        protected PdfPlanningConfig $config,
        protected PdfPlanningFonts $fonts,
        protected array $entries
    ) {
        $this->calculateVars();
    }

    protected function calculateVars(): void
    {
        $differenceMinute = DateTimeUtils::getDifferenceInMinutes($this->config->startTime, $this->config->endTime);
        $this->gridWidth = $this->config->pageWidth - ($this->config->marginX * 2) - $this->config->firstColWidth;
        $this->gridHeight = $this->config->pageHeight - $this->config->marginTopGrid - $this->config->marginBottomGrid;
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
        $this->colsNumber = count($this->headerTitles);
        $this->colWidth = $this->gridWidth / $this->colsNumber;
        $this->minuteHeight = $this->gridHeight / $differenceMinute;
        $this->rowHeight = $this-> gridHeight / $this->config->slotsNumber;
    }

    abstract protected function calculatePositioning(PdfPlanningEntry $entry): array;
    abstract protected function addEntriesSlots(): void;
}
