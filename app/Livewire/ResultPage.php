<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\Student;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\CreateAction;
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
    public $batch;

    public function mount(){
        $exam = session('exam');
        $batch = Exam::find($exam);
        $this->batch = $batch->batch_id;
    }
    public function table(Table $table): Table
    {
        return $table
        ->query(Student::query()->where('level_id', session('level'))
            ->where('batch_id', $this->batch)
          ->where('classroom_id', session('classroom')))

       ->columns([
           TextColumn::make('first_name')
               ->label('Name')
               ->getStateUsing(fn($record) => $record ? $record->first_name . ' ' . $record->last_name : 'N/A')
               ->searchable(),
           TextColumn::make('roll_no')
               ->searchable(),
           TextColumn::make('level.grade')
               ->searchable(),
            TextColumn::make('classroom.name'),
       ])
       ->actions([
           Action::make('make')
           ->icon('heroicon-s-pencil')
           ->accessSelectedRecords()
           ->url(fn($record)=> route('student.show', $record))
           ->openUrlInNewTab()
           ->requiresConfirmation(),
           Action::make('rsult'),
            
    ])
    ->headerActions([
        Action::make('results') 
    ])

    ->bulkActions([
        BulkAction::make('ff')
        ->button()
        ->action(function (Collection $records) {
            session(['selected_records' => $records->pluck('id')]);
            return redirect()->route('students-result');
        })
    
    ]);
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
