<?php
 
namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
 
class BlogPostsChart extends ChartWidget
{
    protected static ?string $heading = 'Students by grade';
    protected static ?int $sort = 2;

 
    protected function getData(): array
    {
        $students = Student::with('level')->get();

    // Group by the grade from the related `level` table
    $levels = $students
        ->groupBy(fn($student) => $student->level->grade ?? 'Unknown') // Handle missing level
        ->map(fn($group) => $group->count())
        ->toArray();
        // dd($levels);
        return [
            'labels' => array_keys($levels),
            'datasets' => [
                [
                    'label' => 'Number of Student by Grade',
                    'data' => array_values($levels),
                    'backgroundColor' => [
                         'rgb(255, 99, 13)',
                         'rgb(255, 205, 86)'
                    ],
                    'borderColor' => '#fff'
                ],
            ],
        ];
    }
 
    protected function getType(): string
    {
        return 'bar';
    }
}