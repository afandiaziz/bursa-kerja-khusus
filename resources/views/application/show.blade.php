@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row justify-content-center">
            <div class="col-md-10 col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('lamaran.index') }}" class="btn btn-outline-blue">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l6 6"></path>
                                <path d="M5 12l6 -6"></path>
                            </svg>
                            Kembali ke Lamaran Saya
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-auto">
                                <span class="bg-transparent border-0 shadow-none avatar avatar-lg">
                                    <img src="{{ filter_var($data->vacancy->company->logo, FILTER_VALIDATE_URL) ? $data->vacancy->company->logo : asset('assets/upload/companies/' . $data->vacancy->company->logo) }}" alt="{{ $data->vacancy->company->name }}">
                                </span>
                            </div>
                            <div class="col">
                                <div class="d-flex">
                                    <div>
                                        <h1 class="text-dark">
                                            {{ $data->vacancy->position }}
                                        </h1>
                                        <div class="text-muted fs-3 mb-2">
                                            {{ $data->vacancy->company->name }}
                                            <br>
                                            {{ $data->vacancy->company->address }}
                                        </div>
                                        <div class="fw-normal fs-3">
                                            {{ $data->vacancy->job_type }}
                                        </div>

                                        <div class="fw-normal fs-3 mt-3">
                                            Melamar pada {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y, H:i') }}
                                            <div class="mt-1">
                                                <b>Status Verifikasi Pelamar:</b>
                                                @if ($data->verified)
                                                    <span style="color: green">Terverifikasi</span>
                                                @else
                                                    <span style="color: red">Belum Terverifikasi</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('lamaran.evidence', ['registrationNumber' => $data->registration_number]) }}" class="btn btn-blue">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-text" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                                    <path d="M9 9l1 0"></path>
                                                    <path d="M9 13l6 0"></path>
                                                    <path d="M9 17l6 0"></path>
                                                </svg>
                                                Unduh Bukti Pendaftaran
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="{{ route('loker.show', ['id' => $data->vacancy_id]) }}" class="btn btn-link">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6"></path>
                                                <path d="M11 13l9 -9"></path>
                                                <path d="M15 4h5v5"></path>
                                            </svg>
                                            Detail Lowongan Pekerjaan
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <table class="mt-3 table-sm">
                            <tr>
                                <th>CV</th>
                                <td>
                                    :
                                    <a href="{{ asset('assets/upload/cv/' . $data->cv) }}" target="_blank">
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
                                </td>
                            </tr>
                            @foreach ($data->vacancy->vacancyCriteriaOrdered() as $item)
                                <tr>
                                    <th>{{ $item->name }}</th>
                                    <td>: @include('components.criteria', ['criteria' => $item, 'data' => $data->applicant_details]) </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
