@extends('layouts.admin')

@section('title')
    Detail Pengembang
@endsection

@section('content')
    <h5>Detail Pengembang</h5>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                 <div class="row info-static">
                     <div class="col-12 text-center">
                          <img src="{{ $item->profile->image }}" alt="" class="img-fluid rounded-circle img-mentor mb-3">
                          <h3>{{ $item->name }}</h3>
                          <hr>
                     </div>
                     <div class="col border-right text-success">
                         <h5>@currency($pendapatan)</h5>
                         <h6>Pendapatan</h6>
                     </div>
                     <div class="col border-right text-warning">
                         <h5>{{ App\Mentor::where('user_id', $item->id)->count() }}</h5>
                         <h6>Total Mentor</h6>
                     </div>
                     <div class="col border-right">
                         {{-- <h5>{{ App\Mentor::where('user_id', $item->id)->count() }}</h5> --}}
                         @php
                            $tes = App\Mentor::where('user_id', $item->id)->get();
                            $total_course = null;
                            foreach ($tes as $t) {
                               $total_course += App\Course::where('mentor_id', $t->id)->count();
                            }
                            // dd($total_course);
                         @endphp
                         <h5 class="">{{ $total_course }}</h5>
                         <h6>Total Course</h6>
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
        .info-static h5{
            font-weight: bold;
        }
    </style>
@endpush
