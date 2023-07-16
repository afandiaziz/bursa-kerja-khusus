@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title h3">
                            Atur Notifikasi Loker
                            <div class="small text-muted">
                                * Rekomendasi pekerjaan akan diberikan sesuai dengan pencarian anda.
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (Auth::user()->keywords->count())
                            <div class="list-group list-group-flush list-group-hoverable">
                                @foreach (Auth::user()->keywords()->orderBy('created_at', 'desc')->get() as $item)
                                    <div class="list-group-item d-flex align-items-center py-2">
                                        <div>
                                            {{ $item->keyword }}
                                        </div>
                                        <div class="ms-auto">
                                            <a class="btn btn-danger cursor-pointer border-bottom" role="button" href="{{ route('loker.notifikasi.delete', ['notification' => false, 'search' => $item->keyword, 'redirect' => true]) }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M4 7l16 0"></path>
                                                    <path d="M10 11l0 6"></path>
                                                    <path d="M14 11l0 6"></path>
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
                                                </svg>
                                                Hapus
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <span class="text-danger">Kamu belum mengatur notifikasi loker.</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
