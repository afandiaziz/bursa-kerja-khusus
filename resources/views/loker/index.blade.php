@extends('layouts.app')

@section('header--')
    <header class="navbar-expand-md bg-light shadow-sm border-bottom">
        <form method="get" action="">
            <div class="navbar-collapse collapse" id="navbar-menu" style="">
                <div class="navbar">
                    <div class="container-xl">
                        <ul class="navbar-nav gap-3">
                            <li class="nav-item">
                                <input type="text" class="form-control border-blue rounded-pill" name="job_type" id="filter-job-type" value="{{ request()->query('job_type') }}">
                            </li>
                            <li class="nav-item">
                                <input type="text" class="form-control border-blue rounded-pill" name="search" id="filter-search" placeholder="Cari Lowongan Pekerjaan" value="{{ request()->query('search') }}">
                            </li>
                        </ul>
                        <ul class="navbar-nav ms-auto gap-2">
                            <li class="nav-item">
                                <button type="submit" class="btn btn-outline-blue rounded-pill">Terapkan Filter</button>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('loker.index') }}" class="btn rounded-pill">Reset Filter</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
    </header>
@endsection

@section('content')
    <div class="container mb-4 py-4">
        <div class="row">
            <div class="col-12" id="loker-container">
                <div class="row">
                    @foreach ($loker as $item)
                        <div class="col-xl-4 col-6 mb-3">
                            <a href="{{ route('loker.show', ['id' => $item->id]) }}" class="text-decoration-none" target="_blank">
                                <div class="card card-loker cursor-pointer">
                                    <div class="card-body" style="height: 180px;">
                                        <div class="row">
                                            <div class="col-auto">
                                                <span class="bg-transparent border-0 shadow-none avatar avatar-lg">
                                                    <img src="{{ filter_var($item->company->logo, FILTER_VALIDATE_URL) ? $item->company->logo : asset('assets/upload/companies/' . $item->company->logo) }}" alt="{{ $item->company->name }}" width="">
                                                </span>
                                            </div>
                                            <div class="col">
                                                <div class="font-weight-bold">
                                                    <h3 class="link-blue mb-1">{{ $item->position }}</h3>
                                                </div>
                                                <div class="text-dark">
                                                    {{ $item->job_type }}
                                                    <div class="mt-1">{{ $item->company->name }}</div>
                                                </div>
                                                <div class="text-muted">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div style="text-overflow: ellipsis; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                                {{ $item->company->address }}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-2 position-absolute bottom-0 pb-3">
                                                            <span class="small">{{ $item->created_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                @if ($loker->lastPage() > 1)
                    <div class="d-flex mt-4 bg-white pt-3 border justify-content-center">
                        {!! $loker->links() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="{{ asset('assets/plugins/tom-select/tom-select.css') }}" rel="stylesheet">

    <style>
        .card-loker:hover {
            background-color: #f5f5f5;
        }
        .card-loker:hover h3 {
            text-decoration: underline;
        }
        .ts-wrapper.multi .ts-control > div {
            background: #206bc4;
            color: #ffffff;
        }
    </style>
@endsection

@section('script')
    <script src="{{ asset('assets/plugins/tom-select/tom-select.complete.min.js') }}"></script>

    <script>
        let latestLoker = null;
        $('.card-loker').click(function() {
            const detail = $(this).data('detail-loker');
            if (detail != latestLoker) {
                $('.card-loker').removeClass('border-blue bg-blue-lt');
                $.ajax({
                    url: "{{ route('loker.detail') }}",
                    type: "GET",
                    data: { detail },
                    success: function({data}) {
                        latestLoker = detail;
                        window.history.pushState(null, null, "{{ route('loker.index') }}?detail=" + detail);
                        $('#detail-loker-content').removeClass('d-none');
                        $(`.card-loker[data-detail-loker="${detail}"]`).addClass('border-blue bg-blue-lt');
                        $('#detail-loker-content').html(data);
                    }, error: function(err) {
                        $('#detail-loker-content').addClass('d-none');
                        $('.card-loker').removeClass('border-blue bg-blue-lt');
                        console.log(err);
                    }
                });
            }
        });

        new TomSelect(document.getElementById('filter-job-type'), {
            maxItems: null,
            valueField: 'id',
            create: false,
            labelField: 'title',
            searchField: 'title',
            plugins: ['checkbox_options'],
            placeholder: 'Tipe Pekerjaan',
            options: [
                {id: 'Full-time', title: 'Full-time', url: 'http://google.com'},
                {id: 'Part-time', title: 'Part-time', url: 'http://google.com'},
                {id: 'Contract', title: 'Contract', url: 'http://google.com'},
                {id: 'Internship', title: 'Internship', url: 'http://google.com'},
                {id: 'Temporary', title: 'Temporary', url: 'http://google.com'},
                {id: 'Volunteer', title: 'Volunteer', url: 'http://google.com'},
            ],
            createOnBlur: true,
        });
    </script>
@endsection
