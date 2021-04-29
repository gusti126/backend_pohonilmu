@extends('layouts.admin')

@section('title')
    Edit BAB
@endsection

@section('content')
    <h1>Edit BAB</h1>
    <form action="{{ route('chapter-update', $item->id) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-md-12">
                <label for="">Judul BAB Materi</label>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                    </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary ">Update</button>
    </form>
@endsection
