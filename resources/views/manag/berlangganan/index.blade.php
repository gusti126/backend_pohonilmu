@extends('layouts.new-admin')

@section('title')
    Management Transaksi
@endsection
@section('halaman')
    Management Transaksi
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block my-2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="total-transaksi">
                <div class="card  rounded shadow-sm p-3">
                    <div class="row">
                        <div class="col-md-3 border-right text-success">

                            <h4 class="h4">
                                <i class="now-ui-icons business_money-coins"></i>
                                @currency($pendapatan)
                            </h4>
                            <p>Total Volume Transaksi</p>
                        </div>
                        <div class="col-md-3 text-primary border-right">
                            <h4 class="h4">
                                <i class="now-ui-icons ui-1_check"></i>
                                {{ $transaksi_sukses_count}}
                            </h4>
                            <p>Total Transaksi Sukses</p>
                        </div>
                        <div class="col-md-3 text-warning border-right">
                            <h4 class="h4">
                                <i class="now-ui-icons ui-1_bell-53"></i>
                                {{ App\TransaksiManual::where('status', 'pending')->count() }}
                            </h4>
                            <p>Total Transaksi Pending</p>
                        </div>
                        <div class="col-md-3 text-danger">
                            <h4 class="h4">
                                 <i class="now-ui-icons ui-1_simple-remove"></i>
                                {{ App\TransaksiManual::where('status', 'gagal')->count() }}
                            </h4>
                            <p>Total Transaksi Gagal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     @livewire('admin.manualtransaksi.index')

     <!-- table sukses-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger"> Transaksi gagal {{ $transaksi_gagal->count() }}</h6>
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
                        @forelse ($transaksi_gagal as $tg)
                            <tr>
                                <td class="text-danger">{{ $tg->status }}</td>
                                <td>{{ $tg->user->email }}</td>
                                <td>{{ $tg->kememberan->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#exampleModalCenter{{ $tg->id }}">
                                    Cek Pembayaran
                                    </button>
                                    @include('includes.modal.transaki-manual-gagal')
                                </td>
                        @empty
                                <td colspan="4"><h6>Data Transaksi Gagal kosong</h6></td>
                            </tr>
                        @endforelse
                    </tbody>
                    {{ $transaksi_gagal->links() }}
                </table>
            </div>
        </div>
    </div>

     <!-- table sukses-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-success"> Transaksi Sukses {{ $transaksi_sukses_count }}</h6>
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
                        @forelse ($transaksi_sukses as $ts)
                            <tr>
                                <td class="text-success">{{ $ts->status }}</td>
                                <td>{{ $ts->user->email }}</td>
                                <td>{{ $ts->kememberan->nama }}</td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm m-2" data-toggle="modal" data-target="#exampleModalCenter{{ $ts->id }}">
                                    Cek Pembayaran
                                    </button>
                                </td>
                                @include('includes.modal.transaki-manual-sukses')
                            </tr>
                        @empty
                            <h4>Data Transaksi Suksess kosong</h4>
                        @endforelse
                    </tbody>
                    {{ $transaksi_sukses->links() }}
                </table>
            </div>
        </div>
    </div>
@endsection
