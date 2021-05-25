@extends('layouts.new-admin')

@section('title')
    Create Kememberan
@endsection
@section('halaman')
    Buat Kememberan Baru
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kel-kememberan.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input type="text" class="form-control" id=""  placeholder="Masukan Nama" name="nama" value="{{ old('nama') }}">
                            <small id="emailHelp" class="form-text text-muted">Nama Atau Judul Kememberan.</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Harga</label>
                            <input type="number" class="form-control" id="" name="harga" value="{{ old('harga') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Bonus Point</label>
                            <input type="number" class="form-control" id="" name="get_point" value="{{ old('get_point') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Akses Kelas</label>
                            <input type="number" class="form-control" id="" name="akses_kelas" value="{{ old('akses_kelas') }}">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
