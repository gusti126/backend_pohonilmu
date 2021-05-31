@extends('layouts.new-admin')

@section('title')
    Materi Manage
@endsection
@section('halaman')
   Manage Materi {{ $course->nama }}
@endsection

@section('content')
@php
    $no = 0;
@endphp
    <div class="card p-4">
            <div class="row">
                <div class="col-md-12">
                    <h6>Total BAB {{ $materi->count() }}</h6>
                </div>
                @forelse ($materi as $chapter)
                    <div class="col-md-6 my-3">
                        <div class="card-materi h-100">
                            @php
                                $no++
                            @endphp
                            <span>{{ $no }}</span>
                            <br>
                            <span style="font-weight: bold; margin-bottom: 6px">{{ $chapter->nama }} <a href="{{ route('chapter-edit', $chapter->id) }}" class="text-info">Edit</a> | <a onclick="return confirm('Yakin Ingin di Hapus')" href="{{ route('chapter-hapus', $chapter->id) }}" class="text-danger">Hapus</a> </span>
                            <br>
                                {{-- menggambungkan data lesson perchapter --}}
                                @foreach ($chapter->lesson as $item)
                                    <div class="row mt-2">
                                        <div class="col-12 ">
                                            {{ $item->nama }} <a href="" class="mx-1 text-info " data-toggle="modal" data-target="#tes{{ $item->id }}"> <i class="now-ui-icons media-1_button-play"></i></a> | <a href="{{ route('edit-lesson', ['course_id' => $course_id, 'id' => $item->id]) }}" class="mx-1 text-success"> <i class="now-ui-icons design-2_ruler-pencil"></i></a> |
                                            <a
                                            onclick="return confirm('Yakin Ingin di Hapus')"
                                            href="{{ route('hapus-lesson', $item->id) }}" class="mx-1 text-danger"> <i class="now-ui-icons ui-1_simple-remove"></i></a>
                                            <br>
                                        </div>
                                        {{-- modal cek video --}}
                                        @include('includes.modal.cekVideo')
                                    </div>
                                @endforeach
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary btn-sm my-1 mb-5" data-toggle="modal" data-target="#tambahLesson{{ $chapter->id }}">Tambah Video Materi</button>
                                    {{-- tambah Materi Video --}}
                                    @include('includes.modal.tambahMateri')
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                @empty
                    <h5>Tidak Ada Materi di Kelas ini</h5>
                @endforelse

            </div>


        <hr>
        <a href="" class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#tambahBAB">Tambah BAB</a>
        @include('includes.modal.tambahBab')
    </div>
@endsection
@push('style')
    <style>
        .card-materi{
            padding: 10px;
            border: 1px solid rgb(224, 224, 224);
        }
    </style>
@endpush
