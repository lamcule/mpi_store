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
                    <form method="POST" action="{{ route('auth.password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" placeholder="Địa chỉ email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" placeholder="Mật khẩu" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" placeholder="Xác nhận mật khẩu" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Thay đổi mật khẩu') }}
                                </button>
                                <a href="{{ route('auth.loginForm') }}" class="float-right">Đăng nhập lại?</a>
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
        .form-control {
            height: 50px !important;
        }

        .footer {
            width: 100%;
            margin-top: 278px;
        }
    </style>
@endpush
