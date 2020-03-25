@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-8 div-setting">

                <section>
                    <div class="setting-header">
                        <h3>Cài đặt</h3>
                    </div>
                    <div class="setting-content">
                        <form method="POST" action="{{ route('admin.setting.settings.update') }}"
                              enctype="multipart/form-data">
                            @csrf
                            {{--@foreach($settings as $setting)--}}
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="">Logo</label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-container">
                                        <input type="file" id="real-input" name="setting_logo_path">
                                        <button type="button" class="browse-btn">
                                            Chọn tệp
                                        </button>
                                        <span class="file-info"></span>
                                    </div>
                                    @if ($errors->has('setting_logo_path'))
                                        <span class="invalid-feedback" role="alert" style="display: block">
                                            <strong>{{ $errors->first('setting_logo_path') }}</strong>
                                        </span>
                                    @endif

                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="">Site name</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="setting_site_name" id="siteName" class="form-control"
                                           value="{{ isset($settings['setting_site_name'])? $settings['setting_site_name'] : ''}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="">Site name small</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="setting_site_name_small" id="siteName" class="form-control"
                                           value="{{ isset($settings['setting_site_name_small'])? $settings['setting_site_name_small'] : ''}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div style="text-align: right">
                                    <button type="submit" class="btn btn-primary  ">Cập nhật</button>
                                    <a href="{{route('admin.app.index')}}" class="btn btn-secondary ">Hủy</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>

            </div>
        </div>

    </div>
@stop

@push('css-stack')
    <style>
        .div-setting {
            margin: 0 auto;
        }

        .div-setting section {
            margin: 20px 0;
        }

        .div-setting section h3 {
            padding-bottom: 10px;
        }

        .input-container {
            /*margin: 3em auto;*/
            /*max-width: 300px;*/
            background-color: #EDEDED;
            /*border: 1px solid #DFDFDF;*/
            border-radius: 5px;
        }

        input[type='file'] {
            display: none;
        }

        .file-info {
            font-size: 0.9em;
        }

        .browse-btn {
            background: #03A595;
            color: #fff;
            min-height: 35px;
            padding: 8px;
            border: none;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .browse-btn:hover {
            background: #4ec0b4;
        }

        .setting-header {
            margin-bottom: 10px;
        }

        .setting-header h3 {
            padding: 10px 0;
            background-color: aliceblue;
            border-radius: 9px;
            width: 100px;
            text-align: center;

        }

        .setting-content .form-group label {
            margin-left: 1rem;
        }
    </style>
@endpush

@section('script')
    <script>
        $(document).ready(function () {

            const uploadButton = document.querySelector('.browse-btn');
            const fileInfo = document.querySelector('.file-info');
            const realInput = document.getElementById('real-input');

            uploadButton.addEventListener('click', (e) => {
                realInput.click();
            });

            realInput.addEventListener('change', () => {
                const name = realInput.value.split(/\\|\//).pop();
                const truncated = name.length > 20
                    ? name.substr(name.length - 20)
                    : name;

                fileInfo.innerHTML = truncated;
            });

        });
    </script>
@stop