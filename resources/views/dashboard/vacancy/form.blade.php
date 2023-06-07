<div class="card">
    <div class="card-body">
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Perusahaan <span class="text-danger">*</span>
            </label>
            <select name="company_id" id="company_id" required class="form-control form-select">
                <option value=""></option>
                @foreach ($companies as $item)
                    <option value="{{ $item->id }}" {{ (isset($data) && $item->id == $data->company_id) ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Tipe Pekerjaan <span class="text-danger">*</span>
            </label>
            <select name="job_type" id="job_type" required class="form-control form-select">
                <option value=""></option>
                <option value="Full-time" {{ (isset($data) && 'Full-time' == $data->job_type) ? 'selected' : '' }}>Full-time</option>
                <option value="Part-time" {{ (isset($data) && 'Part-time' == $data->job_type) ? 'selected' : '' }}>Part-time</option>
                <option value="Contract" {{ (isset($data) && 'Contract' == $data->job_type) ? 'selected' : '' }}>Contract</option>
                <option value="Internship" {{ (isset($data) && 'Internship' == $data->job_type) ? 'selected' : '' }}>Internship</option>
                <option value="Temporary" {{ (isset($data) && 'Temporary' == $data->job_type) ? 'selected' : '' }}>Temporary</option>
                <option value="Volunteer" {{ (isset($data) && 'Volunteer' == $data->job_type) ? 'selected' : '' }}>Volunteer</option>
            </select>
        </div>
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Posisi <span class="text-danger">*</span>
            </label>
            <input type="text" class="form-control" name="position" id="position" value="{{ old('position') ? old('position') : (isset($data) && $data->position ? $data->position : '') }}" required>
        </div>
        <div class="form-group my-2">
            <label for="name" class="form-label text-capitalize">
                Kriteria Pelamar <span class="text-danger">*</span>
            </label>
            <select name="criteria[]" id="criteria" multiple required class="form-control">
                <option value=""></option>
                @foreach ($criteria as $item)
                    <option value="{{ $item->id }}" {{ in_array($item->id, $selectedCriteria) ? 'selected' : '' }}>{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group my-2">
            <label for="description" class="form-label text-capitalize">
                Deskripsi <span class="text-danger">*</span>
            </label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') ? old('description') : (isset($data) && $data->description ? $data->description : '') }}</textarea>
        </div>
        <div class="form-group my-2">
            <label for="information" class="form-label text-capitalize">
                Informasi Tambahan
            </label>
            <textarea name="information" id="information" class="form-control" rows="3">{{ old('information') ? old('information') : (isset($data) && $data->information ? $data->information : '') }}</textarea>
        </div>
        <div class="form-group my-2">
            <label for="deadline" class="form-label text-capitalize">
                Batas Tanggal Pendaftaran <span class="text-danger">*</span>
            </label>
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                </span>
                <input class="form-control" readonly autocomplete="off" placeholder="Pilih tanggal" name="deadline" id="deadline" value="{{ old('deadline') ? old('deadline') : (isset($data) && $data->deadline ? $data->deadline : '') }}" required>
            </div>
        </div>
        <div class="form-group my-2">
            <label for="max_applicants" class="form-label text-capitalize">
                Batas Total Pelamar
            </label>
            <div class="input-icon mb-2">
                <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                        <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                        <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                    </svg>
                </span>
                <input class="form-control" type="number" id="max_applicants" name="max_applicants" value="{{ old('max_applicants') ? old('max_applicants') : (isset($data) && $data->max_applicants ? $data->max_applicants : '') }}">
            </div>
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
