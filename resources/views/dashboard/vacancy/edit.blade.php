@extends('dashboard.layouts.app')
@section('pre-title', 'Edit Lowongan Pekerjaan')
@section('title', $data->company->name . ' - '. $data->position)

@section('content')
    <div class="col-lg-12" id="form-content">
        <form method="post" class="w-100" action="{{ route($prefix . '.update', ['id' => $data->id]) }}">
            @csrf
            @include("dashboard.$prefix.form")
        </form>
    </div>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ck.ck-editor__editable {
            min-height: 200px;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/js/litepicker.js') }}"></script>
    <script src="{{ asset('assets/ckeditor/build/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            window.Litepicker && (new Litepicker({
                element: document.getElementById('deadline'),
                format: 'DD-MM-YYYY',
                buttonText: {
                    previousMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
                    nextMonth: `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
                },
            }));
        });
        ClassicEditor
            .create( document.querySelector( 'textarea#description' ), {
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
        new TomSelect('#company_id');
        new TomSelect('#criteria', {
            plugins: {
                remove_button:{
                    title:'Remove this item',
                }
            },
            persist: false,
            create: true,
        });
    </script>
@endsection
