<?php

namespace App\Livewire;

use App\Models\Esetup;
use App\Models\Exam;
use App\Models\Mark;
use App\Models\Student;
use Filament\Actions\Action as ActionsAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

class ResultPage extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public $fm;
    public function mount()
    {
        $subjectId = session('subject');
        $this->fm = Esetup::where('exam_id', session('exam'))
            ->where('level_id', session('level'))
            ->where('faculty_id', session('faculty'))
            ->whereHas('subjects', function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            })
            ->value('Tr_full_mark');
     
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
            ->actions([

                ActionsEditAction::make('edit')
                    ->form([
                        TextInput::make('roll_no'),
                        TextInput::make('marks')
                            ->numeric()
                            ->maxValue($this->fm)
                            ->required()
                    ]),
            ])->actionsColumnLabel('Actions');
    }
    protected function getHeaderActions(): array
    {
        return [
            ActionsAction::make('edit'),
            // ->url(route('posts.edit', ['post' => $this->post])),

        ];
    }



    public function render()
    {
        return view('livewire.result-page');
    }
}
