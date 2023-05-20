@extends('dashboard.layouts.app')

@section('pre-title', 'Lowongan Pekerjaan: ' . $data->vacancy->company->name . ' - '. $data->vacancy->position)
@section('title', 'Detail Pelamar: ' . $data->user->name)

@section('content')
    <div class="col-12">
        <div class="card">
            @include('dashboard.applicant.detail-info')
        </div>
    </div>
@endsection
