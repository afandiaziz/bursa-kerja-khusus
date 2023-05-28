@extends('layouts.app')

@section('content')
    <div class="container mt-3 mb-5 py-4">
        <div class="row">
            <div class="col-12">
                <div class="hr-text hr-text-center">
                    <h1 class="fw-bolder tracking-wide">TENTANG BKK</h1>
                </div>
            </div>
        </div>
        <div class="row align-middle justify-content-center">
            <div class="col-lg-4 col-md-12 align-middle text-center">
                <img class="img-fluid text-center w-75 pt-2" src="{{ asset('bkk-tentang.webp') }}" alt="tentang bkk, bursa kerja khusus, bkk, tentang kami, info loker">
            </div>
            <div class="col-lg-6 col-md-12 fs-4">
                <p class="pt-3 lh-md">Bursa Kerja Khusus (BKK) adalah sebuah lembaga yang dibentuk di Sekolah Menengah Kejuruan Negeri dan Swasta, sebagai unit pelaksana yang memberikan pelayanan dan informasi lowongan kerja, pelaksana pemasaran, penyaluran dan penempatan tenaga kerja, merupakan mitra Dinas Tenaga Kerja dan Transmigrasi.</p>
                <div>
                    <a href="{{ route('about') }}" class="btn btn-outline-blue text-uppercase shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-narrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l14 0"></path>
                            <path d="M15 16l4 -4"></path>
                            <path d="M15 8l4 4"></path>
                        </svg>
                        Selengkapnya
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-gray-400 my-5 py-4">
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

    <div class="container mb-3 py-4">
        <div class="row">
            <div class="col-12">
                <div class="swiper">
                    <div class="swiper-wrapper">
                        @foreach ($companies as $company)
                            <div class="swiper-slide">
                                <img src="{{ filter_var($company->logo, FILTER_VALIDATE_URL) ? $company->logo : asset('assets/upload/companies/' . $company->logo) }}" alt="{{ $company->name }}" width="">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-prev text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="" width="64" height="64" viewBox="0 0 18 18" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="rgb(20 20 20 / 67%)"></path>
                            <path d="M12 6l-6 6l6 6"></path>
                        </svg>
                    </div>
                    <div class="swiper-button-next text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="" width="64" height="64" viewBox="0 0 18 18" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="rgb(20 20 20 / 67%)"></path>
                            <path d="M7.5 6l6 6l-6 6"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <div class="hr-text hr-text-center">
                    <h1 class="fw-bolder tracking-wide">INFORMASI TERKINI</h1>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="row">
                    @foreach ($information as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <a href="{{ route('informasi.detail', ['slug' => $item->slug]) }}" class="text-decoration-none">
                                <div class="card shadow-sm border">
                                    <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url('{{ filter_var($item->image, FILTER_VALIDATE_URL) ? $item->image : asset('assets/upload/information/' . $item->image) }}')"></div>
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $item->title }}</h3>
                                        <p class="text-muted">
                                            {{ strip_tags(Str::limit($item->content, 100)) }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    <div class="col-12 text-center mt-3">
                        <a href="{{ route('informasi.index') }}" class="btn btn-outline-blue text-uppercase">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevrons-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M7 7l5 5l-5 5"></path>
                                <path d="M13 7l5 5l-5 5"></path>
                            </svg>
                            Lihat Lebih Banyak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
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
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <script>
        function setRegistrationStep(slide) {
            $('div.carousel-item').removeClass('active');
            $(`div.carousel-item[data-slide="${slide}"]`).addClass('active');
            $('.carousel-indicators button').removeClass('active');
            $(`.carousel-indicatorsbutton[data-bs-slide-to="${slide - 1}"]`).addClass('active');
        }
    </script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            spaceBetween: 6,
            centeredSlides: true,
            // responsive
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>
@endsection
