@extends('layout.index')
@section('content')
<h5 class="text-xl font-medium">Keranjang Saya</h5>
    @if (session('message'))
        <div id="toast-bottom-right" class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow bottom-5 left-5" role="alert">
            {{ session('message') }}
        </div>
    @endif
    <section class="grid grid-cols-1 {{ $cartItems ? 'lg:grid-cols-2' : '' }} mt-4 gap-x-6">
        <div>
            @if (!$cartItems)
                <div class="flex flex-col w-4/12 mx-auto">
                    <img src="{{ asset('empty.svg') }}"/>
                    <p class="text-center mt-2">Kamu Belum memiliki kelas</p>
                    <x-filament::link href="{{ route('index',) }}" class="block mt-4 py-2 font-bold bg-blue-50 rounded-lg">
                        <span class="w-full">Eksplor kelas sekarang</span>
                    </x-filament::link>
                </div>
            @else
                <ul>
                    @foreach ($cartItems as $cartItem)
                        <div class="flex flex-row bg-white border rounded-xl items-center justify-between px-4 py-2">
                            <div class="flex items-center gap-x-4">
                                <img src="{{ asset('storage/'.$cartItem->item->thumbnail) }}" alt="{{ $cartItem->item->nama }}" class="bg-slate-50 border w-20 h-14 rounded-xl object-cover">
                                <div class="flex flex-col space-y-1">
                                    <h5 class="text-base">{{ $cartItem->item->nama }}</h5>
                                    <h5 class="text-base font-medium">Rp {{ number_format($cartItem->item->harga, 0, ',', '.') }}</h5>
                                </div>
                            </div>
                            <form action="{{ route('cart.remove', $cartItem->item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-500 text-white rounded-xl">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </ul>
            @endif
        </div>
        @if (!$cartItems)

        @else
            <div class="p-4 bg-white border w-full lg:w-6/12 ml-auto rounded-xl h-fit">
                <h5 class="text-lg font-medium">Rincian Order</h5>
                <div class="flex flex-row items-center justify-between mt-4">
                    <p class="text-gray-600">Total item</p>
                    <p>{{ $counted }}</p>
                </div>
                <div class="flex flex-row items-center justify-between mt-2">
                    <p class="text-gray-600">Total harga</p>
                    <p class="font-bold text-green-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
                <button id="pay-button" class="py-2 bg-black rounded-md text-white w-full mt-4">Bayar Sekarang</button>
            </div>
        @endif
    </section>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="SB-Mid-client-EbZpArANxHBj9XHL"></script>
    <script type="text/javascript">
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        alert("Pembayaran berhasil!");
                        console.log(result);
                    },
                    onPending: function (result) {
                        alert("Menunggu pembayaran!");
                        console.log(result);
                    },
                    onError: function (result) {
                        alert("Pembayaran gagal!");
                        console.log(result);
                    },
                    onClose: function () {
                        alert('Anda menutup pop-up tanpa menyelesaikan pembayaran');
                    }
                });
            });
        </script>
@endsection
