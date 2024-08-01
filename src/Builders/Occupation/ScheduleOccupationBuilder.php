<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Occupation;

use Helip\PdfPlanning\PdfPlanning;

final class ScheduleOccupationBuilder extends PdfPlanning
{
    public function build(): self
    {
        $grid = new PdfPlanningGridOccupationBuilder($this->pdf, $this->config, $this->fonts);
        $grid->addGrid();

        $slots = new PdfPlanningSlotsOccupationBuilder($this->pdf, $this->config, $this->fonts, $this->entries);
        $slots->addEntriesSlots();

        $this->addTitle($this->title);
        return $this;
    }
}
