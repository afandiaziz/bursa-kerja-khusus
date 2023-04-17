@extends('dashboard.layouts.app')

@section('title', 'Kriteria Pelamar ' . $data->name)

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
                    @if ($data->active)
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
                    <a class="mx-1 btn btn-pink" href="{{ route($prefix . '.detail', ['id' => $data->id]) }}">
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
                <div class="table-responsive">
                    <table class="table table-striped w-100 table-bordered table-xs">
                        <tbody>
                            <tr>
                                <th>Nama Kriteria</th>
                                <td class="fw-bold">{{ $data->name }}</td>
                            </tr>
                            <tr>
                                <th>Tipe</th>
                                <td>{{ $data->criteriaType->type }}</td>
                            </tr>
                            @if ($data->parent_id)
                                <tr>
                                    <th>Child Order</th>
                                    <th>{{ $data->parent_order }}</th>
                                </tr>
                            @else
                                <tr>
                                    <th>Parent Order</th>
                                    <th>{{ $data->parent_order }}</th>
                                </tr>
                            @endif
                            @if ($data->min_length)
                                <tr>
                                    <th>Min Length</th>
                                    <td>{{ $data->min_length }}</td>
                                </tr>
                            @endif
                            @if ($data->max_length)
                                <tr>
                                    <th>Max Length</th>
                                    <td>{{ $data->max_length }}</td>
                                </tr>
                            @endif
                            @if ($data->min_number)
                                <tr>
                                    <th>Min Number</th>
                                    <td>{{ $data->min_number }}</td>
                                </tr>
                            @endif
                            @if ($data->max_number)
                                <tr>
                                    <th>Max Number</th>
                                    <td>{{ $data->max_number }}</td>
                                </tr>
                            @endif
                            @if (count($data->criteriaAnswer))
                                <tr>
                                    <th>Pilihan Jawaban</th>
                                    <td>
                                        <ul>
                                            @foreach ($data->criteriaAnswer as $option)
                                                <li>{{ $option->answer }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif
                            @if ($data->criteriaType->type == 'Upload File')
                                <tr>
                                    <th>Max Size per File</th>
                                    <td>
                                        {{ $data->max_size }} mb
                                    </td>
                                </tr>
                                <tr>
                                    <th>Format File yang Diizinkan</th>
                                    <td>
                                        @foreach (explode(',', $data->format_file) as $formatType)
                                            <span class="badge bg-cyan">{{ $formatType }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <th>Kriteria Wajib Diisi</th>
                                <td>
                                    @if ($data->required)
                                        <span class="badge bg-teal">Ya</span>
                                    @else
                                        <span class="badge bg-red">Tidak</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Kriteria Aktif</th>
                                <td>
                                    @if ($data->active)
                                        <span class="badge bg-teal">Ya</span>
                                    @else
                                        <span class="badge bg-red">Tidak</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
