@extends('layouts.new-admin')

@section('title')
    Edit Mentor
@endsection
@section('halaman')
    Edit Mentor
@endsection

@section('content')
    <div class="card shadow p-4">
        <form action="{{ route('kel-mentor.update', $item->id) }}" method="post" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <div id="app">
                    <div class="row text-center justify-content-center mb-3">
                        <div class="col-md-3">
                            <img :src="gambar" alt="" class="img-fluid rounded-circle img-mentor">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Ganti gambar</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image" @change="changeFile">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label for="">Nama</label>
                        <input type="text" class="form-control" value="{{ $item->nama }}" name="nama">
                    </div>
                    <div class="col-md-4">
                        <label for="">Email</label>
                        <input type="email" class="form-control" value="{{ $item->email }}" name="email">
                    </div>
                    <div class="col-md-4">
                        <label for="">Profession</label>
                        <input type="text" class="form-control" value="{{ $item->profesi }}" name="profesi">
                    </div>
                    @if (Auth::user()->role === 'admin')
                        <div class="col-md-4">
                            <label for="">Pengembang</label>
                            <select name="user_id" class="form-control">
                                <option value="{{ $item->user->id }}">{{ $item->user->name }}</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection

@push('style')
    <style>
        .rounded-circle{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush

@push('script')
   <script src="{{ url('backend/vendor/vue/vue.js') }}"></script>
    <script>

        var vm = new Vue({
            el : "#app",
            data : {
                gambar: '{{ $item->image }}',
            },
            mounted(){
                console.log(this.gambar);
            },
             methods: {
                changeFile(event) {
                const file = event.target.files[0]
                this.gambar = URL.createObjectURL(file)
                }
            }
        });
    </script>
@endpush
