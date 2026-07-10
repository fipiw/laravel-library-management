@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Edit Buku</h1>
        <p class="text-muted-custom">Perbarui data buku "{{ $buku->judul }}".</p>
    </div>

    <div class="card-system" style="max-width: 760px;">
        <form action="{{ route('buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
            @include('buku._form')
        </form>
    </div>
@endsection


