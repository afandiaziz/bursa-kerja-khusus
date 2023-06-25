@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row">
            @if ($statusApplied)
                <div class="col-lg-9 col-12">
                    <div class="alert alert-yellow" role="alert">
                        Kamu sudah melamar pekerjaan ini. Cek pada menu <a href="{{ route('lamaran.index') }}">Lamaran Saya</a>.
                    </div>
                </div>
            @endif
            <div class="col-lg-9 col-12">
                @include('loker/detail')
            </div>
        </div>
    </div>
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
