<?php
 
namespace App\Filament\Widgets;

use App\Models\Classroom;
use App\Models\Staff;
use Carbon\Carbon;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
 
class studentsTotal extends BaseWidget
{
    protected static ?int $sort = 1;
    protected ?string $heading = 'Analytics';
    protected ?string $description = 'An overview of some analytics.';
 
 
protected function getStats(): array
{
    $inc = 0;

    $totalStudent = Student::count();
    $staff = Staff::count();
    $classrooms = Classroom::count();
    $totalStudents = Student::whereDate('created_at', '<', Carbon::now()->startOfYear())->count();
    $inc = $totalStudent - $totalStudents;
    
    return [

        Stat::make('Total Students', $totalStudent)
        ->description($inc . ' students increases this year')
        ->descriptionIcon('heroicon-m-arrow-trending-up')
        ->chart([7, 2, 10, 3, 15, 4, 17])
        ->color('success')
        ->extraAttributes([
            'class'=>'cursor-pointer',
        ]),
        
        // ...
        Stat::make('Staff And Teachers', $staff),
        Stat::make('Total Classrooms', $classrooms)->chart([1,3,4,]),
    ];
}
}