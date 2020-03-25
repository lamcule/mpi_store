@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-body">
                    <div class="text-center">
                        <img src="{{ asset('/images/logo.png') }}" alt="" width="150px">
                        <h2 class="mt-3">BỘ KẾ HOẠCH VÀ ĐẦU TƯ</h2>
                        <p class="mb-5 text--grey">Phần mềm quản lý ứng dụng nội bộ</p>
                    </div>
                    <form method="POST" action="">
                        @csrf

                        <div class="form-group col-md-6 offset-md-3">
                            <input id="name" type="text"
                                   class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                   value="{{ old('name') }}" required autofocus placeholder="Họ tên">

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 offset-md-3">
                            <input id="email" type="email"
                                   class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                   value="{{ old('email') }}" required placeholder="Địa chỉ email">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 offset-md-3">
                            <input id="password" type="password"
                                   class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" required placeholder="Mật khẩu">

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group col-md-6 offset-md-3">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required placeholder="Nhập lại mật khẩu">
                        </div>

                        <div class="form-group col-md-6 offset-md-3">
                            <button type="submit" class="btn btn-primary form-control font-weight-bold">
                                {{ __('ĐĂNG KÝ') }}
                            </button>
                            <a href="{{ route('auth.loginForm') }}" class="float-right mt-2">Quay lại đăng nhập?</a>
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
           margin-top: 133px;
       }
    </style>
@endpush
