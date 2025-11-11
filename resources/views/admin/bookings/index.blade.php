@extends('layouts.app')
@section('content')
  <h2>Bookings</h2>
  <table class="table">
    <thead><tr><th>#</th><th>User</th><th>Vehicle</th><th>Period</th><th>Status</th><th>Action</th></tr></thead>
    <tbody>
      @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->user_name }}</td>
        <td>{{ $b->brand }} {{ $b->model }}</td>
        <td>{{ $b->start_date }} - {{ $b->end_date }}</td>
        <td>{{ $b->status }}</td>
        <td>
          @if($b->status === 'pending')
            <form method="POST" action="{{ route('admin.bookings.approve', $b->id) }}" style="display:inline">@csrf<button>Approve</button></form>
            <form method="POST" action="{{ route('admin.bookings.reject', $b->id) }}" style="display:inline">@csrf<button>Reject</button></form>
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
