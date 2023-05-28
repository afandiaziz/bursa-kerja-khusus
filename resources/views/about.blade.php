@extends('layouts.app')

@section('content')
    <div class="container mt-3 mb-4 py-4">
        <div class="row align-middle justify-content-center">
            <div class="col-lg-4 col-md-12 align-middle row align-items-center text-center">
                <img class="img-fluid text-center w-75 pt-2" src="{{ asset('bkk-tentang.webp') }}" alt="tentang bkk, bursa kerja khusus, bkk, tentang kami, info loker">
            </div>
            <div class="col-lg-6 col-md-12 fs-4">
                <p class="pt-3 lh-md">
                    Bursa Kerja Khusus (BKK) adalah sebuah lembaga yang dibentuk di Sekolah Menengah Kejuruan Negeri dan Swasta, sebagai unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pelaksana pemasaran, penyaluran dan penempatan tenaga kerja, merupakan mitra Dinas Tenaga Kerja dan Transmigrasi.
                </p>
                <h2>Tujuan</h2>
                <ol>
                    <li>Sebagai wadah dalam mempertemukan tamatan dengan pencari kerja.</li>
                    <li>Memberikan layanan kepada tamatan sesuai dengan tugas dan fungsi masing-masing seksi yang ada dalam BKK.</li>
                    <li>Sebagai wadah dalam pelatihan tamatan yang sesuai dengan permintaan pencari kerja</li>
                    <li>Sebagai wadah untuk menanamkan jiwa wirausaha bagi tamatan melalui pelatihan.</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="bg-gray-400 mt-5 py-4">
        <div class="container">
            <div class="row">
            <div class="col-12">
                <div class="hr-text hr-text-center">
                    <h1 class="fw-bolder tracking-wide">LANGKAH PENDAFTARAN</h1>
                </div>
            </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-7 col-md-12 order-lg-first order-last">
                    <ul class="timeline pe-3">
                        <li>
                            <div class="timeline-badge shadow-sm font-weight-bold" onclick="setRegistrationStep(1)">1</div>
                            <div class="timeline-panel shadow-sm bg-white">
                                <div class="timeline-body">
                                    <p>Calon pelamar membuka web BKK.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge shadow-sm font-weight-bold" onclick="setRegistrationStep(2)">2</div>
                            <div class="timeline-panel shadow-sm bg-white">
                                <div class="timeline-body">
                                    <p>Calon pelamar mendaftar pada lowongan pekerjaan yang diminati.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge shadow-sm font-weight-bold" onclick="setRegistrationStep(3)">3</div>
                            <div class="timeline-panel shadow-sm bg-white">
                                <div class="timeline-body">
                                    <p>Pelamar mencetak bukti pendaftaran <br>(Pastikan terdapat nomor registrasi pendaftaran <span class="text-danger">*</span>).</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge shadow-sm font-weight-bold" onclick="setRegistrationStep(4)">4</div>
                            <div class="timeline-panel shadow-sm bg-white">
                                <div class="timeline-body">
                                    <p>Pelamar membawa bukti pendaftaran ke kantor BKK dan melakukan verifikasi pendaftaran.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="timeline-badge shadow-sm font-weight-bold" onclick="setRegistrationStep(5)">5</div>
                            <div class="timeline-panel shadow-sm bg-white">
                                <div class="timeline-body">
                                    <p>Pelamar yang resmi terdaftar tinggal menunggu jadwal tes atau informasi lebih lanjut melalui web BKK.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-12 align-middle row justify-content-center align-content-center text-center order-lg-last order-first bg-white mb-lg-0 mb-4 rounded-5 shadow-sm border">
                    <div id="carousel-indicators-dot" class="carousel slide carousel-fade p-5" data-bs-ride="carousel">
                        <div class="carousel-indicators carousel-indicators-dot">
                            <button type="button" data-bs-target="#carousel-indicators-dot" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#carousel-indicators-dot" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#carousel-indicators-dot" data-bs-slide-to="2"></button>
                            <button type="button" data-bs-target="#carousel-indicators-dot" data-bs-slide-to="3"></button>
                            <button type="button" data-bs-target="#carousel-indicators-dot" data-bs-slide-to="4"></button>
                        </div>
                        <div class="carousel-inner">
                            <div data-slide="1" class="carousel-item active">
                                <div class="d-flex justify-content-center">
                                    <img class=" text-center w-75 d-block" src="{{ asset('regist_step_1.svg') }}">
                                </div>
                            </div>
                            <div data-slide="2" class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <img class=" text-center w-100 d-block" src="{{ asset('regist_step_2.svg') }}">
                                </div>
                            </div>
                            <div data-slide="3" class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <img class=" text-center w-75 d-block" src="{{ asset('regist_step_3.svg') }}">
                                </div>
                            </div>
                            <div data-slide="4" class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <img class=" text-center w-100 d-block" src="{{ asset('regist_step_4.svg') }}">
                                </div>
                            </div>
                            <div data-slide="5" class="carousel-item">
                                <div class="d-flex justify-content-center">
                                    <img class=" text-center w-75 d-block" src="{{ asset('regist_step_5.svg') }}">
                                </div>
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-indicators-dot" role="button" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-indicators-dot" role="button" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .timeline {
            list-style: none;
            padding: 20px 0 20px;
            position: relative;
        }
        .timeline:before {
            top: 0;
            bottom: 0;
            right: 40px;
            position: absolute;
            content: " ";
            width: 3px;
            background-color: #206BC4;
            margin-left: -1.5px;
        }
        .timeline > li {
            margin-bottom: 20px;
            position: relative;
        }
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        .timeline > li:after {
            clear: both;
        }
        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }
        .timeline > li:after {
            clear: both;
        }
        .timeline > li > .timeline-panel {
            width: calc( 100% - 75px );
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
        }
        .timeline > li > .timeline-panel:before {
            position: absolute;
            top: 26px;
            right: -15px;
            display: inline-block;
            border-top: 15px solid transparent;
            border-left: 15px solid #ccc;
            border-right: 0 solid #ccc;
            border-bottom: 15px solid transparent;
            content: " ";
        }
        .timeline > li > .timeline-panel:after {
            position: absolute;
            top: 27px;
            right: -14px;
            display: inline-block;
            border-top: 14px solid transparent;
            border-left: 14px solid #fff;
            border-right: 0 solid #fff;
            border-bottom: 14px solid transparent;
            content: " ";
        }
        .timeline > li > .timeline-badge {
            cursor: pointer;
            color: #4e4e4e;
            width: 50px;
            height: 50px;
            line-height: 50px;
            font-size: 1.4em;
            text-align: center;
            position: absolute;
            top: 16px;
            right: 0px;
            margin-left: -25px;
            background-color: #fff;
            border: 2px solid #206BC4;
            z-index: 100;
            border-top-right-radius: 50%;
            border-top-left-radius: 50%;
            border-bottom-right-radius: 50%;
            border-bottom-left-radius: 50%;
        }
        .timeline > li.timeline-inverted > .timeline-panel {
            float: right;
        }
        .timeline > li.timeline-inverted > .timeline-panel:before {
            border-left-width: 0;
            border-right-width: 15px;
            left: -15px;
            right: auto;
        }
        .timeline > li.timeline-inverted > .timeline-panel:after {
            border-left-width: 0;
            border-right-width: 14px;
            left: -14px;
            right: auto;
        }
        .timeline-title {
            margin-top: 0;
            color: inherit;
        }
        .timeline-body > p,
        .timeline-body > ul {
            margin-bottom: 0;
        }
        .timeline-body > p + p {
            margin-top: 5px;
        }
    </style>
@endsection

@section('script')
    <script>
        function setRegistrationStep(slide) {
            $('div.carousel-item').removeClass('active');
            $(`div.carousel-item[data-slide="${slide}"]`).addClass('active');
            $('.carousel-indicators button').removeClass('active');
            $(`.carousel-indicatorsbutton[data-bs-slide-to="${slide - 1}"]`).addClass('active');
        }
    </script>
@endsection
