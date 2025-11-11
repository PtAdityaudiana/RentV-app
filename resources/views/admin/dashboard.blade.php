@extends('layouts.app')
@section('content')
  <h2>Admin Dashboard</h2>
  <p>Pending bookings: {{ $pending }}</p>
  <p>Total vehicles: {{ $vehicles }}</p>
  <p>Total users: {{ $users }}</p>

  <p><a href="{{ route('admin.users.index') }}">Manage Users</a> | <a href="{{ route('admin.vehicles.index') }}">Manage Vehicles</a> | <a href="{{ route('admin.bookings.index') }}">Manage Bookings</a></p>
@endsection
