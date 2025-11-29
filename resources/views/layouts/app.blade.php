<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>@yield('title','Sistem Peminjaman Kendaraan')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
  <header class="topbar">
    <div class="container">
      <a href="{{ route('landing') }}" class="brand">Rent-V</a>
      <nav>
        @if(session('user_id'))
          <a href="{{ route('user.profile.edit') }}">Profile</a>
          <a href="{{ route('user.bookingshistory') }}">Booking History</a>
          <a href="{{ route('user.dashboard') }}">Dashboard</a>
          <a href="{{ route('user.logout') }}">Logout</a>
        @elseif(session('admin_id'))
          <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
          <a href="{{ route('admin.logout') }}">Logout</a>
        @else
          <a href="{{ route('user.login') }}">Login</a>
          <a href="{{ route('user.register') }}">Register</a>
          <a href="{{ route('admin.login') }}">Admin</a>
        @endif
        
      </nav>
    </div>
  </header>

  <main class="container">
    @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert error">{{ $errors->first() }}</div> @endif
    @yield('content')
  </main>
</body>
</html>
