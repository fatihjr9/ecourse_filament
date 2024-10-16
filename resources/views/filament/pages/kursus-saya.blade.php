<x-filament-panels::page>
    @if($courses->isEmpty())
        <div class="flex flex-col w-4/12 mx-auto">
            <img src="{{ asset('empty.svg') }}"/>
            <p class="text-center mt-2">Kamu Belum memiliki kelas</p>
            <x-filament::link href="{{ route('index',) }}" class="block mt-4 py-2 font-bold bg-blue-50 rounded-lg">
                <span class="w-full">Ekplor kelas sekarang</span>
            </x-filament::link>
        </div>
    @else
        <x-filament::grid style="--cols-lg: repeat(4, minmax(0, 1fr));" class="lg:grid-cols-[--cols-lg]">
            @foreach($courses as $course)
                <x-filament::card>
                    <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="Image" class="">
                    <div class="flex flex-col mt-4">
                        <p class="font-bold text-lg">{{ $course->nama }}</p>
                        <p class="mb-4">{{ $course->deskripsi }}</p>
                        <x-filament::link href="{{ route('kursus-saya.detail', $course->id) }}" class="block py-2 font-bold bg-blue-50 rounded-lg">
                            <span class="w-full"> Belajar Sekarang</span>
                        </x-filament::link>
                    </div>
                </x-filament::card>
            @endforeach
        </x-filament::grid>
    @endif
</x-filament-panels::page>
