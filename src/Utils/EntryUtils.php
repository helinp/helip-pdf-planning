<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Utils;

use Helip\PdfPlanning\Models\PdfPlanningEntry;

class EntryUtils
{
    /**
     * @param PdfPlanningEntry[] $entries
     * @return string[]
     */
    public static function getUniqueLocation(array $entries): array
    {
        $locations = array_map(fn (PdfPlanningEntry $entry): string => $entry->getLocation(), $entries);
        $uniqueLocations = array_unique($locations);
        return array_values($uniqueLocations);
    }
}
