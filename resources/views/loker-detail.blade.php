<div class="card shadow-sm border-blue">
    <div class="card-body">
        @if ($detailLoker)
            <div class="row">
                <div class="col-auto">
                    <span class="avatar avatar-lg shadow-none border-0 bg-transparent">
                        <img src="{{ filter_var($detailLoker->company->logo, FILTER_VALIDATE_URL) ? $detailLoker->company->logo : asset('assets/upload/companies/' . $detailLoker->company->logo) }}" alt="{{ $detailLoker->company->name }}">
                    </span>
                </div>
                <div class="col-auto">
                    <h1 class="text-dark">
                        {{ $detailLoker->position }}
                    </h1>
                    <h3 class="my-0 fw-normal">{{ $detailLoker->job_type }}</h3>
                    <div class="text-muted">
                        {{ $detailLoker->company->name }} &#8226; {{ $detailLoker->company->address }}
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-12">
                    <div>
                        <a href="#" class="btn btn-primary shadow border-cyan rounded-pill">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-briefcase" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z"></path>
                                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2"></path>
                                <path d="M12 12l0 .01"></path>
                                <path d="M3 13a20 20 0 0 0 18 0"></path>
                            </svg>
                            Daftar
                        </a>
                    </div>
                    <p>
                        <h2>Tentang Pekerjaan</h2>
                        {!! $detailLoker->description !!}
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
