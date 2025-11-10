@extends('layouts.app')
@section('content')
  <h2>User Login</h2>
  <form method="POST" action="{{ route('user.login') }}">
    @csrf
    <input name="email" placeholder="email" value="{{ old('email') }}">
    <input name="password" type="password" placeholder="password">
    <button>Login</button>
  </form>
@endsection
