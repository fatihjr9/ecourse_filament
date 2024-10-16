<?php

namespace App\Filament\Resources\SubCourseResource\Pages;

use App\Filament\Resources\SubCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubCourse extends EditRecord
{
    protected static string $resource = SubCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
