@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row">
            <div class="col-lg-3 col-12">
                <div class="card">
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-12" id="loker-container">
                <div class="row">
                    @foreach ($loker as $item)
                        <div class="col-6 mb-3">
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
    <style>
        .card-loker:hover {
            background-color: #f5f5f5;
        }
        .card-loker:hover h3 {
            text-decoration: underline;
        }
    </style>
@endsection

@section('script')
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
    </script>
@endsection
