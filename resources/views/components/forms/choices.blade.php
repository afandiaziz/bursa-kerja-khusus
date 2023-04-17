<div class="form-group mt-4">
    <button type="button" class="btn btn-azure" id="add-answer">Tambah Jawaban</button>
</div>
<div id="answer-content">
    @php
        $count = 2;
        if ($old && $old->answer && count($old->answer)) {
            $count = count($old->answer);
        }
    @endphp
    @for ($i = 0; $i < $count; $i++)
        <div class="form-group my-2">
            <label for="answer[]" class="form-label text-capitalize">
                Jawaban {{ $i + 1 }}
            </label>
            <div class="input-group">
                <input type="text" class="form-control" name="answer[]"
                    value="{{ $old && $old->answer && count($old->answer) ? $old->answer[$i] : '' }}">
                <button type="button" class="btn btn-danger" id="remove-answer">Hapus</button>
            </div>
        </div>
    @endfor
</div>
