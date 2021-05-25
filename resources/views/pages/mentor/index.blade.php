@extends('layouts.admin')
@section('title')
    Mentor Page
@endsection
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Mentor Page Index</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Jumlah Data Tables Mentor </h6>
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
                        @forelse ($items as $mentor)
                            <tr>
                                <td>{{ $mentor->nama }}</td>
                                <td>{{ $mentor->profesi }}</td>
                                <td>{{ \App\Course::where('mentor_id', $mentor->id)->count() }}</td>
                                <td class="text-center">
                                    <a href="{{ route('kel-mentor.edit', $mentor->id) }}" class="btn btn-info btn-sm mr-1">Edit</a>
                                    {{-- <form action="{{ route('pengajar.destroy', $mentor->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-outline-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form> --}}
                                </td>
                            </tr>
                        @empty
                            Anda Belum Mendaptarkan Mentor. Daftarkan Mentor dan Ambil Peluan Untuk Mendapatkan Penghasilan Lebih
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
