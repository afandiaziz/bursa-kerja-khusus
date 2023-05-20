@extends('dashboard.layouts.app')
@section('title', 'Verifikasi Pelamar')

@section('content')
    <div class="col-lg-6 col-12">
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label h3 mb-2">Nomor Registrasi</label>
                    <div class="input-icon mb-3">
                        <input type="text" id="registration_number" class="form-control form-control-lg" placeholder="Nomor Registrasi..." autocomplete="off" autofocus required>
                        <span class="input-icon-addon">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-none" id="detail-applicant">
        <div class="card">
        </div>
    </div>
@endsection

@section('script')
    <script>
        function loadPage(applicant) {

        }
        $('input#registration_number').change(function() {
            if ($(this).val().trim()) {
                $.ajax({
                    url: "{{ route('verify.check') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        registration_number: $(this).val().trim()
                    },
                    success: function ({data}) {
                        $('#detail-applicant .card').load("{{ route('applicant.detail.info') }}", {applicant: data, _token: '{{ csrf_token() }}'})
                        $('#detail-applicant').removeClass('d-none')
                    },
                    error: function (response) {
                        $('#detail-applicant').addClass('d-none')
                    }
                });
            } else {
                $('#detail-applicant').addClass('d-none')
            }
        });
    </script>
@endsection
