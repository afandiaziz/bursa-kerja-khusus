@if ($data->criteriaType->type != 'Upload File')
    <form action="#" id="example-form">
        {{-- @dd($data->criteriaType->type, $data->criteriaAnswer->count()) --}}
        <div class="form-group my-2">
            @if ($data->criteriaType->type == 'Teks')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <input type="text" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    {{ $data->required ? 'required' : '' }} class="form-control">
            @endif
            @if ($data->criteriaType->type == 'Angka')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <input type="number" id="{{ $data->id }}" name="{{ $data->id }}"
                    minlength="{{ $data->min_length }}" maxlength="{{ $data->max_length }}"
                    min="{{ $data->min_number }}" max="{{ $data->max_number }}"
                    {{ $data->required ? 'required' : '' }} class="form-control">
            @endif
            @if ($data->criteriaType->type == 'Teks Panjang')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <textarea id="{{ $data->id }}" name="{{ $data->id }}" rows="3" class="form-control"
                    {{ $data->required ? 'required' : '' }}></textarea>
            @endif
            @if ($data->criteriaType->type == 'Pilihan Ganda (Radio)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                @foreach ($data->criteriaAnswer as $item)
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}"
                            value="{{ $item->id }}" {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">{{ $item->answer }}</span>
                    </label>
                @endforeach
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Ya/Tidak)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <div class="d-flex gap-3">
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="1"
                            {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">Ya</span>
                    </label>
                    <label class="form-check">
                        <input class="form-check-input" type="radio" name="{{ $data->id }}" value="0"
                            {{ $data->required ? 'required' : '' }}>
                        <span class="form-check-label">Tidak</span>
                    </label>
                </div>
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Multiple Checkbox)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <div class="row">
                    @foreach ($data->criteriaAnswer as $item)
                        <div class="col-md-6">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $data->id }}[]"
                                    value="{{ $item->id }}" {{ $data->required ? 'required' : '' }}>
                                <span class="form-check-label">{{ $item->answer }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($data->criteriaType->type == 'Pilihan Ganda (Dropdown)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <select name="{{ $data->id }}" id="{{ $data->id }}"
                    class="form-select {{ $data->criteriaAnswer->count() > 8 ? 'select2' : '' }}"
                    {{ $data->required ? 'required' : '' }}>
                    <option value="">Pilih</option>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id }}">{{ $item->answer }}</option>
                    @endforeach
                </select>
            @endif
            @if ($data->criteriaType->type == 'Pilihan (Multiple Dropdown)')
                <label for="{{ $data->id }}" class="form-label">
                    {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
                </label>
                <select name="{{ $data->id }}[]" id="{{ $data->id }}" class="form-select mt-3 select2"
                    {{ $data->required ? 'required' : '' }} multiple>
                    @foreach ($data->criteriaAnswer as $item)
                        <option value="{{ $item->id }}">{{ $item->answer }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        <div class="form-group mt-3">
            <button class="btn btn-dark" type="submit" id="example-submit">Submit</button>
        </div>
    </form>
@else
    <div class="form-group my-2">
        <label for="{{ $data->id }}" class="form-label">
            {{ $data->name }} {!! $data->required ? '<span class="text-danger">*</span>' : '' !!}
        </label>
        <form action="{{ route('criteria.test') }}" method="post" id="example-form">
            @csrf
            <div class="form-group my-2">
                <div class="dropzone" id="input-{{ Str::slug($data->name) }}"></div>
            </div>
            <div class="form-group mt-3">
                <button class="btn btn-dark" type="button" id="example-submit">Submit</button>
            </div>
        </form>
    </div>
@endif
{{-- @push('form-script') --}}
@if ($data->criteriaType->type == 'Upload File')
    <script>
        function configDropzone(clickable) {
            return {
                url: "{{ route('criteria.form.preview.upload') }}",
                method: 'post',
                paramName: '{{ $data->id }}',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                params: {
                    criteria: "{{ $data->id }}",
                    preview: true,
                },
                resizeQuality: 0.8,
                parallelUploads: 100,
                addRemoveLinks: true,
                autoProcessQueue: false,
                clickable: '#' + clickable,
                maxFilesize: {{ $data->max_size }},
                // uploadMultiple: false,
                // maxFiles: 1,
                uploadMultiple: '{{ $data->type_upload ? 'true' : 'false' }}',
                maxFiles: {{ $data->type_upload ? $data->max_files : 1 }},
                acceptedFiles: "{{ $data->format_file ? $data->format_file : '' }}",
                removedfile: function(file) {
                    file.previewElement.remove()
                    $('button[id="example-submit"]').removeAttr('disabled');
                    //     // $.ajax({
                    //     //     url: "",
                    //     //     type: 'DELETE',
                    //     //     data: {
                    //     //         _token: "{{ csrf_token() }}",
                    //     //         id: file.id
                    //     //     },
                    //     // });
                },
                // error(file, message) {
                //     if (
                //         file.status == 'error' && message != 'You can not upload any more files.' ||
                //         file.status == 'error' && message != "You can't upload files of this type." ||
                //         file.status == 'error' && message.includes('File is too big')
                //     ) {

                //     }
                //     $('button[id="example-submit"]').removeAttr('disabled');
                //     console.log('e', file, message)
                // },
                init: function() {
                    const myDropzone = this;
                    this.on("addedfile", function(file) {
                        $('.dropzone .dz-preview').css('margin-top', '32px');
                        $('.dz-remove').addClass(
                                'btn btn-danger btn-sm text-decoration-none position-absolute rounded-2 px-3')
                            .css({
                                'top': '-30px',
                                'left': '6px'
                            });
                        $('.dz-success-mark svg g path').attr('fill', '#2AC840');
                        $('.dz-error-mark svg g g').attr('fill', '#DC3545');
                        $('button[id="example-submit"]').removeAttr('disabled');
                    });

                    $('button[id="example-submit"]').click(function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        myDropzone.processQueue();
                        $('button[id="example-submit"]').attr('disabled', 'disabled');
                    });

                    this.on('sending', function(file) {
                        $('button[id="example-submit"]').attr('disabled', 'disabled');
                    });

                    this.on('completemultiple', function(files) {
                        let statusUpload = true;
                        files.forEach(file => {
                            if (statusUpload && file.status == 'error') {
                                statusUpload = false;
                            }
                        });
                        $('button[id="example-submit"]').removeAttr('disabled');
                        if (statusUpload) {
                            // $('form#example-form').submit();
                        }
                    });

                    // this.on('queuecomplete', function() {
                    // console.log('second')
                    // $('form#example-form').submit();
                    // });
                    // this.on('errormultiple', function(files, message) {
                    //     if (message != 'You can not upload any more files.' || message !=
                    //         "You can't upload files of this type.") {

                    //         // $('button[id="example-submit"]').removeAttr('disabled');
                    //     }
                    //     console.log('third', files, message)
                    // });

                    // this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                    //     // Make sure that the form isn't actually being sent.
                    //     e.preventDefault();
                    //     e.stopPropagation();
                    //     myDropzone.processQueue();
                    // });
                    //     let thisDropzone = this;
                    //     const files = {!! json_encode([]) !!}
                    //     files.map(file => {
                    //         thisDropzone.displayExistingFile(file, file.source);
                    //     });
                    //     thisDropzone.options.maxFiles = thisDropzone.options.maxFiles - files.length;
                    //     $('.dz-remove').addClass('btn btn-danger btn-sm text-decoration-none mt-2');
                    //     $('.dz-success-mark svg g path').attr('fill', '#2AC840');
                    //     $('.dz-error-mark svg g g').attr('fill', '#DC3545');
                }
            }
        }
        new Dropzone('#input-{{ Str::slug($data->name) }}', configDropzone("input-{{ Str::slug($data->name) }}"));
    </script>
@else
    <script>
        $(document).ready(function() {
            $('form#example-form').submit(function(e) {
                console.log();
                if ($("input[type=checkbox]").length) {
                    checked = $("input[type=checkbox]:checked").length;
                    if (!checked) {
                        alert("You must check at least one checkbox.");
                        return false;
                    }
                }
                return true;
            });
        });
    </script>
@endif
{{-- @endpush --}}
<hr>
