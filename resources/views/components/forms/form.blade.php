@if ($data->criteriaType->type != 'Upload File')
    {{-- @dd($data->criteriaType->type, $data->criteriaAnswer->count()) --}}
    <div class="form-floating form-group my-2">
        @switch($data->criteriaType->type)
            @case('Teks')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    {{ $data->required ? 'required' : '' }} class="form-control"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Tanggal')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-dateonly cursor-pointer"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Tanggal dan Waktu')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-datetime cursor-pointer"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Waktu')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-timeonly cursor-pointer"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Jam')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-houronly cursor-pointer"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Menit/Detik')
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-minutesecondonly cursor-pointer"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Angka')
                <input type="number" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} class="form-control"
                    value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Teks Panjang')
                <textarea id="{{ $data->id }}" name="{{ $data->id }}" rows="3" class="form-control"
                    {{ $data->required ? 'required' : '' }}>{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : ''}}</textarea>
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
            @break
            @case('Pilihan Ganda (Radio)')
                <div>
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                </div>
                @foreach ($data->criteriaAnswer as $item)
                    <div>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $data->id }}"
                                value="{{ $item->id }}" {{ $data->required ? 'required' : '' }}
                                {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $item->id ? 'checked' : '' }}>
                            <span class="form-check-label">{{ $item->answer }}</span>
                        </label>
                    </div>
                @endforeach
            @break
            @case('Pilihan (Ya/Tidak)')
                <div>
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                </div>
                <div class="d-flex gap-3">
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="1"
                            {{ $data->required ? 'required' : '' }}
                            {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == '1' ? 'checked' : '' }}>
                        <span class="form-check-label">Ya</span>
                    </label>
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="0"
                            {{ $data->required ? 'required' : '' }}
                            {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == '0' ? 'checked' : '' }}>
                        <span class="form-check-label">Tidak</span>
                    </label>
                </div>
            @break
            @case('Pilihan (Multiple Checkbox)')
                <div class="row">
                    <div class="col-12">
                        <label for="{{ $data->id }}" class="form-label">
                            {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                        </label>
                    </div>
                    @php
                        $selectedValue = Auth::check() ? explode(',', Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value) : [];
                    @endphp
                    @foreach ($data->criteriaAnswer as $item)
                        <div class="col-auto">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $data->id }}[]"
                                    value="{{ $item->id ? $item->id : $item->answer }}" {{ $data->required ? 'required' : '' }}
                                    {{ (count($selectedValue) > 0 && $item->id && in_array($item->id, $selectedValue)) ? 'checked' : '' }}>
                                <span class="form-check-label">{{ $item->answer }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @break
            @case('Pilihan Ganda (Dropdown)')
                <select name="{{ $data->id }}" id="{{ $data->id }}"
                    class="form-select {{ $data->criteriaAnswer->count() > 8 ? 'tomselect--' : 'tomselect--' }}"
                    {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id ? $item->id : $item->answer }}"
                            {{ Auth::check() && $item->id && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $item->id ? 'selected' : '' }}>
                            {{ $item->answer }}
                        </option>
                    @endforeach
                </select>
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Pilihan (Multiple Dropdown)')
                @php
                    $selectedValue = Auth::check() ? explode(',', Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value) : [];
                @endphp
                <select name="{{ $data->id }}[]" id="{{ $data->id }}" class="form-select mt-3 tomselect--"
                    {{ $data->required ? 'required' : '' }} multiple>
                    <option value="">Pilih</option>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id ? $item->id : $item->answer }}" {{ (count($selectedValue) > 0 && $item->id && in_array($item->id, $selectedValue)) ? 'selected' : '' }}>{{ $item->answer }}</option>
                    @endforeach
                </select>
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Hari')
                @php
                    $sourceData = [ 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu' ];
                @endphp
                <select name="{{ $data->id }}" id="{{ $data->id }}" class="form-select tomselect--" {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @foreach ($sourceData as $month)
                        <option value="{{ $month }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
                <label for="{{ $data->id }}" class="form-label" >
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Hanya Bulan dalam Nama Bulan')
                @php
                    $sourceData = [ 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember' ];
                @endphp
                <select name="{{ $data->id }}" id="{{ $data->id }}" class="form-select tomselect--" {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @foreach ($sourceData as $month)
                        <option value="{{ $month }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $month ? 'selected' : '' }}>
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
                <label for="{{ $data->id }}" class="form-label" >
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Hanya Tanggal')
                <select name="{{ $data->id }}" id="{{ $data->id }}" class="form-select tomselect--" {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @for ($date = 1; $date <= 31; $date++)
                        <option value="{{ $date }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $date ? 'selected' : '' }}>
                            {{ $date }}
                        </option>
                    @endfor
                </select>
                <label for="{{ $data->id }}" class="form-label" >
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Hanya Bulan dalam Angka')
                <select name="{{ $data->id }}" id="{{ $data->id }}" class="form-select tomselect--" {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @for ($sourceData = 1; $sourceData <= 12; $sourceData++)
                        <option value="{{ $sourceData }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $sourceData ? 'selected' : '' }}>
                            {{ $sourceData }}
                        </option>
                    @endfor
                </select>
                <label for="{{ $data->id }}" class="form-label" >
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
            @case('Hanya Tahun')
                <select name="{{ $data->id }}" id="{{ $data->id }}" class="form-select tomselect--" {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @for ($sourceData = 1945; $sourceData <= (date('Y') + 100); $sourceData++)
                        <option value="{{ $sourceData }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value == $sourceData ? 'selected' : '' }}>
                            {{ $sourceData }}
                        </option>
                    @endfor
                </select>
                <label for="{{ $data->id }}" class="form-label" >
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <script>
                    setTimeout(() => {
                        new TomSelect(document.getElementById('{{ $data->id }}'));
                    }, 100);
                </script>
            @break
        @endswitch
    </div>
@else
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
