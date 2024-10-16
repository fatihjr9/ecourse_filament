<x-filament-panels::page>
    @if($this->record->subCourses->isEmpty())
        <p>Belum ada materi</p>
    @else
        @foreach($this->record->subCourses as $subCourse)
            <div class="px-4 py-2 border rounded-lg flex flex-row items-center justify-between">
                <a href="{{ $subCourse->link }}" target="_blank">
                    {{ $subCourse->judul }}
                </a>
                <a href="{{ route('filament.course.resources.sub-courses.edit',$subCourse->id ) }}" class="bg-red-500 p-2">
                    Edit
                </a>
            </div>
        @endforeach
    @endif
</x-filament-panels::page>
