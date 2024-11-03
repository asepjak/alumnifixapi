@extends('layouts.login')
@section('title')
    Login
@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                </div>

                                @if ($errors->has('login_error'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('login_error') }}
                                    </div>
                                @endif

                                <form class="user" method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    <!-- Role Selection Dropdown -->


                                    <div class="form-group">
                                        <input type="nomor_induk"
                                            class="form-control form-control-user @error('nomor_induk') is-invalid @enderror"
                                            id="exampleInputnomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}"
                                            aria-describedby="nomor_indukHelp" placeholder="Enter nomor_induk Address...">
                                        @error('nomor_induk')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="password"
                                            class="form-control form-control-user @error('password') is-invalid @enderror"
                                            id="exampleInputPassword" name="password" placeholder="Password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                {{-- <div class="text-center">
                                    <a href="{{route('register.index')}}" class="small">Daftar</a>
                                </div> --}}
                                <div class="text-center">
                                    <a class="small" href="{{ route('register.alumni.submit') }}">Buat Akun Alumni</a>
                                </div>
                                <div class="text-center">
                                <a class="small" href="{{ route('register.perusahaan.index') }}">Buat akun Perusahaan!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    @if ($errors->has('login_error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: "{{ implode(', ', $errors->get('login_error')) }}",
            showConfirmButton: true,
            timer: 3000
        });
    </script>
    @endif
@endsection
