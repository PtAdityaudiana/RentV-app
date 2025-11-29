@extends('layouts.app')
@section('title','Detail Kendaraan')
@section('content')

<div class="card" style="max-width:600px; margin:auto;">
    <h1>{{ $vehicle->brand }} {{ $vehicle->model }}</h1>

    <img src="{{ $vehicle->photo_path ? asset('storage/' . $vehicle->photo_path) : asset('images/no-photo.png') }}" 
         style="max-width:250px; margin:auto;">

    <p><strong>Plat:</strong> {{ $vehicle->plate_number }}</p>
    <p><strong>Type:</strong> {{ $vehicle->type }}</p>
    <p><strong>Warna:</strong> {{ $vehicle->color }}</p>
    <p><strong>Tahun:</strong> {{$vehicle->year}}</p>
    <p><strong>Status:</strong> {{ $vehicle->status }}</p>
    <p><strong>Harga perhari:</strong> Rp.{{ $vehicle->price_per_day }}</p>
    <p><strong>Note:</strong> {{ $vehicle->notes }}</p>
</div>

<br>

@if(session('user_id'))

  @if($vehicle->status === 'available')
    
    <div class="card" style="max-width:600px; margin:auto;">
        <h3 style="margin-bottom:10px;">Request Booking</h3>

        <form method="POST" action="{{ route('booking.store') }}">
            @csrf
            <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">

            <label>Tanggal Pinjam</label>
            <input type="datetime-local" name="start_date" required>

            <label>Tanggal Kembali</label>
            <input type="datetime-local" name="end_date" required>

            <label>Catatan</label>
            <textarea name="notes"></textarea>

            <button style="margin-top:10px;">Request</button>
        </form>
    </div>

  @else
    <div class="alert">Kendaraan tidak tersedia</div>
  @endif

@else
  <div class="card" style="max-width:500px; margin:auto;">
    <p>
      <a href="{{ route('user.login') }}">Login</a> untuk membuat booking.
    </p>
  </div>
@endif

@endsection
