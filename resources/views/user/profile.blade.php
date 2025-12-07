@extends('layouts.app')
@section('title','Edit Profil')

@section('content')
<div class="container">

  @if(session('success'))
    <div class="alert success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert error">{{ session('error') }}</div>
  @endif

  <div class="card profile-card">
    <div class="card-header">
      <h3>Update User Profil</h3>
    </div>
    <div class="card-body">
      <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
          <label>Foto Profil</label>
          <input type="file" name="avatar">
          @if($user->avatar_path)
            <div class="preview">
              <img src="{{ asset('storage/' . $user->avatar_path) }}" style="max-width:150px; margin:auto;" alt="Avatar">

              <button type="submit" name="delete_avatar" value="1" class="btn btn-secondary" 
                style="background:red;color:white;margin-top:10px;" onclick="return confirm('Yakin untuk menghapus foto profil?')">
                Hapus Foto Profil
              </button>
            </div>
          @endif
        </div>

        <div class="form-group">
          <label>Nama Lengkap</label>
          <input type="text" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="phone" value="{{ $user->phone }}">
        </div>

        

        <div class="form-group">
          <label>Password Baru (opsional)</label>
          <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
        </div>

        <div class="form-group">
          <button type="submit" class="btn">Simpan Perubahan</button>
          <a href="{{ route('user.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
