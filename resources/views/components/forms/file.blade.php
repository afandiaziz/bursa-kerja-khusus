<div class="form-group my-2">
    <label for="type_upload" class="form-label text-capitalize">
        Tipe Upload <span class="text-danger">*</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="type_upload" value="0" required
            {{ $old && $old->type_upload == 0 ? 'checked' : '' }}>
        <span class="form-check-label">Single File Upload</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="type_upload" value="1" required
            {{ $old && $old->type_upload == 1 ? 'checked' : '' }}>
        <span class="form-check-label">Multiple File Upload</span>
    </label>
</div>
<div class="form-group my-2">
    <label for="max_files" class="form-label text-capitalize">
        Maximal Files <span class="text-danger">*</span>
    </label>
    <div class="input-group">
        <input type="number" class="form-control" value="{{ $old && $old->max_files ? $old->max_files : '' }}"
            max="10" min="2" name="max_files" disabled required>
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
            {{ $old && $old->format == 1 ? 'checked' : '' }}>
        <span class="form-check-label">Izinkan Semua Jenis File</span>
    </label>
    <label class="form-check">
        <input class="form-check-input" type="radio" name="format" value="0" required
            {{ $old && $old->format == 0 ? 'checked' : '' }}>
        <span class="form-check-label">Jenis File Spesifik</span>
    </label>
    <div id="format_file_content">
        <select name="format_file[]" id="format_file" class="form-select mt-3 select2" required multiple
            {{ $old && $old->format == 0 ? '' : 'disabled' }}>
            <option {{ $old && in_array('.pdf', $old->format_file) ? 'selected' : '' }} value=".pdf">
                PDF Document (.pdf)
            </option>
            <option {{ $old && in_array('.png,.jpg,.jpeg', $old->format_file) ? 'selected' : '' }}
                value=".png,.jpg,.jpeg">
                Gambar(.png, .jpg, .jpeg)
            </option>
            <option {{ $old && in_array('.txt,.text,.rtf,.rtx', $old->format_file) ? 'selected' : '' }}
                value=".txt,.text,.rtf,.rtx">
                Text Document (.txt, .text, .rtf, .rtx)
            </option>
            <option {{ $old && in_array('.docx,.doc,.word,.odt', $old->format_file) ? 'selected' : '' }}
                value=".docx,.doc,.word,.odt">
                Word Document (.docx, .doc, .word, .odt)
            </option>
            <option {{ $old && in_array('.xls,.xlsx,.csv,.ods', $old->format_file) ? 'selected' : '' }}
                value=".xls,.xlsx,.csv,.ods">
                Excel/Spreadsheet Document (.xls, .xlsx, .csv, .ods)
            </option>
            <option {{ $old && in_array('.ppt,.pptx,.odp', $old->format_file) ? 'selected' : '' }}
                value=".ppt,.pptx,.odp">
                Powerpoint/Presentation Document (.ppt, .pptx, .odp)
            </option>
            <option {{ $old && in_array('.zip,.rar,.7zip,.7', $old->format_file) ? 'selected' : '' }}
                value=".zip,.rar,.7zip,.7">
                File Archive (.zip, .rar, .7zip, .7z)
            </option>
        </select>
    </div>
</div>
