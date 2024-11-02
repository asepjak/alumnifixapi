@extends('layouts.login')
@section('title')
Register User
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
                                <h1 class="h4 text-gray-900 mb-4">Pendaftaran Akun</h1>
                            </div>

                            <form class="user" method="POST" action="{{ route('register') }}" id="registrationForm">
                                @csrf

                                <!-- Role Selection -->
                                <div class="form-group mb-3" id="roleSelectionDiv">
                                    <select name="role" id="roleSelect" class="form-control @error('role') is-invalid @enderror"
                                            style="border-radius: 20px; height: 50px; font-size: 14px;">
                                        <option value="" selected disabled>Pilih Jenis Akun</option>
                                        <option value="0" {{ old('role') == '0' ? 'selected' : '' }}>Admin</option>
                                        <option value="1" {{ old('role') == '1' ? 'selected' : '' }}>Alumni</option>
                                        <option value="2" {{ old('role') == '2' ? 'selected' : '' }}>Perusahaan</option>
                                    </select>
                                    @error('role')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Selected Role Display (Initially Hidden) -->
                                <div class="form-group mb-3" id="selectedRoleDiv" style="display: none;">
                                    <input type="hidden" name="role" id="hiddenRoleInput">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span id="selectedRoleText" class="form-control-plaintext"></span>
                                        <button type="button" class="btn btn-sm btn-secondary" id="changeRoleBtn">
                                            Ganti Role
                                        </button>
                                    </div>
                                </div>

                                <!-- Common Fields -->
                                <div class="form-group mb-3">
                                    <input type="text"
                                           class="form-control form-control-user @error('username') is-invalid @enderror"
                                           name="username"
                                           value="{{ old('username') }}"
                                           placeholder="Username">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="email"
                                           class="form-control form-control-user @error('email') is-invalid @enderror"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="Alamat Email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Alumni Fields (Role 1) -->
                                <div id="alumniFields" style="display: none;">
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('nama') is-invalid @enderror"
                                               name="nama"
                                               value="{{ old('name') }}"
                                               placeholder="Nama Perusahaan">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                <div id="alumniFields" style="display: none;">
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                               name="nomor_induk"
                                               value="{{ old('nomor_induk') }}"
                                               placeholder="NIM">
                                        @error('nomor_induk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('email') is-invalid @enderror"
                                               name="email"
                                               value="{{ old('email') }}"
                                               placeholder="Email">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('angkatan') is-invalid @enderror"
                                               name="angkatan"
                                               value="{{ old('angkatan') }}"
                                               placeholder="Angkatan">
                                        @error('angkatan')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('no_tlp') is-invalid @enderror"
                                               name="no_tlp"
                                               value="{{ old('no_tlp') }}"
                                               placeholder="Nomor Telepon">
                                        @error('no_tlp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Company Fields (Role 2) -->
                                <div id="companyFields" style="display: none;">
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('name') is-invalid @enderror"
                                               name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Nama Perusahaan">
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div id="companyFields" style="display: none;">
                                        <div class="form-group mb-3">
                                            <input type="text"
                                                   class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                                   name="nomor_induk"
                                                   value="{{ old('nomor_induk') }}"
                                                   placeholder="NIB">
                                            @error('nomor_induk')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text"
                                            class="form-control form-control-user @error('email') is-invalid @enderror"
                                            name="email"
                                            value="{{ old('email') }}"
                                            placeholder="Email">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="text"
                                                   class="form-control form-control-user @error('website_perusahaan') is-invalid @enderror"
                                                   name="website_perusahaan"
                                                   value="{{ old('website_perusahaan') }}"
                                                   placeholder="Website Perusahaan">
                                            @error('website_perusahaan')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('sektor_bisnis') is-invalid @enderror"
                                               name="sektor_bisnis"
                                               value="{{ old('sektor_bisnis') }}"
                                               placeholder="Sektor Bisnis">
                                        @error('sektor_bisnis')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('alamat') is-invalid @enderror"
                                               name="alamat"
                                               value="{{ old('alamat') }}"
                                               placeholder="Alamat">
                                        @error('alamat')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="text"
                                               class="form-control form-control-user @error('no_tlp') is-invalid @enderror"
                                               name="no_tlp"
                                               value="{{ old('no_tlp') }}"
                                               placeholder="Nomor Telepon">
                                        @error('no_tlp')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Password Fields -->
                                <div class="form-group mb-3">
                                    <input type="password"
                                           class="form-control form-control-user @error('password') is-invalid @enderror"
                                           name="password"
                                           placeholder="Kata Sandi">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <input type="password"
                                           class="form-control form-control-user"
                                           name="password_confirmation"
                                           placeholder="Konfirmasi Kata Sandi">
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Daftar
                                </button>
                            </form>

                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                            </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('roleSelect');
    const alumniFields = document.getElementById('alumniFields');
    const companyFields = document.getElementById('companyFields');
    const form = document.getElementById('registrationForm');
    const roleSelectionDiv = document.getElementById('roleSelectionDiv');
    const selectedRoleDiv = document.getElementById('selectedRoleDiv');
    const selectedRoleText = document.getElementById('selectedRoleText');
    const hiddenRoleInput = document.getElementById('hiddenRoleInput');
    const changeRoleBtn = document.getElementById('changeRoleBtn');

    // Function to get role name
    function getRoleName(roleValue) {
        switch(roleValue) {
            case '0': return 'Admin';
            case '1': return 'Alumni';
            case '2': return 'Perusahaan';
            default: return '';
        }
    }

    // Function to show fields based on role
    function showFieldsForRole(role) {
        // Hide all role-specific fields first
        alumniFields.style.display = 'none';
        companyFields.style.display = 'none';

        // Show fields based on selected role
        switch(role) {
            case '0': // Admin
                form.action = "{{ route('register.admin') }}";
                break;
            case '1': // Alumni
                form.action = "{{ route('register.alumni') }}";
                alumniFields.style.display = 'block';
                break;
            case '2': // Company
                form.action = "{{ route('register.company') }}";
                companyFields.style.display = 'block';
                break;
            default:
                form.action = "{{ route('register') }}";
        }

        // Update UI to show selected role
        if (role) {
            roleSelectionDiv.style.display = 'none';
            selectedRoleDiv.style.display = 'block';
            selectedRoleText.textContent = 'Role: ' + getRoleName(role);
            hiddenRoleInput.value = role;
        }
    }

    // Handle role selection
    roleSelect.addEventListener('change', function() {
        showFieldsForRole(this.value);
    });

    // Handle change role button
    changeRoleBtn.addEventListener('click', function() {
        roleSelectionDiv.style.display = 'block';
        selectedRoleDiv.style.display = 'none';
        roleSelect.value = '';
        alumniFields.style.display = 'none';
        companyFields.style.display = 'none';
        form.action = "{{ route('register') }}";
    });

    // Show fields based on initial value (if any)
    const initialRole = "{{ old('role') }}";
    if (initialRole) {
        showFieldsForRole(initialRole);
    }
});
</script>

<!-- Sweet Alert -->
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
@endpush
@endsection
