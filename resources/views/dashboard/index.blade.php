@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold mb-4">Dashboard</h1>

<p>
    Selamat datang,
    <strong>{{ auth()->user()->name }}</strong>
    ({{ auth()->user()->role }})
</p>

<div class="mt-4">
    @if(auth()->user()->role === 'super_admin')
        <p>Anda memiliki akses penuh sebagai Super Admin dinda.</p>

    @elseif(auth()->user()->role === 'admin')
        <p>Anda dapat mengelola data sebagai Admin.</p>

    @elseif(auth()->user()->role === 'intern')
        <p>Anda hanya dapat melihat data tertentu sebagai Intern.</p>

    @else
        <p>Anda sedang mengakses sebagai Public User.</p>
    @endif
</div>
@endsection
