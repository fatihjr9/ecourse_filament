<x-filament-panels::page>
    @if($courses->isEmpty())
        <p>You haven't purchased any courses yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            @foreach($courses as $course)
                <div class="border border-slate-100 rounded-lg w-fit">
                    <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="Image" class="">
                    <div class="p-4 flex flex-col">
                        <p class="font-bold text-lg dark:text-orange-500">{{ $course->nama }}</p>
                        <p>{{ $course->deskripsi }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</x-filament-panels::page>
