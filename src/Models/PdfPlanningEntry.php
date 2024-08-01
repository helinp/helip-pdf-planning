<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Models;

use DateTime;

class PdfPlanningEntry
{
    /**
     * @param array<string> $texts
     * @param DateTime $startTime
     * @param DateTime $endTime
     * @param int $day 1-7
     * @param string $location
     * @param array<int> $fillColor [r, g, b]
     * @param array<int> $textColor [r, g, b]
     * @param array<PdfPlanningEntryInfo|array<string, string>> $additionalInfos
     */
    public function __construct(
        private readonly DateTime $startTime,
        private readonly DateTime $endTime,
        private readonly int $day,
        private readonly array $texts = [],
        private readonly string $location = '',
        private readonly array $fillColor = [255, 255, 255],
        private readonly array $textColor = [0, 0, 0],
        private array $additionalInfos = []
    ) {
        $this->additionalInfos = array_map(function ($info) {
            if ($info instanceof PdfPlanningEntryInfo) {
                return $info;
            }
        }, $additionalInfos);
    }

    public function getTexts(): array
    {
        return $this->texts;
    }

    public function getStartTime(): DateTime
    {
        return $this->startTime;
    }

    public function getEndTime(): DateTime
    {
        return $this->endTime;
    }

    public function getDay(): int
    {
        return $this->day;
    }

    public function getFillColor(): array
    {
        return $this->fillColor;
    }

    public function getTextColor(): array
    {
        return $this->textColor;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return PdfPlanningEntryInfo[]
     */
    public function getAdditionalInfos(): array
    {
        return $this->additionalInfos;
    }
}
