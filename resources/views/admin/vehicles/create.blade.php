@extends('layouts.app')

@section('content')
<h2>Tambah Kendaraan Baru</h2>

<form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <label>Jenis Kendaraan:</label>
    <select name="type" required>
        <option value="motor">Motor</option>
        <option value="mobil">Mobil</option>
    </select>

    <label>Brand:</label>
    <input type="text" name="brand" required>

    <label>Model:</label>
    <input type="text" name="model">

    <label>Plat Nomor:</label>
    <input type="text" name="plate_number" required>

    <label>Warna:</label>
    <input type="text" name="color">

    <label>Tahun:</label>
    <input type="number" name="year" min="1900" max="{{ date('Y') }}">

    <label>Harga per Hari (Rp):</label>
    <input type="number" name="price_per_day" step="0.01" required>

    <label>Status:</label>
    <select name="status" required>
        <option value="available">Available</option>
        <option value="maintenance">Maintenance</option>
        <option value="unavailable">Unavailable</option>
    </select>

    <label>Catatan:</label>
    <textarea name="notes" rows="3"></textarea>

    <label>Foto (opsional):</label>
    <input type="file" name="photo">

    <button type="submit">Simpan</button>
    <a href="{{ route('admin.vehicles.index') }}" class="cancel">Batal</a>
</form>
@endsection
