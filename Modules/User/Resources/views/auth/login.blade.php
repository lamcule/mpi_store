@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('/images/logo.png') }}" alt="" width="150px">
                        <h2 class="mt-3">BỘ KẾ HOẠCH VÀ ĐẦU TƯ</h2>
                        <p class="mb-5 text--grey">Phần mềm quản lý ứng dụng nội bộ</p>
                    </div>
                    <form method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }} bg--grey" name="email" value="{{ old('email') }}" required autofocus placeholder="Tài khoản">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} bg--grey" name="password" value="{{ old('password') }}" required placeholder="Mật khẩu">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary d-block w-100 font-weight-bold">
                                    {{ __('ĐĂNG NHẬP') }}
                                </button>
                                <div class="mt-2">
                                    @if (Route::has('auth.password.request'))
                                        <a class="btn-link pl-0 text-danger" href="{{ route('auth.password.request') }}">
                                            {{ __('Quên mật khẩu?') }}
                                        </a>
                                    @endif
                                        <a href="{{ route('auth.registerForm') }}" class="btn-link pl-0 float-right">Đăng ký tài khoản</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
@push('css-stack')
    <style scope>
        .form-control, .btn{
            height: 50px !important;
        }
        .footer {
            width: 100%;
            margin-top: 250px;
        }

    </style>
@endpush
