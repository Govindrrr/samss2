<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;

class GenderChart extends ChartWidget
{
    protected static ?string $heading = 'Student by caste';
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $students = Student::with('caste')->get();
        $castes = $students->groupBy(fn($student) => $student->caste->name ?? 'unknown')
        ->map(fn($group) => $group->count())->toArray();
        // dd($castes);
            return [
                'datasets' => [
                    [
                        'label' => '00',
                        'data' => array_values($castes),
                        "backgroundColor" => [
                            'rgb(255, 99, 132)',
                            'rgb(255, 205, 86)']
                    ],
                ],
                'labels' => array_keys($castes),
            ];
    }
    protected function getOptions(): array
{
    return [
        'scales' => [
            'y' => [
                'display' => false, // Hide Y-axis
                'beginAtZero' => true
            ],
            'x' => [
                'display' => false, // Hide X-axis (optional)
            ],
        ],
    ];
}

    protected function getType(): string
    {
        return 'pie';
    }
}
