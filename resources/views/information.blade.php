@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row align-middle justify-content-center">
            <div class="col-12">
                <div class="table-reponsive">
                    <table class="table w-100 table-borderless" id="datatable-ajax">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
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
    </style>
@endsection

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
            columns: [
                {data: 'title', name: 'title', visible: false},
                {data: 'content', name: 'content', visible: false},
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
                $(this).replaceWith('<div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12">' + $(this).html() +'</div>')
            })
            $('#datatable-ajax tbody').addClass('row');
            $("#datatable-ajax_filter input").removeClass('form-control-sm').addClass('ms-0');
        });
    </script>
@endsection
