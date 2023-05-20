@extends('dashboard.layouts.app')
@section('title', 'Tambah Informasi')

@section('content')
    <div class="col-lg-8" id="form-content">
        <form method="post" class="w-100" action="{{ route($prefix . '.store') }}" enctype="multipart/form-data">
            @csrf
            @include("dashboard.$prefix.form")
        </form>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/dropify/dropify.css') }}">
    <style>
        .ck.ck-editor__editable {
            min-height: 200px;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/dropify/dropify.js') }}"></script>
    <script>
        $('.dropify').dropify();
        ClassicEditor
            .create( document.querySelector( 'textarea#content' ), {
                toolbar: [
                    'undo', 'redo', '|',
                    'heading', '|',
                    'bold', 'italic', 'underline',
                    '|', 'subscript', 'superscript', 'horizontalLine', '|',
                    'bulletedList', 'numberedList', , '|', 'outdent', 'indent', 'removeFormat', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed',
                    '|'
                ]
            } )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endsection
