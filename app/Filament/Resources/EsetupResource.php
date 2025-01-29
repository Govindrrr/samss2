<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EsetupResource\Pages;
use App\Filament\Resources\EsetupResource\RelationManagers;
use App\Models\Esetup;
use App\Models\Level;
use App\Models\Subject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EsetupResource extends Resource
{
    protected static ?string $model = Esetup::class;
    protected static ?string $navigationGroup = 'Exam-Setup';
    protected static ?string $modelLabel = 'Exam-setup';
    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Tr_full_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Tr_pass_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Pr_full_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('Pr_pass_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('exam_id')
                    ->relationship('exam', 'name')
                    ->required(),
                Forms\Components\Select::make('faculty_id')
                    ->relationship('faculty', 'name')
                    ->reactive()
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'grade')
                    ->required()
                    ->options(function( callable $get){
                        $facultyId = $get('faculty_id');

                        if(!$facultyId){
                            return [];
                        }
                        else{
                            return Level::where('faculty_id', $facultyId)
                            ->pluck('grade','id');
                        }
                    })
                    ->reactive(),
                    // ->afterStateUpdated(fn($set) => $set('level_id', null)),
                Forms\Components\Select::make('subjects')
                ->relationship('subjects','name')
                ->required()
                ->multiple()
                ->preload()
                ->options(function( callable $get){
                    $levelId = $get('level_id');
                    if(!$levelId){
                        return [];
                    }
                        return Subject::whereHas('levels', function ($query) use ($levelId){
                            $query->where('level_id', $levelId);
                        })->pluck('name','id');
                })
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Tr_full_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Tr_pass_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Pr_full_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Pr_pass_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exam.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('faculty.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.id')
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListEsetups::route('/'),
           
        ];
    }
}
