@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>User Register</h2>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('user.register') }}">
      @csrf

      <div class="form-group">
        <label>Nama</label>
        <input name="name" type="text" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required>
      </div>

      <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
      </div>

      <div class="form-group">
        <label>Phone</label>
        <input name="phone" type="text" placeholder="Masukkan nomor telepon" value="{{ old('phone') }}" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" placeholder="Masukkan password" required>
      </div>

      <button type="submit">Register</button>
    </form>
  </div>
</div>
@endsection
