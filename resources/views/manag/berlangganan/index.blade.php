@extends('layouts.admin')

@section('title')
    Management Berlangganan
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <h2>Management Transaksi Manual</h2>
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
    <div class="row my-3">
        <div class="col-12">
            <div class="total-transaksi">
                <div class="card  rounded shadow-sm p-3">
                    <div class="row">
                        <div class="col-md-3 border-right text-success">
                            <h4 class="h2">@currency($pendapatan)</h4>
                            <p>Total Volume Transaksi</p>
                        </div>
                        <div class="col-md-3 border-right">
                            <h4 class="h2">{{ $transaksi_sukses_count}}</h4>
                            <p>Total Transaksi Sukses</p>
                        </div>
                        <div class="col-md-3 border-right">
                            <h4 class="h2">{{ App\TransaksiManual::where('status', 'pending')->count() }}</h4>
                            <p>Total Transaksi Pending</p>
                        </div>
                        <div class="col-md-3 text-danger">
                            <h4 class="h2">{{ App\TransaksiManual::where('status', 'gagal')->count() }}</h4>
                            <p>Total Transaksi Gagal</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- table pending-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-warning"> Transaksi Pending {{ $transaksi_pending->count() }}</h6>
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
                        @forelse ($transaksi_pending as $tp)
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
                            <h4>Data Transaksi Pending kosong</h4>
                        @endforelse
                    </tbody>
                    {{ $transaksi_pending->links() }}
                </table>
            </div>
        </div>
    </div>

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
                                </td>
                                @include('includes.modal.transaki-manual-gagal')
                            </tr>
                        @empty
                            <h4>Data Transaksi Gagal kosong</h4>
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
