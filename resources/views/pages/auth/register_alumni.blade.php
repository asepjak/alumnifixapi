@extends('layouts.login')

@section('title')
    Registrasi Alumni
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Pendaftaran Alumni</h1>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('register.alumni.index') }}" method="POST" class="user">
                                    @csrf
                                    <!-- Role (Hidden) -->
                                    <input type="hidden" name="role" value="1">

                                    <!-- Nama Lengkap -->
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control form-control-user @error('name') is-invalid @enderror"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder="Nama Lengkap"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Nomor Induk -->
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                            name="nomor_induk"
                                            value="{{ old('nomor_induk') }}"
                                            placeholder="Nomor Induk Mahasiswa"
                                            required>
                                        @error('nomor_induk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Kata Sandi -->
                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            name="password"
                                            placeholder="Kata Sandi"
                                            required>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Konfirmasi Kata Sandi -->
                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control form-control-user"
                                            name="password_confirmation"
                                            placeholder="Konfirmasi Kata Sandi"
                                            required>
                                    </div>

                                    <!-- Nomor Telepon -->
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control form-control-user @error('no_tlp') is-invalid @enderror"
                                            name="no_tlp"
                                            value="{{ old('no_tlp') }}"
                                            placeholder="Nomor Telepon"
                                            required>
                                        @error('no_tlp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div class="form-group">
                                        <input type="email"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="Alamat Email"
                                            required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <!-- Angkatan -->
                                    <div class="form-group">
                                        <input type="text"
                                            class="form-control form-control-user @error('angkatan') is-invalid @enderror"
                                            name="angkatan"
                                            value="{{ old('angkatan') }}"
                                            placeholder="Tahun Angkatan"
                                            required>
                                        @error('angkatan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Daftar Akun
                                    </button>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Sudah punya akun? Masuk!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: true,
                timer: 3000
            });
        </script>
    @endif

    @if ($errors->has('registration_error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ $errors->first('registration_error') }}",
                showConfirmButton: true,
                timer: 3000
            });
        </script>
    @endif
@endsection
