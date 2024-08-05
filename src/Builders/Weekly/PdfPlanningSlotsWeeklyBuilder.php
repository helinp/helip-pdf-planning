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
            $text = implode(PHP_EOL, $entry->getTexts());

            $this->pdf->setFillColor(...$entry->getFillColor());
            $this->pdf->setTextColor(...$entry->getTextColor());
            $this->pdf->setLineStyle(PdfPlanningBorderStyle::STROKE_THICK);
            $this->drawCell($text, $x, $y, $h);

            $this->addAdditionnalInfos($entry->getAdditionalInfos(), $h, $x, $y);
        }

        $this->pdf->endLayer();
    }

    protected function calculateSpecificVars(): void
    {
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
        $differenceMinute = DateTimeUtils::getDifferenceInMinutes($this->config->startTime, $this->config->endTime);
        $this->minuteHeight = $this->gridHeight / $differenceMinute;
    }

    protected function setHeaderTitles(): void
    {
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
    }

    protected function setSlotHeight(): void
    {
        $this->slotHeight = $this->gridHeight / $this->config->slotsNumber;
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
