@extends('layouts.new-admin')

@section('title')
    Page Transaksi
@endsection
@section('halaman')
    Page Transaksi
@endsection

@section('content')
    <div class="row my-3">
        <div class="col-12">
            <div class="total-transaksi">
                <div class="card  rounded shadow-sm p-3">
                    <div class="row">
                        <div class="col-md-4 border-right text-success">
                            <h5 class="h1 ">@currency($total_transaksi_sukses)</h5>
                            <p>Total Volume Transaksi</p>
                        </div>
                        <div class="col-md-4 border-right">
                            <h5 class="h1">{{ App\Order::where('status', 'success')->count() }}</h5>
                            <p>Total Transaksi Sukses</p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="h1">{{ App\Order::where('status', 'pending')->count() }}</h5>
                            <p>Total Transaksi Pending</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow-sm mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Tables Mentor </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Status</th>
                            <th>Nama User</th>
                            <th>Tipe Kememberan</th>
                            <th>Jumlah Transaksi</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $t)
                            <tr>
                                <td class="{{ $t->status === 'success' ? 'text-success' : 'text-warning' }}">{{ $t->status }}</td>
                                <td>{{ $t->user->name }}</td>
                                <td>{{ $t->kememberan->nama }}</td>
                                <td>{{ $t->kememberan->harga }}</td>
                            </tr>
                        @empty
                            Tidak Ada Transaksi
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
