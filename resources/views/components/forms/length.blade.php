<div class="form-group my-2">
    <label for="min_length" class="form-label text-capitalize">
        Minimum Panjang/Banyaknya Teks/Digits
    </label>
    <input type="number" min="0" class="form-control" name="min_length"
        value="{{ $old && $old->min_length ? $old->min_length : '' }}">
</div>
<div class="form-group my-2">
    <label for="max_length" class="form-label text-capitalize">
        Maximum Panjang/Banyaknya Teks/Digits
    </label>
    <input type="number" min="0" class="form-control" name="max_length"
        value="{{ $old && $old->max_length ? $old->max_length : '' }}">

</div>
