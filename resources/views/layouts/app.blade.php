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
      <a href="{{ route('landing') }}" class="brand">RentalKendaraan</a>
      <nav>
        <a href="{{ route('vehicles.index') }}">Kendaraan</a>
        @if(session('user_id'))
          <a href="{{ route('user.dashboard') }}">Dashboard</a>
          <a href="{{ route('user.logout') }}">Logout</a>
        @else
          <a href="{{ route('user.login') }}">Login</a>
          <a href="{{ route('user.register') }}">Register</a>
        @endif
        <a href="{{ route('admin.login') }}">Admin</a>
      </nav>
    </div>
  </header>

  <main class="container">
    @if(session('success')) <div class="alert success">{{ session('success') }}</div> @endif
    @if($errors->any()) <div class="alert error">{{ $errors->first() }}</div> @endif
    @yield('content')
  </main>

  <footer class="footer">
    <div class="container">© {{ date('Y') }} Sistem Peminjaman Kendaraan</div>
  </footer>
</body>
</html>
