<div class="form-group {{ $subIndex == null ? 'mt-4' : '' }}">
    <button type="button" class="btn btn-azure" id="add-answer">Tambah Jawaban</button>
</div>
<div id="answer-content">
    @php
        $count = 2;
        if ($old && isset($old->answer) && $old->answer && count($old->answer)) {
            $count = count($old->answer);
        } elseif ($old && isset($old->criteriaAnswer) && $old->criteriaAnswer && count($old->criteriaAnswer)) {
            $count = count($old->criteriaAnswer);
        }
    @endphp
    @for ($i = 0; $i < $count; $i++)
        <div class="form-group my-2">
            <label class="form-label text-capitalize">
                Jawaban {{ $i + 1 }}
            </label>
            <div class="input-group">
                <input type="text" class="form-control" autocomplete="off"
                    name="{{ $subIndex != null ? "sub[answer][$subIndex][]" : 'answer[]' }}"
                    value="{{ ($old && isset($old->answer) && $old->answer && count($old->answer) ? $old->answer[$i] : $old && isset($old->criteriaAnswer) && $old->criteriaAnswer && count($old->criteriaAnswer)) ? $old->criteriaAnswer[$i]->answer : '' }}"
                >
                <button type="button" class="btn btn-danger" id="remove-answer">Hapus</button>
            </div>
        </div>
    @endfor
</div>
