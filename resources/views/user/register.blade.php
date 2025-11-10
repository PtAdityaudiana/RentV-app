@extends('layouts.app')
@section('content')
  <h2>User Register</h2>
  <form method="POST" action="{{ route('user.register') }}">
    @csrf
    <input name="name" placeholder="Nama" value="{{ old('name') }}">
    <input name="email" placeholder="email" value="{{ old('email') }}">
    <input name="phone" placeholder="phone" value="{{ old('phone') }}">
    <input name="password" type="password" placeholder="password">
    <button>Register</button>
  </form>
@endsection
