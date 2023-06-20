<div class="form-group my-2">
    <label class="form-label text-capitalize">
        Minimum Angka yang diinput
    </label>
    <input type="number" class="form-control"
        name="{{ $subIndex != null ? "sub[min_number][$subIndex]" : 'min_number' }}"
        value="{{ $old && $old->min_number ? $old->min_number : '' }}"
    >
</div>
<div class="form-group my-2">
    <label for="max_number" class="form-label text-capitalize">
        Maximum Angka yang diinput
    </label>
    <input type="number" class="form-control"
        name="{{ $subIndex != null ? "sub[max_number][$subIndex]" : 'max_number' }}"
        value="{{ $old && $old->max_number ? $old->max_number : '' }}"
    >
</div>
