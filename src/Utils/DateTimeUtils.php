<?php


declare(strict_types=1);

namespace Helip\PdfPlanning\Utils;

use DateTime;
use IntlDateFormatter;
use InvalidArgumentException;

class DateTimeUtils
{
    public static function getDifferenceInMinutes(DateTime $start, DateTime $end): int
    {
        $timeDifference = $start->diff($end);
        $totalMinutes = ($timeDifference->h * 60) + $timeDifference->i;

        return $totalMinutes;
    }

    public static function getDayName(int $dayNumber, string $languageCode = 'en'): string
    {
        if ($dayNumber < 1 || $dayNumber > 7) {
            throw new InvalidArgumentException("Day number must be between 1 and 7.");
        }

        $date = new DateTime();
        $date->setISODate(1970, 1, $dayNumber);

        $formatter = new IntlDateFormatter(
            $languageCode,
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            null,
            IntlDateFormatter::GREGORIAN,
            'EEEE'
        );

        return $formatter->format($date);
    }

}
