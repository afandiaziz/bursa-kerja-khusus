@php
    if (isset($old->format_file) && $old->format_file && !is_array($old->format_file)) {
        $old->format_file = explode(',', $old->format_file);
    }
@endphp
<div class="form-group my-2">
    <label for="type_upload" class="form-label text-capitalize">
        Tipe Upload <span class="text-danger">*</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="type_upload" value="0" required
            {{ $old && $old != null && $old->type_upload == 0 ? 'checked' : '' }}>
        <span class="form-check-label">Single File Upload</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="type_upload" value="1" required
            {{ $old && $old != null && $old->type_upload == 1 ? 'checked' : '' }}>
        <span class="form-check-label">Multiple File Upload</span>
    </label>
</div>
<div class="form-group my-2">
    <label for="max_files" class="form-label text-capitalize">
        Maximal Files yang Diupload <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        <input type="number" class="form-control"
            value="{{ $old && $old != null && $old->type_upload == 1 && $old->max_files ? $old->max_files : '' }}"
            max="10" min="2" name="max_files" required
            {{ $old && $old != null && $old->type_upload == 1 ? '' : 'disabled' }}>
        <div class="input-group-text">
            Files
        </div>
    </div>
</div>
<div class="form-group my-2">
    <label for="max_size" class="form-label text-capitalize">
        Maximal Size per File <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        <input type="number" class="form-control" value="{{ $old && $old->max_size ? $old->max_size : 2 }}"
            max="5" min="1" name="max_size" required>
        <div class="input-group-text">
            MB
        </div>
    </div>
</div>
<div class="form-group my-2">
    <label for="format_file" class="form-label text-capitalize">
        Format File yang Diizinkan <span class="text-danger">*</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="format" value="1" required
            {{ ($old && $old != null && isset($old->format) && $old->format == 1) || ($old && $old != null && $old->format_file == null) ? 'checked' : '' }}>
        <span class="form-check-label">Izinkan Semua Jenis File</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="format" value="0" required
            {{ ($old && $old != null && isset($old->format) && $old->format == 0) || ($old && $old != null && $old->format_file != null) ? 'checked' : '' }}>
        <span class="form-check-label">Jenis File Spesifik</span>
    </label>
    <div id="format_file_content">
        <select name="format_file[]" id="format_file" class="form-select mt-3 select2" required multiple
            {{ ($old && $old != null && isset($old->format) && $old->format == 0) || ($old && $old != null && $old->format_file != null) ? '' : 'disabled' }}>
            <option {{ $old && is_array($old->format_file) && in_array('.pdf', $old->format_file) ? 'selected' : '' }}
                value=".pdf">
                PDF Document (.pdf)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.png', $old->format_file) ? 'selected' : '' }}
                value=".png,.jpg,.jpeg">
                Gambar(.png, .jpg, .jpeg)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.txt', $old->format_file) ? 'selected' : '' }}
                value=".txt,.text,.rtf,.rtx">
                Text Document (.txt, .text, .rtf, .rtx)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.docx', $old->format_file) ? 'selected' : '' }}
                value=".docx,.doc,.word,.odt">
                Word Document (.docx, .doc, .word, .odt)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.xls', $old->format_file) ? 'selected' : '' }}
                value=".xls,.xlsx,.csv,.ods">
                Excel/Spreadsheet Document (.xls, .xlsx, .csv, .ods)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.ppt', $old->format_file) ? 'selected' : '' }}
                value=".ppt,.pptx,.odp">
                Powerpoint/Presentation Document (.ppt, .pptx, .odp)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('.zip', $old->format_file) ? 'selected' : '' }}
                value=".zip,.rar,.7zip,.7">
                File Archive (.zip, .rar, .7zip, .7z)
            </option>
        </select>
    </div>
</div>