@foreach ($berita as $beritaItem)
    <!-- Modal Detail -->
    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal{{ $beritaItem['id_berita'] }}" tabindex="-1"
        aria-labelledby="detailModalLabel{{ $beritaItem['id_berita'] }}" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $beritaItem['id_berita'] }}">Detail Berita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>ID Berita</th>
                            <td>{{ $beritaItem['id_berita'] }}</td>
                        </tr>
                        <tr>
                            <th>Judul Berita</th>
                            <td>{{ $beritaItem['judul_berita'] }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi Berita</th>
                            <td>{{ $beritaItem['deskripsi_berita'] }}</td>
                        </tr>
                        <tr>
                            <th>Link Berita</th>
                            <td><a href="{{ $beritaItem['link'] }}" target="_blank">{{ $beritaItem['link'] }}</a></td>
                        </tr>
                        <tr>
                            <th>Gambar</th>
                            <td>
                                <img src="{{ asset('http://raishaapi3.v-project.my.id/storage/' . $beritaItem['gambar']) }}" alt="Gambar Berita"
                                    width="200">
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editBeritaModal{{ $beritaItem['id_berita'] }}" tabindex="-1"
        aria-labelledby="editBeritaModalLabel{{ $beritaItem['id_berita'] }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBeritaModalLabel{{ $beritaItem['id_berita'] }}">Edit Data Berita
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('berita.update', $beritaItem['id_berita']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="judul_berita" class="form-label">Judul Berita</label>
                            <input type="text" class="form-control" id="judul_berita" name="judul_berita"
                                value="{{ $beritaItem['judul_berita'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_terbit" class="form-label">Tanggal Terbit</label>
                            <input type="date" class="form-control" id="tanggal_terbit" name="tanggal_terbit"
                                value="{{ $beritaItem['tanggal_terbit'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi_berita" class="form-label">Deskripsi Berita</label>
                            <input type="text" class="form-control" id="deskripsi_berita" name="deskripsi_berita"
                                value="{{ $beritaItem['deskripsi_berita'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="link" class="form-label">Link Berita</label>
                            <input type="text" class="form-control" id="link" name="link"
                                value="{{ $beritaItem['link'] }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                            @if (!empty($beritaItem['gambar']))
                                <img src="{{ asset('storage/' . $beritaItem['gambar']) }}" alt="Gambar Berita"
                                    width="100" class="mt-2">
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
