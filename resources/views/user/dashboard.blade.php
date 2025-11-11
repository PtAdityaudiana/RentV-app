@extends('layouts.app')
@section('content')
  <h2>Dashboard</h2>
  <p>Halo, {{ $user->name }}</p>

  <h3>Update Profil</h3>
  <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
    @csrf
    <input name="name" value="{{ $user->name }}">
    <input name="phone" value="{{ $user->phone }}">
    <input type="file" name="avatar">
    <input name="password" type="password" placeholder="Ganti password (opsional)">
    <button>Update</button>
  </form>

  <h3>Riwayat Booking</h3>
  <table class="table">
    <thead><tr><th>#</th><th>Vehicle</th><th>Periode</th><th>Status</th></tr></thead>
    <tbody>
      @foreach($bookings as $b)
        <tr>
          <td>{{ $b->id }}</td>
          <td>{{ $b->brand }} {{ $b->model }}</td>
          <td>{{ $b->start_date }} - {{ $b->end_date }}</td>
          <td>{{ $b->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
