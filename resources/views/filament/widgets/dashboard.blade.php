<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-row items-center justify-between">
            <div>
                <h5 class="font-bold">Halo, {{ Auth::user()->name }}</h5>
                <p>Lorem ipsum sit dolor amet</p>
            </div>
            <x-filament::link href="{{ route('index') }}">
                Halaman Utama
            </x-filament::link>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
