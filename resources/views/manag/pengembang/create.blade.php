@extends('layouts.admin')

@section('title')
    Tambah Pengembang
@endsection

@section('content')
    <h4>Tambah Pengembang</h4>
    <div class="card p-4">
        <form action="">
            <div class="form-group">
                <label for="exampleFormControlSelect1">Pilih Pengembang dari User</label>
                <select class="form-control" id="exampleFormControlSelect1" name="role">
                    @foreach ($users as $user)
                        <option value="pengembang">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>
@endsection
