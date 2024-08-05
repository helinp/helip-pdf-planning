<?php

namespace Tests\Unit;

use DateTime;
use Helip\PdfPlanning\Builders\Occupation\ScheduleOccupationBuilder;
use Helip\PdfPlanning\Builders\Weekly\PdfPlanningWeeklyHeaders;
use Helip\PdfPlanning\Builders\Weekly\ScheduleWeeklyBuilder;
use Helip\PdfPlanning\Models\PdfPlanningEntry;
use Helip\PdfPlanning\Models\PdfPlanningEntryInfo;
use Helip\PdfPlanning\PdfPlanningConfig;
use Helip\PdfPlanning\Utils\EntryUtils;
use PHPUnit\Framework\TestCase;

class PdfPlanningTest extends TestCase
{
    private function getDefaultData()
    {
        $datasets = [
            [
                'texts' => ['Team Meeting', 'Budget Review'],
                'startTime' => new DateTime('2021-01-01 09:00:00'),
                'endTime' => new DateTime('2021-01-01 11:00:00'),
                'day' => 1,
                'location' => 'Conference Room',
                'fillColor' => [200, 200, 255],
                'textColor' => [0, 0, 0],
                'count' => 2,
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'C', 'Budget Analysis'),
                    new PdfPlanningEntryInfo('B', 'L', 'Q1 Financials'),
                ]
            ],
            [
                'startTime' => new DateTime('2021-01-02 10:00:00'),
                'endTime' => new DateTime('2021-01-02 12:30:00'),
                'day' => 2,
                'texts' => ['Project Kickoff', 'Initial Planning'],
                'location' => 'Main Hall',
                'fillColor' => [255, 200, 200],
                'textColor' => [0, 0, 0],
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'L', 'Project X'),
                    new PdfPlanningEntryInfo('B', 'R', 'Timeline Discussion')
                ]
            ],
            [
                'startTime' => new DateTime('2021-01-03 14:00:00'),
                'endTime' => new DateTime('2021-01-03 17:00:00'),
                'day' => 3,
                'texts' => ['Technical Workshop', 'Hands-on Session'],
                'location' => 'Lab 3',
                'fillColor' => [200, 255, 200],
                'textColor' => [0, 0, 0],
                'count' => 3,
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'R', 'Introduction to AI'),
                    new PdfPlanningEntryInfo('B', 'C', 'Practical Exercises'),
                ]
                ],
            [
                'startTime' => new DateTime('2021-01-04 08:00:00'),
                'endTime' => new DateTime('2021-01-04 10:00:00'),
                'day' => 4,
                'texts' => ['Training Session', 'Certification Exam'],
                'location' => 'Training Room',
                'fillColor' => [200, 200, 200],
                'textColor' => [0, 0, 0],
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'C', 'Certification'),
                    new PdfPlanningEntryInfo('B', 'L', 'Training Materials'),
                ]
            ],
            [
                'startTime' => new DateTime('2021-01-05 09:00:00'),
                'endTime' => new DateTime('2021-01-05 11:00:00'),
                'day' => 5,
                'texts' => ['Client Meeting', 'Project Review'],
                'location' => 'Conference Room',
                'fillColor' => [255, 255, 200],
                'textColor' => [0, 0, 0],
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'L', 'Client X'),
                    new PdfPlanningEntryInfo('B', 'R', 'Project Y'),
                ]
            ],
            [
                'startTime' => new DateTime('2021-01-06 11:00:00'),
                'endTime' => new DateTime('2021-01-06 12:00:00'),
                'day' => 5,
                'texts' => ['Team Meeting', 'Project Planning'],
                'location' => 'Conference Room',
                'fillColor' => [200, 255, 255],
                'textColor' => [0, 0, 0],
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'C', 'Project Z'),
                    new PdfPlanningEntryInfo('B', 'L', 'Q2 Planning'),
                ]
            ],
            [
                'startTime' => new DateTime('2021-01-06 14:00:00'),
                'endTime' => new DateTime('2021-01-06 16:00:00'),
                'day' => 5,
                'texts' => ['Team Meeting', 'Project Planning'],
                'location' => 'Conference Room',
                'fillColor' => [200, 255, 255],
                'textColor' => [200, 125, 0],
                'additionalInfos' => [
                    new PdfPlanningEntryInfo('T', 'C', 'Project Z'),
                    new PdfPlanningEntryInfo('B', 'L', 'Q2 Planning'),
                ]
            ],
        ];

        $entries = [];
        foreach ($datasets as $data) {
            $entries[] = new PdfPlanningEntry(
                $data['startTime'],
                $data['endTime'],
                $data['day'],
                $data['texts'],
                $data['location'],
                $data['fillColor'],
                $data['textColor'],
                $data['additionalInfos']
            );
        }

        return $entries;
    }


    public function testBuildEmptyGrid()
    {
        $pdfPlanning = new ScheduleWeeklyBuilder();
        $pdfPlanning->setTitle('Empty grid')
            ->addFooterRight('Test');

        $pdfPlanning->build();
        $pdfPlanning->save('tests/documents/', 'testBuildEmptyGrid.pdf');
        $filePath = 'tests/documents/testBuildEmptyGrid.pdf';

        $this->assertFileExists($filePath);
        // Ajoute d'autres assertions pour vérifier le contenu du PDF si nécessaire
    }

    public function testBuildWithData()
    {
        $pdfPlanning = new ScheduleWeeklyBuilder();
        $pdfPlanning->setTitle('Test Build with Data')
            ->addEntries(...$this->getDefaultData())
            ->addFooterRight('Test Footer right')
            ->addFooterLeft('Test Footer left')
            ->addFooterCenter('Test Footer center')
            ->addHeaderLeft('Test Header left')
            ->addHeaderRight('Test Header right');

        $pdfPlanning->build();
        $pdfPlanning->save('tests/documents/', 'testBuildWithData.pdf');
        $filePath = 'tests/documents/testBuildWithData.pdf';

        $this->assertFileExists($filePath);
        // Ajoute d'autres assertions pour vérifier le contenu du PDF si nécessaire
    }

    public function testCustomConfig()
    {
        $pdfConfig = new PdfPlanningConfig(
            marginX: 10,
            marginY: 10,
            firstColWidth: 20,
            marginTopGrid: 30,
            marginBottomGrid: 20,
            hHeader: 0,
            pageOrientation: 'P',
            pageFormat: 'A4',
            slotsNumber: 12,
            stepsLength: 30,
            startTime: new DateTime('1970-01-01 07:00:00'),
            endTime: new DateTime('1970-01-01 19:25:00'),
            locale: 'fr',
            headerTitles: PdfPlanningWeeklyHeaders::createWithWeekdays(1, 7)
        );

        $pdfPlanning = new ScheduleWeeklyBuilder(
            config: $pdfConfig
        );

        $pdfPlanning->setTitle('Test Custom Config')
            ->addEntries(...$this->getDefaultData())
            ->addFooterRight('Test Footer right')
            ->addFooterLeft('Test Footer left')
            ->addFooterCenter('Test Footer center')
            ->addHeaderLeft('Test Header left')
            ->addHeaderRight('Test Header right')
        ;
    
        $pdfPlanning->build();
        $pdfPlanning->save('tests/documents/', 'testCustomConfig.pdf');
        $filePath = 'tests/documents/testCustomConfig.pdf';

        $this->assertFileExists($filePath);
    }

    public function testCustomHeaders() {
        $pdfHeaders = PdfPlanningWeeklyHeaders::createWithCustomTitles(
            'Banana', 'Apple', 'Orange', 'Grape', 'Pineapple'
        );

        $pdfConfig = new PdfPlanningConfig(
            headerTitles: $pdfHeaders
        );

        $pdfPlanning = new ScheduleWeeklyBuilder(
            config: $pdfConfig
        );

        $pdfPlanning->setTitle('Test Custom Headers')
            ->addEntries(...$this->getDefaultData())
            ->addFooterRight('Test Footer right')
            ->addFooterLeft('Test Footer left')
            ->addFooterCenter('Test Footer center')
            ->addHeaderLeft('Test Header left')
            ->addHeaderRight('Test Header right')
        ;
    
        $pdfPlanning->build();
        $pdfPlanning->save('tests/documents/', 'testCustomHeaders.pdf');
        $filePath = 'tests/documents/testCustomHeaders.pdf';

        $this->assertFileExists($filePath);
    }

    public function testBuildOccupation()
    {
        $pdfConfig = new PdfPlanningConfig(
            marginX: 10,
            marginY: 10,
            firstColWidth: 10,
            slotsNumber: 6,
            marginTopGrid: 30,
            marginBottomGrid: 20,
            locale: 'es',
        );

        $pdfPlanning = new ScheduleOccupationBuilder(
            config: $pdfConfig
        );
        $pdfPlanning->setTitle('Test Build with Counter')
            ->addEntries(...$this->getDefaultData())
            ->addHeaderRight('Test Header right');

        $pdfPlanning->build();
        $pdfPlanning->save('tests/documents/', 'testBuildOccupation.pdf');
        $filePath = 'tests/documents/testBuildOccupation.pdf';

        $this->assertFileExists($filePath);
    }
}
