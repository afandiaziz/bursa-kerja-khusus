<div class="card">
    <div class="card-body">
        <div class="form-group my-2">
            <label for="title" class="form-label text-capitalize">
                Judul <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ? old('title') : (isset($data) && $data->title ? $data->title : '') }}" required>
        </div>
        <div class="form-group my-2">
            <label for="content" class="form-label text-capitalize">
                Isi <span class="text-danger">*</span>
            </label>
            <textarea name="content" id="content" class="form-control" rows="3">{{ old('content') ? old('content') : (isset($data) && $data->content ? $data->content : '') }}</textarea>
        </div>
        <div class="form-group my-2">
            <label for="image" class="form-label text-capitalize">
                Gambar Thumbnail <span class="text-danger">*</span>
            </label>
            <input type="file" name="image" id="image" class="dropify" accept=".png,.jpg,.jpeg" data-allowed-file-extensions="jpg png jpeg" data-default-file="{{ old('image') ? old('image') : (isset($data) && $data->image ? (filter_var($data->image, FILTER_VALIDATE_URL) ? $data->image : asset('assets/upload/companies/' . $data->image)) : '') }}" data-max-file-size="2M">
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex">
            <div class="ms-auto">
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </div>
    </div>
</div>
