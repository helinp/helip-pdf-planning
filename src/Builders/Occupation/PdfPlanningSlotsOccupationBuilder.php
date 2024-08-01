<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Occupation;

use Helip\PdfPlanning\Builders\PdfPlanningSlotBuilderAbstract;
use Helip\PdfPlanning\Models\PdfPlanningEntry;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;
use Helip\PdfPlanning\Utils\DateTimeUtils;
use Helip\PdfPlanning\Utils\TextUtils;

class PdfPlanningSlotsOccupationBuilder extends PdfPlanningSlotBuilderAbstract
{
    private array $grille = [];

    public function addEntriesSlots(): void
    {
        $this->pdf->setPageMark();
        $this->pdf->startLayer('DataGrid', true, true);
        $this->pdf->setFont($this->fonts->regular, '', 8, '', true);

        foreach ($this->entries as $entry) {
            list($x, $y, $h) = $this->calculatePositioning($entry);

            $formattedTime = $entry->getStartTime()->format('H:i') . ' - ' . $entry->getEndTime()->format('H:i');
            $entryTexts = $entry->getTexts();

            $data = [
                'formattedTime' => $formattedTime,
                'entryTexts' => $entryTexts
            ];

            if (!isset($this->grille[$x . $y])) {
                $this->grille[$x . $y] = [
                    'x' => $x,
                    'y' => $y,
                    'h' => $this->rowHeight,
                    'texts' => []
                ];
            }

            $this->grille[$x . $y]['texts'][] = $data;
        }

        foreach ($this->grille as $item) {
            $combinedText = TextUtils::combineTextsAndTimes($item['texts']);

            $this->pdf->Multicell(
                $this->colWidth,
                $item['h'],
                $combinedText,
                PdfPlanningBorderStyle::STROKE_THIN,
                'C',
                false,
                true,
                $item['x'],
                $item['y'],
                true,
                0,
                false,
                true,
                0,
                'M',
                true
            );
        }

        $this->pdf->endLayer();
    }



    /**
     * Calculate the variables needed to draw the grid.
     */
    protected function calculateVars(): void
    {
        $differenceMinute = DateTimeUtils::getDifferenceInMinutes($this->config->startTime, $this->config->endTime);
        $this->gridWidth = $this->config->pageWidth - ($this->config->marginX * 2) - $this->config->firstColWidth;
        $this->gridHeight = $this->config->pageHeight - $this->config->marginTopGrid - $this->config->marginBottomGrid;
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
        $this->colsNumber = count($this->headerTitles);
        $this->colWidth = $this->gridWidth / $this->colsNumber;
        $this->minuteHeight = $this->gridHeight / $differenceMinute;
        $this->rowHeight = $this->gridHeight / $this->config->slotsNumber;
    }

    /**
     * Calculate the position of the entry cell in the grid.
     */
    protected function calculatePositioning(PdfPlanningEntry $entry): array
    {
        $nCol = array_search($entry->getLocation(), $this->headerTitles);
        $x = $this->config->firstColWidth + $this->config->marginX + $nCol * $this->colWidth;
        $y = ($entry->getDay() - 1) * $this->rowHeight + $this->config->marginTopGrid;

        $h = $this->minuteHeight * DateTimeUtils::getDifferenceInMinutes($entry->getStartTime(), $entry->getEndTime());

        return [$x, $y, $h];
    }
}
