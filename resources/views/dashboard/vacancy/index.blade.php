@extends('dashboard.layouts.app')

@section('title', 'Manajemen Lowongan Pekerjaan')

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
                        Tambah Lowongan Pekerjaan
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cards mb-3">
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('vacancy.index') }}" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-info">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                                <path d="M12 12l0 .01"></path>
                                                <path d="M3 13a20 20 0 0 0 18 0"></path>
                                            </svg>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Lowongan Pekerjaan
                                            </div>
                                            <div class="text-muted">
                                                {{ $totalVacancy }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="?active=true" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-green text-green">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                                <path d="M12 12l0 .01"></path>
                                                <path d="M3 13a20 20 0 0 0 18 0"></path>
                                            </svg>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Lowongan Pekerjaan Aktif
                                            </div>
                                            <div class="text-muted">
                                                {{ $vacancyActive }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="?active=false" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-danger text-danger">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M11 7h8a2 2 0 0 1 2 2v8m-1.166 2.818a1.993 1.993 0 0 1 -.834 .182h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2"></path>
                                                <path d="M8.185 4.158a2 2 0 0 1 1.815 -1.158h4a2 2 0 0 1 2 2v2"></path>
                                                <path d="M12 12v.01"></path>
                                                <path d="M3 13a20 20 0 0 0 11.905 1.928m3.263 -.763a20 20 0 0 0 2.832 -1.165"></path>
                                                <path d="M3 3l18 18"></path>
                                            </svg>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Lowongan Pekerjaan Tidak Aktif
                                            </div>
                                            <div class="text-muted">
                                                {{ $vacancyNotActive }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped w-100 table-bordered table-xs" id="datatable-ajax">
                        <thead>
                            <tr>
                                <th width="3%">No</th>
                                <th>Nama Perusahaan</th>
                                <th>Posisi</th>
                                <th>Total Pelamar</th>
                                <th>Total Pelamar Terverifikasi/Batas Total Pelamar</th>
                                <th>Batas Pendaftaran</th>
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
                    data: 'company'
                },
                {
                    data: 'position'
                },
                {
                    data: 'applicants'
                },
                {
                    data: 'applicants_verified'
                },
                {
                    data: 'deadline'
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
