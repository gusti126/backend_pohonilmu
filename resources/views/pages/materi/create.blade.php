@extends('layouts.admin')

@section('title')
    Materi Manage
@endsection

@section('content')
    Page Materi
    <div class="card p-4">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block my-2">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block my-2">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @forelse ($materi as $chapter)
        <span style="font-weight: bold">{{ $chapter->nama }} <br> </span>
            {{-- mengambuk data lesson perchapter --}}
            @foreach ($chapter->lesson as $item)
                <div class="row">
                    <div class="col-12">
                        {{ $item->nama }} <a href="" class="mx-1 text-primary" data-toggle="modal" data-target="#tes{{ $item->id }}">Cek Video</a> | <a href="{{ route('edit-lesson', ['course_id' => $course_id, 'id' => $item->id]) }}" class="mx-1 text-info">Edit</a> |
                        <a href="" class="mx-1 text-danger">Hapus</a>
                        <br>
                    </div>
                    {{-- modal cek video --}}
                    @include('includes.modal.cekVideo')
                </div>
            @endforeach
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary btn-sm my-1" data-toggle="modal" data-target="#tambahLesson{{ $chapter->id }}">Tambah Video Materi</button>
                    {{-- tambah Materi Video --}}
                    @include('includes.modal.tambahMateri')
                </div>
            </div>
            @empty
            <h4>Belum Ada Materi di Kelas Ini</h4>
        @endforelse
        <hr>
        <a href="" class="btn btn-primary btn-block btn-sm" data-toggle="modal" data-target="#tambahBAB">Tambah BAB</a>
        @include('includes.modal.tambahBab')
    </div>
@endsection
