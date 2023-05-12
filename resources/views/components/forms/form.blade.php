@if ($data->criteriaType->type != 'Upload File')
    <form action="#" id="example-form">
        {{-- @dd($data->criteriaType->type, $data->criteriaAnswer->count()) --}}
        <div class="form-group my-2">
            @if ($data->criteriaType->type == 'Teks')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    {{ $data->required ? 'required' : '' }} class="form-control">
            @endif
            @if ($data->criteriaType->type == 'Angka')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <input type="number" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} class="form-control">
            @endif
            @if ($data->criteriaType->type == 'Teks Panjang')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <textarea id="{{ $data->id }}" name="{{ $data->id }}" rows="3" class="form-control"
                    {{ $data->required ? 'required' : '' }}></textarea>
            @endif
            @if ($data->criteriaType->type == 'Pilihan Ganda (Radio)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                @foreach ($data->criteriaAnswer as $item)
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}"
                            value="{{ $item->id }}" {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">{{ $item->answer }}</span>
                    </label>
                @endforeach
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Ya/Tidak)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <div class="d-flex gap-3">
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="1"
                            {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">Ya</span>
                    </label>
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="0"
                            {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">Tidak</span>
                    </label>
                </div>
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Multiple Checkbox)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <div class="row">
                    @foreach ($data->criteriaAnswer as $item)
                        <div class="col-md-6">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $data->id }}[]"
                                    value="{{ $item->id }}" {{ $data->required ? 'required' : '' }}>
                                <span class="form-check-label">{{ $item->answer }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($data->criteriaType->type == 'Pilihan Ganda (Dropdown)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <select name="{{ $data->id }}" id="{{ $data->id }}"
                    class="form-select {{ $data->criteriaAnswer->count() > 8 ? 'select2' : '' }}"
                    {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id }}">{{ $item->answer }}</option>
                    @endforeach
                </select>
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Multiple Dropdown)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <select name="{{ $data->id }}[]" id="{{ $data->id }}" class="form-select mt-3 select2"
                    {{ $data->required ? 'required' : '' }} multiple>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id }}">{{ $item->answer }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group mt-3">
            <button class="btn btn-dark" type="submit" id="example-submit">Submit</button>
        </div>
    </form>
@else
    <div class="form-group my-2">
        <label for="{{ $data->id }}" class="form-label">
            {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
        </label>
        <form action="{{ route('criteria.test') }}" method="post" id="example-form">
            @csrf
            <div class="form-group my-2">
                <div class="dropzone" id="input-file-{{ $data->id }}"></div>
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-dark" type="button" id="example-submit">Submit</button>
            </div>
        </form>
    </div>
@endif
@if ($data->criteriaType->type == 'Upload File')
    <script>
        new Dropzone('#input-file-{{ $data->id }}', configDropzone(
            "{{ $data->id }}",
            {{ $data->type_upload ? 'true' : 'false' }},
            {{ $data->type_upload ? $data->max_files : 1 }},
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
@endif
<hr>
