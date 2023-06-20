@switch($data->criteriaType->type)
    @case('Custom')
        <div class="form-group my-2 border-top border-bottom py-3">
            <div class="d-flex align-items-center">
                <div class="fs-3 fw-bold">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </div>
                @if ($data->is_multiple)
                    <div class="ms-auto">
                        <div class="cursor-pointer btn btn-link border" role="button" data-bs-toggle="modal" data-bs-target="#modal-{{ $data->id }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                                <path d="M9 12l6 0"></path>
                                <path d="M12 9l0 6"></path>
                            </svg>
                            Tambahkan {{ $data->name }}
                        </div>
                    </div>
                @endif
            </div>
            @if (!$data->is_multiple)
                <div class="row">
                    <div class="col-md-6">
                        <div class="mt-2" id="form-custom-view-container">
                            @foreach ($data->children as $index => $item)
                                @if ($item->criteria_type_id)
                                    <div class="my-3">
                                        @include('components.forms.form', ['data' => $item, 'custom' => true])
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="modal modal-blur fade" id="modal-{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form action="{{ route('profil.update') }}" method="post" enctype="multipart/form-data" target="_blank">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">
                                        Tambah {{ $data->name }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-2">
                                    <div class="mt-2" id="form-custom-view-container">
                                        @foreach ($data->children as $index => $item)
                                            @if ($item->criteria_type_id)
                                                <div class="my-3">
                                                    @include('components.forms.form', ['data' => $item, 'custom' => true])
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</button>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @break

    @default
        {{-- @dd($data->criteriaType->type, $data->criteriaAnswer->count()) --}}
        <div class="form-floating form-group my-2">
            @switch($data->criteriaType->type)
                @case('Tags')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                        {{ $data->required ? 'required' : '' }} class="form-control tomselect-tags--"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'), {
                                    persist: false,
                                    createOnBlur: true,
                                    create: true
                                });
                            }, 100);
                        </script>
                    @endif
                @break
                @case('Email')
                    <input type="email" id="{{ $data->id }}" name="{{ $data->id }}" {{ $data->required ? 'required' : '' }} class="form-control"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                @break
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
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
                    @if(isset($custom) && $custom == false)
                        <script>
                            setTimeout(() => {
                                new TomSelect(document.getElementById('{{ $data->id }}'));
                            }, 100);
                        </script>
                    @endif
                @break
                @case('Upload File')
                    <input type="file" class="filepond" id="{{ $data->id }}"
                        name="{{ $data->is_multiple ? $data->id.'[]' : $data->id }}"
                        {{ $data->required ? 'required' : '' }}
                        {!! ($data->is_multiple && $data->max_files && $data->max_files > 1 ? 'data-max-files="'.$data->max_files.'"' : '') !!}
                        {!! ($data->max_size ? 'data-max-file-size="'.$data->max_size.'MB"' : '') !!}
                        {!! $data->is_multiple ? 'multiple' : '' !!}
                        {!! $data->format_file ? 'accept="'. $data->format_file. '"' : '' !!}
                    >
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    @php
                        $data->filename
                    @endphp
                    <script>
                        defaultFiles = [];
                        "{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->first()?->filename : '' }}".split(',').forEach(file => {
                            if (file) {
                                defaultFiles.push({
                                    source: '{{ url("assets/upload/$data->id") }}' + '/' + file,
                                    options: {
                                        type: 'local',
                                    },
                                });
                            }
                        });
                        console.log(defaultFiles)
                        $('input[type="file"]#{{ $data->id }}.filepond').filepond({
                            storeAsFile: true,
                            files: defaultFiles,
                        });
                    </script>
                @break
            @endswitch
        </div>
    @break

@endswitch
