@extends('dashboard.layouts.app')
@section('title', 'Hasil Seleksi Pelamar')

@section('content')
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('applicant.selection.upload') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-3">
                        <label class="form-label text-dark h3 mb-2">Upload Data Seleksi Pelamar <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" autocomplete="off" autofocus required accept=".xls,.xlsx">
                        <div class="text-muted mt-1">
                            <div>- Pelamar harus sudah terverifikasi</div>
                            <div>- File yang diupload harus berformat .XLS, .XLSX</div>
                            <div class="mt-2">
                                <a href="{{ url(asset('assets/upload/format-import-seleksi.xlsx')) }}" class="btn btn-link border">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-spreadsheet" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M14 3v4a1 1 0 0 0 1 1h4"></path>
                                        <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z"></path>
                                        <path d="M8 11h8v7h-8z"></path>
                                        <path d="M8 15h8"></path>
                                        <path d="M11 11v7"></path>
                                    </svg>
                                    Unduh format file
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button type="submit" class="btn btn-success">Upload Hasil Seleksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
