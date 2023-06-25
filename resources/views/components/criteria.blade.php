
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
    <span class="text-danger">BELUM DIISI</span>
@endif
