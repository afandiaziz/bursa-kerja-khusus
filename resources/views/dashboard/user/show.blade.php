@extends('dashboard.layouts.app')
@section('title', 'Data Pelamar/Pengguna')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row justify-content-center">
            <div class="col-11">

                @if (isset($buttonBack) && $buttonBack)
                    <div>
                        <a class="btn btn-dark mb-2" href="{{ route('user.index') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l6 6"></path>
                                <path d="M5 12l6 -6"></path>
                            </svg>
                            Kembali
                        </a>
                    </div>
                @endif
                <div class="card card-body">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-detail-applicant" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h1.5"></path>
                                    <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    <path d="M20.2 20.2l1.8 1.8"></path>
                                </svg>&nbsp;
                                Detail Pelamar
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a href="#tabs-applications" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                    <path d="M12 12l0 .01"></path>
                                    <path d="M3 13a20 20 0 0 0 18 0"></path>
                                </svg>&nbsp;
                                Lamaran
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane show active" id="tabs-detail-applicant">
                        <div class="card">
                            <div class="card-body">
                                <h1 class="mb-0">{{ $data->name }}</h1>
                                <h3>({{ $data->email }})</h3>
                                <h3>
                                    CV:
                                    <a href="{{ $data->cv ? url(asset('assets/upload/cv/' . $data->cv)) : '#' }}" class="btn btn-link fs-3" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                            <path d="M9 9l1 0"></path>
                                            <path d="M9 13l6 0"></path>
                                            <path d="M9 17l6 0"></path>
                                        </svg>
                                        {{ $data->cv }}
                                    </a>
                                </h3>
                                <div class="row gap-4 mt-4 mb-3">
                                    @foreach ($criteria->where('active', true) as $item)
                                        <div class="{{ $item->criteriaType->type == 'Custom' ? 'col-12 border-top border-bottom py-2' : 'col-auto' }}">
                                            <div class="text-secondary text-uppercase fs-4 fw-bold">{{ $item->name }}</div>
                                            <div class="fs-3">
                                                @include('components.criteria', ['criteria' => $item, 'data' => $data->user_details, 'child' => $data])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-applications">
                        <div class="card">
                            <div class="card-body">
                                @if ($data->applications->count())
                                    <div class="table-reponsive">
                                        <table class="table w-100 table-borderless" id="datatable-ajax">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                @else
                                    <h2>Pelamar belum melamar pekerjaan apapun. </h2>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        div.dataTables_wrapper div.dataTables_paginate ul.pagination {
            justify-content: center !important;
        }
        div.dataTables_wrapper div.dataTables_filter {
            text-align: unset !important
        }
        .card-loker:hover {
            background-color: #f5f5f5;
        }
        .card-loker:hover h3 {
            text-decoration: underline;
        }
    </style>
@endsection

@if ($data->applications->count())
    @section('script')
        <script>
            $("#datatable-ajax thead").hide();
            const dt = $('#datatable-ajax').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                deferRender: true,
                bInfo: false,
                bLengthChange: false,
                searching: false,
                columns: [
                    {
                        searchable: false,
                        orderable: false,
                        data: 'card',
                    },
                ],
                // position search box and pagination to the left
                dom: '<"row"<"col-12"f>>' +
                    '<"row"<"col-12"t>>' +
                    '<"row"<"col-12"p>>',
                lengthMenu:[20],
                language: {
                    search: '',
                    searchPlaceholder: 'Cari',
                    paginate: {
                        previous: '<svg xmlns="http://www.w3.org/2000/svg" class="mx-3 icon icon-tabler icon-tabler-chevron-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M15 6l-6 6l6 6"></path> </svg>',
                        next: '<svg xmlns="http://www.w3.org/2000/svg" class="mx-3 icon icon-tabler icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M9 6l6 6l-6 6"></path> </svg>'
                    },
                    zeroRecords: 'Tidak ditemukan',
                    infoEmpty: 'Tidak ditemukan',
                    infoFiltered: 'Tidak ditemukan'
                },
            });
            dt.on('draw', function(data){
                $('#datatable-ajax tbody tr').each(function(){
                    $(this).replaceWith('<div class="col-md-6 col-12 mb-3">' + $(this).html() +'</div>')
                })
                $('#datatable-ajax tbody').addClass('row');
                $("#datatable-ajax_filter input").removeClass('form-control-sm').addClass('ms-0');
            });
        </script>
    @endsection
@endif
