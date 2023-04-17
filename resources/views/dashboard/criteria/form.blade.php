<div class="card">
    <div class="card-body">
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Nama Kriteria <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="name"
                value="{{ old('name') ? old('name') : (isset($data) && $data->name ? $data->name : '') }}" required>
        </div>
        <div class="form-group my-2">
            <label for="parent_order" class="form-label text-capitalize">
                Urutan <span class="text-danger">*</span>
            </label>
            <input type="number" {{ isset($parent_order) ? 'min="' . $parent_order . '"' : '' }} class="form-control"
                name="parent_order"
                value="{{ old('parent_order') ? old('parent_order') : (isset($data) && $data->parent_order ? $data->parent_order : $parent_order) }}"
                required>
        </div>
        <div class="form-group my-2">
            <label for="parent_order" class="form-label text-capitalize">
                Wajib Diisi <span class="text-danger">*</span>
            </label>
            <div class="d-flex gap-3">
                <div>
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="required" value="1" required
                            {{ (old('required') != null && old('required')) == 1 ? 'checked' : (isset($data) && $data->required == 1 ? 'checked' : '') }}>
                        <span class="form-check-label">Ya</span>
                    </label>
                </div>
                <div>
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="required" value="0" required
                            {{ old('required') != null && old('required') == 0 ? 'checked' : (isset($data) && $data->required == 0 ? 'checked' : '') }}>
                        <span class="form-check-label">Tidak</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Tipe Data Kriteria <span class="text-danger">*</span>
            </label>
            <select name="criteria_type_id" id="criteria_type_id" class="form-control w-100 select2">
                <option value="">Pilih Tipe Data Kriteria</option>
                @foreach ($criteriaTypes as $criteriaType)
                    <option value="{{ $criteriaType->id }}"
                        {{ old('criteria_type_id') && old('criteria_type_id') == $criteriaType->id ? 'selected' : (!old('criteria_type_id') && isset($data) && $data->criteria_type_id == $criteriaType->id ? 'selected' : '') }}>
                        {{ $criteriaType->type }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-none" id="additional-content"></div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <div class="ms-auto">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
