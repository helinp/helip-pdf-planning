<?php

declare(strict_types=1);

namespace Helip\PdfPlanning;

use Helip\PdfPlanning\Fonts\PdfPlanningFonts;
use Helip\PdfPlanning\Models\PdfPlanningEntry;
use TCPDF;

abstract class PdfPlanning
{
    protected TCPDF $pdf;
    protected PdfPlanningFonts $fonts;
    protected PdfPlanningConfig $config;
    protected string $filename = 'output.pdf';
    protected string $path = '';

    protected float $largeurMaxGrid;
    protected int $hHeader = 20;
    protected array $headerTitles;
    protected array $entries = [];
    protected string $title = '';

    public function __construct(
        PdfPlanningConfig $config = null,
        PdfPlanningFonts $fonts = null
    ) {
        $this->config = $config ?? new PdfPlanningConfig();
        $this->fonts = $fonts ?? new PdfPlanningFonts();
        $this->pdf = PdfPlanningInitialize::initialize($this->config, $this->fonts, $this->title);

        $this->addPage();
    }

    abstract public function build(): self;

    protected function getConfig(): PdfPlanningConfig
    {
        return $this->config;
    }

    protected function getFonts(): PdfPlanningFonts
    {
        return $this->fonts;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function addEntries(PdfPlanningEntry ...$entries): self
    {
        $this->entries = $entries;
        return $this;
    }

    public function addPage(): self
    {
        $this->pdf->AddPage();
        return $this;
    }

    public function save(string $path, string $filename): string
    {
        return PdfFileSaver::save($this->pdf, $path, $filename);
    }

    public function addTitle(string $text): self
    {
        $this->pdf->setTextColor('000');
        $this->pdf->setFont($this->fonts->bold, '', 16, '', true);
        $this->pdf->MultiCell(0, $this->hHeader, $text, 0, 'C', false, 0, $this->getConfig()->marginX, $this->getConfig()->marginY, true, 0, false, true, 0, "T", true);
        return $this;
    }

    public function addHeaderLeft(string $text): self
    {
        $this->addHeader($text, 'L', '000', 9);
        return $this;
    }

    public function addHeaderRight(string $text): self
    {
        $this->addHeader($text, 'R', '000', 9);
        return $this;
    }

    public function addFooterCenter(string $text): self
    {
        $this->addFooter($text, 'C', '000', 9);
        return $this;
    }

    public function addFooterLeft(string $text): self
    {
        $this->addFooter($text, 'L', '000', 9);
        return $this;
    }

    public function addFooterRight(string $text): self
    {
        $this->addFooter($text, 'R', '000', 9);
        return $this;
    }

    private function addHeader(string $string, string $align, string $color, float $fontSize): void
    {
        $this->pdf->setTextColor($color);
        $this->pdf->setFont($this->fonts->regular, '', $fontSize, '', true);
        $this->pdf->MultiCell($this->getConfig()->pageWidth - ($this->getConfig()->marginX * 2), $this->hHeader, $string, 0, $align, false, 0, $this->getConfig()->marginX, $this->getConfig()->marginY, true, 0, false, true, 0, "T", true);
    }

    private function addFooter(string $string, string $align, string $color, float $fontSize): void
    {
        $this->pdf->setTextColor($color);
        $this->pdf->setFont($this->fonts->regular, '', $fontSize, '', true);
        $this->pdf->MultiCell($this->getConfig()->pageWidth - ($this->getConfig()->marginX * 2), 10, $string, 0, $align, false, 0, $this->getConfig()->marginX, $this->getConfig()->pageHeight - $this->getConfig()->marginY - 10, true, 0, false, true, 0, "B", true);
    }
}
