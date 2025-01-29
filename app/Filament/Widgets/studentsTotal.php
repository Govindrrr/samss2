<?php
 
namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
class studentsTotal extends BaseWidget
{
    protected static ?int $sort = 1;
 
protected function getStats(): array
{
    $totalStudent = Student::count();
    return [
        Stat::make('Unique views', '192.1k')
        ->description('32k increase')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('success'),

        Stat::make('Total Students', $totalStudent)
        ->description('32k increase')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->chart(['baishak','jeth','ashar','shawan'])
        ->color('success'),
        // ...
        Stat::make('Staff And Teachers', '57'),
    ];
}
}