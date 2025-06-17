<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\studentsTotal;
use App\Models\Batch;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Subject;
use App\Models\Type;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Page;


class Markspage extends Page
{

    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-plus';
    protected static ?string $navigationGroup = 'Exam-Setup';
    protected static ?string $title = 'Marks Entry';
    protected static string $view = 'filament.pages.markspage';

    public $level;
    public $classroom;
    public $faculty;
    public $exam;
    public $subject;
    public $createMark = true;
    public $createNext = false;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('exam')
                    ->label("Exam Id")
                    ->reactive()
                    ->required()
                    ->options(fn()=>
                        Exam::whereHas('batch', function ($q) {
                            $q->where('is_active', true);
                        })->pluck('name', 'id')),
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
                        $set('subject', null);
                    }),
                
                Select::make('subject')
                ->label("Subject")
                ->options(fn(Get $get) => Subject::whereHas('levels', function ($query) use ($get) {
                    $query->where('level_id', $get('level'));
                })
                ->pluck('name', 'id'))
                ->reactive(), 
                Select::make('classroom')
                    ->options(fn(Get $get) => Classroom::where('level_id', (int) $get('level'))->pluck('name', 'id'))
                    ->reactive() // This makes the subcategory field update reactively
            ])
            ->columns(3)
        ;
    }
    public function next()
    {
        $this->validate([
            'subject'=>'required',
            'classroom'=>'required',
            'level'=>'required',
            'exam'=>'required',
            
        ]);
       
      session()->put([
        'faculty'=>$this->faculty,
        'subject'=>$this->subject,
        'level'=>$this->level,
        'exam'=>$this->exam,
        'classroom'=>$this->classroom,
    ]);
    // dd(session()->all());

    $this->createMark = false;
    $this->createNext = true;
    
    }
    public function back(){
        $this->createNext = false;
        $this->createMark = true;
    }

}
