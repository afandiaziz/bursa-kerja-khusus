@extends('layouts.app')

@section('content')
    <form action="{{ route('profil.update') }}" method="post" enctype="multipart/form-data" target="_blank">
        @csrf
        <div class="container mb-4 py-4">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <div class="card-title text-white">
                                Edit Data Diri
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floating-input-name" name="name" value="{{ Auth::user()->name }}" autocomplete="off" required>
                                        <label for="floating-input-name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floating-input-email" readonly disabled value="{{ Auth::user()->email }}" autocomplete="off" required>
                                        <label for="floating-input-email" class="form-label">Email <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($criteria as $data)
                                    <div class="{{ $data->children && count($data->children) > 0 ? 'col-md-12 mt-4' : 'col-md-6' }}">
                                        @include('components.forms.form', ['custom' => false])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <button type="submit" class="btn btn-success ms-auto">Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body color-blue">
                            <div class="form-floating form-group mt-3">
                                <input type="file" class="filepond" id="cv" name="cv" data-max-file-size="2MB" accept="application/pdf">
                                <label for="cv" class="form-label">
                                    CV <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/css/tempus-dominus.css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/solid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/fontawesome.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/js/tempus-dominus.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/js/jQuery-provider.js"></script>

    <style>
        .dropzone {
            border: var(--tblr-border-width) dashed var(--tblr-border-color);
        }
        span.select2-container {
            padding-top: 20px
        }
        .form-floating .ts-wrapper.form-control, .form-floating .ts-wrapper.form-select {
            padding-top: 22px !important;
            padding-left: 4px !important;
        }
        .ts-wrapper.multi .ts-control > div {
            background: #206bc4;
            color: #ffffff;
        }
    </style>

    <script>
        function initPicker(i = null, type = null) {
            let currentValue = moment();
            if (i) {
                if (type == 'daterangepicker-dateonly' && $(i).val().trim()) {
                    currentValue = moment(`${$(i).val().split(' - ')[0].split('/')[1]+'/'+$(i).val().split(' - ')[0].split('/')[0]+'/'+$(i).val().split(' - ')[0].split('/')[2]}`)
                }
            }
            $('input.daterangepicker-dateonly').daterangepicker({
                showDropdowns: true,
                locale: {
                    format: 'DD/MM/YYYY',
                },
                ranges: {
                    'Today': [ currentValue, moment() ],
                }
            });
            $('.datetimepicker-dateonly').tempusDominus({
                localization: {
                    locale: 'id',
                    format: 'dd/MM/yyyy',
                    dayViewHeaderFormat: 'MMMM yyyy',
                },
                display: {
                    buttons: {
                        today: false,
                        clear: false,
                        close: false
                    },
                    components: {
                        clock: false,
                        hours: false,
                        minutes: false,
                        seconds: false,
                    },
                    theme: 'light'
                }
            });
            $('.datetimepicker-dateonly').on('show.td', function(e) {
                $('.tempus-dominus-widget .calendar-header').addClass('d-flex justify-content-between')
            });
            $('.datetimepicker-houronly').tempusDominus({
                localization: {
                    locale: 'id',
                    format: 'HH',
                },
                display: {
                    buttons: {
                        today: false,
                        clear: false,
                        close: false
                    },
                    components: {
                        calendar: false,
                        date: false,
                        month: false,
                        year: false,
                        decades: false,
                        clock: true,
                        hours: true,
                        minutes: false,
                        seconds: false,
                    },
                    theme: 'light'
                }
            });
            $('.datetimepicker-timeonly').tempusDominus({
                localization: {
                    locale: 'id',
                    format: 'HH:mm',
                },
                display: {
                    buttons: {
                        today: false,
                        clear: false,
                        close: false
                    },
                    components: {
                        calendar: false,
                        date: false,
                        month: false,
                        year: false,
                        decades: false,
                        clock: true,
                        hours: true,
                        minutes: true,
                        seconds: false,
                    },
                    theme: 'light'
                }
            });
            $('.datetimepicker-datetime').tempusDominus({
                localization: {
                    locale: 'id',
                    format: 'dd/MM/yyyy HH:mm:00',
                    dayViewHeaderFormat: 'MMMM yyyy',
                },
                display: {
                    buttons: {
                        today: false,
                        clear: false,
                        close: false
                    },
                    components: {
                        calendar: true,
                        date: true,
                        month: true,
                        year: true,
                        decades: true,
                        clock: true,
                        hours: true,
                        minutes: true,
                        seconds: false,
                    },
                    theme: 'light'
                }
            });
            $('.datetimepicker-datetime').on('show.td', function(e) {
                $('.tempus-dominus-widget .calendar-header').addClass('d-flex justify-content-between')
            });
            $('.datetimepicker-minutesecondonly').tempusDominus({
                localization: {
                    locale: 'id',
                    format: 'mm:ss',
                },
                display: {
                    buttons: {
                        today: false,
                        clear: false,
                        close: false
                    },
                    components: {
                        calendar: false,
                        date: false,
                        month: false,
                        year: false,
                        decades: false,
                        clock: true,
                        hours: false,
                        minutes: true,
                        seconds: true,
                    },
                    theme: 'light'
                }
            });
        }
    </script>

    <script>
        let defaultFiles = [];
        FilePond.registerPlugin(
            // encodes the file as base64 data
            // FilePondPluginFileEncode,

            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize,
            // corrects mobile image orientation
            FilePondPluginImageExifOrientation,
            // previews dropped images
            FilePondPluginImagePreview
        );
        initPicker();
    </script>
@endsection

@section('script')
    <script>
        $('#cv.filepond').filepond();
    </script>
@endsection
