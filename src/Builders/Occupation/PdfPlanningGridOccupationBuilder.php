<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Occupation;

use Helip\PdfPlanning\Builders\PdfPlanningGridBuilderAbstract;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;
use Helip\PdfPlanning\Utils\DateTimeUtils;
use Helip\PdfPlanning\Utils\EntryUtils;

class PdfPlanningGridOccupationBuilder extends PdfPlanningGridBuilderAbstract
{
    protected function addRows(): void
    {
        $x1 = $this->config->firstColWidth + $this->config->marginX;
        $x2 = $this->config->pageWidth - $this->config->marginX;

        for ($i = 0; $i < $this->config->slotsNumber; ++$i) {

            $y = $this->config->marginTopGrid + ($i * $this->slotHeight);

            $headerText = DateTimeUtils::getDayName($i + 1, $this->config->locale);
            $this->pdf->Line($x1, $y, $x2, $y, PdfPlanningBorderStyle::STROKE_THIN);

            // Avoid to display the last line header
            if ($i === $this->config->slotsNumber) {
                break;
            }

            $this->addLineHeaders($this->slotHeight, $y - $this->slotHeight, $this->config->marginX, $headerText);
        }
    }

    protected function calculateSpecificVars(): void
    {
    }

    protected function setHeaderTitles(): void
    {
        $this->headerTitles =  EntryUtils::getUniqueLocation($this->entries);
    }

    protected function setSlotHeight(): void
    {
        $this->slotHeight = $this->gridHeight / $this->config->slotsNumber;
    }

    protected function addLineHeaders(float $h, float $y, float $x, string $text): void
    {
        // rotation
        $this->pdf->setFont($this->fonts->bold, '', 8, '', true);

        $this->pdf->StartTransform();
        $this->pdf->Rotate(90, $this->config->marginX, $y);
        $this->pdf->TranslateX(-$this->slotHeight * 2);

        $this->pdf->Multicell(
            $h,
            $this->config->firstColWidth,
            $text,
            1,
            'C',
            false,
            false,
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
        $this->pdf->StopTransform();
    }
}
