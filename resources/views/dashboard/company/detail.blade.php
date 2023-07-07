@extends('dashboard.layouts.app')

@section('title', 'Detail Perusahaan: ' . $data->name)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex">
                <div>
                    <a class="mx-1 btn btn-dark" href="{{ route($prefix . '.index') }}">
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
                <div class="ms-auto">
                    @if ($data->status)
                        <a class="mx-1 btn btn-danger" href="{{ route($prefix . '.activate', ['id' => $data->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24"
                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M18 6l-12 12"></path>
                                <path d="M6 6l12 12"></path>
                            </svg>
                            Nonaktifkan
                        </a>
                    @else
                        <a class="mx-1 btn btn-success" href="{{ route($prefix . '.activate', ['id' => $data->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l5 5l10 -10"></path>
                            </svg>
                            Aktifkan
                        </a>
                    @endif
                    <a class="mx-1 btn btn-warning" href="{{ route($prefix . '.edit', ['id' => $data->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                            <path d="M16 5l3 3"></path>
                        </svg>
                        Edit
                    </a>
                    <a class="mx-1 btn btn-pink" href="{{ route($prefix . '.delete', ['id' => $data->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash-filled"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path
                                d="M20 6a1 1 0 0 1 .117 1.993l-.117 .007h-.081l-.919 11a3 3 0 0 1 -2.824 2.995l-.176 .005h-8c-1.598 0 -2.904 -1.249 -2.992 -2.75l-.005 -.167l-.923 -11.083h-.08a1 1 0 0 1 -.117 -1.993l.117 -.007h16z"
                                stroke-width="0" fill="currentColor"></path>
                            <path
                                d="M14 2a2 2 0 0 1 2 2a1 1 0 0 1 -1.993 .117l-.007 -.117h-4l-.007 .117a1 1 0 0 1 -1.993 -.117a2 2 0 0 1 1.85 -1.995l.15 -.005h4z"
                                stroke-width="0" fill="currentColor"></path>
                        </svg>
                        Hapus
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        <img src="{{ filter_var($data->logo, FILTER_VALIDATE_URL) ? $data->logo : asset('assets/upload/companies/' . $data->logo) }}" alt="{{ $data->name }}" width="">
                    </div>
                    <div class="col-md-9 mt-3">
                        <h1>{{ $data->name }}</h1>
                        <p>
                            @if ($data->phone)
                                <div class="text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path>
                                    </svg>
                                    {{ $data->phone }}
                                </div>
                            @endif
                            @if ($data->email)
                                <div class="text-primary mt-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path>
                                        <path d="M3 7l9 6l9 -6"></path>
                                    </svg>
                                    {{ $data->email }}
                                </div>
                            @endif
                            @if ($data->website)
                                <div class="text-primary mt-1">
                                    <a href="{{ $data->website }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                            <path d="M11 13l9 -9"></path>
                                            <path d="M15 4h5v5"></path>
                                        </svg>
                                        {{ $data->website }}
                                    </a>
                                </div>
                            @endif
                            <div class="mt-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"></path>
                                </svg>
                                {{ $data->address }}
                            </div>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex">
                <div class="card-title h3">
                    Daftar Lowongan Pekerjaan
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cards mb-3">
                    <div class="col-sm-6 col-xxl-3">
                        <a href="{{ route($prefix . '.detail', ['id' => $data->id]) }}" class="text-decoration-none">
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
                                                {{ $data->vacancies->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <a href="{{ route($prefix . '.detail', ['active' => 'true', 'id' => $data->id]) }}" class="text-decoration-none">
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
                                                {{ $data->vacanciesActive()->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-xxl-3">
                        <a href="{{ route($prefix . '.detail', ['active' => 'false', 'id' => $data->id]) }}" class="text-decoration-none">
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
                                                {{ $data->vacanciesNotActive()->count() }}
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
                                <th>Posisi</th>
                                <th>Tipe Pekerjaan</th>
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
                    data: 'position'
                },
                {
                    data: 'job_type'
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
