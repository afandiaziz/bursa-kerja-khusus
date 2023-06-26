@switch($data->criteriaType->type)
    @case('Custom')
        <div class="form-group my-2 border-top border-bottom py-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="fs-3 fw-bold">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </div>
                @if ($data->is_multiple)
                    <div class="ms-auto">
                        <div class="cursor-pointer btn btn-link border" id="button-form-custom-store-{{ $data->id }}" role="button">
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
            <hr class="mt-3 mb-0">
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
                @php
                    $data->children = is_array($data->children) ? collect($data->children) : $data->children
                @endphp
                @if (Auth::user()->user_details_child($data->id)->where('criteria_id', $data->children->first()->id)->count() > 0)
                    <div class="row">
                        @foreach (Auth::user()->user_details_child($data->id)->where('criteria_id', $data->children->firstOrFail()->id)->select('index')->orderBy('index', 'desc')->get() as $item)
                            <div class="col-md-12 my-1" data-index="{{ $item->index }}">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="d-flex align-items-baseline">
                                            <div class="me-2">
                                                <div style="font-size: 36px" class="text-blue">&bullet;</div>
                                            </div>
                                            <div>
                                                @foreach ($data->children as $index => $child)
                                                    <div class="{{ $index == 0 ? 'fs-3 fw-medium' : 'mt-1' }}">
                                                        @php
                                                            $valueChildByIndex = Auth::user()->user_details_child($data->id)->where('criteria_id', $child->id)->where('index', $item->index)->select('user_details.*')->first();
                                                        @endphp
                                                        {{ $valueChildByIndex ? $valueChildByIndex?->value : '-' }}
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="d-flex pt-3">
                                            <div class="btn btn-link me-1" role="button" id="button-form-custom-edit-{{ $data->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                    <path d="M16 5l3 3"></path>
                                                </svg>
                                                Edit
                                            </div>
                                            <div class="btn btn-link text-danger" role="button" id="button-form-custom-delete-{{ $data->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                                Hapus
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <script>
                    $('div#button-form-custom-store-{{ $data->id }}').click(function (){
                        fetch(`{{ route('profil.load.modal.custom') }}`, {
                            method: 'post',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': `{{ csrf_token() }}`
                            },
                            body: JSON.stringify({
                                criteria: '{{ $data->id }}',
                            })
                        }).then(response => response.json()).then(({message, view}) => {
                            if (message == 'success') {
                                $('body div#modal-{{ $data->id }}').remove();
                                $('body').append(view);
                                $('body div#modal-{{ $data->id }} .modal-title span').text('Tambah');
                                $('body div#modal-{{ $data->id }}').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }).modal('show');
                            }
                        });
                    });
                    $('div#button-form-custom-edit-{{ $data->id }}').click(function (){
                        const parent = $(this).parent().parent().parent().parent();
                        fetch(`{{ route('profil.load.modal.custom') }}`, {
                            method: 'post',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': `{{ csrf_token() }}`
                            },
                            body: JSON.stringify({
                                criteria: '{{ $data->id }}',
                                index: parent.data('index'),
                            })
                        }).then(response => response.json()).then(({message, view}) => {
                            if (message == 'success') {
                                $('body div#modal-{{ $data->id }}').remove();
                                $('body').append(view);
                                $('body div#modal-{{ $data->id }} .modal-title span').text('Edit');
                                $('body div#modal-{{ $data->id }}').modal({
                                    backdrop: 'static',
                                    keyboard: false
                                }).modal('show');
                            }
                        });
                    });
                    $('div#button-form-custom-delete-{{ $data->id }}').click(function (){
                        Swal.fire({
                            title: 'Hapus informasi ini?',
                            html: "Informasi ini akan hilang selamanya.<br> Yakin mau menghapusnya?",
                            showCancelButton: true,
                            reverseButtons: true,
                            confirmButtonText: 'Hapus',
                            confirmButtonColor: '#3085d6',
                            cancelButtonText: 'Batal',
                        }).then(({isConfirmed}) => {
                            const parent = $(this).parent().parent().parent().parent();
                            if (isConfirmed) {
                                fetch(`{{ route('profil.delete.custom') }}`, {
                                    method: 'delete',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': `{{ csrf_token() }}`
                                    },
                                    body: JSON.stringify({
                                        parent: '{{ $data->id }}',
                                        index: parent.data('index')
                                    })
                                }).then(response => response.json()).then(({message}) => {
                                    if (message == 'success') {
                                        parent.fadeOut(300, function () {
                                            parent.remove();
                                        });
                                    }
                                })
                            }
                        })
                    });
                </script>
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
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
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
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                @break
                @case('Teks')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                        {{ $data->required ? 'required' : '' }} class="form-control"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                @break
                @case('Date Range')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control daterangepicker-dateonly cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker('input#{{ $data->id }}[name="{{ $data->id }}"].daterangepicker-dateonly', 'daterangepicker-dateonly');
                    </script>
                @break
                @case('Tanggal')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-dateonly cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker();
                    </script>
                @break
                @case('Tanggal dan Waktu')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-datetime cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker();
                    </script>
                @break
                @case('Waktu')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-timeonly cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker();
                    </script>
                @break
                @case('Jam')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-houronly cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker();
                    </script>
                @break
                @case('Menit/Detik')
                    <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} readonly class="form-control datetimepicker-minutesecondonly cursor-pointer"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                    <script>
                        initPicker();
                    </script>
                @break
                @case('Angka')
                    <input type="number" id="{{ $data->id }}" name="{{ $data->id }}"
                        minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                        min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                        {{ $data->required ? 'required' : '' }} class="form-control"
                        value="{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : '' }}">
                    <label for="{{ $data->id }}" class="form-label">
                        {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                    </label>
                @break
                @case('Teks Panjang')
                    <textarea id="{{ $data->id }}" name="{{ $data->id }}" rows="3" class="form-control"
                        {{ $data->required ? 'required' : '' }}>{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value : ''}}</textarea>
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
                                    {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $item->id ? 'checked' : '' }}>
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
                                {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == '1' ? 'checked' : '' }}>
                            <span class="form-check-label">Ya</span>
                        </label>
                        <label class="form-check">
                            <input class="form-check-input" type="radio" name="{{ $data->id }}" value="0"
                                {{ $data->required ? 'required' : '' }}
                                {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == '0' ? 'checked' : '' }}>
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
                            $selectedValue = Auth::check() ? explode(',', Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value) : [];
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
                                {{ Auth::check() && $item->id && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $item->id ? 'selected' : '' }}>
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
                        $selectedValue = Auth::check() ? explode(',', Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value) : [];
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
                            <option value="{{ $month }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $month ? 'selected' : '' }}>
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
                            <option value="{{ $month }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $month ? 'selected' : '' }}>
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
                            <option value="{{ $date }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $date ? 'selected' : '' }}>
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
                            <option value="{{ $sourceData }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $sourceData ? 'selected' : '' }}>
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
                            <option value="{{ $sourceData }}" {{ Auth::check() && Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->value == $sourceData ? 'selected' : '' }}>
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
                    <input type="file" class="filepond"
                        id="{{ $data->id }}"
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
                        "{{ Auth::check() ? Auth::user()->user_details->where('criteria_id', $data->id)->where('index', ($data->index ? $data->index : null))->first()?->filename : '' }}".split(',').forEach(file => {
                            if (file) {
                                defaultFiles.push({
                                    source: '{{ url("assets/upload/$data->id") }}' + '/' + file,
                                    options: {
                                        type: 'input',
                                    },
                                });
                            }
                        });
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
