@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>Edit Data User</h2>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
      @csrf
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="name" value="{{ $user->name }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="{{ $user->email }}" required>
      </div>

      <div class="form-group">
        <label>Password (biarkan kosong jika tidak diubah)</label>
        <input type="password" name="password">
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $user->phone }}" required>
      </div>

      <button type="submit">Perbarui</button>
      <a href="{{ route('admin.users.index') }}" style="display:inline-block" class="btn btn-secondary">Batal</a>
    </form>
  </div>
</div>
@endsection
