<header class="header">
    <!--main menu-->
    <div id="showbacktop" class="mobile-sticky full-nav six-menu py-3 bg-white border-lg-1 border-bottom">
        <div class="container">
            <nav id="main-menu" class="main-menu navbar navbar-expand-lg navbar-light z-index-50 p-0">
                <!--navigation-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Your logo -->
                <div class="nav-logo6">
                    <a class="navbar-brand" rel="home" href="{{ route('home') }}" title="" itemprop="url">
                        <img class="img-fluid logo-six" alt="logo images"
                            src="{{ asset('frontend/images/logonew.png') }}">
                    </a>
                </div>
                <!--end Toggle Button-->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarTogglerDemo2" aria-controls="navbarTogglerDemo2" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor"
                        viewBox="0 0 512 512">
                        <path d="M221.09,64A157.09,157.09,0,1,0,378.18,221.09,157.1,157.1,0,0,0,221.09,64Z"
                            style="fill:none;stroke:currentColor;stroke-miterlimit:10;stroke-width:32px" />
                        <line x1="338.29" y1="338.29" x2="448" y2="448"
                            style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px" />
                    </svg>
                </button>
                <!-- Menu -->
                <div id="navbarNavDropdown" class="collapse navbar-collapse hover-mode">
                    <ul id="menu-primary-menu" class="main-nav navbar-uppercase navbar-nav navbar-end ms-auto">
                        <li
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home active nav-item">
                            <a title="Home" href="{{ route('home') }}" class="nav-link">Trang chủ</a>
                        </li>
                        <li
                            class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children dropdown mega-dropdown nav-item">
                            <a title="Champions" href="#" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false" class="nav-link" id="menu-item-dropdown-13">Giới thiệu</a>
                            <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-13" role="menu">
                                {{-- @foreach($chuyenMucGioiThieus as $gt)
                                    <li>
                                        <a href="{{ route('gioi-thieu', ['slug' => $gt->slug]) }}" class="dropdown-item">{{ $gt->ten }}</a>
                                    </li>
                                @endforeach --}}
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('huong.dan.vien.list') }}" class="nav-link">Thành viên</a>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link" id="menu-item-dropdown-15">Dịch vụ</a>
                            <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-15" role="menu">
                                {{-- @foreach($chuyenMucDichVus as $dv)
                                    <li>
                                        <a href="{{ route('dich-vu', ['slug' => $dv->slug]) }}" class="dropdown-item">{{ $dv->ten }}</a>
                                    </li>
                                @endforeach --}}
                            </ul>
                        </li>
                        <li>
                            <a href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                class="nav-link" id="menu-item-dropdown-16">Tin tức - Tuyển dụng</a>
                            <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-16" role="menu">
                                {{-- @foreach($chuyenMucTinTucs as $tt)
                                    <li>
                                        <a href="#" class="dropdown-item">{{ $tt->ten }}</a>
                                    </li>
                                @endforeach --}}
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('thu-vien') }}" class="nav-link">Thư viện ảnh</a>
                        </li>

                        <li>
                            <a href="{{ route('lienHe') }}" class="nav-link">Liên hệ</a>
                        </li>
                    </ul>
                </div>
                <!--Search form-->
                <div class="navbar-nav ms-3 d-none d-lg-block">
                    <div class="dropdown dropstart">
                        <!--button-->
                        <button id="dropdownMenuButton" class="btn btn-light bg-transparent border-0" type="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem"
                                fill="currentColor" viewBox="0 0 512 512">
                                <path d="M221.09,64A157.09,157.09,0,1,0,378.18,221.09,157.1,157.1,0,0,0,221.09,64Z"
                                    style="fill:none;stroke:currentColor;stroke-miterlimit:10;stroke-width:32px" />
                                <line x1="338.29" y1="338.29" x2="448" y2="448"
                                    style="fill:none;stroke:currentColor;stroke-linecap:round;stroke-miterlimit:10;stroke-width:32px" />
                            </svg>
                        </button>
                        <!--hide search-->
                        <div class="dropdown-menu no-shadow border-0 py-0" aria-labelledby="dropdownMenuButton">
                            <form class="form-inline" method="get" action="#" role="search">
                                <div class="input-group w-100">
                                    <input class="form-control" name="s" type="text"
                                        placeholder="Tìm kiếm &hellip;" value="">
                                    <span class="input-group-append d-none">
                                        <input class="submit btn btn-primary" id="searchsubmit" name="submit"
                                            type="submit" value="Search">
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!--search mobile-->
            <div class="collapse navbar-collapse py-2" id="navbarTogglerDemo2">
                <!--search form-->
                <form class="form-inline" method="get" action="https://demo.bootstrap.news/football/"
                    role="search">
                    <div class="input-group w-100">
                        <input class="form-control border border-end-0" name="s" type="text"
                            placeholder="Tìm kiếm &hellip;" value="">
                        <input class="submit btn btn-primary" id="searchmobile" name="submit" type="submit"
                            value="Tìm kiếm">
                    </div>
                </form>
            </div>
        </div>
    </div>
</header>
