@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row align-middle justify-content-center">
            <div class="col-12">
                <div class="card border shadow-sm">
                    <div class="card-body">
                        <div class="mt-3">
                            <a href="{{ url()->previous() }}" class="text-dark text-decoration-none hover-color-primary bg-azure-lt border btn">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l14 0"></path>
                                    <path d="M5 12l6 6"></path>
                                    <path d="M5 12l6 -6"></path>
                                </svg>
                                Kembali
                            </a>
                        </div>
                        <h1 class="fs-1 mt-3 text-dark">
                            {{ $data->title }}
                        </h1>
                        <div class="text-muted small mt-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-time" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4"></path>
                                <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"></path>
                                <path d="M15 3v4"></path>
                                <path d="M7 3v4"></path>
                                <path d="M3 11h16"></path>
                                <path d="M18 16.496v1.504l1 1"></path>
                            </svg>
                            {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y') }}
                        </div>
                        <hr>
                        <div class="text-center mt-4">
                            <img src="{{ filter_var($data->image, FILTER_VALIDATE_URL) ? $data->image : asset('assets/upload/information/' . $data->image) }}" class="rounded" alt="{{ $data->title }}">
                        </div>
                        <div class="mt-4">
                            {!! $data->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
