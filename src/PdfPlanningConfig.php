<?php

declare(strict_types=1);

namespace Helip\PdfPlanning;

use Helip\PdfPlanning\Utils\TcpdfUtils;
use DateTime;
use DateTimeInterface;
use Helip\PdfPlanning\Builders\Weekly\PdfPlanningWeeklyHeaders;
use InvalidArgumentException;

class PdfPlanningConfig
{
    public readonly float $pageHeight;
    public readonly float $pageWidth;

    public function __construct(
        public readonly float $marginY = 7,
        public readonly float $marginX = 7,
        public readonly float $firstColWidth = 10,
        public readonly float $marginTopGrid = 25, // distance in mm from the top of the page to the top of the grid
        public readonly float $marginBottomGrid = 15, // distance in mm from the bottom of the page to the bottom of the grid
        public readonly float $hHeader = 0,
        public readonly string $pageOrientation = 'L',
        public readonly string $pageFormat = 'A4',
        public readonly int $slotsNumber = 10,
        public readonly int $stepsLength = 60, // line demarcation every x minutes
        public readonly DateTimeInterface $startTime = new DateTime('1970-01-01 08:00:00'),
        public readonly DateTimeInterface $endTime = new DateTime('1970-01-01 18:00:00'),
        public readonly string $locale = 'en',
        public PdfPlanningWeeklyHeaders $headerTitles = new PdfPlanningWeeklyHeaders(),
    ) {
        // Validation
        if ($this->marginY < 0 || $this->marginX < 0) {
            throw new InvalidArgumentException('Margins cannot be negative.');
        }
        if ($this->firstColWidth <= 0) {
            throw new InvalidArgumentException('First column width must be greater than zero.');
        }

        if($this->headerTitles->getHeaderTitles() === []) {
            $this->headerTitles = PdfPlanningWeeklyHeaders::createWithWeekdays(1, 5, $this->locale);
        }

        $pageSize = TcpdfUtils::getPageSizeFromFormat($this->pageFormat, $this->pageOrientation);
        $this->pageHeight = $pageSize[1];
        $this->pageWidth = $pageSize[0];
    }
}
