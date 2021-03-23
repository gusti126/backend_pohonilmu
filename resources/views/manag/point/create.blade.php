@extends('layouts.admin')

@section('title')
    Management Create Hadia
@endsection

@section('content')
    <h5>Buat Hadiah Page</h5>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form action="{{ route('hadiah-store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div id="app">
            <div class="row">
                <div class="col-md-6">
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
