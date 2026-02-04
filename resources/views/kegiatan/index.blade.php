@extends('layouts.app')

@section('title', 'Data Kegiatan')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Data Kegiatan</h1>

    <ul>
        @forelse ($kegiatans as $kegiatan)
            <li>{{ $kegiatan->judul }}</li>
        @empty
            <li>Belum ada data kegiatan</li>
        @endforelse
    </ul>
@endsection
