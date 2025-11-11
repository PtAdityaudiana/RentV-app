@extends('layouts.app')

@section('content')
<h2>Tambah User Baru</h2>

<form action="{{ route('admin.users.store') }}" method="POST">
    @csrf
    <label>Nama:</label>
    <input type="text" name="name" required>

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Password:</label>
    <input type="text" name="password" required>

    <label>Phone:</label>
    <input type="text" name="phone" required>

    <button type="submit">Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="cancel">Batal</a>
</form>
@endsection
