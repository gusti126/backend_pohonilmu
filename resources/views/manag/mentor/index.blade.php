@extends('layouts.new-admin')

@section('title')
    Mentor Page
@endsection

@section('content')
@section('halaman')
    Mentor Page
@endsection
    {{-- <div class="row "> --}}
        {{-- <div class="col-6">
            <h4>Halaman Mentor</h4>
        </div> --}}
        {{-- <div class="col-6 text-right">
            <a href="{{ route('kel-mentor.create') }}" class="btn btn-primary ">Tambah Mentor</a>
        </div> --}}
        {{-- <div class="col-12">
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
        </div> --}}
    {{-- </div> --}}

    <!-- DataTales Example -->
    {{-- <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Tables Mentor {{ $jumlah_mentor }}</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr class="text-center">
                            <th>Nama</th>
                            <th>Profession</th>
                            <th>Total Kelas</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($items as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->profesi }}</td>
                                <td>{{ \App\Course::where('mentor_id', $item->id)->count() }}</td>
                                <td>
                                    <a href="{{ route('pengajar.edit', $item->id) }}" class="btn btn-info btn-sm mr-1">Edit</a>
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
                            <h5>Tidak Ada Data Mentor</h5>
                        @endforelse
                        {{ $items->links() }}
                    </tbody>
                </table>
            </div>
        </div>
    </div> --}}
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="float-left">Jumlah Mentor {{ \App\Mentor::count() }}</h5>

                </div>
                <div class="col-6 text-right">
                    <a href="{{ route('kel-mentor.create') }}" class="btn btn-primary">
                        <i class="now-ui-icons ui-1_simple-add"></i> Tambah Mentor
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Profesi</th>
                        <th>Total Kelas</th>
                        <th class="">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->profesi }}</td>
                            <td>{{ \App\Course::where('mentor_id', $item->id)->count() }}</td>
                            <td>
                                <a href="{{ route('kel-mentor.edit', $item->id) }}" class="btn btn-info btn-sm btn-icon mx-2">
                                    <i class="now-ui-icons design-2_ruler-pencil"></i>
                                </a>
                                <form action="{{ route('kel-mentor.destroy', $item->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm btn-icon mx-2" onclick="return confirm('Hapus Mentor {{ $item->nama }}')">
                                       <i class="now-ui-icons ui-1_simple-remove"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <h5>Tidak Ada Data Mentor</h5>
                    @endforelse
                    {{ $items->links() }}
                </tbody>
            </table>
        </div>
    </div>

@endsection
