<?php

namespace App\Filament\Resources\SubCourseResource\Pages;

use App\Filament\Resources\SubCourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubCourses extends ListRecords
{
    protected static string $resource = SubCourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
