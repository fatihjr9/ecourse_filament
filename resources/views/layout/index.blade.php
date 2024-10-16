<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Software Mahasiswa</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <!-- JS -->
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-EbZpArANxHBj9XHL"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
</head>
<body class="bg-gray-50 h-screen flex flex-col justify-between">
    <div>
        <header class="py-6 px-6 lg:px-20 border-b bg-white">
            <nav class="flex flex-row items-center justify-between">
                <h5>Software Mahasiswa</h5>
                <div class="flex flex-row gap-x-4">
                    <a href="{{ route('index') }}">Beranda</a>
                    <a href="">Kursus</a>
                    <a href="">Tentang Kami</a>
                    <a href="">Kontak Kami</a>
                </div>
                @if(Auth::check())
                    <div class="flex flex-riw items-center gap-x-4">
                        <a href="{{ route('cart.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                            </svg>
                        </a>
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-amber-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                            Halo, {{ Auth::user()->name }}
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44">
                            <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownDefaultButton">
                              <li>
                                <a href="{{ route('filament.course.pages.dashboard') }}" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                              </li>
                                <li>
                                    <form method="POST" action="{{ route('filament.course.auth.logout') }}" class="w-full">
                                          @csrf
                                          <button type="submit" class="block px-4 py-2 hover:bg-gray-100 w-full text-left">Sign out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="flex flex-row gap-x-4">
                        <a href="{{ route('filament.course.auth.login') }}">Login</a>
                        <a href="{{ route('filament.course.auth.register') }}">Daftar</a>
                    </div>
                @endif
            </nav>
        </header>

        <main>
            <section class="py-6 px-6 lg:px-20">
                @yield('content')
            </section>
        </main>
    </div>

    <footer class="py-6 text-center border-t bg-white">
        <p>&copy; 2024 Software Mahasiswa. Semua hak dilindungi.</p>
    </footer>

</body>
</html>
