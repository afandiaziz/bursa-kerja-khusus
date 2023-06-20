@php
    if (isset($old->format_file) && $old->format_file && !is_array($old->format_file)) {
        $old->format_file = explode(',', $old->format_file);
    }
@endphp
<div class="form-group my-2">
    <label for="is_multiple" class="form-label text-capitalize">
        Tipe Upload <span class="text-danger">*</span>
    </label>
    <label class="form-check">
        <input class="form-check-input input-is_multiple" type="radio" value="0" required
            name="{{ $subIndex != null ? "sub[is_multiple][$subIndex]" : 'is_multiple' }}"
            {{ $old && $old != null && $old->is_multiple == 0 ? 'checked' : '' }}
        >
        <span class="form-check-label">Single File Upload</span>
    </label>
    <label class="form-check">
        <input class="form-check-input input-is_multiple" type="radio" value="1" required
            name="{{ $subIndex != null ? "sub[is_multiple][$subIndex]" : 'is_multiple' }}"
            {{ $old && $old != null && $old->is_multiple == 1 ? 'checked' : '' }}
        >
        <span class="form-check-label">Multiple File Upload</span>
    </label>
</div>
<div class="form-group my-2">
    <label for="max_files" class="form-label text-capitalize">
        Maximal Files yang Diupload <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        <input type="number" class="form-control" max="10" min="2" required
            value="{{ $old && $old != null && $old->is_multiple == 1 && $old->max_files ? $old->max_files : '' }}"
            name="{{ $subIndex != null ? "sub[max_files][$subIndex]" : 'max_files' }}"
            {{ $old && $old != null && $old->is_multiple == 1 ? '' : 'disabled' }}
        >
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
        <input type="number" class="form-control" max="5" min="1" required
            value="{{ $old && $old->max_size ? $old->max_size : 2 }}"
            name="{{ $subIndex != null ? "sub[max_size][$subIndex]" : 'max_size' }}"
        >
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
        <input class="form-check-input input-format" type="radio" value="1" required
            name="{{ $subIndex != null ? "sub[format][$subIndex]" : 'format' }}"
            {{ ($old && $old != null && isset($old->format) && $old->format == 1) || ($old && $old != null && $old->format_file == null) ? 'checked' : '' }}
        >
        <span class="form-check-label">Izinkan Semua Jenis File</span>
    </label>
    <label class="form-check">
        <input class="form-check-input input-format" type="radio" value="0" required
            name="{{ $subIndex != null ? "sub[format][$subIndex]" : 'format' }}"
            {{ ($old && $old != null && isset($old->format) && $old->format == 0) || ($old && $old != null && $old->format_file != null) ? 'checked' : '' }}
        >
        <span class="form-check-label">Jenis File Spesifik</span>
    </label>
    <div id="format_file_content">
        <select id="format_file" class="form-select mt-3" required multiple
            name="{{ $subIndex != null ? "sub[format_file][$subIndex][]" : 'format_file[]' }}"
            {{ ($old && $old != null && isset($old->format) && $old->format == 0) || ($old && $old != null && $old->format_file != null) ? '' : 'disabled' }}>
            <option {{ $old && is_array($old->format_file) && in_array('application/pdf', $old->format_file) ? 'selected' : '' }}
                value="application/pdf">
                PDF Document (.pdf)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('image/png', $old->format_file) ? 'selected' : '' }}
                value="image/png, image/jpeg">
                Gambar(.png, .jpg, .jpeg)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('text/plain', $old->format_file) ? 'selected' : '' }}
                value="text/plain">
                Text Document (.txt)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', $old->format_file) ? 'selected' : '' }}
                value="application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/msword, application/vnd.oasis.opendocument.text, application/rtf">
                Word Document (.docx, .doc, .rtf, .odt)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('application/vnd.ms-excel', $old->format_file) ? 'selected' : '' }}
                value="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, text/csv, application/vnd.oasis.opendocument.spreadsheet">
                Excel/Spreadsheet Document (.xls, .xlsx, .csv, .ods)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('application/vnd.ms-powerpoint', $old->format_file) ? 'selected' : '' }}
                value="application/vnd.ms-powerpoint, application/vnd.openxmlformats-officedocument.presentationml.presentation, application/vnd.oasis.opendocument.presentation">
                Powerpoint/Presentation Document (.ppt, .pptx, .odp)
            </option>
            <option {{ $old && is_array($old->format_file) && in_array('application/zip', $old->format_file) ? 'selected' : '' }}
                value="application/zip, application/vnd.rar, application/x-7z-compressed">
                File Archive (.zip, .rar, .7zip)
            </option>
        </select>
        <script>
            new TomSelect('#format_file');
        </script>
    </div>
</div>
