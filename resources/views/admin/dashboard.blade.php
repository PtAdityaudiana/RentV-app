@extends('layouts.app')
@section('content')
  <h2>Admin Dashboard</h2>

  <div style="margin-bottom:20px;">
    <p><strong>Pending bookings:</strong> {{ $pending }}</p>
    <p><strong>Total vehicles:</strong> {{ $vehicles }}</p>
    <p><strong>Total users:</strong> {{ $users }}</p>

    <p>
      <a href="{{ route('admin.users.index') }}" class="btn">Manage Users</a> |
      <a href="{{ route('admin.vehicles.index') }}" class="btn">Manage Vehicles</a>
    </p>
  </div>

  <hr>
  <h3>Bookings Management</h3>

  <table class="table" border="1" cellpadding="6" cellspacing="0" width="100%">
    <thead style="background:#f5f5f5;">
      <tr>
        <th>#</th>
        <th>User</th>
        <th>Vehicle</th>
        <th>Period</th>
        <th>Note</th>
        <th>Action</th>
        <th>Status Control</th>
      </tr>
    </thead>
    <tbody>
      @foreach($bookings as $b)
      <tr>
        <td>{{ $b->id }}</td>
        <td>{{ $b->user_name }}</td>
        <td>{{ $b->brand }} {{ $b->model }}</td>
        <td>{{ $b->start_date }} - {{ $b->end_date }}</td>
        <td>{{ $b->notes }}</td>

        <td>
          @if($b->status === 'pending')
            <form method="POST" action="{{ route('admin.bookings.approve', $b->id) }}" style="display:inline">@csrf
              <button class="approve">Approve</button>
            </form>
            <form method="POST" action="{{ route('admin.bookings.reject', $b->id) }}" style="display:inline">@csrf
              <button class="reject">Reject</button>
            </form>
          @endif
        </td>

        <td>
          @if($b->status === 'approved')
            <form method="POST" action="{{ route('admin.bookings.return', $b->id) }}" style="display:inline">@csrf
              <button class="return">Mark as Returned</button>
            </form>
            <form method="POST" action="{{ route('admin.bookings.late', $b->id) }}" style="display:inline">@csrf
              <button class="late">Mark as Late</button>
            </form>

          @elseif($b->status === 'late')
            <span style="color:red;">Late</span>

          @elseif($b->status === 'returned')
            <span style="color:green;">Returned</span>

          @elseif($b->status === 'rejected')
            <span style="color:black;">Rejected</span>

          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection
