<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubCourseResource\Pages;
use App\Filament\Resources\SubCourseResource\RelationManagers;
use App\Models\SubCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SubCourseResource extends Resource
{
    protected static ?string $model = SubCourse::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Hidden::make("course_id")->default(
                fn($livewire) => $livewire->ownerRecord->course_id ??
                    request()->get("course")
            ),
            Forms\Components\TextInput::make("judul")
                ->required()
                ->label("Judul"),
            Forms\Components\TextInput::make("link")->required()->label("Link"),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([Tables\Actions\EditAction::make()])
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
    public static function shouldRegisterNavigation(
        array $parameters = []
    ): bool {
        return false;
    }
    public static function getPages(): array
    {
        return [
            "index" => Pages\ListSubCourses::route("/"),
            "create" => Pages\CreateSubCourse::route("/create"),
            "edit" => Pages\EditSubCourse::route("/{record}/edit"),
        ];
    }
}
