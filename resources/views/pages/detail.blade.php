@extends('layout.index')
@section('content')
    <section class="flex flex-col lg:flex-row justify-between items-start gap-8">
        <section class="w-10/12">
            <div class="p-2 bg-white rounded-lg border border-zinc-200" id="video-container">
                <div id="video-display">
                    <img src="{{ asset('storage/'.$courses->thumbnail) }}" alt="{{ $courses->nama }}" class="w-full h-96 p-2 rounded-xl object-cover">
                </div>
            </div>
            <div class="mt-4">
                <p class="text-gray-400 text-sm">Deskripsi Kursus</p>
                <h5 class="mb-4">{{ $courses->deskripsi }}</h5>
            </div>
            <div class="mt-4">
                <p class="text-gray-400 text-sm">Materi Kursus</p>
                @if($courses->subCourses->count() > 0)
                    @foreach ($courses->subCourses as $index => $subcourse)
                        <a href="#"
                            class="subcourse-link truncate mb-1 block p-2 rounded bg-slate-100 transition-colors {{ $index === 0 ? ' active text-gray-900 font-semibold bg-white border' : 'text-gray-600 pointer-events-none opacity-50' }}"
                            data-title="{{ $subcourse->judul }}"
                            data-link="{{ $subcourse->link }}">
                            {{ $subcourse->judul }}
                        </a>
                    @endforeach
                @else
                    <p>Materi belum ditambahkan.</p>
                @endif
                @if($courses->subCourses->count() > 0)
                    <div class="bg-gray-100 text-gray-500 border border-zinc-200 px-4 py-2 flex flex-col mb-1">
                        <p class="font-semibold text-center">{{ $total }} Video lainnya</p>
                    </div>
                @elseif($courses->subCourses->count() < 4)
                    <div class="bg-gray-100 text-gray-500 border border-zinc-200 px-4 py-2 flex flex-col mb-1">
                        <p class="font-semibold text-center">0 Video lainnya</p>
                    </div>
                @else
                    <p class="hidden">Materi belum ditambahkan.</p>
                @endif
            </div>
        </section>
        <section class="flex flex-col space-y-4 w-full lg:w-4/12 ml-auto">
            <div class="p-6 bg-white border rounded-xl h-fit">
                <div class="flex flex-row items-center justify-between border-b">
                    <div>
                        <p class="text-gray-400 text-sm">Nama Kursus</p>
                        <h5 class="mb-4 text-xl font-medium">{{ $courses->nama }}</h5>
                    </div>
                    <div>
                        <p class="text-gray-400 text-sm">Harga</p>
                        <h5 class="mb-4 text-xl font-semibold">Rp {{ number_format($courses->harga, 0, ',', '.') }}</h5>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-x-2 divide-x mt-2">
                    <div class="flex flex-row items-center gap-x-1 justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                        <h5 class="text-gray-600">{{ $totalSubCourses }} Video</h5>
                    </div>
                    <div class="flex flex-row items-center gap-x-1 justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <h5 class="text-gray-600">{{ \Carbon\Carbon::parse($courses->created_at)->translatedFormat('d F Y') }}</h5>
                    </div>
                </div>
                <div class="mt-6 flex flex-col space-y-2">
                    @if($isPaid)
                        <a href="{{ route('filament.course.pages.kursus-saya') }}" class="py-3 text-center rounded-xl w-full bg-black text-white">Lanjutkan Belajar</a>
                    @else
                    <form action="{{ route('cart.add', $courses->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="py-3 rounded-xl w-full bg-black text-white">Tambahkan ke keranjang</button>
                    </form>
                    @endif

                    <!-- Menampilkan pesan sukses jika kursus berhasil ditambahkan -->
                    @if (session('message'))
                        <div class="alert alert-success mt-2">
                            {{ session('message') }}
                        </div>
                    @endif
                    <a href="{{ route('index') }}" class="py-3 text-center rounded-xl w-full bg-gray-100 text-black">Kembali</a>
                </div>
            </div>
            <div class="p-6 bg-white border rounded-xl h-fit">
                <div class="flex flex-col border-b">
                    <h5 class="mb-4 text-xl font-medium">Kursus lainnya</h5>
                    <div>
                    @if ($relatedCourses->isNotEmpty())
                        @foreach($relatedCourses as $c)
                            <div class="w-full bg-white rounded-xl border border-zinc-200 flex items-center">
                                <img class="w-36 h-28 rounded-tl-xl rounded-bl-xl" src="{{ asset('storage/' . $c->thumbnail) }}" alt="{{ $c->nama }}" />
                                <div class="w-full ml-4">
                                    <div>
                                        <h5 class="font-medium">{{ $c->nama }}</h5>
                                        <p class="text-gray-400">{{ $c->deskripsi }}</p>
                                    </div>
                                    <h5 class="text-lg font-semibold">Rp{{ number_format($c->harga, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>Tidak ada kursus lain.</p>
                    @endif
                    </div>
                </div>
            </div>
        </section>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const subcourseLinks = document.querySelectorAll('.subcourse-link');
            const videoDisplay = document.getElementById('video-display');

            function updateVideoDisplay(title, videoLink) {
                // Mengambil video ID dari link YouTube
                const videoId = new URL(videoLink).searchParams.get('v');
                videoDisplay.innerHTML = `
                    <iframe class="w-full h-96 rounded-lg" width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>
                `;
            }

            // Menampilkan video untuk subcourse pertama saat halaman dimuat
            const firstSubcourse = document.querySelector('.subcourse-link.active');
            if (firstSubcourse) {
                const title = firstSubcourse.getAttribute('data-title');
                const videoLink = firstSubcourse.getAttribute('data-link');
                updateVideoDisplay(title, videoLink);
            }

            // Tambahkan event listener hanya jika link tidak di-disable
            subcourseLinks.forEach(link => {
                if (!link.classList.contains('pointer-events-none')) {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();

                        // Menghapus kelas 'active' dari semua link
                        subcourseLinks.forEach(l => l.classList.remove('active', 'bg-gray-200', 'text-gray-900', 'font-semibold'));
                        this.classList.add('active', 'bg-gray-200', 'text-gray-900', 'font-semibold');

                        const title = this.getAttribute('data-title');
                        const videoLink = this.getAttribute('data-link');
                        updateVideoDisplay(title, videoLink);
                    });
                }
            });
        });
    </script>
@endsection
