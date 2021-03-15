@extends('layouts.manag')

@section('title')
    Tambah Mentor
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
    <div id="app">
        <h3>Tambah Mentor</h3>
            <form action="{{ route('kel-mentor.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card p-4">
                    {{-- 'nama', 'email', 'profesi', 'image', 'no_rekening', 'user_id' --}}
                    <div id="app">
                        <div class="row">
                            <div class="col-4">
                                <img :src="gambar" alt="" class="img-fluid w-50 mb-2">
                                <input type="file" name="image" class="form-control-file" @change="changeFile">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Nama</label>
                                <input type="text" name="nama" class="form-control" placeholder="Nama Mentor .." value="{{ old('nama') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Profesi</label>
                                <input type="text" class="form-control" name="profesi" placeholder="Profesi Mentor .." value="{{ old('profesi') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">no rekening</label>
                                <input type="number" class="form-control" name="no_rekening" placeholder="no rekening Mentor .." value="{{ old('no_rekening') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="">Pengembang</label>
                            <select name="user_id" id="" class="form-control">
                                <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                @foreach ($pengembang as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan Mentor</button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
@endsection

@push('script')
   <script src="{{ url('backend/vendor/vue/vue.js') }}"></script>
    <script>

        var vm = new Vue({
            el : "#app",
            data : {
                gambar: '',
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
