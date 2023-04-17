@extends('dashboard.layouts.app')
@section('title', 'Edit Kriteria Pelamar' . ' - ' . $data->name)

@section('content')
    <div class="col-lg-8">
        <form action="{{ route($prefix . '.update', ['id' => $data->id]) }}" method="post" class="w-100" target="_blank">
            @csrf
            @include('dashboard.criteria.form')
        </form>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
                    $('#additional-content').addClass('d-block').removeClass('d-none')
                        .html(response);
                    $('.select2').select2();
                },
                error: function(xhr, status, error) {
                    console.log(xhr, status, error);
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2();
            if ($('#criteria_type_id').val().trim()) {
                getAdditional($('#criteria_type_id').val());
            }
            $('#criteria_type_id').change(function() {
                if ($(this).val().trim()) {
                    getAdditional($(this).val());
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
                if ($('input[type="radio"][name="format"]:checked').val() == 0) {
                    $('#format_file').removeAttr('disabled');
                } else {
                    $('#format_file').attr('disabled', 'disabled').val(null).trigger('change');
                }
            });
            $('body').on('change', 'input[type="radio"][name="type_upload"]', function() {
                if ($('input[type="radio"][name="type_upload"]:checked').val() == 1) {
                    $('input[name="max_files"]').removeAttr('disabled');
                } else {
                    $('input[name="max_files"]').attr('disabled', 'disabled');
                }
            });
        });
    </script>
@endsection
