{{-- @extends('layouts.app')

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
        <p>Anda memiliki akses penuh sebagai Super Admin.</p>

    @elseif(auth()->user()->role === 'admin')
        <p>Anda dapat mengelola data sebagai Admin.</p>

    @elseif(auth()->user()->role === 'intern')
        <p>Anda hanya dapat melihat data tertentu sebagai Intern.</p>

    @else
        <p>Anda sedang mengakses sebagai Public User.</p>
    @endif
</div>
@endsection --}}
@extends('layouts.app')

@section('title','Profile')
@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
              <div class="col-span-12 space-y-6 xl:col-span-7">
                <!-- Metric Group One -->
                @include('layouts.partials.metric-group.metric-group-01')

                <!-- Metric Group One -->

                <!-- ====== Chart One Start -->
                @include('layouts.partials.chart.chart-01')

                <!-- ====== Chart One End -->
              </div>
              <div class="col-span-12 xl:col-span-5">
                <!-- ====== Chart Two Start -->
                @include('layouts.partials.chart.chart-02')

                <!-- ====== Chart Two End -->
              </div>

              <div class="col-span-12">
                <!-- ====== Chart Three Start -->
                @include('layouts.partials.chart.chart-03')

                <!-- ====== Chart Three End -->
              </div>

              <div class="col-span-12 xl:col-span-5">
                <!-- ====== Map One Start -->
                @include('layouts.partials.map-01')

                <!-- ====== Map One End -->
              </div>

              <div class="col-span-12 xl:col-span-7">
                <!-- ====== Table One Start -->
                @include('layouts.partials.table.table-01')

                <!-- ====== Table One End -->
              </div>
            </div>
@endsection
