@extends('dashboard.layouts.app')
@section('pre-title', 'Lowongan Pekerjaan')
@section('title', $data->company->name . ' - '. $data->position)

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
                <h1>
                    <a href="{{ route('company.detail', $data->company_id) }}" class="text-primary">{{ $data->company->name }}</a>
                </h1>
                <h3>
                    <b>Posisi:</b> {{ $data->position }}
                    <br>
                </h3>
                <p class="mt-4">
                    <b>Kriteria yang dibutuhkan:</b>
                    <ul>
                        @foreach ($data->vacancyCriteriaOrdered() as $item)
                            <li>{{ $item->name }}</li>
                        @endforeach
                    </ul>
                </p>
                <p class="mt-4">
                    <b>Deskripsi:</b> <br>
                    {!! $data->description !!}
                </p>
                <p>
                    <b>Informasi Tambahan:</b> <br>
                    {!! $data->information !!}
                </p>

                <h3>
                    <b>Batas Pendaftaran:</b>
                    <span class="text-danger">
                        {{ \Carbon\Carbon::parse($data->deadline)->translatedFormat('d F Y') }}
                    </span>
                </h3>
                <h3>
                    <b>Total Pelamar:</b>
                    <span class="text-success">
                        {{ $data->applicants->count() }}
                    </span>
                </h3>
                <h3>
                    <b>Total Pelamar Terverifikasi/Batas Total Pelamar:</b>
                    <span class="text-danger">
                        {{ $data->applicants->where('verified', 1)->count() . '/' . ($data->max_applicants ? $data->max_applicants : '∞') }}
                    </span>
                </h3>
            </div>
            <div class="card-footer">
                <b>Dibuat pada tanggal:</b>
                <span class="text-success">
                    {{ \Carbon\Carbon::parse($data->deadline)->translatedFormat('d F Y H:i') }}
                </span>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex">
                <div>
                    <h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                            <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                            <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                            <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                        </svg>
                        Pelamar
                    </h3>
                </div>
                <div class="ms-auto">
                    <a class="mx-1 btn btn-purple" href="{{ route($prefix . '.edit', ['id' => $data->id]) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path>
                            <path d="M7 11l5 5l5 -5"></path>
                            <path d="M12 4l0 12"></path>
                        </svg>
                        Download Data Pelamar
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row row-cards mb-3">
                    <div class="col-sm-6 col-lg-3">
                        <a href="{{ route('vacancy.detail', ['id' => $data->id]) }}" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-info">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-info text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path>
                                                    <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M17 10h2a2 2 0 0 1 2 2v1"></path>
                                                    <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                                                    <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Pelamar
                                            </div>
                                            <div class="text-muted">
                                                {{ $data->applicants->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="?verified=1" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-green">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-green text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                                    <path d="M15 19l2 2l4 -4"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Pelamar Terverifikasi
                                            </div>
                                            <div class="text-muted">
                                                {{ $data->applicants->where('verified', 1)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <a href="?verified=0" class="text-decoration-none">
                            <div class="card card-sm shadow-sm border-red">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="bg-red text-white avatar">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552"></path>
                                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2"></path>
                                                    <path d="M3 3l18 18"></path>
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold">
                                                Pelamar Belum Terverifikasi
                                            </div>
                                            <div class="text-muted">
                                                {{ $data->applicants->where('verified', 0)->count() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <table class="table table-bordered table-xs table-striped w-100 table-responsive" id="datatable-ajax">
                    <thead>
                        <tr>
                            <th width="3%">No</th>
                            <th>Nomor <br>Registrasi</th>
                            <th>Tanggal <br>Registrasi</th>
                            <th>Status Verifikasi<br> Pendaftaran</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th></th>
                            {{-- <th>Nomor Handphone/Whatsapp</th> --}}
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#datatable-ajax').DataTable({
            ajax: '?vacancy={{ $data->id }}&verified={{ request()->get("verified") ?? "" }}',
            serverSide: true,
            processing: true,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'registration_number'
                },
                {
                    data: 'registration_date'
                },
                {
                    data: 'verified'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                // {
                //     data: 'phone',
                //     orderable: false,
                //     searchable: false
                // }
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
