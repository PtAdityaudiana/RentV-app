@extends('layouts.app')

@section('content')
<h2>Edit Data User</h2>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf

    <label>Nama:</label>
    <input type="text" name="name" value="{{ $user->name }}" required>

    <label>Email:</label>
    <input type="email" name="email" value="{{ $user->email }}" required>

    <label>Password (biarkan kosong jika tidak diubah):</label>
    <input type="text" name="password">

    <label>Phone:</label>
    <input type="text" name="phone" value="{{ $user->phone }}" required>

    <button type="submit">Perbarui</button>
    <a href="{{ route('admin.users.index') }}" class="cancel">Batal</a>
</form>
@endsection
