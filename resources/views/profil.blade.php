@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row justify-content-center">
            <div class="col-9">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h1 class="mb-0">{{ Auth::user()->name }}</h1>
                                <h3>({{ Auth::user()->email }})</h3>
                            </div>
                            <div class="ms-auto">
                                <a class="btn btn-link cursor-pointer" role="button" href="{{ route('profil.edit') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                        <path d="M16 5l3 3"></path>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </div>
                        <div class="row gap-4 mt-4 mb-3">
                            @foreach ($criteria as $item)
                                <div class="{{ $item->criteriaType->type == 'Custom' ? 'col-12' : 'col-auto' }}">
                                    <div class="text-secondary text-uppercase fs-4 fw-bold">{{ $item->name }}</div>
                                    <div class="fs-3">
                                        @include('components.criteria', ['criteria' => $item, 'data' => Auth::user()->user_details, 'child' => Auth::user()])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @if (Auth::user()->cv && file_exists(public_path('assets/upload/cv/' . Auth::user()->cv)))
                <div class="col-3">
                    <a href="{{ url('assets/upload/cv/' . Auth::user()->cv) }}" target="_blank">
                        <div class="card">
                            <div class="card-body color-blue">
                                <div class="my-0 py-0 text-secondary text-uppercase fs-4 fw-bold">CV</div>
                                <div class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="4em" viewBox="0 0 512 512"><path d="M64 464H96v48H64c-35.3 0-64-28.7-64-64V64C0 28.7 28.7 0 64 0H229.5c17 0 33.3 6.7 45.3 18.7l90.5 90.5c12 12 18.7 28.3 18.7 45.3V288H336V160H256c-17.7 0-32-14.3-32-32V48H64c-8.8 0-16 7.2-16 16V448c0 8.8 7.2 16 16 16zM176 352h32c30.9 0 56 25.1 56 56s-25.1 56-56 56H192v32c0 8.8-7.2 16-16 16s-16-7.2-16-16V448 368c0-8.8 7.2-16 16-16zm32 80c13.3 0 24-10.7 24-24s-10.7-24-24-24H192v48h16zm96-80h32c26.5 0 48 21.5 48 48v64c0 26.5-21.5 48-48 48H304c-8.8 0-16-7.2-16-16V368c0-8.8 7.2-16 16-16zm32 128c8.8 0 16-7.2 16-16V400c0-8.8-7.2-16-16-16H320v96h16zm80-112c0-8.8 7.2-16 16-16h48c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v32h32c8.8 0 16 7.2 16 16s-7.2 16-16 16H448v48c0 8.8-7.2 16-16 16s-16-7.2-16-16V432 368z"/></svg>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
