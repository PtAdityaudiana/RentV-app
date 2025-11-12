@extends('layouts.app')
@section('title','Detail Kendaraan')
@section('content')
  <h1>{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
  <img src="{{ $vehicle->photo_path ? asset('storage/' . $vehicle->photo_path) : asset('images/no-photo.png') }}" style="max-width:300px;">
  <p>Plat: {{ $vehicle->plate_number }}</p>
  <p>Type: {{ $vehicle->type }}</p>
  <p>Status: {{ $vehicle->status }}</p>
  <p>Harga perhari: Rp.{{ $vehicle->price_per_day}}</p>
  <p>Note: {{ $vehicle->notes }}</p>

  @if(session('user_id'))
    @if($vehicle->status === 'available')
      <h3>Request Booking</h3>
      <form method="POST" action="{{ route('booking.store') }}">
        @csrf
        <input type="hidden" name="vehicle_id" value="{{ $vehicle->id }}">
        <label>Start</label><input type="datetime-local" name="start_date" required>
        <label>End</label><input type="datetime-local" name="end_date" required>
        <label>Catatan</label><textarea name="notes"></textarea>
        <button>Request</button>
      </form>
    @else
      <div class="alert">Kendaraan tidak tersedia</div>
    @endif
  @else
    <p><a href="{{ route('user.login') }}">Login</a> untuk membuat booking.</p>
  @endif
@endsection
