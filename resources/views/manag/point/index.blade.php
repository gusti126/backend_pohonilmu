@extends('layouts.admin')

@section('title')
    Management Hadia
@endsection

@section('content')
    <div class="row my-3">
        <div class="col-md-9">
            <div class="card p-3">
                <div class="row">
                    <div class="col border-right">
                        <h6 >Jumlah Hadiah {{ $total_hadiah }}</h6>
                    </div>
                    <div class="col border-right">
                        <h6 >Status Penukaran Sukses {{ $CpenukaranS }}</h6>
                    </div>
                    <div class="col">
                        <h6 >Status Penukaran Pending {{ $CpenukaranP }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 text-right">
            <a href="{{ route('create-hadiah') }}" class="btn btn-primary">Tambah Hadiah</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block my-2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block my-2">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
        @foreach ($items as $item)
            <div class="col-md-4 my-3">
                <div class="card shadow">
                    <img src="{{ $item->image }}" alt="" class="img-fluid">
                    <div class="card-body-hadiah p-2">
                        <p style="font-weight: bold; margin: unset;">{{ $item->note }}</p>
                        {{-- <p>Total Yang Menukarkan Hadiah {{ $item['penukaran_hadiah_count'] }}</p> --}}
                       <div class="text-center">
                            <a href="{{ route('edit-hadiah', $item->id) }}" class="btn btn-primary">Ubah</a>
                        <a href="{{ route('delete-hadiah', $item->id) }}" class="btn btn-outline-danger ml-5">Delete</a>
                       </div>

                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12 my-4">
            {{ $items->links() }}
        </div>

    </div>
    <!-- DataTales Example -->
     {{-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Tables penukaran hadiah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>nama</th>
                            <th>Nomor Telepon</th>
                            <th>Hadiah</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($collect as $item)
                            <tr>
                                <td>{{ $item['user']['name'] }}</td>
                                <td>{{ $item['user']['profile']['no_tlp'] }}</td>
                                <td>{{ $item['hadiah']['note'] }}</td>
                                <td>{{ $item['date'] }}</td>
                            </tr>
                        @empty
                            <h5>Tidak Ada Data Mentor</h5>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}

    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Tables Penukaran Hadiah</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr class="text-center">
                                <th>Status</th>
                                <th>User</th>
                                <th>Hadiah</th>
                                <th>Jumlah Point Hadiah</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tukar_hadiah as $item)
                                <tr>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->hadiah->note }}</td>
                                    <td>{{ $item->hadiah->jumlah_point }}</td>
                                    <td>
                                        <a href="" class="btn btn-info btn-sm">Detail</a>
                                        <a href="{{ route('hendle-hadiah-sukses', $item->id) }}" class="btn btn-success btn-sm">Ubah Sukses</a>
                                    </td>
                                </tr>
                            @empty
                                <h5>Tidak Ada Penukaran Hadiah</h5>
                            @endforelse
                            {{ $tukar_hadiah->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
