<form action="{{ route('create-lesson', $chapter->course_id)}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="tambahLesson{{ $chapter->id }}" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSayaLabel">{{ $chapter->nama }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <br/>
                    <div class="form-group">
                        <label>Chapter Id</label>
                        <input class="form-control" type="text" placeholder="{{$chapter->nama}}" value="{{$chapter->id}}" name="chapter_id" readonly>
                        <label for="">Judul Video Materi</label>
                        <input type="text" class="form-control" name="nama">
                        <label for="">Url Youtube Video Materi</label>
                        <input type="text" class="form-control" name="video">
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
