@extends('dashboard.layouts.app')

@section('title', 'Dashboard')
@section('content')
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-green text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path> <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path> <path d="M12 12l0 .01"></path> <path d="M3 13a20 20 0 0 0 18 0"></path> </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $totalActiveJobs }}
                        </div>
                        <div class="text-muted">
                            Lowongan Aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-red text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M11 7h8a2 2 0 0 1 2 2v8m-1.166 2.818a1.993 1.993 0 0 1 -.834 .182h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2h2"></path> <path d="M8.185 4.158a2 2 0 0 1 1.815 -1.158h4a2 2 0 0 1 2 2v2"></path> <path d="M12 12v.01"></path> <path d="M3 13a20 20 0 0 0 11.905 1.928m3.263 -.763a20 20 0 0 0 2.832 -1.165"></path> <path d="M3 3l18 18"></path> </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $totalNotActiveJobs }}
                        </div>
                        <div class="text-muted">
                            Lowongan Tidak Aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-cyan text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-factory-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M3 21h18"></path> <path d="M5 21v-12l5 4v-4l5 4h4"></path> <path d="M19 21v-8l-1.436 -9.574a.5 .5 0 0 0 -.495 -.426h-1.145a.5 .5 0 0 0 -.494 .418l-1.43 8.582"> </path> <path d="M9 17h1"></path> <path d="M14 17h1"></path> </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $totalCompanies }}
                        </div>
                        <div class="text-muted">
                            Perusahaan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-purple text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path> <path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path> <path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path> <path d="M17 10h2a2 2 0 0 1 2 2v1"></path> <path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path> <path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path> </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $totalApplicants }}
                        </div>
                        <div class="text-muted">
                            Pelamar/Pengguna
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-sm">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="bg-teal text-white avatar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-news" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"> <path stroke="none" d="M0 0h24v24H0z" fill="none"></path> <path d="M16 6h3a1 1 0 0 1 1 1v11a2 2 0 0 1 -4 0v-13a1 1 0 0 0 -1 -1h-10a1 1 0 0 0 -1 1v12a3 3 0 0 0 3 3h11"></path> <path d="M8 8l4 0"></path> <path d="M8 12l4 0"></path> <path d="M8 16l4 0"></path> </svg>
                        </span>
                    </div>
                    <div class="col">
                        <div class="font-weight-medium">
                            {{ $totalInformations }}
                        </div>
                        <div class="text-muted">
                            Informasi
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
