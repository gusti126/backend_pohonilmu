@extends('layouts.admin')

@section('title')
    Management Berlangganan
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <h2>Management Berlangganan</h2>
        </div>
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block my-2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>
     <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Data Tables Request Berlangganan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Status</th>
                            <th>Nama User</th>
                            <th>Email</th>
                            <th>Kode Refrensi</th>
                            <th>Tipe Keanggotaan</th>
                            <th>Bukti Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi_manual as $transaksi)
                            <tr>
                                <td>{{ $transaksi->status }}</td>
                                <td>{{ $transaksi->user->name }}</td>
                                <td>{{ $transaksi->user->email }}</td>
                                @if ($transaksi->referal === null)
                                    <td>Tidak Memasukan Kode</td>
                                @else
                                    <td>{{ $transaksi->referal }}</td>
                                @endif

                                <td>{{ $transaksi->kememberan->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModalCenter{{ $transaksi->id }}">
                                    Bukti
                                    </button>
                                    <a href="{{ route('set-gagal-transaksi', $transaksi->id) }}" class="btn btn-outline-danger btn-sm">Set Gagal</a>
                                </td>
                                <td></td>
                                @include('includes.modal.transaki-manual')
                            </tr>
                        @empty
                            <h4>Data request berlangganan kosong</h4>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
