@extends('layouts.login')

@section('title')
    Register Account
@endsection

@section('content')
    @if(session('success'))
        <meta name="success-message" content="{{ session('success') }}">
    @endif
    @if(session('error'))
        <meta name="error-message" content="{{ session('error') }}">
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun</h1>
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

                                <form class="user" method="POST" action="{{ route('register.index') }}" id="registrationForm">
                                    @csrf
                                    <!-- User Type Selection -->
                                    <div class="form-group mb-4">
                                        <select name="user_type" id="userType" class="form-control form-select">
                                            <option value="">Pilih Tipe User</option>
                                            <option value="0">Admin</option>
                                            <option value="1">Alumni</option>
                                            <option value="2">Perusahaan</option>
                                        </select>
                                    </div>

                                    <!-- Common Fields for Admin and Alumni -->
                                    <div id="commonFields" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('username') is-invalid @enderror"
                                                name="username" value="{{ old('username') }}" placeholder="Username">
                                            @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" placeholder="Nama Lengkap">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                                name="nomor_induk" value="{{ old('nomor_induk') }}" placeholder="Nomor Induk">
                                            @error('nomor_induk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('angkatan') is-invalid @enderror"
                                                name="angkatan" value="{{ old('angkatan') }}" placeholder="Angkatan">
                                            @error('angkatan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('no_tlp') is-invalid @enderror"
                                                name="no_tlp" value="{{ old('no_tlp') }}" placeholder="Nomor Telepon">
                                            @error('no_tlp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password_confirmation" placeholder="Konfirmasi Password">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block" id="commonSubmitBtn">
                                            Daftar
                                        </button>
                                    </div>

                                    <!-- Company Fields -->
                                    <div id="companyFields" style="display: none;">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror"
                                                name="name" value="{{ old('name') }}" placeholder="Nama Perusahaan">
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                                name="nomor_induk" value="{{ old('nomor_induk') }}" placeholder="NIB">
                                            @error('nomor_induk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('sektor_bisnis') is-invalid @enderror"
                                                name="sektor_bisnis" value="{{ old('sektor_bisnis') }}" placeholder="Sektor Bisnis">
                                            @error('sektor_bisnis')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('website_perusahaan') is-invalid @enderror"
                                                name="website_perusahaan" value="{{ old('website_perusahaan') }}"
                                                placeholder="Website Perusahaan">
                                            @error('website_perusahaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user @error('no_tlp') is-invalid @enderror"
                                                name="no_tlp" value="{{ old('no_tlp') }}" placeholder="Nomor Telepon">
                                            @error('no_tlp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                            @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                                name="password" placeholder="Password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                name="password_confirmation" placeholder="Konfirmasi Password">
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Daftar Sebagai Perusahaan
                                        </button>
                                    </div>
                                </form>

                                <hr>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Sudah punya akun? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
function toggleFields() {
    const userType = document.getElementById('userType').value;
    const commonFields = document.getElementById('commonFields');
    const companyFields = document.getElementById('companyFields');
    const form = document.getElementById('registrationForm');
    const commonSubmitBtn = document.getElementById('commonSubmitBtn');

    // Sembunyikan semua field terlebih dahulu
    if (commonFields) commonFields.style.display = 'none';
    if (companyFields) companyFields.style.display = 'none';

    // Reset action form ke default
    form.action = "{{ route('register.index') }}";

    // Tampilkan field yang relevan berdasarkan tipe user yang dipilih
    switch (userType) {
        case '0': // Admin
            if (commonFields) {
                commonFields.style.display = 'block';
                commonSubmitBtn.textContent = 'Daftar Sebagai Admin';
            }
            break;

        case '1': // Alumni
            if (commonFields) {
                commonFields.style.display = 'block';
                commonSubmitBtn.textContent = 'Daftar Sebagai Alumni';
                form.action = "{{ route('register.alumni.submit') }}";
            }
            break;

        case '2': // Perusahaan
            if (companyFields) {
                companyFields.style.display = 'block';
                form.action = "{{ route('register.perusahaan.submit') }}";
            }
            break;

        default:
            // Jika tidak ada pilihan, sembunyikan semua form
            break;
    }
}

// Inisialisasi kondisi form pada saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const userType = document.getElementById('userType');
    if (userType) {
        toggleFields();
        userType.addEventListener('change', toggleFields);
    }
});

// Inisialisasi SweetAlert jika ada pesan sukses atau error
if (typeof Swal !== 'undefined') {
    if (document.querySelector('meta[name="success-message"]')) {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: document.querySelector('meta[name="success-message"]').content,
            showConfirmButton: true,
            timer: 3000
        });
    }

    if (document.querySelector('meta[name="error-message"]')) {
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: document.querySelector('meta[name="error-message"]').content,
            showConfirmButton: true,
            timer: 3000
        });
    }
}
</script>
@endsection
