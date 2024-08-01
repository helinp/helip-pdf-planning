<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Utils;

class TextUtils
{
    /**
     * Combine text items and associated time ranges, removing duplicates and merging times.
     *
     * @return string Formatted string with combined texts and their time ranges.
     */
    public static function combineTextsAndTimes(array $data): string
    {
        $result = [];

        foreach ($data as $row) {
            $formattedText = implode(' - ', $row['entryTexts']);
            $time = $row['formattedTime'];

            if (isset($result[$formattedText])) {
                $result[$formattedText] .= ' · ' . $time;
                continue;
            }

            $result[$formattedText] = $formattedText . PHP_EOL . $time;
        }

        return implode(PHP_EOL, $result);
    }
}
