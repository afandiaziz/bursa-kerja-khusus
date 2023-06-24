@extends('layouts.app')

@section('content')
    <form action="{{ route('profil.update') }}" method="post" enctype="multipart/form-data" target="_blank">
        @csrf
        <div class="container mb-4 py-4">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <div class="card-title text-white">
                                Edit Data Diri
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="floating-input-name" name="name" value="{{ Auth::user()->name }}" autocomplete="off" required>
                                        <label for="floating-input-name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floating-input-email" readonly disabled value="{{ Auth::user()->email }}" autocomplete="off" required>
                                        <label for="floating-input-email" class="form-label">Email <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($criteria as $data)
                                    <div class="{{ $data->children && count($data->children) > 0 ? 'col-md-12 mt-4' : 'col-md-6' }}">
                                        @include('components.forms.form', ['custom' => false])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="card-footer d-flex">
                            <button type="submit" class="btn btn-success ms-auto">Simpan</button>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="card">
                        <div class="card-body color-blue">
                            <div class="form-floating form-group mt-3">
                                <input type="file" class="filepond" id="cv" name="cv" data-max-file-size="2MB" required accept="application/pdf">
                                <label for="cv" class="form-label">
                                    CV (pdf) <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('css')
    @include('components.plugins')
@endsection

@section('script')
    @if (Auth::user()->cv && file_exists(public_path('assets/upload/cv/' . Auth::user()->cv)))
        <script>
            $('#cv.filepond').filepond({
                storeAsFile: true,
                files: [{
                    source: '{{ url("assets/upload/cv/".Auth::user()->cv) }}',
                    options: {
                        type: 'input',
                    },
                }],
            });
        </script>
    @else
        <script>
            $('#cv.filepond').filepond({
                storeAsFile: true,
            });
        </script>
    @endif
@endsection
