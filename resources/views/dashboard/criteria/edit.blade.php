@extends('dashboard.layouts.app')
@section('title', 'Edit Kriteria Pelamar' . ' - ' . $data->name)

@section('content')
    <div class="col-lg-8" id="form-content">
        <form method="post" class="w-100" id="form-edit"
            action="{{ route($prefix . '.update', ['id' => $data->id]) }}">
            @csrf
            @include("dashboard.$prefix.form")
        </form>
    </div>
    <div class="col-lg-4" id="preview-form">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tampilan Input dari Kriteria {{ $data->name }}</div>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
@endsection

@section('css')
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/css/tempus-dominus.css" />
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
        .litepicker .container__months .month-item-header .button-previous-month>svg,
        .litepicker .container__months .month-item-header .button-previous-month>img,
        .litepicker .container__months .month-item-header .button-next-month>svg,
        .litepicker .container__months .month-item-header .button-next-month>img {
            fill: var(--litepicker-button-prev-month-color) !important;
        }
    </style>
@endsection

@section('script')
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js"></script> --}}
    <script src="{{ asset('assets/js/dropzone/config.dropzone.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/solid.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/fontawesome.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/js/tempus-dominus.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.4.1/dist/js/jQuery-provider.js"></script>
    <script>
        function initPicker() {
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
        function getAdditional(val) {
            $.ajax({
                url: "{{ route($prefix . '.form.additional') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    type: val,
                    old: '{{ json_encode(old()) }}',
                    data: '{{ $data->id }}',
                },
                success: function(response) {
                    $('#additional-content').addClass('d-block').removeClass('d-none').html(response);
                    initPicker();
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        }

        function previewForm() {
            setTimeout(() => {
                const data = $('#form-edit').serializeArray();
                $.ajax({
                    url: "{{ route($prefix . '.form.preview') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: "{{ $data->id }}",
                        data
                    },
                    success: function({html, selector}) {
                        $('#preview-form .card-body').html(html);
                        initPicker();
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr, status, error);
                    }
                });
            }, 500);
        }

        $(document).ready(function() {
            previewForm();
            new TomSelect('.tomselect--');
            if ($('#criteria_type_id').val().trim()) {
                getAdditional($('#criteria_type_id').val());
            }
            $('#criteria_type_id').change(function() {
                if ($(this).val().trim()) {
                    getAdditional($(this).val());
                    previewForm();
                } else {
                    $('#additional-content').addClass('d-none').removeClass('d-block')
                        .html('');
                }
            });
            $('body').on('click', 'button#remove-answer', function() {
                if ($('#additional-content #answer-content .form-group').length === 2) {
                    $('#additional-content #answer-content button#remove-answer').addClass('disabled')
                    return;
                }
                $(this).parent().parent().remove();
                $('#additional-content #answer-content').each(function() {
                    $(this).find('label').each(function(index) {
                        $(this).text(`Jawaban ${index + 1}`);
                    });
                });
                previewForm();
            });
            $('body').on('click', 'button#add-answer', function() {
                const answerContent = $('#additional-content #answer-content .form-group').last();
                const answerContentClone = answerContent.clone();
                answerContentClone.find('input').val('');
                answerContentClone.find('label').each(function() {
                    $(this).text(
                        `Jawaban ${$('#additional-content #answer-content .form-group').length + 1}`
                    );
                });
                answerContent.after(answerContentClone);
                if ($('#additional-content #answer-content .form-group').length > 2) {
                    $('#additional-content #answer-content button#remove-answer').removeClass('disabled')
                }
            });
            $('body').on('change', 'input[type="radio"][name="format"]', function() {
                const selector = document.getElementById('format_file');
                if ($('input[type="radio"][name="format"]:checked').val() == 0) {
                    $('#format_file').removeAttr('disabled');
                    selector.tomselect.enable();
                } else {
                    $('#format_file').attr('disabled', 'disabled').val(null).trigger('change');
                    selector.tomselect.disable();
                }
            });
            $('body').on('change', 'input[type="radio"][name="type_upload"]', function() {
                if ($('input[type="radio"][name="type_upload"]:checked').val() == 1) {
                    $('input[name="max_files"]').removeAttr('disabled');
                } else {
                    $('input[name="max_files"]').attr('disabled', 'disabled');
                }
            });

            $('body #form-content').on('change', 'input, select', function() {
                previewForm();
            });
        });
    </script>
@endsection
