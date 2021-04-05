<!-- Modal suksess-->
<div class="modal fade" id="exampleModalCenter{{ $ts->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Bukti Pembayaran {{ $ts->user->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
            <div class="col-md-6"><span style="font-weight: bold">Nama</span></div>
            <div class="col-md-6">
                {{ $ts->user->name }}
            </div>

            <div class="col-md-6"><span style="font-weight: bold">Email</span></div>
            <div class="col-md-6">
                {{ $ts->user->email }}
            </div>

            <div class="col-md-6"><span style="font-weight: bold">Tipe Kememberan</span></div>
            <div class="col-md-6">
                {{ $ts->kememberan->nama }}
            </div>

            <div class="col-md-6"><span style="font-weight: bold">Kode Referal</span></div>
            <div class="col-md-6">
                @if ($ts->referal === null)
                    Tidak Memasukan Kode
                @else
                    {{ $ts->referal }}
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <img src="{{ $ts->bukti_pembayaran }}" alt="image pembayaran" class="img-fluid">
            </div>
        </div>
        {{-- @if ($ts->referal === null)
                        <td>Tidak Memasukan Kode</td>
                    @else
                        <td>{{ $ts->referal }}</td>
                    @endif --}}
      </div>
      <div class="modal-footer">
        <a href="{{ route('set-gagal-transaksi', $ts->id) }}" class="btn btn-outline-danger">Set Gagal</a>
       <a href="{{ route('set-sukses-transaksi', $ts->id) }}" class="btn btn-success ml-3">Set Sukses</a>
      </div>
    </div>
  </div>
</div>
