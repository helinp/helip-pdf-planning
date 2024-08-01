<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Weekly;

use Helip\PdfPlanning\PdfPlanning;

final class ScheduleWeeklyBuilder extends PdfPlanning
{
    public function build(): self
    {
        $grid = new PdfPlanningGridWeeklyBuilder($this->pdf, $this->config, $this->fonts);
        $grid->addGrid();

        $slots = new PdfPlanningSlotsWeeklyBuilder($this->pdf, $this->config, $this->fonts, $this->entries);
        $slots->addEntriesSlots();

        $this->addTitle($this->title);
        return $this;
    }
}
