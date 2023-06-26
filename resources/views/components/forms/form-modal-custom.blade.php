<div class="modal modal-blur fade" id="modal-{{ $data->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content border-blue shadow-lg">
            <form method="post" enctype="multipart/form-data" action="{{ route('profil.store.custom') }}">
                @csrf
                <input type="hidden" name="parent" value="{{ $data->id }}" required autocomplete="off" readonly>
                @if ($index != null)
                    <input type="hidden" name="index" value="{{ $index }}" required autocomplete="off" readonly>
                @endif
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span>Tambah</span> {{ $data->name }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-2">
                    <div class="mt-2" id="form-custom-view-container">
                        @foreach ($data->children as $item)
                            @if (isset($isUpdate) && $isUpdate)
                                @php
                                    $item->index = $index;
                                @endphp
                            @endif
                            @if ($item->criteria_type_id)
                                <div class="my-3">
                                    @include('components.forms.form', ['data' => $item, 'custom' => true])
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <div role="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</div>
                    <button type="submit" class="btn btn-success" id="button-form-modal-custom-{{ $data->id }}">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
