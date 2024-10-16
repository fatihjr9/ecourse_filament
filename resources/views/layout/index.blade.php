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
                        <a href="{{ route('cart.index') }}">Keranjang</a>
                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="text-white bg-orange-400 hover:bg-orange-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" type="button">
                            Halo {{ Auth::user()->name }}
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
