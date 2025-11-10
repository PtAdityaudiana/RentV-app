@extends('layouts.app')

@section('title','Landing')

@section('content')
  <h1>Sistem Peminjaman Kendaraan</h1>
  <p>Selamat datang. Sistem ini sederhana: user dapat melihat kendaraan, request peminjaman, dan admin akan approve/reject.</p>


  <h2>Kendaraan Tersedia</h2>
  <div class="grid">
    @foreach($vehicles as $v)
      <div class="card">
        <img src="{{ $v->photo_path ? asset('storage/' . $v->photo_path) : asset('images/no-photo.png') }}" alt="">
        <h3>{{ $v->brand }} {{ $v->model }}</h3>
        <p>{{ ucfirst($v->type) }} • {{ $v->plate_number }}</p>
        <a class="btn" href="{{ route('vehicles.show', $v->id) }}">Lihat</a>
      </div>
    @endforeach
  </div>
@endsection
