@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Tambah Anggota</h1>
        <p class="text-muted-custom">Lengkapi form berikut untuk mendaftarkan anggota baru.</p>
    </div>

    <div class="card-system" style="max-width: 720px;">
        <form action="{{ route('anggota.store') }}" method="POST">
            @include('anggota._form')
        </form>
    </div>
@endsection


