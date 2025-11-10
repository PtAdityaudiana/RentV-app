@extends('layouts.app')
@section('content')
  <h2>Admin Login</h2>
  <form method="POST" action="{{ route('admin.login') }}">
    @csrf
    <input name="username" placeholder="username" value="{{ old('username') }}">
    <input name="password" type="password" placeholder="password">
    <button>Login</button>
  </form>
@endsection
