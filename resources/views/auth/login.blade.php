@extends('layouts.app')

@section('content')
<div class="container">
    {{-- <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}
    <section class="auth">
        <div class="login">
            <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                <div class="card-body">
                    <div class="row justify-content-center text-center">
                        <div class="col-12">
                            <img
                                src="{{ url('backend/img/logo.png') }}"
                                alt="..."
                                class="img-fluid img-login w-50"
                                />
                        </div>
                    </div>
                    <h5 class="card-title">Login</h5>
                    <div class="card-text">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group ">
                            <label for="email" class="">Masukan {{ __('E-Mail Address') }}</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="password" class="">{{ __('Password') }}</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sign btn-primary mr-4 mb-3 btn-block">
                        Login
                        </button>
                         <a
                        href="{{ route('register') }}"
                        class="btn btn-outline-dark  mb-3 btn-block"
                        >
                        Register
                        </a>
                        {{-- <br />
                        <a href="{{ route('password.request') }}" class="lupa-password">Lupa Password ?</a> --}}
                    </form>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('style')
    <style>
        body {
            background: #D8EBFF !important;
        }
        .card{
            margin-top: 50%;
            border-radius: 20px !important;
        }
        .btn{
            border-radius: 30px !important;
        }
        .btn-sign{
            background: #353434 !important;
        }
        .form-control{
            border-radius: 30px !important;
        }
    </style>
@endpush
