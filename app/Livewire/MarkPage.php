<?php

namespace App\Livewire;

use App\Models\Batch;
use App\Models\Classroom;
use App\Models\Esetup;
use App\Models\Exam;
use App\Models\Level;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Type;
use App\Models\User;
use Livewire\Component;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MarkPage extends Component implements Forms\Contracts\HasForms, Tables\Contracts\HasTable
{
    use Forms\Concerns\InteractsWithForms;
    use Tables\Concerns\InteractsWithTable;

    public $full_mark;
    public $Esetup;
    public $pass_mark;
    public $mark;
    public $roll_no;
    public $student_id;
    public $student;
    public $level;
    public $batch;
    public $classroom;
    public $exam;
    public $subject;
    public $rolll;
    public function mount(): void
    {
        $subjectId = session('subject');
        $this->Esetup = Esetup::where('exam_id', session('exam'))
            ->where('level_id', session('level'))
            ->where('faculty_id', session('faculty'))
            ->whereHas('subjects', function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            })
            ->first();
        // dd($this->Esetup);

        $this->subject = Subject::where('id', session('subject'))->first()->name;
        $this->level = Level::where('id', session('level'))->first()->grade;
        $this->classroom = Classroom::where('id', session('classroom'))->first()->name;
        $this->exam = Exam::where('id', session('exam'))->first()->name;
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Marks Entry')
                    ->description(fn() => "Subject: {$this->subject} ,Class: {$this->level} ,Section: {$this->classroom}")
                    ->schema([
                        // TextInput::make('roll_no')
                        //     ->label('Roll No.')
                        //     ->afterStateUpdated(function ($state) {
                        //         if (!$state) {
                        //             $this->student = null;
                        //             return;
                        //         }
                        //         $class = session('level');
                        //         $batch = session('batch');
                        //         $classroom = session('classroom');
                        //         $student = Student::where('roll_no', $state)
                        //             ->where('level_id', $class)
                        //             ->where('classroom_id', $classroom)
                        //             ->first();
                        //         if ($student) {
                        //             $this->student_id = $student->id;
                        //             $this->student = $student->first_name  . " " .  $student->middle_name  . " " .  $student->last_name;
                        //         } else {
                        //             $this->student = "Student not found !!!!!";
                        //             $this->student_id = null;
                        //         }
                        //     })
                        //     ->reactive(),
                        Select::make('roll_no')
                            ->label('Roll No.')
                            ->reactive()
                            ->afterStateUpdated(function ($state) {
                                $class = session('level');
                                $batch = session('batch');
                                $classroom = session('classroom');
                                $student = Student::inActiveBatch()->where('roll_no', $state)
                                    ->where('level_id', $class)
                                    ->where('classroom_id', $classroom)
                                    ->first();
                                if ($student) {
                                    $this->student_id = $student->id;
                                    $this->student = $student->first_name  . " " .  $student->middle_name  . " " .  $student->last_name;
                                }
                            })
                            ->options(fn() =>
                            Student::inActiveBatch()->where('level_id', session('level'))
                                ->where('classroom_id', session('classroom'))->get()
                                // ->pluck('first_name','roll_no')),
                                ->mapWithKeys(fn($student) => [$student->roll_no => "{$student->roll_no} {$student->first_name} {$student->middle_name} {$student->last_name}"])),

                        // Select::make('name')
                        // ->options(fn()=> 
                        //     Student::query()->where('level_id', session('level'))
                        //     ->where('classroom_id', session('classroom'))->get()
                        //     // ->pluck('first_name','id')),
                        //     ->mapWithKeys(fn($student)=>[$student->id => "{$student->first_name} {$student->middle_name} {$student->last_name}"])),

                        // TextInput::make('student')

                        //     ->label('Student Name')
                        //     ->disabled(),
                        TextInput::make('mark')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue($this->Esetup->Tr_full_mark)
                            ->label('Obtained Mark'),
                    ])
                    ->columns(2)

            ]);
    }

    // private function fetchNameByRollNo($rollNo): ?string
    // {
    //     $studentName = Student::where('roll_no', $rollNo)->first();
    //     return $studentName;
    // }

    public function submit()
    {
        if ($this->Esetup) {

            $validator = Validator::make($this->only(['roll_no', 'mark', 'student_id']), [
                'roll_no' => [
                    'required',
                    Rule::unique('marks', 'roll_no')
                        ->where('level_id', session('level'))
                        ->where('subject_id', session('subject'))
                        ->where('classroom_id', session('classroom')),
                ],
                'mark' => 'required',
                'student_id' => 'required',
            ]);
            if ($validator->fails()) {
                // dd($validator->errors()->all());
                Notification::make()
                    ->title('Failed!')
                    ->body(implode($validator->errors()->all()))
                    ->danger()
                    ->send();

                // dd($validator);
            } else {
                $mark = new Mark();
                $mark->student_id = $this->student_id;
                $mark->roll_no = $this->roll_no;
                $mark->level_id = session('level');
                $mark->subject_id = session('subject');
                $mark->classroom_id = session('classroom');
                $mark->exam_id = session('exam');
                $mark->full_mark = $this->Esetup->Tr_full_mark;
                $mark->pass_mark = $this->Esetup->Tr_pass_mark;
                $mark->marks = $this->mark;
                $mark->save();

                $roll = $this->roll_no;
                $name = $this->student;
                Notification::make()
                    ->title('Success!')
                    ->body("Marks of the Roll no.{$roll} Name with <strong>{$name}</strong>  <br>has submitted succesfully !")
                    ->success()
                    ->send();
                $this->reset(['mark', 'student', 'roll_no']);
            }
        }
        // dd('click');
        else {
            Notification::make()
                // ->duration(300)
                ->title('Failed!')
                ->body("Data not found in Exam Setup !")
                ->danger()
                ->send();
        }
        // dd($this->student->id);

    }

   
    public function table(Table $table): Table
    {
        return $table
            ->query(Mark::query()->where('level_id', session('level'))
                ->where('classroom_id', session('classroom'))
                ->where('exam_id', session('exam'))
                ->where('subject_id', session('subject')))

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
                // Filter::make('is_varified')
                //     ->query(fn(Builder $query) => $query->whereNotNull('email_verified_at'))
            ])
            ->actions([
                EditAction::make('Edit')
                    ->form([
                        TextInput::make('roll_no'),
                        TextInput::make('marks')
                            ->numeric()
                            ->maxValue($this->Esetup->Tr_full_mark),
                    ]),
                // ->mountUsing(function (Form $form, User $record) {
                //     $form->fill([
                //         'name' => $record->name,
                //         'email' => $record->email,
                //     ]);
                // })
                // ->action(function (array $data, User $record): void {
                //     $record->update($data);

                //     Notification::make()
                //         ->success()
                //         ->title('Date updated')
                //         ->send();
                // }),
                Action::make('delete')
                    ->action(function (Mark $record) {
                        $record->delete();

                        Notification::make()
                            ->success()
                            ->title('REcord Deleted !')
                            ->send();
                    })
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                ]),
            ]);
    }
    public function render()
    {
        return view('livewire.mark-page');
    }
}
