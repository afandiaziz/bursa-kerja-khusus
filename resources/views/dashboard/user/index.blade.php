@extends('dashboard.layouts.app')
@section('title', 'Data Pelamar/Pengguna')

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped w-100 table-bordered table-xs" id="datatable-ajax">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th></th>
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
            ajax: '',
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
                    data: 'email'
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
