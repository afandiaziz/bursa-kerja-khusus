<div class="card shadow-sm">
    <div class="card-body">
        @if ($detailLoker)
            {{-- @dd($detailLoker->vacancyCriteriaOrdered()) --}}
            <div class="row">
                <div class="col-auto">
                    <span class="avatar avatar-lg shadow-none border-0 bg-transparent">
                        @if ($detailLoker->company->logo)
                            <img src="{{ filter_var($detailLoker->company->logo, FILTER_VALIDATE_URL) ? $detailLoker->company->logo : asset('assets/upload/companies/' . $detailLoker->company->logo) }}" alt="{{ $detailLoker->company->name }}">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-factory-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 21h18"></path>
                                <path d="M5 21v-12l5 4v-4l5 4h4"></path>
                                <path d="M19 21v-8l-1.436 -9.574a.5 .5 0 0 0 -.495 -.426h-1.145a.5 .5 0 0 0 -.494 .418l-1.43 8.582"></path>
                                <path d="M9 17h1"></path>
                                <path d="M14 17h1"></path>
                            </svg>
                        @endif
                    </span>
                </div>
                <div class="col-auto">
                    <h1 class="text-dark">
                        {{ $detailLoker->position }}
                    </h1>
                    <div class="text-muted fs-3 mb-2">
                        {{ $detailLoker->company->name }}
                        <br>
                        {{ $detailLoker->company->address }}
                    </div>
                    <div class="fw-normal fs-3">
                        {{ $detailLoker->job_type }}
                    </div>
                    <div>{{ $detailLoker->created_at->diffForHumans() }}</div>

                    <div class="d-flex">
                        @if (Auth::check() && Auth::user()->role == 'applicant')
                            <div role="button" @if (!$statusApplied) data-bs-toggle="modal" data-bs-target="#modal-apply-{{ $detailLoker->id }}" @endif class="btn btn-primary mt-3 shadow rounded-pill @if ($statusApplied) disabled @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                    <path d="M12 12l0 .01"></path>
                                    <path d="M3 13a20 20 0 0 0 18 0"></path>
                                </svg>
                                @if (!$statusApplied)
                                    Lamar
                                @else
                                    Dilamar
                                @endif
                            </div>
                            @if (!$statusApplied)
                                <div class="modal modal-blur fade" id="modal-apply-{{ $detailLoker->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data" action="{{ route('loker.daftar', ['id' => $detailLoker->id]) }}">
                                                @csrf
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body py-2">
                                                    <div class="row">
                                                        <div class="col-12 mb-3 text-center h2 mt-3">
                                                            Kamu akan melamar ke {{ $detailLoker->company->name }} sebagai {{ $detailLoker->position }}
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-floating form-group mt-3">
                                                                <input type="file" class="filepond" id="cv" name="cv" data-max-file-size="2MB" required accept="application/pdf">
                                                                <label for="cv" class="form-label">
                                                                    CV (pdf) <span class="text-danger">*</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @foreach ($detailLoker->vacancyCriteriaOrdered() as $data)
                                                            <div class="col-12">
                                                                @include('components.forms.form', ['custom' => false])
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div role="button" class="btn me-auto" data-bs-dismiss="modal">Tutup</div>
                                                    <button type="submit" class="btn btn-success" id="button-form-modal-apply-{{ $detailLoker->id }}">Lamar Sekarang</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @else
                            <a href="{{ route('login') . '?redirect=loker/detail/' . $detailLoker->id }}" class="btn btn-primary mt-3 shadow rounded-pill">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                    <path d="M12 12l0 .01"></path>
                                    <path d="M3 13a20 20 0 0 0 18 0"></path>
                                </svg>
                                Lamar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <h2>Tentang Pekerjaan</h2>
                    {!! $detailLoker->description !!}
                </div>
            </div>
        @endif
    </div>
</div>
