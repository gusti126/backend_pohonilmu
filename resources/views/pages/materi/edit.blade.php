@extends('layouts.new-admin')

@section('title')
Edit Materi Video
@endsection
@section('halaman')
Edit Materi Video
@endsection

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <div class="card shadow">
                @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block my-3 mx-3">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <h5 class="card-title">Edit Materi Video</h5>
                <form action="{{ route('update-lesson', ['course_id' => $course_id, 'id' => $item->id]) }}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Nama</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nama" placeholder="Masukan nama" value="{{ $item->nama }}">
                            </div>
                    </div>
                    <div class="col-md-6">
                            <label for="">Video URL</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="video" placeholder="Masukan nama" value="https://www.youtube.com/watch?v={{ $item->video }}">
                            </div>
                    </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Update</button>
                </form>
            </div>
        </div>
    </div>
                <!-- /.container-fluid -->
@endsection
