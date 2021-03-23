@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
<h3 class="my-3">Dashboard Management</h3>
    <div class="row">
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-success p-3">
                <h5>Pendapatan @currency($pendapatan) </h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-info p-3">
                <h5>Bayar Semua Mentor @currency($bayar_mentor) </h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-warning p-3">
                <h5>Sisa Uang @currency($sisa_uang)</h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-danger p-3">
                <h5>Jumlah Pengembang : {{ $count_pengembang }}</h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-danger p-3">
                <h5>Jumlah Mentor : {{ $count_mentor }}</h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-secondary p-3">
                <h5>Jumlah Kelas : {{ $count_kelas }}</h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-success p-3">
                <h5>Jumlah Episode : {{ $count_chapter }}</h5>
            </div>
        </div>
        <div class="col-md-4 my-1">
            <div class="card shadow border-left-warning p-3">
                <h5>Jumlah Materi atau Video : {{ $count_lesson }}</h5>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-12">
            <h5>Pendapatan Tiap Kelas</h5>
        </div>
        @foreach ($kelas as $k)
            <div class="col-md-4 my-2">
                <div class="card shadow-sm">
                    <img class="card-img-top" src="{{ $k->image }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $k->nama }}</h5>
                        <p class="text-primary">
                            {{ $k->kategori->nama }}
                            <span class="text-dark float-right">
                                <i class="fa fa-users" aria-hidden="true"></i>
                                {{ \App\MyCourse::where('course_id', $k->id)->count() }}
                            </span>
                        </p>
                        <p>Pendapatan : Rp.{{ \App\MyCourse::where('course_id', $k->id)->count()*100 }}.00</p>
                        <p>Mentor : {{ $k->mentor->nama }} {{ $k->mentor->no_rekening }}</p>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-12 my-3">
            {{ $kelas->links() }}
        </div>
    </div>

@endsection

@push('style')
    <style>
        .card-img-top{
            height: 175px;
            width: 100%;
            object-fit: cover;
        }
    </style>
@endpush
