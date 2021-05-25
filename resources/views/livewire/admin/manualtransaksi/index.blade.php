<div>
    <!-- table pending-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning"> Transaksi Pending {{ $pending->count() }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" >
                    <thead>
                        <tr class="text-center">
                            <th>Status</th>
                            <th>Email</th>
                            <th>Tipe Keanggotaan</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pending as $tp)
                            <tr>
                                <td class="text-warning">{{ $tp->status }}</td>
                                <td>{{ $tp->user->email }}</td>
                                <td>{{ $tp->kememberan->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#exampleModalCenter{{ $tp->id }}">
                                    Cek Pembayaran
                                    </button>
                                    @include('includes.modal.transaki-manual')
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center"><h6>Data Transaksi Pending kosong</h6></td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        window.addEventListener('swal',function(e){
            Swal.fire(e.detail);
        });
        window.livewire.on('depositUpdate', () => {
            $('#edit').removeClass('d-none');
        });
    </script>
@endpush
