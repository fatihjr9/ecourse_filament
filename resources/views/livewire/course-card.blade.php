<div class="grid grid-cols-2 lg:grid-cols-5 gap-x-3">
    @foreach($courses as $item)
        <div class="border rounded-lg bg-white">
            <img src="{{ asset('storage/'.$item->thumbnail) }}" alt="Image" class="w-full h-60 p-2 rounded-xl">
            <div class="p-4 flex flex-col">
                <p>{{ $item->nama }}</p>
                <p class="font-bold">Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
                <a href="{{ route('detail',$item->id) }}" class="bg-orange-500 text-center mt-2 text-white w-full rounded-xl py-2">Detail Kursus</a>
            </div>
        </div>
    @endforeach
</div>
