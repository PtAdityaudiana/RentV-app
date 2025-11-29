@extends('layouts.app')
@section('content')
  <h2>Vehicles</h2>
  <p><a href="{{ route('admin.vehicles.create') }}" class="btn">Create Vehicle</a></p>
  <table class="table">
    <thead><tr>
      <th>#</th>
      <th>Brand</th>
      <th>Photo</th>
      <th>Plate</th>
      <th>Harga/Hari</th
      ><th>Status</th>
      <th>Action</th>
    </tr></thead>
    <tbody>
      @foreach($vehicles as $v)
      <tr>
        <td>{{ $v->id }}</td>
        <td>{{ $v->brand }} {{ $v->model }}</td>
        <td><img src="{{ $v->photo_path ? asset('storage/' . $v->photo_path) : asset('images/no-photo.png') }}" 
         style="max-width:130px; margin:auto;"></td>
        <td>{{ $v->plate_number }}</td>
        <td><p>Rp.{{ $v->price_per_day }}</p></td>
        <td>{{ $v->status }}</td>
        <td>
          <a href="{{ route('admin.vehicles.edit', $v->id) }}">Edit</a>
          <form style="display:inline" method="POST" action="{{ route('admin.vehicles.delete', $v->id) }}">@csrf<button>Delete</button></form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
