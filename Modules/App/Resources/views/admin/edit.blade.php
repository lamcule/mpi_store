@extends('layouts.app')

@section('content')
    @if(isset($app))
        <div class="create-app">
            <div class="justify-content-center">
                <div id="kv-avatar-errors-2" class="center-block" style="width:800px;display:none"></div>
                <form method="POST" action="{{ route('admin.app.update',[$app->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="w-100">
                        <div>
                            @if (session('success'))
                                <div class="alert alert-success fade show" role="alert">
                                    <div class="container">
                                        <div>
                                            <strong>{{ session('success') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (session('error') || $errors->any())
                                <div class="alert alert-danger fade show" role="alert">
                                    <div class="container">
                                        <div>
                                            <strong>Cập nhật ứng dụng lỗi.</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if (session('status'))
                                <div class="alert alert-danger fade show" role="alert">
                                    <div class="container">
                                        <div>
                                            <strong>{{ session('status') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-header border-bottom-0 bg--grey">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-3 d-flex align-items-center">
                                        <p>Cập nhật ứng dụng</p>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="float-right">
                                            <button type="submit" class="btn bg--grey text-primary border-primary">Lưu
                                            </button>
                                            <a href="{{ route('admin.app.index') }}"
                                               class="btn bg--grey text-danger border-danger ml-3">Bỏ qua</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container">
                            <div class="create-app__content row padding--top-20">
                                <div class="col-md-2">
                                    <div>
                                        <p>Biểu tượng ứng dụng</p>
                                        <div class="avatar-upload">
                                            <div class="avatar-preview">
                                                {{--@php(dd($app->avatar))--}}
                                                <div id="imagePreview"
                                                     style="background-image: url({{ $app->avatar != null ? asset($app->avatar) : asset('images/app_icon.png') }});">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type='file' id="imageUpload" name="avatar"
                                                   accept=".png, .jpg, .jpeg"/>
                                            <label for="imageUpload" class="text-primary">Thay đổi</label>
                                        </div>
                                    </div>
                                    <div>
                                        <p>Phiên bản:</p>
                                        <p class="text--grey">iOS: {{ $app->iOS_version }}</p>
                                        <p class="text--grey">Android: {{ $app->android_version }}</p>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-6 form-group {{ $errors->has('title') ? 'is-invalid' : '' }}">
                                            <label for="name">Tên ứng dụng</label>
                                            <input type="text" class="form-control bg--grey" id="name" name="title"
                                                   value="{{ $app->title }}">
                                            @if ($errors->has('title'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-3 form-group {{ $errors->has('iOS_version') ? 'is-invalid' : '' }}">
                                            <label for="iOS_version">iOS version</label>
                                            <input type="text" class="form-control bg--grey" id="iOS_version"
                                                   name="iOS_version" value="{{ $app->iOS_version }}">
                                            @if ($errors->has('iOS_version'))
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('iOS_version') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                        <div class="col-md-3 form-group {{ $errors->has('android_version') ? 'is-invalid' : '' }}">
                                            <label for="android_version">Android version</label>
                                            <input type="text" class="form-control bg--grey" id="android_version"
                                                   name="android_version" value="{{ $app->android_version }}">
                                            @if ($errors->has('android_version'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('android_version') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label for="">Mô tả</label>
                                        </div>
                                        <textarea name="description" id="" rows="10"
                                                  class="form-control bg--grey w-100 mb-3">{{ $app->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row image-files">
                                <div class="col-md-12">
                                    <p class="pb-2 border-bottom test">Ảnh màn hình</p>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-0">
                                        @if(!empty($app->media))
                                            @foreach($app->media as $media)
                                                <div class="img-update">
                                                    <input type="hidden" name="image_old[]"
                                                           value="{{ $media->id }}">
                                                    <img src="{{ asset($media->path) }}" alt="">
                                                    <a class="btn btn-sm btn-default btn-outline-secondary delete-image">
                                                        <i class="fa fa-minus"></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="file-loading">
                                        <input id="file-1" type="file" name="images_screen[]" multiple class="file"
                                               data-overwrite-initial="false" data-min-file-count="2">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="app-files">
                            <div class="card-header border-bottom-0 bg--grey">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <p>Bản bulid</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Ngày tải lên</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p>Tên file</p>
                                        </div>
                                        <div class="col-md-2">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="container">
                                <div class="row app-files__row">
                                    <div class="col-md-2">
                                        <p class="{{ $errors->has('iOS_file') ? 'is-invalid' : '' }}">iOS</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text--grey">{{ $app->iOS_file_name ? date('d/m/Y - m:h',strtotime($app->iOS_date)) : '--' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="iOS_file_name" class="text-primary">{{ $app->iOS_file_name }}</p>
                                        @if ($errors->has('iOS_file'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('iOS_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <input class="d-none" type='file' id="iOSFile" name="iOS_file"
                                               value="{{ $app->iOS_path }}"/>
                                        <div class="d-flex justify-content-between">
                                            <i id="deleteiOS" class="far fa-trash-alt text-danger upload-icon"></i>
                                            <label for="iOSFile" style="margin-bottom: 0">
                                                <i class="fas fa-cloud-upload-alt text-primary upload-icon"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0 mb-0">
                                <div class="row app-files__row">
                                    <div class="col-md-2">
                                        <p class="{{ $errors->has('android_file') ? 'is-invalid' : '' }}">Android</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text--grey">{{ $app->android_file_name ? date('d/m/Y - m:h',strtotime($app->android_date)) : '--'}}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <p id="android_file_name" class="text-primary">{{ $app->android_file_name }}</p>
                                        @if ($errors->has('android_file'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('android_file') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <input class="d-none" type='file' id="AndroidFile" name="android_file"
                                               value="{{ $app->android_path }}"/>
                                        <div class="d-flex justify-content-between">
                                            <i id="deleteAndroid" class="far fa-trash-alt text-danger upload-icon"></i>
                                            <label for="AndroidFile">
                                                <i class="fas fa-cloud-upload-alt text-primary upload-icon"></i>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
@section('css')
    <link href="{{ asset('vendor/kartik-v-bootstrap-fileinput/css/fileinput.css') }}" media="all" rel="stylesheet"
          type="text/css">
    <style scope>
        .footer {
            margin-top: 350px;
        }

        i {
            cursor: pointer;
        }

        .avatar-upload {
            position: relative;
            width: 155px;
            height: 155px;
            margin-top: 10px;
        }

        .avatar-edit input {
            display: none;
        }

        .avatar-edit label {
            cursor: pointer;
            margin-left: 50px;
        }

        .avatar-upload .avatar-preview {
            height: 100%;
            position: relative;
        }

        .avatar-upload .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 30px;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        .main-section {
            padding: 20px;
            margin-top: 100px;
            background-color: #fff;
            box-shadow: 0px 0px 20px #c1c1c1;
        }

        .fileinput-remove, .fileinput-upload {
            display: none;
        }

        .file-preview {
            border-radius: unset !important;
            border: unset !important;
            padding: unset !important;
            width: unset !important;
            margin-bottom: unset !important;
        }

        .file-drop-zone {
            border: unset !important;
            border-radius: unset !important;
        }

        .file-drop-zone-title {
            /*display: none;*/
            content: '' !important;
        }

        .file-caption {
            display: none;
        }

        .file-caption-main {
            position: absolute;
            top: -50px;
            right: 0;
            width: 50px;
        }

        .btn-file {
            background-color: #38c172;
            border-color: #38c172;
            border-radius: 50% !important;
            padding: 2px 6px;
        }

        .btn-file i {
            font-size: 14px !important;
        }

        .hidden-xs {
            display: none;
        }

        .file-footer-caption, .file-upload-indicator, .kv-file-upload, .kv-file-zoom {
            display: none !important;
        }

        .kv-file-remove {
            position: absolute;
            top: -260px;
            right: -10px;
            background: #e3342f;
            border: 1px solid #e3342f;
            border-radius: 100%;
        }

        .kv-file-remove i, .delete-image i {
            color: white;
            font-size: 14px;
            position: absolute;
            top: 3px;
            left: 3px;
        }

        .btn-kv {
            width: 20px;
            height: 20px;
            line-height: 20px;
        }

        .krajee-default.file-preview-frame .kv-file-content {
            max-width: 150px;
            height: 250px;
        }

        .krajee-default.file-preview-frame .file-thumbnail-footer {
            height: unset;
        }

        .upload-icon {
            font-size: 20px;
        }

        .table td {
            vertical-align: unset;
        }

        .invalid-feedback {
            display: unset;
        }

        .invalid-feedback strong {
            font-size: 13px;
        }

        .is-invalid {
            color: #e3342f;
            font-weight: bold;
        }

        .file-sortable .file-drag-handle {
            display: none;
        }

        .img-update {
            max-width: 150px;
            height: 250px;
            float: left;
            margin: 10px 10px;
            border: 1px solid #ddd;
            box-shadow: 1px 1px 5px 0 #a2958a;
            position: relative;
        }

        .img-update img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }

        .img-update a {
            position: absolute;
            top: -10px;
            background: #e3342f;
            border: 1px solid #e3342f;
            border-radius: 100%;
            cursor: pointer;
            width: 20px;
            height: 20px;
            line-height: 20px;
            right: -10px;
            padding: 0.25rem 0.5rem;
            font-size: 0.7875rem;
        }

        .file-drop-zone {
            border: unset !important;
            border-radius: unset !important;
            margin: 12px 0;
            padding: 0;
        }

        .krajee-default.file-preview-frame {
            margin: 0 10px 10px 10px;
            padding: 0;
        }

        .file-drop-zone-title {
            display: none;
        }

        .close {
            padding: 0 !important;
            position: unset !important;
        }

    </style>
@endsection
@section('script')
    <script src="{{ asset('vendor/kartik-v-bootstrap-fileinput/js/fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/kartik-v-bootstrap-fileinput/themes/fa/theme.js') }}" type="text/javascript"></script>
    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imageUpload").change(function () {
            readURL(this);
        });

		$("#deleteiOS").click(function () {
			$("#iOSFile").val("");
			$('#iOS_file_name').text('');
		});
		$("#deleteAndroid").click(function () {
			$("#AndroidFile").val("");
			$('#android_file_name').text('');
		});

        $('#iOSFile').change(function () {
            var i = $(this).prev('label').clone();
            var file = $('#iOSFile')[0].files[0].name;
            $('#iOS_file_name').text(file);
        });
        $('#AndroidFile').change(function () {
            var i = $(this).prev('label').clone();
            var file = $('#AndroidFile')[0].files[0].name;
            $('#android_file_name').text(file);
        });
        $('.delete-image').click(function () {
            $(this).parent().remove();
        });
    </script>
    <script type="text/javascript">
        $("#file-1").fileinput({
            theme: 'fa',
            uploadUrl: "/image-view",
            // initialPreview: [
            //     '<img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/Desert.jpg" class="file-preview-image kv-preview-data" style="width:auto;height:auto;max-width:100%;max-height:100%;" alt="image">',
            //     '<img src="http://kartik-v.github.io/bootstrap-fileinput-samples/samples/Lighthouse.jpg" class="file-preview-image kv-preview-data" style="width:auto;height:auto;max-width:100%;max-height:100%;" alt="image">',
            // ],
            uploadExtraData: function () {
                return {
                    _token: $("input[name='_token']").val(),
                };
            },
            // initialPreviewFileType: 'image',
            allowedFileExtensions: ['jpg', 'png', 'gif', 'jpeg'],
            overwriteInitial: false,
            maxFileSize: 2000,
            maxFilesNum: 10,
            slugCallback: function (filename) {
                return filename.replace('(', '_').replace(']', '_');
            }
        });
        $(function () {
            let t = $('.file-caption-main i');
            t.removeClass('fa fa-folder-open');
            t.addClass('fas fa-plus');
            $('.file-caption-main').addClass('justify-content-center')
        });
    </script>
@endsection
