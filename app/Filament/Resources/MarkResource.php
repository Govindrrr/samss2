<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MarkResource\Pages;
use App\Filament\Resources\MarkResource\RelationManagers;
use App\Models\Mark;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MarkResource extends Resource
{
    protected static ?string $model = Mark::class;
    protected static ?string $navigationGroup = 'Exam-Setup';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('roll_no')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('marks')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pass_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('full_mark')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('pr_full_mark')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('pr_pass_mark')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('pr_marks')
                    ->numeric()
                    ->default(null),
                Forms\Components\Select::make('exam_id')
                    ->relationship('exam', 'name')
                    ->required(),
                Forms\Components\Select::make('student_id')
                    ->relationship('student', 'first_name')
                    ->required(),
                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'grade')
                    ->required(),
                Forms\Components\Select::make('subject_id')
                    ->relationship('subject', 'name')
                    ->required(),
                Forms\Components\Select::make('classroom_id')
                    ->relationship('classroom', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('roll_no')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pass_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pr_full_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pr_pass_mark')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pr_marks')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('exam.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('student.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('level.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject.name')
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListMarks::route('/'),
            'create' => Pages\CreateMark::route('/create'),
            'view' => Pages\ViewMark::route('/{record}'),
            'edit' => Pages\EditMark::route('/{record}/edit'),
        ];
    }
}
