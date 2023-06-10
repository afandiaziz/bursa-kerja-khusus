@extends('layouts.app')

@section('content')
    <div class="container mb-4 py-4">
        <div class="row">
            <div class="col-lg-4 col-12">
                @foreach ($loker as $item)
                    <div class="card card-loker cursor-pointer {{ $detailLoker && $detailLoker->id == $item->id ? 'border-blue' : '' }}" data-detail-loker="{{ $item->id }}">
                        <div class="card-body">
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
                                        {{ $item->company->address }}
                                        <br>
                                        <br>
                                        <span class="small">{{ $item->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($loker->lastPage() > 1)
                    <div class="d-flex mt-4 bg-white pt-3 border justify-content-center">
                        {!! $loker->links() !!}
                    </div>
                @endif
            </div>
            <div class="col-lg-8 col-12 {{ $detailLoker ? '' : 'd-none' }}" id="detail-loker-content">
                @include('loker-detail')
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
                $('.card-loker').removeClass('border-blue');
                $.ajax({
                    url: "{{ route('loker.detail') }}",
                    type: "GET",
                    data: { detail },
                    success: function({data}) {
                        latestLoker = detail;
                        window.history.pushState(null, null, "{{ route('loker.index') }}?detail=" + detail);
                        $('#detail-loker-content').removeClass('d-none');
                        $(`.card-loker[data-detail-loker="${detail}"]`).addClass('border-blue');
                        $('#detail-loker-content').html(data);
                    }, error: function(err) {
                        $('#detail-loker-content').addClass('d-none');
                        $('.card-loker').removeClass('border-blue');
                        console.log(err);
                    }
                });
            }
        });
    </script>
@endsection
