<div id="additional-custom-container">
    <div class="form-group mt-4 mb-3">
        <label class="form-label text-capitalize">
            Multiple Jawaban <span class="text-danger">*</span>
        </label>
        <div class="d-flex gap-3">
            <div>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="is_multiple" value="1" required
                        {{ $old && $old != null && $old->is_multiple == 1 ? 'checked' : '' }}>
                    <span class="form-check-label">Ya</span>
                </label>
            </div>
            <div>
                <label class="form-check">
                    <input class="form-check-input" type="radio" name="is_multiple" value="0" required
                        {{ $old && $old != null && $old->is_multiple == 0 ? 'checked' : '' }}>
                    <span class="form-check-label">Tidak</span>
                </label>
            </div>
        </div>
    </div>

    <div class="form-group my-2">
        <button type="button" class="btn btn-azure" id="add-sub">Tambah Inputan</button>
    </div>

    <div id="form-custom-container">
        @php
            $count = 2;
            if ($old && isset($old->children) && $old->children && count($old->children)) {
                $count = count($old->children);
            } elseif ($old && isset($old->criteriaAnswer) && $old->criteriaAnswer && count($old->criteriaAnswer)) {
                $count = count($old->criteriaAnswer);
            }
        @endphp
        @for ($i = 0; $i < $count; $i++)
            <div class="form-group my-3 border-bottom pb-3">
                <div class="row align-items-center">
                    <div class="col">
                        <label class="form-label text-capitalize">
                            Nama Input <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="sub[name][{{ $i }}]" required autocomplete="off"
                            value="{{ ($old && isset($old->children) && $old->children && count($old->children) ? $old->children[$i]->name : '') }}">
                    </div>
                    <div class="col">
                        <label class="form-label text-capitalize">
                            Tipe Input <span class="text-danger">*</span>
                        </label>
                        <select name="sub[criteria_type_id][{{ $i }}]" class="form-control form-select w-100" required autocomplete="off">
                            <option value="">Pilih Tipe Data Kriteria</option>
                            @foreach ($criteriaTypes as $criteriaType)
                                <option value="{{ $criteriaType->id }}"
                                    {{ ($old && isset($old->children) && $old->children && count($old->children) && $old->children[$i]->criteria_type_id == $criteriaType->id ? 'selected' : '') }}>
                                    {{ $criteriaType->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label class="form-label text-capitalize">
                            Wajib Diisi <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3">
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" name="sub[required][{{ $i }}]" value="1" required
                                        {{ ($old && isset($old->children) && $old->children && count($old->children) && $old->children[$i]->required == 1 ? 'checked' : '') }}>
                                    <span class="form-check-label">Ya</span>
                                </label>
                            </div>
                            <div>
                                <label class="form-check">
                                    <input class="form-check-input" type="radio" name="sub[required][{{ $i }}]" value="0" required
                                        {{ ($old && isset($old->children) && $old->children && count($old->children) && $old->children[$i]->required == 0 ? 'checked' : '') }}>
                                    <span class="form-check-label">Tidak</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col text-end">
                        <button type="button" class="btn btn-outline-orange btn-sm px-3 rounded-2" id="remove-sub">Hapus Inputan Ini</button>
                    </div>
                    <div class="col-12" data-index="{{ $i }}"> <div class="p-3 border ms-3 mt-2 custom-additional-form-container d-none"></div> </div>
                </div>
            </div>
            <script>
                new TomSelect('select[name="sub[criteria_type_id][{{ $i }}]"]');
            </script>
        @endfor
    </div>
    <div class="d-none" id="custom-template">
        <div class="form-group my-3 border-bottom pb-3">
            <div class="row align-items-center">
                <div class="col">
                    <label class="form-label text-capitalize">
                        Nama Input <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" name="template[name][0]" autocomplete="off" disabled readonly>
                </div>
                <div class="col">
                    <label class="form-label text-capitalize">
                        Tipe Input <span class="text-danger">*</span>
                    </label>
                    <select name="template[criteria_type_id][0]" class="form-control form-select w-100" autocomplete="off" disabled readonly>
                        <option value="">Pilih Tipe Data Kriteria</option>
                        @foreach ($criteriaTypes as $criteriaType)
                            <option value="{{ $criteriaType->id }}">
                                {{ $criteriaType->type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <label class="form-label text-capitalize">
                        Wajib Diisi <span class="text-danger">*</span>
                    </label>
                    <div class="d-flex gap-3">
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="template[required][0]" value="1" disabled readonly>
                                <span class="form-check-label">Ya</span>
                            </label>
                        </div>
                        <div>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="template[required][0]" value="0" disabled readonly checked>
                                <span class="form-check-label">Tidak</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-outline-orange btn-sm px-3 rounded-2" id="remove-sub">Hapus Inputan Ini</button>
                </div>
                <div class="col-12" data-index="{{ $i }}"> <div class="p-3 border ms-3 mt-2 custom-additional-form-container d-none"></div> </div>
            </div>
        </div>
    </div>
</div>
