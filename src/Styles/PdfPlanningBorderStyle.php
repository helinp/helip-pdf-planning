<?php

declare(strict_types=1);

namespace Helip\PdfPlanning\Styles;

class PdfPlanningBorderStyle
{
    public const STROKE_THIN = [
        'width' => 0.2,
        'cap' => 'butt',
        'join' => 'miter',
        'dash' => '',
        'phase' => 10,
        'color' => [215, 215, 215],
    ];

    public const STROKE_THICK = [
        'width' => 0.3,
        'cap' => 'butt',
        'join' => 'miter',
        'dash' => '',
        'phase' => 10,
        'color' => [0, 0, 0],
    ];

    public const STROKE_NONE = [
        'width' => 0,
        'cap' => 'butt',
        'join' => 'miter',
        'dash' => '',
        'phase' => 10,
        'color' => [255, 255, 255],
    ];

    public const RECTANGLE_THIN = [
        'LTRB' => [
            'width' => 0.3,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 0,
            'color' => [0, 0, 0],
        ],
    ];

    public const RECTANGLE_THICK = [
        'LTRB' => [
            'width' => 0.5,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 0,
            'color' => [0, 0, 0],
        ],
    ];

    public const DASHED_RECTANGLE = [
        'LTRB' => [
            'width' => 1.0,
            'cap' => 'butt',
            'join' => 'miter',
            'dash' => 5,
            'color' => [0, 125, 125],
        ],
    ];
}
