@extends('dashboard.layouts.app')

@section('pre-title', 'Lowongan Pekerjaan: ' . $data->vacancy->company->name . ' - '. $data->vacancy->position)
@section('title', 'Detail Pelamar: ' . $data->user->name)

@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex">
                <div>
                    <a class="mx-1 btn btn-dark" href="{{ url()->previous() }}">
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
                    @if (!$data->verified)
                        <a class="mx-1 btn btn-green" href="{{ route($prefix . '.verify', ['id' => $data->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"></path>
                                <path d="M15 19l2 2l4 -4"></path>
                            </svg>
                            Verifikasi Pelamar
                        </a>
                    @else
                        <a class="mx-1 btn btn-pink" href="{{ route($prefix . '.verify', ['id' => $data->id]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8.18 8.189a4.01 4.01 0 0 0 2.616 2.627m3.507 -.545a4 4 0 1 0 -5.59 -5.552"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4c.412 0 .81 .062 1.183 .178m2.633 2.618c.12 .38 .184 .785 .184 1.204v2"></path>
                                <path d="M3 3l18 18"></path>
                            </svg>
                            Batal Verifikasi Pelamar
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <h1>
                    {{ $data->registration_number }}
                </h1>
                <p class="mt-3 mb-2">
                    <b>Tanggal registrasi:</b>
                    <b class="text-success">
                        {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d F Y H:i') }}
                    </b>
                </p>
                <p>
                    <b>Status Verifikasi Pelamar:</b>
                    @if ($data->verified)
                        <span class="badge bg-green">Terverifikasi</span>
                    @else
                        <span class="badge bg-pink">Belum Terverifikasi</span>
                    @endif
                </p>
                <hr class="my-3">
                <h2>
                    <a href="{{ route('applicant.detail', $data->id) }}" class="text-primary">{{ $data->user->name }}</a>
                </h2>
                <h3>
                    {{ $data->user->email }}
                </h3>
                <table class="mt-3 table-sm">
                    @foreach ($data->vacancy->vacancyCriteria as $item)
                        <tr>
                            <th>{{ $item->criteria->name }}</th>
                            <td>: {{ $data->user->user_details->where('criteria_id', $item->criteria_id)->first()?->value ?? '-' }}</td>
                        </tr>
                    @endforeach
                </table>

                <a href="" class="btn btn-info mt-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                        <path d="M6 21v-2a4 4 0 0 1 4 -4h1.5"></path>
                        <path d="M18 18m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                        <path d="M20.2 20.2l1.8 1.8"></path>
                    </svg>
                    Lihat Lengkap Detail Pelamar
                </a>
            </div>
        </div>
    </div>
@endsection
