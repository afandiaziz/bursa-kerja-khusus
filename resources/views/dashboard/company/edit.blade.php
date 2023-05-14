@extends('dashboard.layouts.app')
@section('title', 'Edit Perusahaan' . ' - ' . $data->name)

@section('content')
    <div class="col-lg-8" id="form-content">
        <form method="post" class="w-100" action="{{ route($prefix . '.update', ['id' => $data->id]) }}" enctype="multipart/form-data">
            @csrf
            @include("dashboard.$prefix.form")
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dropify/dropify.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/dropify/dropify.js') }}"></script>
    <script>
        const drEvent = $('.dropify').dropify();
        drEvent.on('dropify.beforeClear', function(event, element){
            $.ajax({
                url: "{{ route($prefix . '.delete-logo', ['id' => $data->id]) }}",
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
            });
        });
    </script>
@endsection
