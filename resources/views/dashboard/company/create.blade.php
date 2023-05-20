@extends('dashboard.layouts.app')
@section('title', 'Tambah Perusahaan')

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
@endsection

@section('script')
    <script src="{{ asset('assets/dropify/dropify.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
