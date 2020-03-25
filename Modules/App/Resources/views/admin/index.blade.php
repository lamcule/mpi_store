@extends('layouts.app')

@section('content')
    <div class="card-header border-bottom-0 bg--grey">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <form method="POST" id="form" action="{{ route('admin.app.search') }}">
                        @csrf
                        <div class="form-group has-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" id="search" class="form-control" name="text_search"
                                   placeholder="Tìm kiếm">
                        </div>
                    </form>
                </div>
                <div class="col-md-9">
                    <a href="{{ route('admin.app.create') }}" class="float-right">
                        <img src="{{ asset('images/plus.png') }}" width="32px" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container list-app">
        <div class="row justify-content-center mr-0 ml-0">
            <div class="w-100">
                <div class="list-app__content d-block">
                    @if(isset($apps))
                        @foreach($apps as $app)
                            <div class="app-item float-left">
                                <div class="d-block text-center">
                                    <a href="{{ route('admin.app.edit',[$app->id]) }}">
                                        <img src="{{  $app->avatar != null ? asset( $app->avatar ) : asset('images/app_icon.png') }}"
                                             alt="">
                                    </a>
                                </div>
                                <div class="app-item__info text--grey">
                                    <a href="{{ route('admin.app.edit',[$app->id]) }}">
                                        <h5 class="font-weight-bold text--grey">{{ $app->title }}</h5>
                                    </a>
                                    <p>iOS: {{ $app->iOS_version }}</p>
                                    <p>Android: {{ $app->android_version }}</p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css-stack')
    <style scope>
        .footer {
            margin-top: 350px;
        }

        .form-group {
            margin-bottom: 0;
        }

        #search {
            border-radius: 20px;
        }
    </style>
@endpush
@section('script')
    <script>
        $('#search').keypress(function (e) {
            if (e.which === 13) {
                $('#form').submit();
                return false;
            }
        });
    </script>
@endsection
