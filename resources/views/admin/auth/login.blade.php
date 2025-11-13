@extends('layouts.app')
@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2>Admin Login</h2>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('admin.login') }}">
      @csrf
      <div class="form-group">
        <label>Username</label>
        <input name="username" type="text" placeholder="Masukkan username" value="{{ old('username') }}">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" placeholder="Masukkan password">
      </div>
      <button type="submit">Login</button>
    </form>
  </div>
</div>
@endsection
