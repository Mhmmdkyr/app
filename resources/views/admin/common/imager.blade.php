<!DOCTYPE html>
<html lang="en">

<head>
    <title>Imager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="{{ url('/') }}/backend/css/common/imager.css?version?<?= VERSION ?>">
    <link rel="stylesheet" href="{{ url('/') }}/backend/css/common/jquery.fancybox.min.css?version?<?= VERSION ?>">
    <link rel="stylesheet" href="{{ url('/') }}/backend/css/jquery.Jcrop.css?version=<?= VERSION ?>" />
    <style media="screen">
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation-name: spin;
            animation-duration: 5000ms;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        .uploading {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            z-index: 12;
            background: #fff;
            padding-top: 140px;
            display: none
        }

        .uploading.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="library-tab" data-bs-toggle="tab" data-bs-target="#library"
                            type="button" role="tab" aria-controls="library" aria-selected="true"><i
                                data-feather="image" style="width: 15px"></i>
                            {{ __('Image Library') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="upload-tab" data-bs-toggle="tab" data-bs-target="#upload"
                            type="button" role="tab" aria-controls="upload" aria-selected="false"><i
                                data-feather="upload" style="width: 15px"></i>
                            {{ __('Upload Images') }}</button>
                    </li>
                    <li class="nav-item d-none" role="presentation">
                        <button class="nav-link" id="cropper-tab" data-bs-toggle="tab" data-bs-target="#cropper"
                            type="button" role="tab" aria-controls="cropper" aria-selected="false"></button>
                    </li>
                    <li class="nav-item display-selected d-none ms-auto">
                        <a class="nav-link text-danger text-small pe-0" id="delete_images" href="javascript:;"
                            data-bs-container="body" data-bs-toggle="popover" data-bs-placement="left"
                            title="File deletion confirmation" data-bs-html="true"
                            data-bs-content="<span class='selected-count'><span></span></span> selected files will be completely deleted. <br><small class='text-danger'>Do you confirm?</small><br /><hr /><a class='btn btn-danger btn-sm ms-auto delete-images' href='#'>Delete Files</a>"
                            aria-current="page" href="#"><small><i data-feather="trash"
                                    style="width: 15px; display: inline-block; margin-top: -4px"></i> Delete</small></a>
                    </li>
                    <li class="nav-item display-selected d-none">
                        <a class="nav-link text-muted text-small pe-0" href="javascript:;" onClick="deselect()"
                            aria-current="page" href="#"><small><i data-feather="x"
                                    style="width: 15px; display: inline-block; margin-top: -4px"></i>
                                Deselect</small></a>
                    </li>

                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade text-center" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                        <div class="upload-area align-middle">
                            <form action="{{ url('/') }}/admin/imager/upload" method="post"
                                enctype="multipart/form-data" id="upload_form">
                                <input type="file" name="files[]" multiple id="upload-input">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                            <i data-feather="upload" style="width: 60px !important; height: 60px;"></i>
                            <h4>Dosyaları buraya sürükleyin</h4>
                            <small class="text-muted d-block mb-2">ya da</small>
                            <P><a href="" class="btn btn-outline-primary">Dosya Seçin</a></P>


                        </div>
                        <div class="uploading text-center">
                            <i data-feather="loader" class="spin text-muted"
                                style="width: 50px; height: 50px; display: inline-block; margin-bottom: 20px"></i>
                            <p><small>Dosyalarınız sunucuya yükleniyor...</small></p>
                            <h4 class="text-dark mt-0 pt-0">Lütfen Bekleyin</h4>
                        </div>
                    </div>
                    <div class="tab-pane fade show active pt-3 pb-2" id="library" role="tabpanel"
                        aria-labelledby="library-tab">
                        <div class="library-repository" style="padding-right: 10px !important">
                            <div class="row image-scaffold">
                                <div class="loading-div text-muted">Yükleniyor...</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <hr>
                                <div class="row">
                                    <div class="col-5">
                                        <b class="selected-count text-muted d-none"><i data-feather="layers"
                                                style="width: 15px"></i> <span></span> <b></b></b>
                                    </div>
                                    <div class="col-7 text-end">
                                        <button onclick="close_modal()"
                                            class="btn btn-link text-muted text-decoration-none me-4 btn-sm">{{ __('Cancel') }}</button>
                                        <button disabled class="btn btn-primary btn-sm add_image_button"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade p-0" id="cropper" role="tabpanel" aria-labelledby="cropper-tab">
                        <div id="cropper-main" style="width: 100%; height: calc(100vh - 155px); overflow: hidden">
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var url = "{{ url('/') }}";
        var lang_add_image = "{{ __('Add Image') }}";
        var lang_add_images = "{{ __('Add Images') }}";
        var lang_selected_image = "{{ __('Selected Image') }}";
        var lang_selected_images = "{{ __('Selected Images') }}";
        var csrf_token = '{{ csrf_token() }}';
    </script>
    <script src="{{ url('/') }}/backend/js/common/common.js?version=<?= VERSION ?>"></script>
    <script src="{{ url('/') }}/backend/js/common/jquery.fancybox.min.js?version=<?= VERSION ?>"></script>
    <script src="{{ url('/') }}/backend/js/jquery.Jcrop.js?version=<?= VERSION ?>"></script>
    <script src="{{ url('/') }}/backend/js/common/imager.js?version=<?= VERSION ?>"></script>
    
</body>

</html>
