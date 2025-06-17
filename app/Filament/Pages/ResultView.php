<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\Faculty;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Student;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ResultView extends Page
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.result-view';

    public $exam;
    public $faculty;
    public $level;
    public $classroom;
    public $roll_no;

    public function mount(){
        $this->form->fill([
            'level' => session('level'),
            'exam' => session('exam'),
            'classroom'=> session('classroom')
        ]);
    }
    public function form(Form $form): Form
    {

        return $form->schema([
            Tabs::make('User Details')
                ->tabs([
                    Tabs\Tab::make('Basic Info')->schema([
                        Grid::make(3)->schema([
                            Select::make('exam')
                                ->label('Exam Id')
                                ->reactive()
                                ->options(
                                    Exam::inActiveBatch()->get()->pluck('name', 'id')
                                ),
                            Select::make('level')
                                ->label('Grade')
                                ->reactive()
                                ->options(
                                    // if($this->faculty){
                                        //     Level::where('faculty_id', (int) $get('faculty'))->pluck('grade', 'id');          
                                        // }
                                        Level::all()->pluck('grade','id')
                                        )
                                        ->default(4)
                                        ->afterStateUpdated(function (callable $set) {
                                            $set('classroom', null);
                                        }),
                            Select::make('classroom')
                                ->label('Section')
                                ->reactive()
                                ->options(fn(Get $get) => Classroom::where('level_id', (int) $get('level'))->pluck('name', 'id')),
                            TextInput::make('roll_no')
                                ->label('Roll No')
                                ->numeric()
                        ]),
                    ]),
                ]),


        ]);
    }
    public function Submit(){
        $this->validate([
            'level' => 'required',
            'exam' => 'required',
        ]);

        session()->put([
            'level' => $this->level,
            'exam' => $this->exam,
            'classroom' => $this->classroom,
        ]);
        if($this->roll_no){
            // return 123;
            dd(34343);
        }
        return redirect()->route('filament.admin.pages.result-page');
    }
}
