@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>Edit Data Kendaraan</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label>Jenis Kendaraan</label>
        <select name="type" required>
          <option value="motor" {{ $vehicle->type == 'motor' ? 'selected' : '' }}>Motor</option>
          <option value="mobil" {{ $vehicle->type == 'mobil' ? 'selected' : '' }}>Mobil</option>
        </select>
      </div>

      <div class="form-group">
        <label>Brand</label>
        <input type="text" name="brand" value="{{ $vehicle->brand }}" required>
      </div>

      <div class="form-group">
        <label>Model</label>
        <input type="text" name="model" value="{{ $vehicle->model }}">
      </div>

      <div class="form-group">
        <label>Plat Nomor</label>
        <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}" required>
      </div>

      <div class="form-group">
        <label>Warna</label>
        <input type="text" name="color" value="{{ $vehicle->color }}">
      </div>

      <div class="form-group">
        <label>Tahun</label>
        <input type="number" name="year" value="{{ $vehicle->year }}" min="1900" max="{{ date('Y') }}">
      </div>

      <div class="form-group">
        <label>Harga per Hari (Rp)</label>
        <input type="number" name="price_per_day" value="{{ $vehicle->price_per_day }}" step="0.01" required>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" required>
          <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>Available</option>
          <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
          <option value="unavailable" {{ $vehicle->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
        </select>
      </div>

      <div class="form-group">
        <label>Catatan</label>
        <textarea name="notes" rows="3">{{ $vehicle->notes }}</textarea>
      </div>

      <div class="form-group">
        <label>Ganti Foto (opsional)</label>
        <input type="file" name="photo">
      </div>

      @if($vehicle->photo_path)
      <div class="preview">
        <p>Foto saat ini:</p>
        <img src="{{ asset('storage/'.$vehicle->photo_path) }}" alt="Vehicle Photo">
      </div>
      @endif

      <button type="submit">Perbarui</button>
      <a href="{{ route('admin.vehicles.index') }}" class="cancel">Batal</a>
    </form>
  </div>
</div>
@endsection
