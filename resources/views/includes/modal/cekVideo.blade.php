 <div class="modal fade" id="tes{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalSayaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalSayaLabel">BAB {{ $chapter->nama }}
                    <br>
                    <span style="font-weight: normal">{{ $item->nama }}</span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <br/>
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $item->video }}" allowfullscreen>
                    </iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                {{-- <button type="button" class="btn btn-primary">Oke</button> --}}
            </div>
        </div>
    </div>
</div>
