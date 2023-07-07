@extends('dashboard.layouts.app')

@section('title', 'Manajemen Perusahaan')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="card-header-action">
                    <a href="{{ route($prefix . '.create') }}" class="btn btn-primary text-capitalize">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-plus" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"></path>
                            <path d="M9 12l6 0"></path>
                            <path d="M12 9l0 6"></path>
                        </svg>
                        Tambah Perusahaan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100 table-bordered table-xs" id="datatable-ajax">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Perusahaan</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#datatable-ajax').DataTable({
            ajax: '?company_datatable=true',
            serverSide: true,
            processing: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name'
                },
                {
                    data: 'address'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'email'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
        });
    </script>
@endsection
