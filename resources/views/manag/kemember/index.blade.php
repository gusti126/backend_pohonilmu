@extends('layouts.admin')

@section('title')
    Member Page
@endsection

@section('content')
    <div class="row my-3">
        <div class="col-6">
            <h4>Halaman Mentor</h4>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('kel-kememberan.create') }}" class="btn btn-primary ">Tambah Kememberan</a>
        </div>
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
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Tables Kememberan </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Akses Kelas</th>
                            <th>Bonus Point</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->harga }}</td>
                                <td>{{ $item->akses_kelas }}</td>
                                <td>{{ $item->get_point }}</td>
                                <td>
                                    <a href="{{ route('kel-kememberan.edit', $item->id) }}" class="btn btn-info btn-sm mr-1">Edit</a>
                                    <form action="{{ route('kel-kememberan.destroy', $item->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5"><h5>Data Kememberan Kosong</h5></td>
                            </tr>
                        @endforelse
                        {{ $items->links() }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
