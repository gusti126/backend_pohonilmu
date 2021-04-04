@extends('layouts.admin')

@section('title')
    Tambah Pengembang
@endsection

@section('content')
    <h4>Tambah Pengembang</h4>
    <div class="card p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('kel-pengembang.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Pilih Pengembang dari User</label>
                        <select class="selectpicker form-control" data-live-search="true" name="id_user">
                            @foreach ($users as $item)
                                <option data-tokens="{{ $item->name }}" value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">No Rekening GM</label>
                    <input type="text" class="form-control" name="rekening_gm">
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <style>
        .selectpicker{
            border: 1px solid #d1d3e2 !important;
        }
    </style>
@endpush

@push('script')
    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endpush
