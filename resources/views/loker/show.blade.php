@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row">
            <div class="col-lg-9 col-12">
                @include('loker/detail')
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('assets/plugins/tempus-dominus/tempus-dominus.css') }}" rel="stylesheet"  />
    <link href="{{ asset('assets/plugins/tom-select/tom-select.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/filepond/filepond.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/filepond/filepond-plugin-image-preview.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"  />

    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.jquery.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-plugin-file-encode.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-plugin-file-validate-size.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-plugin-file-validate-type.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-plugin-image-exif-orientation.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-plugin-image-preview.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tom-select/tom-select.complete.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/momentjs/moment.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/font-awesome/solid.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/font-awesome/fontawesome.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempus-dominus/tempus-dominus.js') }}"></script>
    <script src="{{ asset('assets/plugins/tempus-dominus/jQuery-provider.js') }}"></script>

    <style>
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
    @if (Auth::user()->cv && file_exists(public_path('assets/upload/cv/' . Auth::user()->cv)))
        <script>
            $('#cv.filepond').filepond({
                storeAsFile: true,
                files: [{
                    source: '{{ url("assets/upload/cv/".Auth::user()->cv) }}',
                    options: {
                        type: 'input',
                    },
                }],
            });
        </script>
    @else
        <script>
            $('#cv.filepond').filepond({
                storeAsFile: true,
            });
        </script>
    @endif
@endsection
