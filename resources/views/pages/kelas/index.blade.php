@extends('layouts.new-admin')

@section('title')
    Kelas Page
@endsection
@section('halaman')
    Kelas Page
@endsection

@section('content')

    @if (Auth::user()->role === 'pengembang')
        @forelse ($items as $item)
            <div class="card p-4 my-2">
                <div class="row">
                        <div class="col-12">
                            <h6>List Kelas : {{ $item->nama }}</h6>
                            <hr>
                        </div>
                        @foreach ($item->course as $c)
                            <div class="col-md-3 my-2">
                                <img src="{{ $c->image }}" alt="" class="img-fluid">
                                <br>
                                <h6 style="color: black" class="mt-2">{{ $c->nama }}</h6>
                                <a href="{{ route('kelas.edit', $c->id) }}" class="btn btn-info btn-sm">Edit</a>
                                <a href="{{ route('materi', $c->id) }}" class="btn btn-primary btn-sm mx-3">Materi</a>
                                <form action="{{ route('kelas.destroy', $c->id) }}" method="post" class="d-inline">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-outline-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @endforeach
                </div>
            </div>
            @empty
                <h4>Anda Belum Mempunyai Kelas</h4>
        @endforelse
        {{ $items->links() }}
    @endif
    <div class="card">
        <div class="card-body">
            @if (Auth::user()->role === 'admin')
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
                    </div>
                        @foreach ($all_kelas as $k)
                                <div class="col-md-4 my-2">
                                    <div class="card card-kelas shadow-sm">
                                        <img class="card-img-top" src="{{ $k->image }}" alt="Card image cap">
                                        <div class="card-body">
                                            <h6>{{ $k->nama }}</h6>
                                            <p class="text-primary">
                                                {{ $k->kategori->nama }}
                                                <span class="text-dark float-right">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                    {{ \App\MyCourse::where('course_id', $k->id)->count() }}
                                                </span>
                                            </p>
                                            <p>Pendapatan : Rp.{{ \App\MyCourse::where('course_id', $k->id)->count()*100 }}.00</p>
                                            <p>Mentor : {{ $k->mentor->nama }} {{ $k->mentor->no_rekening }}</p>
                                        <a href="{{ route('kelas.edit', $k->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <a href="{{ route('materi', $k->id) }}" class="btn btn-primary btn-sm mx-3">Materi</a>
                                            <form action="{{ route('kelas.destroy', $k->id) }}" method="post" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus Kelas ?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        <div class="col-12 my-3">
                            {{ $all_kelas->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


@push('style')
    <style>
        .card-kelas{
            border: 1px solid rgb(160, 153, 153);
        }
        .img-fluid{
            border-radius: 10px;
            height: 140px;
            width: 100%;
            object-fit: cover;
        }
        .card-img-top{
            height: 175px;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
