<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Batch;
use App\Models\Classroom;
use App\Models\Level;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('batches', function ($query) {
                $query->where('is_active', true);
            });
    }

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('father_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mother_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date_of_birth_AD'),
                Forms\Components\DatePicker::make('date_of_birth_BS')
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->reactive()
                    ->afterStateUpdated(function (callable $set){
                        $set('level_id', null);
                    })
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'grade')
                    ->reactive()
                    ->options(fn(Get $get) => Level::where('faculty_id', (int) $get('faculty_id'))->pluck('grade', 'id'))
                    ->afterStateUpdated(function (callable $set){
                        $set('classroom_id', null);
                    })
                    ->required(),
                Forms\Components\Select::make('batch_id')
                    ->relationship('batch', 'name')
                    ->label('Joined Year')
                    ->required(),
                Forms\Components\Select::make('batches')
                    ->label('Current Batch')
                    ->relationship('batches', 'name')
                    ->multiple()
                    ->preload(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('gender')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('roll_no')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->options(fn(Get $get) => Classroom::where('level_id', (int) $get('level_id'))->pluck('name', 'id'))
                    ->required(),
                Forms\Components\Select::make('caste_id')
                    ->relationship('caste', 'name')
                    ->required(),
                Forms\Components\Select::make('religion_id')
                    ->relationship('religion', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Full Name')
                    ->searchable()
                    ->getStateUsing(fn($record) => "{$record->first_name} {$record->middle_name} {$record->last_name}"),
                Tables\Columns\TextColumn::make('father_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth_BS')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('level.grade')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone')
                    ->sortable(),

                Tables\Columns\TextColumn::make('roll_no')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('classroom.name')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('Level')
                    ->label('Filter by Class')
                    ->searchable()
                    ->preload()
                    ->relationship('level', 'grade'),
                SelectFilter::make('classroom')
                    ->label('Filter by Section')
                    ->searchable()
                    ->preload()
                    ->relationship('classroom', 'name')
            ], layout: FiltersLayout :: AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('upgrade')
                    ->icon('heroicon-o-sparkles')
                    ->color('primary')
                    ->action( function( Collection $records){
                        $newYear = Batch::max('id');
                        // dd($newYear);
                      
                        foreach( $records as $student){
                            // dd($student->level);
                            $nextLevel = Level::where('level', $student->level->level + 1)->first();
                            // dd($nextLevel);
                           if($nextLevel){
                            $student->level_id = $nextLevel->id;
                            $student->batches()->attach($newYear);
                            $student->save();
                           
                           }
                        }
                    })
                ]),
               
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),

        ];
    }
}
