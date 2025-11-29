@extends('layouts.app')
@section('title','Daftar Kendaraan')
@section('content')
<h1>Riwayat Booking</h1>
  <table class="table">
    <thead><tr>
      <th>Vehicle</th>
      <th>Periode</th>
      <th>Harga/Hari</th>
      <th>Status</th>
    </tr></thead>
    <tbody>
      @foreach($bookings as $b)
        <tr>
          <td>{{ $b->brand }} {{ $b->model }}</td>
          <td>{{ $b->start_date }} - {{ $b->end_date }}</td>
          <td><p>Rp.{{$b->price_per_day}}</p></td>
          <td>{{ $b->status }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endsection
