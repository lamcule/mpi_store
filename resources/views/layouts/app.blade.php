<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
            integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    {{-- Bootstrap --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
          integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    @yield('css')
    @section('styles')
    @show
    @stack('css-stack')
</head>
<body>
<div id="app">
    @if(isset(Auth::user()->id))
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container header">
                <div class="d-flex">
                    <a class="navbar-brand" href="{{ route('admin.app.index') }}">
                        <img src="{{ isset($settings['setting_logo_path']) ? asset($settings['setting_logo_path']) :""}}" width="80" alt="">
                    </a>
                    <div class="site-name pt-3">
                        <h4> {{isset($settings['setting_site_name']) ?$settings['setting_site_name'] : ""}}</h4>
                        <p class="text--grey"> {{ isset($settings['setting_site_name_small']) ? $settings['setting_site_name_small']: ""}}</p>
                    </div>

                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse header__right" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-primary p-0 float-right"
                               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                               v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>
                            <p class="text--grey">{{ Auth::user()->email }}</p>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('auth.logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        <li class="border-left pr-0" style="padding-top:10px">
                            <a href="{{ route('admin.setting.settings.index') }}">
                                <img src="{{ asset('images/setting.png') }}" class="setting" alt="">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    @endif

    <main>
        @yield('content')

    </main>
    <div class="footer">
        <div class="text-center border-top text--grey">
            <p>Bản quyền thuộc về Bộ Kế hoạch và Đầu tư</p>
            <p>Địa chỉ: 6B, Hoàng Diệu, Ba Đình, Hà Nội - ĐT: 080.43485</p>
            <p>Phòng Hành chính - Văn phòng Bộ: 024.38455298 - Fax: 024.38234453. </p>
            <p>Trưởng Ban Biên tập: Nguyễn Như Sơn - Giám đốc Trung tâm Tin học - Email: banbientap@mpi.gov.vn</p>
        </div>
    </div>
</div>
@yield('script')
</body>
</html>
