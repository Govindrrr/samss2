<?php

namespace App\Filament\Pages;

use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Mark;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
class ResultPage extends Page implements HasTable
{
    
    use InteractsWithForms;
    use InteractsWithTable;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $title = 'Result';
    protected static string $view = 'filament.pages.result-page';


    public $faculty;
    public $level;
    public $exam;
    public $classroom;
    public $makeResult = false;
    public $createResult = true;
    public $createNext = false;

    public function form(Form $form): Form
    {
        return $form->schema([
            Select::make('exam')
            ->label("Exam Id")
            ->reactive()
            ->required()
            ->options(
                Exam::all()->pluck('name', 'id'))
            ->default(function () {
               return Exam::where('id','desc')->first();       
            }),
        Select::make('faculty')
            ->label("Faculty")
            ->reactive()
            ->options(
                Faculty::all()->pluck('name', 'id')
            )
            ->afterStateUpdated(function (callable $set) {
                $set('level', null);
            }),
            
        Select::make('level')
            ->label("Class")
            ->reactive() // Make it reactive based on faculty
            ->options(fn(Get $get) => Level::where('faculty_id', (int) $get('faculty'))->pluck('grade', 'id'))
            ->afterStateUpdated(function (callable $set) {
                $set('classroom', null);
            }),
        Select::make('classroom')
            ->options(fn(Get $get) => Classroom::where('level_id', (int) $get('level'))->pluck('name', 'id'))
            ->reactive() // This makes the subcategory field update reactively
    ])
    ->columns(4);
    }

    public function table(Table $table): Table
    {
        return $table
        ->query(Mark::query()->where('level_id', session('level'))
        ->where('exam_id', session('exam'))
        ->where('classroom_id', session('classroom')))
        ->columns([
            TextColumn::make('student.first_name')
            ->label('Name')
            ->getStateUsing(fn($record) => $record->student ? $record->student->first_name . ' ' . $record->student->last_name : 'N/A')
            ->searchable(),
        TextColumn::make('roll_no')
            ->searchable(),
        TextColumn::make('subject.name')
            ->searchable(),
        TextColumn::make('marks')
            ->searchable(),
        ])
        ->filters([
            SelectFilter::make('subject_id')
            ->options(function () {
                return Mark::join('subjects', 'marks.subject_id', '=', 'subjects.id')
                ->where('marks.level_id', session('level'))
                ->where('marks.exam_id', session('exam'))
                ->distinct()
                ->pluck('subjects.name', 'subjects.id');})
            ->label('Filter by Subjects')
            ->preload(),
            SelectFilter::make('classroom_id')
            ->options(function () {
                return Mark::join('classrooms', 'marks.classroom_id', '=', 'classrooms.id')
                ->where('marks.classroom_id', session('classroom'))
                ->where('marks.exam_id', session('exam'))
                ->distinct()
                ->pluck('classrooms.name', 'classrooms.id');})
            ->label('Filter by Subjects')
            ->preload(),
        ], layout: FiltersLayout :: AboveContent)
        ->bulkActions([
            BulkActionGroup::make([
            DeleteBulkAction::make(),
            ]),
        ]);

    }

    public function back(){
        $this->createResult = true;
        $this->makeResult = false;
        $this->createNext = false;
    }
    public function next(){
        $this->validate([
            'classroom'=>'required',
            'level'=>'required',
            'exam'=>'required',
            
        ]);
       
      session()->put([
        'faculty'=>$this->faculty,
        'level'=>$this->level,
        'exam'=>$this->exam,
        'classroom'=>$this->classroom,
    ]);
        $this->createResult = false;
        $this->createNext = true;
    }
    public function result(){
        $this->validate([
            'classroom'=>'required',
            'level'=>'required',
            'exam'=>'required',
            
        ]);
       
      session()->put([
        'faculty'=>$this->faculty,
        'level'=>$this->level,
        'exam'=>$this->exam,
        'classroom'=>$this->classroom,
    ]);
        $this->createResult = false;
        $this->createNext = false;
        $this->makeResult = true;
    }
    public function submit(){

    }
}
