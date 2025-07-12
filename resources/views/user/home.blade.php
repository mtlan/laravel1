@extends('layouts/app')
@section('space-work')
    <main id="content">
        <!--top section-->
        <div class="top-section col-12">
                <div class="main clearfix position-relative">
                    <div class="main_1 clearfix">
                        <section id="center" class="center_home">
                            <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                        class="active" aria-label="Slide 1"></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                        aria-label="Slide 2" class=""></button>
                                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                        aria-label="Slide 3" class="" aria-current="true"></button>
                                </div>
                                <div class="carousel-inner">
                                    @if($banners->count() > 0)
                                        @foreach($banners as $index => $banner)
                                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                <img src="{{ asset($banner->url) }}" class="d-block w-100"
                                                    alt="{{ $banner->ten }}">
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="carousel-item active">
                                            <img src="{{ asset('frontend/images/banner.jpg') }}" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('frontend/images/banner4.png') }}" class="d-block w-100"
                                                alt="...">
                                        </div>
                                        <div class="carousel-item">
                                            <img src="{{ asset('frontend/images/banner5.jpg') }}" class="d-block w-100"
                                                alt="...">
                                        </div>
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </section>
                    </div>
                    <div class="main_2 clearfix position-absolute w-100">
                        <section id="spec">
                            <div class="container">
                                <div class="row spec_1">
                                    <div class="col">
                                        <div class="spec_1i text-center">
                                            <a class="color_4" href="{{ route('huong.dan.vien.list') }}">
                                                <span class="color_1"><i class="bi bi-database"></i></span>
                                                <h5 class="mt-3 mb-0">Cơ sở dữ liệu<br>
                                                    hội viên</h5>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="spec_1i text-center">
                                            <a class="color_4" href="{{ route('dang.ky.thong.tin') }}">
                                                <span class="color_1"><i class="bi bi-person-vcard"></i></span>
                                                <h5 class="mt-3 mb-0">Đăng ký <br>
                                                    thẻ</h5>
                                            </a>
                                        </div>
                                    </div>
                                    {{-- <div class="col">
                                        <div class="spec_1i text-center">
                                            <a class="color_4" href="#">
                                                <span class="color_1"><i class="bi bi-postcard"></i></span>
                                                <h5 class="mt-3 mb-0">Gia hạn<br>
                                                    thẻ</h5>
                                            </a>
                                        </div>
                                    </div> --}}
                                    <div class="col">
                                        <div class="spec_1i text-center">
                                            <a class="color_4" href="#">
                                                <span class="color_1"><i class="bi bi-question-lg"></i></span>
                                                <h5 class="mt-3 mb-0">Câu hỏi <br>
                                                    thường gặp</h5>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="block-area">
                        <div class="block-title-4">
                            <h4 class="h5 title-arrow"><span>TIN TỨC - SỰ KIỆN</span></h4>
                        </div>
                        <div class="border-bottom-last-0 first-pt-0">
                            @foreach ($tinTucs as $tinTuc)
                                <article
                                    class="card card-full hover-a py-4 post-188 post type-post status-publish format-standard has-post-thumbnail hentry category-news tag-kids"
                                    id="post-188">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-12 col-lg-6">
                                            <!--thumbnail-->
                                            <div class="image-wrapper">
                                                <a href="detail.html">
                                                    <img width="100%" height="202" src="{{ asset($tinTuc->hinhanh) }}"
                                                        class="img-fluid" alt="" /> <!-- post type -->
                                                </a>
                                            </div>
                                        </div>

                                        <!--content-->
                                        <div class="col-sm-6 col-md-12 col-lg-6">
                                            <div class="card-body pt-3 pt-sm-0 pt-md-3 pt-lg-0">
                                                <h3 class="card-title h2 h3-sm h2-md">
                                                    <a
                                                        href="{{ route('chiTietTin', ['slug' => $tinTuc->slug]) }}">{{ $tinTuc->ten }}</a>
                                                </h3>
                                                <div class="card-text mb-2 text-muted small">
                                                    <time class="news-date"
                                                        datetime="2019-09-16T10:22:35+00:00">{{ $tinTuc->created_at->format('d/m/Y') }}</time>
                                                </div>
                                                <p class="card-text">{{ str($tinTuc->mota)->words(100) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                    {{-- {{ $tinTucs->links('user.customPaginate1') }} --}}
                    {{ $tinTucs->links('user.customPaginate1') }}

                </div>

                @include('user.right-sidebar')
            </div>
        </div>
    </main>
@endsection
