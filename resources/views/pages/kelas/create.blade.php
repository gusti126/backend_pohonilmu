@extends('layouts.admin')

@section('title')
    Tambah Kelas
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
        <h3>Tambah Kelas</h3>
            <form action="{{ route('kelas.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="card p-4">
                    <div class="row">
                        <div class="col-md-3">
                            <img :src="gambar" alt="" class="img-fluid">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlFile1">Masukan Gambar</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image" @change="changeFile">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Pilih Mentor</label>
                            <select class="form-control" name="mentor_id">
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Pilih Kategori Utama</label>
                            <select class="form-control" name="kategori_id" v-model="pick" @change="onChange($event)">
                                {{-- @foreach ($kategori as $item)
                                    <option>{{ $item->nama }}</option>
                                @endforeach --}}
                                 <option v-for="s in selected" :value="s.id">@{{ s.nama }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="">Pilih Sub Kategori</label>
                            <select class="form-control" name="sub_kategori" v-if="kategori">
                                <option  v-for="k in kategori" :value="k.nama">@{{ k.nama }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="">Judul Kelas</label>
                            <input type="text" class="form-control" placeholder="Masukan judul kelas ..." name="nama" value="{{ old('nama') }}">
                        </div>
                        <div class="col-md-6">
                            <label for="">Price Kelas</label>
                            <input type="number" class="form-control" placeholder="Masukan harga kelas ..." name="harga" value="{{ old('harga') }}">
                        </div>
                        <div class="col-md-12">
                            <label for="">Deskripsi</label>
                            <textarea name="deskripsi" id="" cols="30" rows="10" class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary my-3 btn-block">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
    </div>
@endsection


@push('script')
    <script src="//cdn.ckeditor.com/4.16.0/basic/ckeditor.js"></script>
   <script src="{{ url('backend/vendor/vue/vue.js') }}"></script>
    <script>

        var vm = new Vue({
            el : "#app",
            data : {
                selected: [
                    @foreach($kategori as $k)
                        {
                            id: {{ $k->id }},
                            nama: "{{ $k->nama }}",
                        },
                    @endforeach
                ],
                pick: null,
                kategori : null,
                formal : [
                    {
                        id: 1,
                        nama: 'Sekolah Dasar 1'
                    },
                    {
                        id: 2,
                        nama: 'Sekolah Dasar 2'
                    },
                    {
                        id: 3,
                        nama: 'Sekolah Dasar 3'
                    },
                    {
                        id: 4,
                        nama: 'Sekolah Dasar 4'
                    },
                    {
                        id: 5,
                        nama: 'Sekolah Dasar 5'
                    },
                    {
                        id: 6,
                        nama: 'Sekolah Dasar 6'
                    },
                    {
                        id: 7,
                        nama: 'SMP 1'
                    },
                    {
                        id: 8,
                        nama: 'SMP 2'
                    },
                    {
                        id: 9,
                        nama: 'SMP 3'
                    },
                    {
                        id: 10,
                        nama: 'SMA 1'
                    },
                    {
                        id: 11,
                        nama: 'SMA 2'
                    },
                    {
                        id: 12,
                        nama: 'SMA 3'
                    },

                ],
                informal : [
                    {
                        id: 1,
                        nama : 'Petani',
                    },
                    {
                        id: 2,
                        nama : 'Peternak',
                    },
                    {
                        id: 3,
                        nama : 'Tukang',
                    },
                    {
                        id: 4,
                        nama: 'Buruh',
                    },
                ],
                softskill : [
                    {
                        id: 1,
                        nama: "Komunikasi"
                    },
                    {
                        id: 2,
                        nama: "Kepemimpinan"
                    },
                    {
                        id: 3,
                        nama: "Keuangan"
                    },
                    {
                        id: 4,
                        nama: "Kolaborasi"
                    },
                ],
                hardskill : [
                    {
                        id: 1,
                        nama: "Teknologi"
                    },
                    {
                        id: 2,
                        nama: "Analisa Data"
                    },
                    {
                        id: 3,
                        nama: "Marketing"
                    },
                    {
                        id: 4,
                        nama: "Sales"
                    },
                ],
                gambar : '',

            },
            mounted(){
                console.log(this.gambar);
            },
             methods: {
                changeFile(event) {
                const file = event.target.files[0]
                this.gambar = URL.createObjectURL(file)
                },
                onChange(event) {
                    console.log(event.target.value);
                    // this.kategori = this.formal;
                    if(this.pick === 1){
                        this.kategori = this.formal;
                    }
                    if(this.pick === 2){
                        this.kategori = this.informal;
                    }
                    if(this.pick === 3){
                        this.kategori = this.softskill;
                    }
                    if(this.pick === 5){
                        this.kategori = this.hardskill;
                    }

                    // console.log(this.pick);
                },
                 changeItem: function changeItem(rowId, event) {
                    this.selected = "rowId: " + rowId + ", target.value: " + event.target.value;
                    }
            }
        });
         CKEDITOR.replace( 'deskripsi' );
    </script>
@endpush
