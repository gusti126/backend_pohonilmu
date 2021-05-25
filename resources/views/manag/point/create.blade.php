@extends('layouts.new-admin')

@section('title')
    Management Create Hadiah
@endsection
@section('title')
    Buat Hadiah
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

                <form action="{{ route('hadiah-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div id="app">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Pilih Gambar</label>
                                <img :src="gambar" alt="" class="img-fluid w-50 my-2">
                                <input type="file" class="form-control-file" name="image" @change="changeFile">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Note</label>
                                <input type="text" class="form-control" name="note" value="{{ old('note') }}">
                                <small id="emailHelp" class="form-text text-muted">Judul ataupun deskripsi hadiah.</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Jumlah Point</label>
                                <input type="number" class="form-control" name="jumlah_point" value="{{ old('jumlah_point') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>

            </div>
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
