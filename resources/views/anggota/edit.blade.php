@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Edit Anggota</h1>
        <p class="text-muted-custom">Perbarui data anggota "{{ $anggota->nama }}".</p>
    </div>

    <div class="card-system" style="max-width: 720px;">
        <form action="{{ route('anggota.update', $anggota) }}" method="POST">
            @include('anggota._form')
        </form>
    </div>
@endsection


