@extends('layouts.alumni')

@section('title')
    Edit Alumni Profile
@endsection

@section('content-alumni')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Alumni Profile</h1>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="alumniProfileForm" method="POST" action="{{ route('alumni.update', $alumni->id_alumni) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id_alumni" value="{{ $alumni->id_alumni }}">

                    <div class="form-group">
                        <label for="gambar">Gambar Profil</label>
                        @if($alumni->gambar)
                            <div>
                                <img src="{{ asset('storage/' . $alumni->gambar) }}" alt="Current Image" style="width: 100px; height: auto; border-radius: 8px; margin-bottom: 10px;">
                            </div>
                        @else
                            <div>
                                <p>Tidak ada gambar yang diunggah.</p>
                            </div>
                        @endif
                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                        <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                    </div>

                    <div class="form-group">
                        <label for="nama_alumni">Nama</label>
                        <input type="text" class="form-control" id="nama_alumni" name="nama_alumni" value="{{ old('nama_alumni', $alumni->nama_alumni) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $alumni->user->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="no_tlp">Nomor HP</label>
                        <input type="text" class="form-control" id="no_tlp" name="no_tlp" value="{{ old('no_tlp', $alumni->no_tlp) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $alumni->alamat) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $alumni->tanggal_lahir) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password (biarkan kosong jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Alumni</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#alumniProfileForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                const formData = new FormData(this); // Create a FormData object from the form

                $.ajax({
                    url: $(this).attr('action'), // Use the form action
                    type: 'PUT',
                    data: formData,
                    contentType: false, // Set content type to false to send FormData
                    processData: false, // Set processData to false to prevent jQuery from transforming the data
                    success: function(response) {
                        // Handle success - You can show a success message or redirect
                        alert('Profile updated successfully!');
                        // Optionally, you might want to redirect or reload the page
                        window.location.href = response.redirect; // Assuming the response contains a redirect URL
                    },
                    error: function(xhr) {
                        // Handle error
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = 'There was an error updating the profile:\n';
                        for (let key in errors) {
                            errorMessage += errors[key].join('\n') + '\n';
                        }
                        alert(errorMessage);
                    }
                });
            });
        });
    </script>
@endsection
