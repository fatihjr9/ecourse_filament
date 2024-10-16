<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";
    protected static ?string $navigationLabel = "Kursus";

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make("nama")->required(),
            TextInput::make("harga")->required(),
            FileUpload::make("thumbnail")
                ->directory("course-thumbnails") // specify the directory if needed
                ->image()
                ->maxSize(1024),
            Textarea::make("deskripsi")->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make("thumbnail"),
                Tables\Columns\TextColumn::make("nama")->searchable(),
                Tables\Columns\TextColumn::make("harga"),
                Tables\Columns\TextColumn::make("deskripsi"),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            "index" => Pages\ListCourses::route("/"),
            "create" => Pages\CreateCourse::route("/create"),
            "view" => Pages\ViewCourse::route("/{record}"),
            "edit" => Pages\EditCourse::route("/{record}/edit"),
        ];
    }
}
