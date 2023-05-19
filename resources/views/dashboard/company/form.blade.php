<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 order-lg-1 order-0">
                <div class="form-group my-2">
                    <label for="logo" class="form-label text-capitalize">
                        Logo
                    </label>
                    <input type="file" name="logo" id="logo" class="dropify" accept=".png,.jpg,.jpeg" data-allowed-file-extensions="jpg png jpeg" data-default-file="{{ old('logo') ? old('logo') : (isset($data) && $data->logo ? (filter_var($data->logo, FILTER_VALIDATE_URL) ? $data->logo : asset('assets/upload/companies/' . $data->logo)) : '') }}" data-max-file-size="2M">
                </div>
            </div>
            <div class="col-lg-8 order-1 order-lg-0">
                <div class="form-group my-2">
                    <label for="name" class="form-label text-capitalize">
                        Nama <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : (isset($data) && $data->name ? $data->name : '') }}" required>
                </div>
                <div class="form-group my-2">
                    <label for="email" class="form-label text-capitalize">
                        Email
                    </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') ? old('email') : (isset($data) && $data->email ? $data->email : '') }}">
                </div>
                <div class="form-group my-2">
                    <label for="phone" class="form-label text-capitalize">
                        Phone
                    </label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') ? old('phone') : (isset($data) && $data->phone ? $data->phone : '') }}">
                </div>
            </div>
        </div>
        <div class="form-group my-2">
            <label for="website" class="form-label text-capitalize">
                Website
            </label>
            <input type="text" class="form-control" id="website" name="website" value="{{ old('website') ? old('website') : (isset($data) && $data->website ? $data->website : '') }}">
        </div>
        <div class="form-group my-2">
            <label for="address" class="form-label text-capitalize">
                Alamat <span class="text-danger">*</span>
            </label>
            <textarea name="address" id="address" class="form-control" rows="3" required>{{ old('address') ? old('address') : (isset($data) && $data->address ? $data->address : '') }}</textarea>
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
