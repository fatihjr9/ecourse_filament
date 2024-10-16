<x-filament-panels::page>
    <x-filament::grid style="--cols-lg: repeat(2, minmax(0, 1fr));" class="lg:grid-cols-[--cols-lg] gap-4">
        <x-filament::card>
            <div id="video-display">
                <img src="{{ asset('storage/'.$course->thumbnail) }}" alt="{{ $course->nama }}" class="w-full h-96 p-2 rounded-xl object-cover">
            </div>
        </x-filament::card>
        <x-filament::card>
            <div class="mt-4">
                <p class="text-gray-400 font-medium mb-4">Materi Kursus</p>
                <div class="h-72 overflow-y-scroll rounded-lg">
                    @if($subCourses->count() > 0)
                        @foreach ($subCourses as $index => $subcourse)
                            <a href="#"
                                class="subcourse-link truncate mb-3 block p-4 rounded-lg transition-colors border"
                                data-title="{{ $subcourse->judul }}"
                                data-link="{{ $subcourse->link }}">
                                {{ $subcourse->judul }}
                            </a>
                        @endforeach
                    @else
                        <p>Materi belum ditambahkan.</p>
                    @endif
                </div>
            </div>
        </x-filament::card>
    </x-filament::grid>
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
                        subcourseLinks.forEach(l => l.classList.remove('active', 'bg-blue-50', 'text-blue-500', 'font-semibold'));
                        this.classList.add('active', 'bg-blue-50', 'text-blue-500', 'font-semibold');

                        const title = this.getAttribute('data-title');
                        const videoLink = this.getAttribute('data-link');
                        updateVideoDisplay(title, videoLink);
                    });
                }
            });
        });
    </script>
</x-filament-panels::page>
