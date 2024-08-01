<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Weekly;

use Helip\PdfPlanning\Builders\PdfPlanningSlotBuilderAbstract;
use Helip\PdfPlanning\Models\PdfPlanningEntry;
use Helip\PdfPlanning\Models\PdfPlanningEntryInfo;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;
use Helip\PdfPlanning\Utils\DateTimeUtils;

class PdfPlanningSlotsWeeklyBuilder extends PdfPlanningSlotBuilderAbstract
{
    /**
     * Add the entries to the grid.
     */
    public function addEntriesSlots(): void
    {
        $this->pdf->setPageMark();
        $this->pdf->startLayer('DataGrid', true, true);
        $this->pdf->setFont($this->fonts->regular, '', 8, '', true);

        /** @var PdfPlanningEntry $entry */
        foreach ($this->entries as $entry) {
            list($x, $y, $h) = $this->calculatePositioning($entry);
            $this->drawCell($entry, $x, $y, $h);
            $this->addAdditionnalInfos($entry->getAdditionalInfos(), $h, $x, $y);
        }

        $this->pdf->endLayer();
    }

    /**
     * Calculate the position of the entry cell in the grid.
     *
     */
    protected function calculatePositioning(PdfPlanningEntry $entry): array
    {
        $x = $this->config->marginX
            + $this->config->firstColWidth
            + (($entry->getDay() - 1) * $this->colWidth);

        $y = $this->config->marginTopGrid
            + (DateTimeUtils::getDifferenceInMinutes(($this->config->startTime), $entry->getStartTime()) * $this->minuteHeight);

        $h = $this->minuteHeight
            * DateTimeUtils::getDifferenceInMinutes($entry->getStartTime(), $entry->getEndTime());

        return [$x, $y, $h];
    }

    /**
     * @param PdfPlanningEntry $entry
     * @param float $x
     * @param float $y
     * @param float $h height of the cell
     */
    private function drawCell(PdfPlanningEntry $entry, float $x, float $y, float $h): void
    {
        $this->pdf->setFillColor(...$entry->getFillColor());
        $this->pdf->setTextColor(...$entry->getTextColor());
        $this->pdf->setLineStyle(PdfPlanningBorderStyle::STROKE_THICK);

        $this->pdf->Multicell(
            $this->colWidth,
            $h,
            implode(PHP_EOL, $entry->getTexts()),
            PdfPlanningBorderStyle::STROKE_THIN,
            'C',
            1,
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

    /**
     * @param PdfPlanningEntryInfo[] $additionnalInfos
     */
    private function addAdditionnalInfos(array $additionnalInfos, $h, $x, $y)
    {
        /** $info<PdfPlanningEntryInfo> */
        foreach ($additionnalInfos as $info) {

            $this->pdf->Multicell(
                $this->colWidth,
                $h,
                $info->getText(),
                0,
                $info->getHAlign(),
                false,
                true,
                $x,
                $y,
                true,
                0,
                false,
                true,
                0,
                $info->getVAlign(),
                true
            );
        }
    }
}
