@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row align-middle justify-content-center">
            @if (Auth::user()->applications->count())
                <div class="col-12">
                    <div class="table-reponsive">
                        <table class="table w-100 table-borderless" id="datatable-ajax">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            @else
                <div class="col-6">
                    <div class="card card-body border-warning text-center fs-2 py-4">
                        <div class="fw-bold">
                            Kamu belum melamar pekerjaan apapun.
                        </div>
                        <div>
                            <a href="{{ route('loker.index') }}" class="btn btn-blue mt-3">Jelajahi Lowongan Pekerjaan</a>
                        </div>
                    </div>
                </div>
            @endif
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

@if (Auth::user()->applications->count())
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
