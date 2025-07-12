@extends('layouts/app')
@section('space-work')
    <main id="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb u-breadcrumb  pt-3 px-0 mb-0 bg-transparent small">
                        <a class="breadcrumb-item" href="{{route('home')}}">Trang chủ</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                        <a href="{{route('tinTucSuKien')}}" rel="category tag">Chuyên mục</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                        <span class="d-none d-md-inline">{{$chuyenMuc->ten}}</span>
                    </div>
                </div>
                <div class="col-12 text-center mt-4">
                    <div class="category-title">
                        <h1 class="h2 h1-md">Chuyên mục: <span>{{$chuyenMuc->ten}}</span></h1>
                        <hr class="hr-after mx-auto">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="border-bottom-last-0 first-pt-0">
                        @foreach ($tinTucs as $tinTuc)
                        <article
                            class="card card-full hover-a py-4 post-188 post type-post status-publish format-standard has-post-thumbnail hentry category-news tag-kids"
                            id="post-188">
                            <div class="row">
                                <div class="col-sm-6 col-md-12 col-lg-6">
                                    <!--thumbnail-->
                                    <div class="image-wrapper">
                                        <a href="#">
                                            <img width="100%" height="202" src="{{asset($tinTuc->hinhanh)}}" class="img-fluid"
                                                alt="Kids football Academy open registration" /> <!-- post type -->
                                        </a>
                                    </div>
                                </div>

                                <!--content-->
                                <div class="col-sm-6 col-md-12 col-lg-6">
                                    <div class="card-body pt-3 pt-sm-0 pt-md-3 pt-lg-0">
                                        <h3 class="card-title h2 h3-sm h2-md">
                                            <a href="{{route('chiTietTin', ['slug' => $tinTuc->slug])}}">{{$tinTuc->ten}}</a>
                                        </h3>
                                        <div class="card-text mb-2 text-muted small">
                                            <time class="news-date" datetime="2019-09-16T10:22:35+00:00">{{$tinTuc->created_at->format('d/m/Y')}}</time>
                                        </div>
                                        <p class="card-text">{{str($tinTuc->mota)->words(100)}}</p>
                                    </div>
                                </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="gap-2"></div>
                </div>


                @include('user.right-sidebar')
            </div>

        </div>
    </main>
@endsection
