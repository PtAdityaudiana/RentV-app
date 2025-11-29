@extends('layouts.app')

@section('content')
<div class="profile-card">
  <div class="card-header">
    <h2 style="text-align: center;">User Login</h2>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('user.login') }}">
      @csrf

      <div class="form-group">
        <label>Email</label>
        <input name="email" type="email" placeholder="Masukkan email" value="{{ old('email') }}" required>
      </div>

      <div class="form-group">
        <label>Password</label>
        <input name="password" type="password" placeholder="Masukkan password" required>
      </div>

      <button type="submit">Login</button>
    </form>
  </div>
</div>
@endsection
