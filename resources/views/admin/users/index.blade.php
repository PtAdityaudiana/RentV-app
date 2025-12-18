@extends('layouts.app')
@section('content')
  <h2>Users</h2>
  <p>
    <a href="{{ route('admin.users.create') }}" class="btn">Create User</a>
    <a href="{{ url()->previous() }}" class="btn btn-secondary"> Back</a>
  </p>
  <table class="table">
    <thead><tr>
      <th>User Id</th>
      <th>Profile Pic</th>
      <th>Name</th>
      <th>Email</th>
      <th>Phone Number</th>
      <th>Action</th>
    </tr></thead>
    <tbody>
      @foreach($users as $u)
      <tr>
        <td>{{ $u->id }}</td>
        <td><img src="{{ $u->avatar_path ? asset('storage/' . $u->avatar_path) : asset('images/no-photo.png') }}" 
         style="max-width:50px; margin:auto;"></td>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->phone}}</td>
        <td>
            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn">Edit</a>
            <form style="display:inline" method="POST" action="{{ route('admin.users.delete', $u->id) }}">@csrf<button class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus user ini?')">Delete</button></form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
