@extends('layouts.admin')

@section('title')
    Management Pengembang
@endsection

@section('content')
    <div class="row">
        <div class="col-6">
            <h2>Management Pengembang</h2>
        </div>
        <div class="col-6 text-right">
            <a href="{{ route('kel-pengembang.create') }}" class="btn btn-primary">Tambah Pengembang</a>
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
            <h6 class="m-0 font-weight-bold text-primary"> Data Tables Pengembang</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Total Mentor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ App\Mentor::where('user_id', $item->id)->count() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kel-pengembang.show', $item->id) }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="{{ route('kel-pengembang.edit', $item->id) }}" class="btn btn-primary btn-sm mx-3">Edit</a>
                                    <form action="{{ route('kel-mentor.destroy', $item->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <h5>Tidak Ada Data Pengembang</h5>
                        @endforelse
                        {{ $items->links() }}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
