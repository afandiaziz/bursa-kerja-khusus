@extends('dashboard.layouts.app')
@section('title', 'Edit Kriteria Pelamar' . ' - ' . $data->name)

@section('content')
    <div class="col-lg-8" id="form-content">
        <form method="post" class="w-100" id="form-edit" target="_blank"
            action="{{ route($prefix . '.update', ['id' => $data->id]) }}">
            @csrf
            @include("dashboard.$prefix.form")
        </form>
    </div>
    <div class="col-lg-8" id="preview-form">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Tampilan Input dari Kriteria {{ $data->name }}</div>
            </div>
            <div class="card-body"></div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        /* .dropzone {
            border: var(--tblr-border-width) dashed var(--tblr-border-color);
        } */
        /* span.select2-container {
            padding-top: 20px
        } */
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
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        }

        function getAdditionalCustom(element) {
            $.ajax({
                url: "{{ route($prefix . '.form.additional') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    type: element.val(),
                    old: '{{ json_encode(old()) }}',
                    data: '{{ $data->id }}',
                    sub: $(element.parent().parent().find('.custom-additional-form-container')[0]).parent().data('index'),
                },
                success: function(response) {
                    if (response) {
                        $(element.parent().parent().find('.custom-additional-form-container')[0]).addClass('d-block').removeClass('d-none').html(response);
                    } else {
                        $(element.parent().parent().find('.custom-additional-form-container')[0]).removeClass('d-block').addClass('d-none').html('');
                    }
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
                        data,
                    },
                    success: function({html, selector}) {
                        $('#preview-form .card-body').html(html);

                        $('.filepond').filepond();
                        document.querySelectorAll('#example-form #form-custom-view-container .tomselect--').forEach((item) => {
                            new TomSelect(item);
                            item.tomselect.sync();
                        });
                        document.querySelectorAll('#example-form #form-custom-view-container .tomselect-tags--').forEach((item) => {
                            new TomSelect(item, {
                                persist: false,
                                createOnBlur: true,
                                create: true
                            });
                            item.tomselect.sync();
                        });
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
            new TomSelect('select#criteria_type_id.tomselect--');
            if ($('#criteria_type_id').val().trim()) {
                getAdditional($('#criteria_type_id').val());
            }
            $('#criteria_type_id').change(function() {
                if ($(this).val().trim()) {
                    getAdditional($(this).val());
                    previewForm();
                } else {
                    $('#additional-content').addClass('d-none').removeClass('d-block').html('');
                }
            });
            $('body').on('click', 'button#remove-answer', function() {
                if ($('#additional-content #answer-content .form-group').length <= 2) {
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
            $('body').on('change', 'input[type="radio"][name="format"], input[type="radio"].form-check-input.input-format', function() {
                const selector = $(this).parent().parent().find('select');
                if ($(this).val() == 0) {
                    $(selector).removeAttr('disabled');
                    selector[0].tomselect.enable();
                } else {
                    $(selector).attr('disabled', 'disabled');
                    selector[0].tomselect.disable();
                }
            });
            $('body').on('change', 'input[type="radio"][name="is_multiple"], input[type="radio"].form-check-input.input-is_multiple', function() {
                if ($(this).val() == 1) {
                    $(this).parent().parent().next().find('input').removeAttr('disabled');
                } else {
                    $(this).parent().parent().next().find('input').attr('disabled', 'disabled');
                }
            });
            $('body #form-content').on('change', 'input, select', function() {
                previewForm();
            });

            $('body').on('click', 'button#remove-sub', function() {
                if ($('#additional-content #form-custom-container .form-group').length <= 2) {
                    $('#additional-content #form-custom-container button#remove-sub').addClass('disabled')
                    return;
                }
                $(this).parent().parent().find('select')[0].tomselect.destroy()
                $(this).parent().parent().parent().remove();
                previewForm();
            });
            $('body').on('click', 'button#add-sub', function() {
                const template = $('#custom-template .form-group').last();
                const subContainer = $('#additional-content #form-custom-container > .form-group').last();
                const subContainerCloned = template.clone();
                const index = $('#additional-content #form-custom-container > .form-group').length;
                subContainerCloned.find('input[type="text"]').val('');
                subContainerCloned.find('select').val('');
                $(subContainerCloned.find('input')[0]).attr('name', 'sub[name][' + (index) + ']').removeAttr('disabled').removeAttr('readonly').attr('required', 'required');
                $(subContainerCloned.find('input')[1]).attr('name', 'sub[required][' + (index) + ']').removeAttr('disabled').removeAttr('readonly').attr('required', 'required');
                $(subContainerCloned.find('input')[2]).attr('name', 'sub[required][' + (index) + ']').removeAttr('disabled').removeAttr('readonly').attr('required', 'required');
                $(subContainerCloned.find('select')[0]).attr('name', 'sub[criteria_type_id][' + (index) + ']').removeAttr('disabled').removeAttr('readonly').attr('required', 'required');
                $(subContainerCloned.find('select')[0]).parent().data('index', (index));
                new TomSelect(subContainerCloned.find('select')[0]);
                subContainer.after(subContainerCloned);
                if (index > 2) {
                    $('#additional-content #form-custom-container button#remove-sub').removeClass('disabled');
                }
            });
            $('#additional-content').on('change', '#additional-custom-container select', function() {
                getAdditionalCustom($(this));
            });
            setTimeout(() => {
                $('#additional-content #additional-custom-container #form-custom-container select').each(function() {
                    getAdditionalCustom($(this));
                });
            }, 450);
        });
    </script>
@endsection
