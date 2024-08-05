<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Weekly;

use DateInterval;
use Helip\PdfPlanning\Builders\PdfPlanningGridBuilderAbstract;
use Helip\PdfPlanning\Styles\PdfPlanningBorderStyle;
use DateTime;
use Helip\PdfPlanning\Utils\DateTimeUtils;

class PdfPlanningGridWeeklyBuilder extends PdfPlanningGridBuilderAbstract
{
    protected function addRows(): void
    {
        $x1 = $this->config->firstColWidth + $this->config->marginX;
        $x2 = $this->config->pageWidth - $this->config->marginX;

        for ($n = 0; $n <= $this->config->slotsNumber; ++$n) {

            $y = $this->config->marginTopGrid + ($n * $this->slotHeight);

            /** @var DateTime $heure */
            $heure = clone $this->config->startTime;
            $interval = new DateInterval('PT' . (int) $this->slotTimeLength * $n . 'M');
            $heure->add($interval);
            $headerText = $heure->format('H:i');

            $this->addLineHeaders($this->slotHeight, $y - ($this->slotHeight / 2), $this->config->marginX, $headerText);

            $this->pdf->Line($x1, $y, $x2, $y, PdfPlanningBorderStyle::STROKE_THIN);
        }
    }

    protected function setHeaderTitles(): void
    {
        $this->headerTitles = $this->config->headerTitles->getHeaderTitles();
    }

    protected function calculateSpecificVars(): void
    {
        $differenceMinute = DateTimeUtils::getDifferenceInMinutes($this->config->startTime, $this->config->endTime);
        $this->slotTimeLength = $differenceMinute / $this->config->slotsNumber;
    }

    protected function addLineHeaders(float $h, float $y, float $x, string $text): void
    {
        $this->pdf->setFont($this->fonts->regular, '', 8, '', true);
        $this->pdf->Multicell(
            $this->config->firstColWidth,
            $h,
            $text,
            '',
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
    }
}
