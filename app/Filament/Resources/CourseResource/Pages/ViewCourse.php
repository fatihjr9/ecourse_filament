<?php

namespace App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\SubCourseResource;
use App\Filament\Resources\CourseResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Course;
use Filament\Actions;

class ViewCourse extends ViewRecord
{
    protected static string $resource = CourseResource::class;
    protected static string $view = "filament.resources.course-resource.pages.view-course";

    public function getTitle(): string
    {
        return $this->record->nama;
    }

    public function mount(int|string $record): void
    {
        $this->record = Course::findOrFail($record);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label("Hapus Kursus"),
            Actions\CreateAction::make()->label("Tambah Materi")->url(
                fn() => SubCourseResource::getUrl("create", [
                    "course" => $this->record->id,
                ])
            ),
        ];
    }
}
