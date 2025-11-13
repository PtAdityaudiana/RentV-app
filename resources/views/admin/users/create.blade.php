@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>Tambah User Baru</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input type="text" name="password" required>
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" required>
      </div>

      <button type="submit">Simpan</button>
      <a href="{{ route('admin.users.index') }}" class="cancel">Batal</a>
    </form>
  </div>
</div>
@endsection
