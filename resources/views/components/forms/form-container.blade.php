@include('components.forms.form', ['custom' => false])
{{-- @if ($data->criteriaType->type != 'Upload File')
    <form action="#" id="example-form">
        @include('components.forms.form', ['custom' => false])
    </form>
@else --}}
{{-- @endif --}}
{{-- @if ($data->criteriaType->type == 'Upload File')
    <script>
        new Dropzone('#input-file-{{ $data->id }}', configDropzone(
            "{{ $data->id }}",
            {{ $data->is_multiple ? 'true' : 'false' }},
            {{ $data->is_multiple ? $data->max_files : 1 }},
            {{ $data->max_size }},
            '{{ $data->format_file }}',
        ));
    </script>
@else
    <script>
        $(document).ready(function() {
            $('form#example-form').submit(function(e) {
                console.log();
                if ($("input[type=checkbox]").length) {
                    checked = $("input[type=checkbox]:checked").length;
                    if (!checked) {
                        alert("You must check at least one checkbox.");
                        return false;
                    }
                }
                return true;
            });
        });
    </script>
@endif --}}
<hr>
