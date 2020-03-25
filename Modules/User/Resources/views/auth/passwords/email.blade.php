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
                <form method="POST" action="{{ route('auth.password.email') }}">
                    @csrf

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Địa chỉ email">

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                            @if (session('status'))
                                <span class="valid-feedback" role="alert">
                                    <strong>{{ session('status')  }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Gửi mail quên mật khẩu') }}
                            </button>
                            <a href="{{ route('auth.loginForm') }}" class="float-right">Quay lại đăng nhập?</a>
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
        .form-control{
            height: 50px !important;
        }
        .footer {
            width: 100%;
            margin-top: 360px;
        }
    </style>
@endpush
