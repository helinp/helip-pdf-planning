<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders;

use Helip\PdfPlanning\Fonts\PdfPlanningFonts;
use Helip\PdfPlanning\PdfPlanningConfig;
use TCPDF;

abstract class PdfPlanningBuilderAbstract
{
    protected float $gridWidth;
    protected float $gridHeight;

    protected int $colsNumber;
    protected float $colWidth;
    protected array $headerTitles;

    public function __construct(
        protected TCPDF $pdf,
        protected PdfPlanningConfig $config,
        protected PdfPlanningFonts $fonts,
        protected array $entries
    ) {
        $this->setHeaderTitles();
        $this->calculateVars();
        $this->calculateSpecificVars();
        $this->setSlotHeight();
    }

    abstract protected function setHeaderTitles(): void;
    abstract protected function calculateSpecificVars(): void;
    abstract protected function setSlotHeight(): void;

    private function calculateVars(): void
    {
        $this->gridWidth = $this->config->pageWidth - ($this->config->marginX * 2) - $this->config->firstColWidth;
        $this->gridHeight = $this->config->pageHeight - $this->config->marginTopGrid - $this->config->marginBottomGrid;
        $this->colsNumber = count($this->headerTitles);
        $this->colWidth = $this->gridWidth / $this->colsNumber;
    }
}
