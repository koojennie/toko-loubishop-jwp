@extends('layouts.app')
@section('page-header')
  <div class="iq-navbar-header" style="height: 215px;">
    <div class="container-fluid iq-container">
      <div class="row">
        <div class="col-md-12">
          <div class="flex-wrap d-flex justify-content-between align-items-center">
            <div>
              <h1>Profil Pengguna</h1>
              <p>Kelola informasi akun pengguna aplikasi pencatatan stok.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="iq-header-img">
      <img src="{{ asset('hope-ui/assets/images/dashboard/top-header.jpg') }}" alt="header"
        class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
    </div>
  </div>
@endsection
@section('content')
  <div class="container-fluid content-inner mt-n5 py-0">
    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if ($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    <div class="row">
      <div class="col-lg-4">
        <div class="card" data-aos="fade-up" data-aos-delay="400">
          <div class="card-body text-center">
            <img src="{{ asset('hope-ui/assets/images/avatars/user-logo.svg') }}" alt="{{ $user->name }}"
              class="rounded-pill img-fluid avatar-130 mb-3">
            <h4 class="mb-1">{{ $user->name }}</h4>
            @if(auth()->user()->role === 'admin')
            <p class="text-muted mb-2">Administrator</p>
            @else
            <p class="text-muted mb-2">Pimpinan</p>
            @endif
            <span class="badge rounded-pill bg-primary">Aktif</span>
            <hr>
            <div class="text-start">
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Email</span>
                <span class="fw-semibold text-end">{{ $user->email }}</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Role</span>
                @if(auth()->user()->role === 'admin')
                <span class="fw-semibold">Admin</span>
                @else
                <span class="fw-semibold">Pimpinan</span>
                @endif
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Status Akun</span>
                <span class="fw-semibold">Aktif</span>
              </div>
              <div class="d-flex justify-content-between">
                <span class="text-muted">Terdaftar</span>
                <span class="fw-semibold">{{ $user->created_at ? $user->created_at->format('d/m/Y') : '-' }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card" data-aos="fade-up" data-aos-delay="500">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="header-title">
              <h4 class="card-title mb-1">Informasi Profil</h4>
              <p class="mb-0 text-muted">Perbarui informasi akun pengguna yang sedang login.</p>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST">
              @csrf
              @method('PUT')
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}" placeholder="Masukkan nama lengkap" required>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Masukkan email" required>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Role</label>
                  <input type="text" name="role" class="form-control @error('role') is-invalid @enderror"
                    value="{{ old('role', $user->role) }}" placeholder="Masukkan role" required readonly>
                  @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  {{-- kalau ini jennie untuk option enum edit buat belajar ya --}}
                  {{-- <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                      <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                          Administrator
                      </option>
                      <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>
                          Pimpinan
                      </option>
                  </select>

                  @error('role')
                      <div class="invalid-feedback">{{ $message }}</div>
                  @enderror --}}
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Status Akun</label>
                  <input type="text" class="form-control" value="Aktif" readonly>
                  <small class="text-muted">Status ditampilkan sebagai informasi akun aktif.</small>
                </div>
              </div>
              <div class="d-flex justify-content-end gap-2">
                <button type="reset" class="btn btn-soft-secondary">Reset</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
