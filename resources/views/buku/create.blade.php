@extends('layouts.app')

@section('title', 'Tambah Buku')

@section('content')
    <div class="mb-4">
        <h1 class="mb-1">Tambah Buku</h1>
        <p class="text-muted-custom">Lengkapi form berikut untuk menambah data buku baru.</p>
    </div>

    <div class="card-system" style="max-width: 760px;">
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
            @include('buku._form')
        </form>
    </div>
@endsection


