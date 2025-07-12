@extends('layouts/app')
@section('space-work')
    <main id="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb u-breadcrumb  pt-3 px-0 mb-0 bg-transparent small">
                        <a class="breadcrumb-item" href="{{ route('home') }}">Trang chủ</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                        <span class="d-none d-md-inline">Tin tức - Sự kiện</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    @foreach ($chuyenMucs as $chuyenMuc)
                        @if ($chuyenMuc->tinTucs->count() > 0)
                            <div class="block-area">
                                <div class="block-title-4">
                                    <h4 class="h5 title-arrow"><span>{{ $chuyenMuc->ten }}</span></h4>
                                </div>
                                <div class="row">
                                    @foreach ($chuyenMuc->tinTucs as $tinTuc)
                                        <article class="col-6 col-lg-4">
                                            <div class="card card-full hover-a mb-4">
                                                <!--thumbnail-->
                                                <div class="image-wrapper">
                                                    <a href="detail.html">
                                                        <img width="100%" height="129"
                                                            src="{{ asset($tinTuc->hinhanh) }}" class="img-fluid"
                                                            alt="" /> <!-- post type -->
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    <div class="card-text mb-2 text-muted small">
                                                        <!--date-->
                                                        <time class="news-date"
                                                            datetime="2019-09-16T10:15:20+00:00">{{ $tinTuc->created_at->format('d/m/Y') }}</time>
                                                    </div>
                                                    <!--title-->
                                                    <h2 class="card-title h5 h4-sm h6-md h5-lg"><a
                                                            href="{{ route('chiTietTin', ['slug' => $tinTuc->slug]) }}">{{ $tinTuc->ten }}</a></h2>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                @include('user.right-sidebar')
            </div>

        </div>
    </main>
@endsection
