@extends('layout.index')
@section('content')
    <section class="grid grid-cols-2">
        <h5 class="font-bold text-7xl">Tidak ada kata <br class="hidden lg:block"/> terlambat untuk<br class="hidden lg:block"/> belajar</h5>
        <img src="{{ asset('header.png') }}"/>
    </section>
    <section class="mt-10">
        <h5 class="mb-4 text-xl font-semibold">Kursus Terbaru kami</h5>
        <livewire:course-card />
    </section>
@endsection
