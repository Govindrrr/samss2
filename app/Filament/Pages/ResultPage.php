<?php

namespace App\Filament\Pages;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Exports\Exporter;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Blade;

// class ResultPage extends Page implements HasTable
// {

//     use InteractsWithForms;
//     use InteractsWithTable;
//     protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
//     protected static ?string $title = 'Result';
//     protected static string $view = 'filament.pages.result-page';


//     public $faculty;
//     public $level;
//     public $exam;
//     public $classroom;
//     public $makeResult = false;
//     public $createResult = true;
//     public $createNext = false;

//     public function form(Form $form): Form
//     {
//         return $form->schema([
//             Select::make('exam')
//                 ->label("Exam Id")
//                 ->reactive()
//                 ->required()
//                 ->options(
//                     Exam::all()->pluck('name', 'id')
//                 )
//                 ->default(function () {
//                     return Exam::where('id', 'desc')->first();
//                 }),
//             Select::make('faculty')
//                 ->label("Faculty")
//                 ->reactive()
//                 ->options(
//                     Faculty::all()->pluck('name', 'id')
//                 )
//                 ->afterStateUpdated(function (callable $set) {
//                     $set('level', null);
//                 }),

//             Select::make('level')
//                 ->label("Class")
//                 ->reactive() // Make it reactive based on faculty
//                 ->options(fn(Get $get) => Level::where('faculty_id', (int) $get('faculty'))->pluck('grade', 'id'))
//                 ->afterStateUpdated(function (callable $set) {
//                     $set('classroom', null);
//                 }),
//             Select::make('classroom')
//                 ->options(fn(Get $get) => Classroom::where('level_id', (int) $get('level'))->pluck('name', 'id'))
//                 ->reactive() // This makes the subcategory field update reactively
//         ])
//             ->columns(4);
//     }

//     public function table(Table $table): Table
//     {
//         return $table
//             // ->query(Student::query())
//             ->query(Mark::query()->when($this->level, fn($q)=> $q->where('level_id', $this->level))
//             ->when($this->exam, fn($q)=> $q->where('exam_id', $this->exam))
//             ->when($this->classroom, fn($q)=> $q->where('classroom_id', $this->classroom)))
//             ->columns([
//                 TextColumn::make('first_name')
//                     ->label('Name')
//                     ->getStateUsing(fn($record) => $record ? $record->first_name . ' ' . $record->last_name : 'N/A')
//                     ->searchable(),
//                 TextColumn::make('roll_no')
//                     ->searchable(),
//                 TextColumn::make('level.grade')
//                     ->searchable(),
//                 TextColumn::make('classroom.name')
//             ])
//             ->filters([
//                 Filter::make('class')
//                     ->query(function ($query) {
//                         if ($this->level) {
//                             $query->where('level_id', $this->level);  // Filter the table based on the selected class
//                         }
//                     }),
//                 Filter::make('section')
//                     ->query(function ($query) {
//                         if ($this->classroom) {
//                             $query->where('classroom_id', $this->classroom);  // Filter the table based on the selected class
//                         }
//                     }),
//             ], layout: FiltersLayout::AboveContent)
//              ->bulkActions([
//                 BulkAction::make('ff')
//                     ->button()
//                     ->action(function (Collection $records) {
//                         session(['selected_records' => $records->pluck('id')]);
//                         return redirect()->route('students-result');
//             })
//             ]);
//     }

//     public function back()
//     {
//         $this->createResult = true;
//         $this->makeResult = false;
//         $this->createNext = false;
//     }
//     public function next()
//     {
//         $this->validate([
//             'classroom' => 'required',
//             'level' => 'required',
//             'exam' => 'required',
//         ]);

//         session()->put([
//             'faculty' => $this->faculty,
//             'level' => $this->level,
//             'exam' => $this->exam,
//             'classroom' => $this->classroom,
//         ]);
//         $this->createResult = false;
//         $this->createNext = true;
//     }
//     public function result()
//     {
//         $this->validate([
//             'classroom' => 'required',
//             'level' => 'required',
//             'exam' => 'required',

//         ]);

//         session()->put([
//             'faculty' => $this->faculty,
//             'level' => $this->level,
//             'exam' => $this->exam,
//             'classroom' => $this->classroom,
//         ]);
//         $this->createResult = false;
//         $this->createNext = false;
//         $this->makeResult = true;
//     }
//     public function submit() {}
// }

class ResultPage extends Page implements HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public $level;
    public $exam;
    public $classroom;
    protected static string $view = 'filament.pages.result-page';

    public function mount()
    {
        // $this->level = session('level');
        // $this->classroom = session('classsroom');
        // dd($this->level. ' level');
    }
    public function table(Table $table): Table
    {
        return $table
            ->query(Student::inActiveBatch()
                ->where('level_id', session('level')))
            // ->query(Mark::query()->when($this->level, fn($q)=> $q->where('level_id', $this->level))
            // ->when($this->exam, fn($q)=> $q->where('exam_id', $this->exam))
            // ->when($this->classroom, fn($q)=> $q->where('classroom_id', $this->classroom)))
            ->columns([
                TextColumn::make('first_name')
                    ->label('Name')
                    ->getStateUsing(fn($record) => $record ? $record->first_name . ' ' . $record->last_name : 'N/A')
                    ->searchable(),
                TextColumn::make('roll_no')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('level.grade')
                    ->searchable(),
                TextColumn::make('classroom.name')
            ])
            ->filters([], layout: FiltersLayout::AboveContent)
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('export'),
                    // Exporter::getColumns()

                    BulkAction::make('Marksheet')

                        ->action(function (Collection $records) {
                            
                             $pdf = Pdf::loadHTML(
                                    Blade::render('studentsresult', ['stds' => $records])
                                );
                                
                        file_put_contents(public_path('myfiles/certificate.pdf'), $pdf->output());
                        return response()->download(public_path('myfiles/certificate.pdf'));

                           
                        }),
                ]),
                BulkAction::make('Certificate')
                    ->button()
                    ->action(function (Collection $records) {
                        session(['selected_records' => $records->pluck('id')]);
                        return redirect()->route('students-result');
                    })
            ]);
    }
    public function Result() {}
}
