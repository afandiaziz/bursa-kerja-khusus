
@if ($data->where('criteria_id', $criteria->id)->first() && $data->where('criteria_id', $criteria->id)->first()?->value != null)
    @switch($criteria->criteriaType->type)
        @case('Tags')
            {{ str_replace(',', ', ', $data->where('criteria_id', $criteria->id)->first()?->value) }}
        @break
        @case('Teks')
        @case('Angka')
        @case('Teks Panjang')
            {!! $data->where('criteria_id', $criteria->id)->first()?->value !!}
        @break
        @case('Pilihan (Ya/Tidak)')
            {{ $data->where('criteria_id', $criteria->id)->first()?->value == '1' ? 'Ya' : 'Tidak' }}
        @break
        @case('Pilihan (Multiple Checkbox)')
        @case('Pilihan (Multiple Dropdown)')
            @foreach ($criteria->criteriaAnswer->whereIn('id', explode(',', $data->where('criteria_id', $criteria->id)->first()?->value)) as $criteriaAnswer)
                <span class="badge bg-orange-lt text-dark border mt-1">{{ $criteriaAnswer->answer }}</span>
            @endforeach
        @break
        @case('Pilihan Ganda (Radio)')
        @case('Pilihan Ganda (Dropdown)')
            {{
                $data->where('criteria_id', $criteria->id)->first()
                    ->criteria->criteriaAnswer->where('id', $data->where('criteria_id', $criteria->id)->first()?->value)->first()->answer
            }}
        @break
        @case('Tanggal')
            {{ \Carbon\Carbon::parse(str_replace('/', '-', $data->where('criteria_id', $criteria->id)->first()?->value))->translatedFormat('d F Y') }}
        @break
        @case('Tanggal dan Waktu')
            {{ \Carbon\Carbon::parse(str_replace('/', '-', $data->where('criteria_id', $criteria->id)->first()?->value))->translatedFormat('d F Y H:i:s') }}
        @break
        @case('Waktu')
            Pukul {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Menit/Detik')
            Menit {{ explode(':', $data->where('criteria_id', $criteria->id)->first()?->value)[0] }}
            &nbsp;
            Detik {{ explode(':', $data->where('criteria_id', $criteria->id)->first()?->value)[1] }}
        @break
        @case('Jam')
            Jam {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Hari')
            Hari {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Hanya Tanggal')
            Tanggal {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Hanya Tahun')
            Tahun {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Hanya Bulan dalam Nama Bulan')
            Bulan {{ $data->where('criteria_id', $criteria->id)->first()?->value }}
        @break
        @case('Hanya Bulan dalam Angka')
            Bulan {{ \Carbon\Carbon::parse('2001-'.$data->where('criteria_id', $criteria->id)->first()?->value.'-19')->translatedFormat('F') }}
        @break
    @endswitch
@else
    @if ($criteria->criteriaType->type == 'Custom')
        @if ($criteria->is_multiple)
            @php
                $criteria->children = is_array($criteria->children) ? collect($criteria->children) : $criteria->children;
            @endphp
            @if ($child->user_details_child($criteria->id)->where('criteria_id', $criteria->children->first()->id)->count() > 0)
                <div class="row">
                    @foreach ($child->user_details_child($criteria->id)->where('criteria_id', $criteria->children->firstOrFail()->id)->select('index')->orderBy('index', 'desc')->get() as $item)
                        <div class="col-md-12 my-1" data-index="{{ $item->index }}">
                            <div class="d-flex align-items-baseline">
                                <div class="me-2">
                                    <div style="font-size: 36px" class="text-blue">&bullet;</div>
                                </div>
                                <div>
                                    @foreach ($criteria->children as $index => $children)
                                        <div class="{{ $index == 0 ? 'fs-3 fw-medium' : 'mt-1' }}">
                                            @php
                                                $valueChildByIndex = $child->user_details_child($criteria->id)->where('criteria_id', $children->id)->where('index', $item->index)->first();
                                            @endphp
                                            {{ $valueChildByIndex ? $valueChildByIndex?->value : '-' }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endif
    @else
        <span class="text-danger">BELUM DIISI</span>
    @endif
@endif
