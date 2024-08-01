<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Utils;

use TCPDF_STATIC;

class TcpdfUtils
{
    /**
     * Get the page size in mm from a format and an orientation.
     */
    public static function getPageSizeFromFormat(string $format, string $orientation): array
    {
        $sizes = TCPDF_STATIC::getPageSizeFromFormat($format);

        switch ($orientation) {
            case 'P':
                return [self::pointsToMm($sizes[0]), self::pointsToMm($sizes[1])];
            case 'L':
                return [self::pointsToMm($sizes[1]), self::pointsToMm($sizes[0])];
            default:
                throw new \InvalidArgumentException('Invalid orientation');
        }
    }

    public static function pointsToMm(float $points): float
    {
        return $points / 2.838;
    }
}
