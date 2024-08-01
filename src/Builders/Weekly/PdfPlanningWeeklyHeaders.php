<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Builders\Weekly;

use Helip\PdfPlanning\Utils\DateTimeUtils;

class PdfPlanningWeeklyHeaders
{
    private array $headerTitles = [];
    private const WEEKDAYS = [1, 2, 3, 4, 5, 6, 7];
    private bool $isWeekdays = false;

    public function __construct()
    {
    }

    /**
     * Factory method to create an instance with weekdays configuration.
     *
     * @param int $start Start index (from 1 to 7 for Monday to Sunday)
     * @param int $end End index (from 1 to 7 for Monday to Sunday)
     * @return self
     * @throws \InvalidArgumentException
     */
    public static function createWithWeekdays(int $start, int $end, string $languageCode = 'en'): self
    {
        $instance = new self();
        $instance->setWeekdays($start, $end, $languageCode);

        return $instance;
    }

    /**
     * Factory method to create an instance with custom titles.
     *
     * @param string ...$titles Custom titles
     * @return self
     */
    public static function createWithCustomTitles(string ...$titles): self
    {
        $instance = new self();
        $instance->setCustomTitles(...$titles);
        return $instance;
    }

    /**
     * Sets the days of the week based on start and end indices.
     *
     * @param int $start Start index (from 1 to 7 for Monday to Sunday)
     * @param int $end End index (from 1 to 7 for Monday to Sunday)
     * @throws \InvalidArgumentException
     */
    private function setWeekdays(int $start, int $end, string $langageCode): void
    {
        $this->validateWeekdayRange($start, $end);

        $this->headerTitles = array_map(
            fn ($day) => DateTimeUtils::getDayName($day, $langageCode),
            array_slice(self::WEEKDAYS, $start - 1, $end - $start + 1)
        );

        $this->isWeekdays = true;
    }

    /**
     * Validates the weekday range.
     */
    private function validateWeekdayRange(int $start, int $end): void
    {
        if ($start < 1 || $start > 7 || $end < 1 || $end > 7 || $start > $end) {
            throw new \InvalidArgumentException('Invalid start or end index. They must be between 1 and 7, and start must be less than or equal to end.');
        }
    }

    /**
     * Sets custom column titles.
     *
     * @param string ...$titles Custom titles
     */
    private function setCustomTitles(string ...$titles): void
    {
        $this->headerTitles = $titles;
    }

    /**
     * Returns the header titles.
     *
     * @return array<int|string>
     */
    public function getHeaderTitles(): array
    {
        return $this->headerTitles;
    }

    /**
     * Returns whether the header titles are weekdays.
     *
     * @return bool
     */
    public function isWeekdays(): bool
    {
        return $this->isWeekdays;
    }
}
