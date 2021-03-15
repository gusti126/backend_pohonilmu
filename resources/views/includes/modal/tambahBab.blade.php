<form action="{{ route('chapter-create')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambahBAB" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSayaLabel">Tambah BAB Materi
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <br/>
                    <div class="form-group">
                        <label>Course id</label>
                        <input class="form-control" type="text" placeholder="{{$course_id}}" value="{{$course_id}}" name="course_id" readonly>
                        <label for="">Judul BAB Materi</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
