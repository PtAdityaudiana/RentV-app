@extends('layouts.app')
@section('title','Daftar Kendaraan')
@section('content')

  <h2>Dashboard</h2>
  <p>Halo, {{ $user->name }}</p>

  <h1>Daftar Kendaraan</h1>
  <form method="GET" class="search">
    <input name="q" placeholder="Cari brand, model, plat..." value="{{ request('q') }}">
    <select name="type">
      <option value="">-- Semua jenis --</option>
      <option {{ request('type')=='motor'?'selected':'' }} value="motor">Motor</option>
      <option {{ request('type')=='mobil'?'selected':'' }} value="mobil">Mobil</option>
    </select>
    <button>Cari</button>
  </form>

  <h2>Kendaraan Tersedia</h2>
  <div class="grid">
    @foreach($vehicles as $v)
      <div class="card">
        <img src="{{ $v->photo_path ? asset('storage/' . $v->photo_path) : asset('images/no-photo.png') }}" style="max-width:200px; margin:auto; alt=""
        >
        <h3>{{ $v->brand }} {{ $v->model }}</h3>
        <p>{{ ucfirst($v->type) }} • {{ $v->plate_number }}</p>
        <p>Rp.{{$v->price_per_day}} per hari</p>
        <a class="btn" href="{{ route('vehicles.show', $v->id) }}">Lihat</a>
      </div>
    @endforeach
  </div>
  
@endsection
