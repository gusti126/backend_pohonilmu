@extends('layouts.admin')

@section('title')
    Kelas Page
@endsection

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1>Kelas Page Ma</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{ route('kelas.create') }}" class="btn btn-primary">Tambah Kelas</a>
        </div>
        <div class="col-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $message }}</strong>
                </div>
            @endif
        </div>
    </div>
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
        <h1>Anda Belum Mempunyai Kelas</h1>
    @endforelse
    {{ $items->links() }}
@endsection


@push('style')
    <style>
        .img-fluid{
            border-radius: 10px;
            height: 140px;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
