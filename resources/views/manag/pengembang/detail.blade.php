@extends('layouts.admin')

@section('title')
    Detail Pengembang
@endsection

@section('content')
    <h5>Detail Pengembang</h5>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                 <div class="row">
                     <div class="col-12 text-center">
                          <img src="{{ $item->profile->image }}" alt="" class="img-fluid rounded-circle img-mentor mb-3">
                          <h3>{{ $item->name }}</h3>
                          <hr>
                     </div>
                     <div class="col border-right text-success">
                         <h5>@currency($pendapatan)</h5>
                         <h6>Pendapatan</h6>
                     </div>
                     <div class="col border-right">
                         <h5>{{ App\Mentor::where('user_id', $item->id)->count() }}</h5>
                         <h6>Total Mentor</h6>
                     </div>

                 </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .rounded-circle{
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
    </style>
@endpush
