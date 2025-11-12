@extends('layouts.app')

@section('content')
<h2>Edit Data Kendaraan</h2>

<form action="{{ route('admin.vehicles.update', $vehicle->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    

    <label>Jenis Kendaraan:</label>
    <select name="type" required>
        <option value="motor" {{ $vehicle->type == 'motor' ? 'selected' : '' }}>Motor</option>
        <option value="mobil" {{ $vehicle->type == 'mobil' ? 'selected' : '' }}>Mobil</option>
    </select>

    <label>Brand:</label>
    <input type="text" name="brand" value="{{ $vehicle->brand }}" required>

    <label>Model:</label>
    <input type="text" name="model" value="{{ $vehicle->model }}">

    <label>Plat Nomor:</label>
    <input type="text" name="plate_number" value="{{ $vehicle->plate_number }}" required>

    <label>Warna:</label>
    <input type="text" name="color" value="{{ $vehicle->color }}">

    <label>Tahun:</label>
    <input type="number" name="year" value="{{ $vehicle->year }}" min="1900" max="{{ date('Y') }}">

    <label>Harga per Hari (Rp):</label>
    <input type="number" name="price_per_day" value="{{ $vehicle->price_per_day }}" step="0.01" required>

    <label>Status:</label>
    <select name="status" required>
        <option value="available" {{ $vehicle->status == 'available' ? 'selected' : '' }}>Available</option>
        <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        <option value="unavailable" {{ $vehicle->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
    </select>

    <label>Catatan:</label>
    <textarea name="notes" rows="3">{{ $vehicle->notes }}</textarea>

    <label>Ganti Foto (opsional):</label>
    <input type="file" name="photo">

    @if($vehicle->photo_path)
        <div style="margin-top:10px;">
            <p>Foto saat ini:</p>
            <img src="{{ asset('storage/'.$vehicle->photo_path) }}" alt="Vehicle Photo" width="200" style="border-radius:8px;">
        </div>
    @endif

    <button type="submit">Perbarui</button>
    <a href="{{ route('admin.vehicles.index') }}" class="cancel">Batal</a>
</form>
@endsection
