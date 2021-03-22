@extends('layouts.admin')

@section('title')
    Create Kememberan
@endsection

@section('content')
    <h4>Create Kememberan</h4>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('kel-kememberan.update', $item->id) }}" method="post" enctype="multipart/form-data">
    @method('PUT')
    @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Nama</label>
                    <input type="text" class="form-control" id=""  placeholder="Masukan Nama" name="nama" value="{{ $item->nama }}">
                    <small id="emailHelp" class="form-text text-muted">Nama Atau Judul Kememberan.</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Harga</label>
                    <input type="number" class="form-control" id="" name="harga" value="{{ $item->harga }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Bonus Point</label>
                    <input type="number" class="form-control" id="" name="get_point" value="{{ $item->get_point }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Akses Kelas</label>
                    <input type="number" class="form-control" id="" name="akses_kelas" value="{{ $item->akses_kelas }}">
                </div>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
