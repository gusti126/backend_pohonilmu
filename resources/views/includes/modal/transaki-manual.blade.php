<!-- Modal -->
<div class="modal fade" id="exampleModalCenter{{ $transaksi->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pembayaran {{ $transaksi->user->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="{{ $transaksi->bukti_pembayaran }}" alt="image pembayaran" class="img-fluid">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
       <a href="{{ route('set-sukses-transaksi', $transaksi->id) }}" class="btn btn-success">Ubah Status Sukses</a>
      </div>
    </div>
  </div>
</div>
