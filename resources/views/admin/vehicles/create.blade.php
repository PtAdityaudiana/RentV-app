@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>Tambah Kendaraan Baru</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label>Jenis Kendaraan</label>
        <select name="type" required>
          <option value="motor">Motor</option>
          <option value="mobil">Mobil</option>
        </select>
      </div>

      <div class="form-group">
        <label>Brand</label>
        <input type="text" name="brand" required>
      </div>

      <div class="form-group">
        <label>Model</label>
        <input type="text" name="model">
      </div>

      <div class="form-group">
        <label>Plat Nomor</label>
        <input type="text" name="plate_number" required>
      </div>

      <div class="form-group">
        <label>Warna</label>
        <input type="text" name="color">
      </div>

      <div class="form-group">
        <label>Tahun</label>
        <input type="number" name="year" min="1900" max="{{ date('Y') }}">
      </div>

      <div class="form-group">
        <label>Harga per Hari (Rp)</label>
        <input type="number" name="price_per_day" step="0.01" required>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" required>
          <option value="available">Available</option>
          <option value="maintenance">Maintenance</option>
          <option value="unavailable">Unavailable</option>
        </select>
      </div>

      <div class="form-group">
        <label>Catatan</label>
        <textarea name="notes" rows="3"></textarea>
      </div>

      <div class="form-group">
        <label>Foto (opsional)</label>
        <input type="file" name="photo">
      </div>

      <button type="submit">Simpan</button>
      <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
