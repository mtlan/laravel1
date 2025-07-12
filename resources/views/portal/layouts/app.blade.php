<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang quản trị</title>

    {{-- Bootstrap 5 css --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}"> --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesbrand" name="author">
    {{-- App favicon  --}}
    <link rel="shortcut icon" href="{{ secure_asset('/front/assets/images/favicon.ico') }}">

    <!-- {{-- Favicon --}}
    {{-- <link rel="shortcut icon" href="{{ asset('favicon/favicon.ico') }}" type="image/x-icon"> --}} -->

    <link rel="stylesheet" href="{{ secure_asset('css/mystyle.css?v=1.0') }}">
    <!-- {{-- Font awesome --}} -->
    <link rel="stylesheet" href="{{ secure_asset('vendor/fontawesome/css/all.min.css') }}">
    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link id="fontsLink" rel="stylesheet">

    <!-- jsvectormap css -->
    <link href="{{ secure_asset('/front/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css">

    <!--Swiper slider css-->
    <link href="{{ secure_asset('/front/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Layout config Js -->
    <script src="{{ secure_asset('/front/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ secure_asset('/front/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    <link href="{{ secure_asset('/front/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">
    <!-- App Css-->
    <link href="{{ secure_asset('/front/assets/css/app.min.css') }}" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ secure_asset('/front/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Sử dụng thư việc để tạo date và format tiếng việt -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/vi.js"></script> --}}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Thêm css cho summernote -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Thêm css cho bootstrap-tag -->
    <link href="{{ secure_asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">

    <!-- Thêm css cho dropzone -->
    {{-- <link rel="stylesheet" href="{{asset('vendor/dropzone/dropzone.css')}}" type="text/css"> --}}

    <!-- {{-- Jquery --}} -->
    <script src="{{ secure_asset('vendor/jquery/jquery.min.js') }}"></script>

    @livewireStyles
</head>

@if ($errors->any())
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Lỗi',
                html: "{{ $errors->first() }}",
                icon: "error"
            })
        })
    </script>
@endif

@if (session()->has('user_message'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                html: "{!! session()->get('user_message') !!}",
                icon: "info"
            })
        });
    </script>
@endif

@if (session()->has('user_success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Thành công',
                html: "{!! session()->get('user_success') !!}",
                icon: "success"
            })
        });
    </script>
@endif

@if (session()->has('user_error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Lỗi',
                html: "{!! session()->get('user_error') !!}",
                icon: "error"
            })
        });
    </script>
@endif

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="index.html" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{ secure_asset('/front/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ secure_asset('/front/assets/images/logo-dark.png') }}" alt="" height="22">
                    </span>
                </a>
                <a href="index.html" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ secure_asset('/front/assets/images/logo-sm.png') }}" alt="" height="22">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ secure_asset('/front/assets/images/logo-light.png') }}" alt="" height="22">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover"
                    id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">
                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                        <li class="nav-item">
                            <a class="nav-link menu-link collapsed" href="#sidebarDashboards" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarDashboards">
                                <i class="ph-gauge"></i> <span data-key="t-dashboards">Bảng điều khiển</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarDashboards">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}" class="nav-link" data-key="t-analytics">
                                            Trang chủ </a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a href="{{ route('portal.dashboard') }}" class="nav-link"
                                            data-key="t-crm">Trang quản trị</a>
                                    </li> --}}
                                    {{-- <li class="nav-item">
                                        <a href="index.html" class="nav-link" data-key="t-ecommerce"> Ecommerce </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="dashboard-learning.html" class="nav-link" data-key="t-learning">
                                            Learning </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="dashboard-real-estate.html" class="nav-link"
                                            data-key="t-real-estate"> Real Estate </a> --}}
                        </li>
                    </ul>
                </div>
                </li>

                @hasanyrole('admin|super_admin')
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Người dùng</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('portal.yeu.cau.dang.ky.thong.tin') }}" class="nav-link menu-link"> <i
                                class="ph-file-text"></i>
                            <span data-key="t-calendar">Yêu cầu đăng ký/chỉnh sửa/gia hạn thông tin</span></a>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="{{ route('portal.orders') }}" class="nav-link menu-link"> <i class="ph-file-text"></i>
                            <span data-key="t-pending-order">Yêu cầu đăng ký thông tin</span><span class="badge badge-pill bg-danger"
                                data-key="t-pending-order">{{ $count_orders }}</span></a>
                    </li>
                    <li class="nav-item">
                            <a class="nav-link menu-link collapsed" href="#sidebarPages" data-bs-toggle="collapse"
                                role="button" aria-expanded="false" aria-controls="sidebarPages">
                                <i class="ph-address-book"></i> <span data-key="t-pages">Pages</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarPages">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="pages-starter.html" class="nav-link" data-key="t-starter"> Starter
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-profile.html" class="nav-link" data-key="t-profile"> Profile
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-profile-settings.html" class="nav-link"
                                            data-key="t-profile-setting"> Profile Settings </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-contacts.html" class="nav-link" data-key="t-contacts">
                                            Contacts </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-timeline.html" class="nav-link" data-key="t-timeline">
                                            Timeline </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-faqs.html" class="nav-link" data-key="t-faqs"> FAQs </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-pricing.html" class="nav-link" data-key="t-pricing"> Pricing
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-maintenance.html" class="nav-link" data-key="t-maintenance">
                                            Maintenance </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-coming-soon.html" class="nav-link" data-key="t-coming-soon">
                                            Coming Soon </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-privacy-policy.html" class="nav-link"
                                            data-key="t-privacy-policy"> Privacy Policy </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="pages-term-conditions.html" class="nav-link"
                                            data-key="t-term-conditions"> Term & Conditions </a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}

                    {{-- <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Đối tác
                            Cloudzone</span>
                    </li> --}}

                    {{-- <li class="nav-item">
                        <a href="{{ route('portal.get.vps.vn.list') }}" class="nav-link menu-link"><i
                                class="ph-file-text"></i><span data-key="t-chat">Tất cả đơn hàng Cloud VPS</span> </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('portal.get.vps.nn.list') }}" class="nav-link menu-link"><i
                                class="ph-file-text"></i><span data-key="t-chat">Tất cả đơn hàng VPS Nước ngoài</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('portal.get.proxy.list') }}" class="nav-link menu-link"><i
                                class="ph-file-text"></i><span data-key="t-chat">Tất cả đơn hàng Proxy VN - US</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('portal.get.agency.info') }}" class="nav-link menu-link"> <i
                                class="ph-chats"></i> <span data-key="t-chat">Thông tin đại lý</span> </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('portal.request.recharge.to.account') }}" class="nav-link menu-link"> <i
                                class="ph-chats"></i> <span data-key="t-chat">Nạp tiền vào đại lý</span> </a>
                    </li> --}}
                @endhasanyrole

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-apps">Quản trị</span>
                </li>

                {{-- <li class="nav-item">
                    <a href="#sidebarEcommerce" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarEcommerce">
                        <i class="ph-storefront"></i> <span data-key="t-ecommerce">Đăng ký dịch vụ</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarEcommerce">
                        <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                <a href="{{ route('portal.user.products.cloud.vps') }}" class="nav-link"
                                    data-key="t-products">Cloud VPS VN</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.products.vps.nn') }}" class="nav-link"
                                    data-key="t-products">VPS Nước ngoài</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.products.proxy.vn.us') }}" class="nav-link"
                                    data-key="t-products">Proxy VN - US</a>
                            </li>
                             <li class="nav-item">
                                        <a href="apps-ecommerce-products-grid.html" class="nav-link"
                                            data-key="t-products-grid">VPS Nước Ngoài</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-product-details.html" class="nav-link"
                                            data-key="t-product-Details">Proxy VN - US - UK</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-add-product.html" class="nav-link"
                                            data-key="t-create-product">Máy chủ vật lý</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-orders.html" class="nav-link"
                                            data-key="t-orders">Web Hosting</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-order-overview.html" class="nav-link"
                                            data-key="t-order-overview">Đăng ký tên miền</a>
                                    </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="#sidebarLearning" class="nav-link menu-link  collapsed" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarLearning">
                        <i class="ph-graduation-cap"></i> <span data-key="t-learning">Dịch vụ của tôi</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarLearning">
                        <ul class="nav nav-sm flex-column">
                             <li class="nav-item">
                                <a href="{{ route('portal.user.rented.vps.list') }}" class="nav-link"
                                    data-key="t-products">Cloud
                                    VPS VN</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.rented.vps.nn.list') }}" class="nav-link"
                                    data-key="t-products">VPS Nước ngoài</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.rented.proxy.list') }}" class="nav-link"
                                    data-key="t-products">Proxy</a>
                            </li>
                             <li class="nav-item">
                                        <a href="apps-ecommerce-products-grid.html" class="nav-link"
                                            data-key="t-products-grid">VPS Nước Ngoài</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-product-details.html" class="nav-link"
                                            data-key="t-product-Details">Proxy</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-add-product.html" class="nav-link"
                                            data-key="t-create-product">Hosting cPanel</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-orders.html" class="nav-link"
                                            data-key="t-orders">Delicated Server</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-ecommerce-order-overview.html" class="nav-link"
                                            data-key="t-order-overview">Domain</a>
                                    </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="nav-item">
                    <a href="#sidebarInvoices" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarInvoices">
                        <i class="ph-file-text"></i> <span data-key="t-invoices">Quản lý thanh toán</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarInvoices">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('portal.user.order.history') }}" class="nav-link"
                                    data-key="t-list-view">Lịch sử đơn hàng</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.delivered.orders') }}" class="nav-link"
                                    data-key="t-overview">Đơn hàng
                                    đã giao</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.user.pending.orders') }}" class="nav-link"
                                    data-key="t-create-invoice">Hoá
                                    đơn chờ giao</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('portal.huongdanvien') }}" class="nav-link menu-link"> <i
                            class="ph-chats"></i> <span data-key="t-chat">Quản lý hướng dẫn viên</span> </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('portal.the') }}" class="nav-link menu-link"> <i class="ph-envelope"></i>
                        <span data-key="t-email">Quản lý thẻ</span> </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('portal.chuyenmuc') }}" class="nav-link menu-link"> <i
                            class="ph-envelope"></i>
                        <span data-key="t-email">Quản lý chuyên mục</span> </a>
                </li>

                {{-- <li class="nav-item">
                    <a href="{{ route('portal.tukhoa') }}" class="nav-link menu-link"> <i class="ph-envelope"></i>
                        <span data-key="t-email">Quản lý từ khóa</span> </a>
                </li> --}}

                <li class="nav-item">
                    <a href="{{ route('portal.tintuc') }}" class="nav-link menu-link"> <i class="ph-envelope"></i>
                        <span data-key="t-email">Quản lý tin tức</span> </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('portal.video') }}" class="nav-link menu-link"> <i
                            class="ph-file-video-thin"></i>
                        <span data-key="t-email">Quản lý video</span> </a>
                </li>

                <li class="nav-item">
                    <a href="#thuVienAnh" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarTickets">
                        <i class="ph-ticket"></i> <span data-key="t-support-tickets">Quản lý thư viện ảnh</span>
                    </a>
                    <div class="collapse menu-dropdown" id="thuVienAnh">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('portal.banner') }}" class="nav-link"
                                    data-key="t-list-view">Banner</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('portal.thumuccha') }}" class="nav-link"
                                    data-key="t-list-view">Thư viện ảnh</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li class="nav-item">
                    <a href="#sidebarTickets" class="nav-link menu-link collapsed" data-bs-toggle="collapse"
                        role="button" aria-expanded="false" aria-controls="sidebarTickets">
                        <i class="ph-ticket"></i> <span data-key="t-support-tickets">Quản lý hoạt động</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarTickets">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="apps-tickets-list.html" class="nav-link" data-key="t-list-view">Nhật
                                    ký hoạt động</a>
                            </li>
                            {{-- <li class="nav-item">
                                        <a href="apps-tickets-overview.html" class="nav-link"
                                            data-key="t-overview">Overview</a>
                                    </li> --}}
                        </ul>
                    </div>
                </li>

                {{-- <li class="nav-item">
                            <a href="#sidebarRealeEstate" class="nav-link menu-link collapsed"
                                data-bs-toggle="collapse" role="button" aria-expanded="false"
                                aria-controls="sidebarRealeEstate">
                                <i class="ph-buildings"></i> <span data-key="t-real-estate">Real Estate</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarRealeEstate">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item">
                                        <a href="apps-real-estate-grid.html" class="nav-link"
                                            data-key="t-listing-grid">Listing Grid</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-real-estate-list.html" class="nav-link"
                                            data-key="t-listing-list">Listing List</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-real-estate-map.html" class="nav-link"
                                            data-key="t-listing-map">Listing Map</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-real-estate-property-overview.html" class="nav-link"
                                            data-key="t-property-overview">Property Overview</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarAgent" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarAgent"
                                            data-key="t-agent"> Agent </a>
                                        <div class="collapse menu-dropdown" id="sidebarAgent">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="apps-real-estate-agent-list.html" class="nav-link"
                                                        data-key="t-list-view"> List View </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="apps-real-estate-agent-grid.html" class="nav-link"
                                                        data-key="t-grid-view"> Grid View </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="apps-real-estate-agent-overview.html" class="nav-link"
                                                        data-key="t-overview"> Overview </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#sidebarAgencies" class="nav-link" data-bs-toggle="collapse"
                                            role="button" aria-expanded="false" aria-controls="sidebarAgencies"
                                            data-key="t-agencies"> Agencies </a>
                                        <div class="collapse menu-dropdown" id="sidebarAgencies">
                                            <ul class="nav nav-sm flex-column">
                                                <li class="nav-item">
                                                    <a href="apps-real-estate-agencies-list.html" class="nav-link"
                                                        data-key="t-list-view"> List View </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="apps-real-estate-agencies-overview.html" class="nav-link"
                                                        data-key="t-overview"> Overview </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-real-estate-add-properties.html" class="nav-link"
                                            data-key="t-add-property">Add Property</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="apps-real-estate-earnings.html" class="nav-link"
                                            data-key="t-earnings">Earnings</a>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                @hasanyrole('admin|super_admin')
                    <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-components">Hệ
                            thống</span></li>

                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarUI" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarUI">
                            <i class="ph-bandaids"></i> <span data-key="t-bootstrap-ui">Quản lý danh mục</span>
                        </a>
                        <div class="collapse menu-dropdown mega-dropdown-menu" id="sidebarUI">
                            <div class="row">
                                <div class="col-lg-4">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="{{ route('portal.dm.ngonngu') }}" class="nav-link"
                                                data-key="t-alerts">Quản lý
                                                ngôn ngữ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('portal.dm.noicapthe') }}" class="nav-link"
                                                data-key="t-badges">Quản lý nơi cấp thẻ</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('portal.dm.thoihanthe') }}" class="nav-link"
                                                data-key="t-buttons">Quản
                                                lý thời hạn thẻ</a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a href="{{ route('portal.addon_rams') }}" class="nav-link"
                                                data-key="t-colors">Quản lý
                                                Addon-ram</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('portal.addon_disks') }}" class="nav-link"
                                                data-key="t-carousel">Quản lý Addon-disk</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarAdvanceUI" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarAdvanceUI">
                            <i class="ph-stack-simple"></i> <span data-key="t-advance-ui">Nạp thẻ && Chuyển
                                khoản</span>
                        </a>
                         <div class="collapse menu-dropdown" id="sidebarAdvanceUI">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('portal.card_providers') }}" class="nav-link"
                                        data-key="t-scrollbar">Quản lý nhà cung cấp thẻ</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('portal.banks') }}" class="nav-link" data-key="t-scrollbar">Quản
                                        lý tài khoản ngân hàng</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('portal.card_transactions') }}" class="nav-link"
                                        data-key="t-sweet-alerts">Quản lý nạp thẻ cào</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('portal.bank_transactions') }}" class="nav-link"
                                        data-key="t-nestable-list">Quản lý chuyển khoản</a>
                                </li>
                            </ul>
                        </div> -
                    </li>-}}

                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('portal.files') }}">
                            <i class="ph-paint-brush-broad"></i> <span data-key="t-widgets">Quản lý tệp</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarForms" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarForms">
                            <i class="ri-file-list-3-line"></i> <span data-key="t-forms">Đối tác đám mây</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarForms">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('portal.cloud_partners') }}" class="nav-link"
                                        data-key="t-basic-elements">Quản lý đối tác</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarIcons" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarIcons">
                            <i class="ph-traffic-cone"></i> <span data-key="t-icons">Quản trị hệ thống</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarIcons">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('portal.users') }}" class="nav-link" data-key="t-remix">Quản lý
                                        người
                                        dùng</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('portal.roles') }}" class="nav-link" data-key="t-remix">Quản lý
                                        vai trò</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('portal.permissions') }}" class="nav-link"
                                        data-key="t-material-design">Quản lý quyền</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link" href="{{ route('portal.activity_log_list') }}">
                            <i class="bi bi-share"></i> <span data-key="t-multi-level">Nhật ký hoạt động</span>
                        </a>
                    </li> --}}

                    {{-- <li class="nav-item">
                        <a class="nav-link menu-link collapsed" href="#sidebarMaps" data-bs-toggle="collapse"
                            role="button" aria-expanded="false" aria-controls="sidebarMaps">
                            <i class="ph-map-trifold"></i> <span data-key="t-maps">Cài đặt && Thiết lập</span>
                        </a>
                        <div class="collapse menu-dropdown" id="sidebarMaps">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('portal.system_installations') }}" class="nav-link"
                                        data-key="t-google">Quản lý các
                                        thiết lập hệ thống</a>
                                </li>
                            </ul>
                        </div>
                    </li> --}}
                @endhasanyrole
                </ul>
            </div>
            <!-- Sidebar -->
        </div>

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>
    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ secure_asset('/front/assets/images/logo-sm.png') }}" alt=""
                                    height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ secure_asset('/front/assets/images/logo-dark.png') }}" alt=""
                                    height="22">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ secure_asset('/front/assets/images/logo-sm.png') }}" alt=""
                                    height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ secure_asset('/front/assets/images/logo-light.png') }}" alt=""
                                    height="22">
                            </span>
                        </a>
                    </div>

                    <button type="button"
                        class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                        id="topnav-hamburger-icon">
                        <span class="hamburger-icon">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>

                    <form class="app-search d-none d-md-inline-flex">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                                id="search-options" value="">
                            <span class="mdi mdi-magnify search-widget-icon"></span>
                            <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                                id="search-close-options"></span>
                        </div>
                        <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                            <div data-simplebar="" style="max-height: 320px;">
                                <!-- item-->
                                <div class="dropdown-header">
                                    <h6 class="text-overflow text-muted mb-0 text-uppercase">Recent Searches</h6>
                                </div>

                                <div class="dropdown-item bg-transparent text-wrap">
                                    <a href="index.html" class="btn btn-subtle-secondary btn-sm btn-rounded">how
                                        to setup <i class="mdi mdi-magnify ms-1"></i></a>
                                    <a href="index.html" class="btn btn-subtle-secondary btn-sm btn-rounded">buttons
                                        <i class="mdi mdi-magnify ms-1"></i></a>
                                </div>
                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-1 text-uppercase">Pages</h6>
                                </div>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-bubble-chart-line align-middle fs-18 text-muted me-2"></i>
                                    <span>Analytics Dashboard</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-lifebuoy-line align-middle fs-18 text-muted me-2"></i>
                                    <span>Help Center</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <i class="ri-user-settings-line align-middle fs-18 text-muted me-2"></i>
                                    <span>My account settings</span>
                                </a>

                                <!-- item-->
                                <div class="dropdown-header mt-2">
                                    <h6 class="text-overflow text-muted mb-2 text-uppercase">Members</h6>
                                </div>

                                <div class="notification-list">
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="{{ secure_asset('/front/assets/images/users/avatar-2.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">Angela Bernier</h6>
                                                <span class="fs-2xs mb-0 text-muted">Manager</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="{{ secure_asset('/front/assets/images/users/avatar-3.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">David Grasso</h6>
                                                <span class="fs-2xs mb-0 text-muted">Web Designer</span>
                                            </div>
                                        </div>
                                    </a>
                                    <!-- item -->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item py-2">
                                        <div class="d-flex">
                                            <img src="{{ secure_asset('/front/assets/images/users/avatar-5.jpg') }}"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-1">
                                                <h6 class="m-0">Mike Bunch</h6>
                                                <span class="fs-2xs mb-0 text-muted">React Developer</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="text-center pt-3 pb-1">
                                <a href="#" class="btn btn-primary btn-sm">View All Results <i
                                        class="ri-arrow-right-line ms-1"></i></a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-grid fs-2xl'></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg p-0 dropdown-menu-end">
                            <div class="p-3 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fw-semibold fs-base"> Browse by Apps </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="btn btn-sm btn-subtle-info"> View All Apps
                                            <i class="ri-arrow-right-s-line align-middle"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="p-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/github.png') }}"
                                                alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/bitbucket.png') }}"
                                                alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/dribbble.png') }}"
                                                alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/dropbox.png') }}"
                                                alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/mail_chimp.png') }}"
                                                alt="mail_chimp">
                                            <span>Mail Chimp</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#!">
                                            <img src="{{ secure_asset('/front/assets/images/brands/slack.png') }}"
                                                alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                            id="page-header-cart-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                            aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-bag fs-2xl'></i>
                            <span
                                class="position-absolute topbar-badge cartitem-badge fs-3xs translate-middle badge rounded-pill bg-info">5</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-xl dropdown-menu-end p-0 product-list"
                            aria-labelledby="page-header-cart-dropdown">
                            <div class="p-3 border-bottom">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-lg fw-semibold"> My Cart <span
                                                class="badge bg-secondary fs-sm cartitem-badge ms-1">7</span></h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar="" style="max-height: 300px;">
                                <div class="p-3">
                                    <div class="text-center empty-cart" id="empty-cart">
                                        <div class="avatar-md mx-auto my-3">
                                            <div class="avatar-title bg-info-subtle text-info fs-2 rounded-circle">
                                                <i class='bx bx-cart'></i>
                                            </div>
                                        </div>
                                        <h5 class="mb-3">Your Cart is Empty!</h5>
                                        <a href="#!" class="btn btn-success w-md mb-3">Shop Now</a>
                                    </div>

                                    <div class="d-block dropdown-item product text-wrap p-2">
                                        <div class="d-flex">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ secure_asset('/front/assets/images/products/32/img-1.png') }}"
                                                        class="avatar-xs" alt="user-pic">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fs-sm text-muted">Fashion</p>
                                                <h6 class="mt-0 mb-3 fs-md">
                                                    <a href="#!" class="text-reset">Blive Printed Men Round
                                                        Neck</a>
                                                </h6>
                                                <div class="text-muted fw-medium d-none">$<span
                                                        class="product-price">327.49</span></div>
                                                <div class="input-step">
                                                    <button type="button" class="minus">–</button>
                                                    <input type="number" class="product-quantity" value="2"
                                                        min="0" max="100" readonly="">
                                                    <button type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div
                                                class="ps-2 d-flex flex-column justify-content-between align-items-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-primary remove-cart-btn"
                                                    data-bs-toggle="modal" data-bs-target="#removeCartModal"><i
                                                        class="ri-close-fill fs-lg"></i></button>
                                                <h5 class="mb-0">$ <span class="product-line-price">654.98</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item product text-wrap p-2">
                                        <div class="d-flex">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ secure_asset('/front/assets/images/products/32/img-5.png') }}"
                                                        class="avatar-xs" alt="user-pic">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fs-sm text-muted">Sportwear</p>
                                                <h6 class="mt-0 mb-3 fs-md">
                                                    <a href="#!" class="text-reset">Willage Volleyball
                                                        Ball</a>
                                                </h6>
                                                <div class="text-muted fw-medium d-none">$<span
                                                        class="product-price">49.06</span></div>
                                                <div class="input-step">
                                                    <button type="button" class="minus">–</button>
                                                    <input type="number" class="product-quantity" value="3"
                                                        min="0" max="100" readonly="">
                                                    <button type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div
                                                class="ps-2 d-flex flex-column justify-content-between align-items-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-primary remove-cart-btn"
                                                    data-bs-toggle="modal" data-bs-target="#removeCartModal"><i
                                                        class="ri-close-fill fs-lg"></i></button>
                                                <h5 class="mb-0">$ <span class="product-line-price">147.18</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item product text-wrap p-2">
                                        <div class="d-flex">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ secure_asset('/front/assets/images/products/32/img-10.png') }}"
                                                        class="avatar-xs" alt="user-pic">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fs-sm text-muted">Fashion</p>
                                                <h6 class="mt-0 mb-3 fs-md">
                                                    <a href="#!" class="text-reset">Cotton collar tshirts
                                                        for men</a>
                                                </h6>
                                                <div class="text-muted fw-medium d-none">$<span
                                                        class="product-price">53.33</span></div>
                                                <div class="input-step">
                                                    <button type="button" class="minus">–</button>
                                                    <input type="number" class="product-quantity" value="3"
                                                        min="0" max="100" readonly="">
                                                    <button type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div
                                                class="ps-2 d-flex flex-column justify-content-between align-items-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-primary remove-cart-btn"
                                                    data-bs-toggle="modal" data-bs-target="#removeCartModal"><i
                                                        class="ri-close-fill fs-lg"></i></button>
                                                <h5 class="mb-0">$ <span class="product-line-price">159.99</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item product text-wrap p-2">
                                        <div class="d-flex">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ secure_asset('/front/assets/images/products/32/img-11.png') }}"
                                                        class="avatar-xs" alt="user-pic">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fs-sm text-muted">Fashion</p>
                                                <h6 class="mt-0 mb-3 fs-md">
                                                    <a href="#!" class="text-reset">Jeans blue men
                                                        boxer</a>
                                                </h6>
                                                <div class="text-muted fw-medium d-none">$<span
                                                        class="product-price">164.37</span></div>
                                                <div class="input-step">
                                                    <button type="button" class="minus">–</button>
                                                    <input type="number" class="product-quantity" value="1"
                                                        min="0" max="100" readonly="">
                                                    <button type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div
                                                class="ps-2 d-flex flex-column justify-content-between align-items-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-primary remove-cart-btn"
                                                    data-bs-toggle="modal" data-bs-target="#removeCartModal"><i
                                                        class="ri-close-fill fs-lg"></i></button>
                                                <h5 class="mb-0">$ <span class="product-line-price">164.37</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-block dropdown-item product text-wrap p-2">
                                        <div class="d-flex">
                                            <div class="avatar-sm me-3 flex-shrink-0">
                                                <div class="avatar-title bg-light rounded">
                                                    <img src="{{ secure_asset('/front/assets/images/products/32/img-8.png') }}"
                                                        class="avatar-xs" alt="user-pic">
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="mb-1 fs-sm text-muted">Fashion</p>
                                                <h6 class="mt-0 mb-3 fs-md">
                                                    <a href="#!" class="text-reset">Full Sleeve Solid Men
                                                        Sweatshirt</a>
                                                </h6>
                                                <div class="text-muted fw-medium d-none">$<span
                                                        class="product-price">180.00</span></div>
                                                <div class="input-step">
                                                    <button type="button" class="minus">–</button>
                                                    <input type="number" class="product-quantity" value="1"
                                                        min="0" max="100" readonly="">
                                                    <button type="button" class="plus">+</button>
                                                </div>
                                            </div>
                                            <div
                                                class="ps-2 d-flex flex-column justify-content-between align-items-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-sm btn-ghost-primary remove-cart-btn"
                                                    data-bs-toggle="modal" data-bs-target="#removeCartModal"><i
                                                        class="ri-close-fill fs-lg"></i></button>
                                                <h5 class="mb-0">$ <span class="product-line-price">180.00</span>
                                                </h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="count-table">
                                        <table class="table table-borderless mb-0  fw-semibold">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td class="text-end cart-subtotal">$1306.52</td>
                                                </tr>
                                                <tr>
                                                    <td>Discount <span class="text-muted">(Steex15)</span>:</td>
                                                    <td class="text-end cart-discount">- $195.98</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charge :</td>
                                                    <td class="text-end cart-shipping">$65.00</td>
                                                </tr>
                                                <tr>
                                                    <td>Estimated Tax (12.5%) : </td>
                                                    <td class="text-end cart-tax">$163.31</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            <div class="p-3 border-bottom-0 border-start-0 border-end-0 border-dashed border"
                                id="checkout-elem">
                                <div class="d-flex justify-content-between align-items-center pb-3">
                                    <h5 class="m-0 text-muted">Total:</h5>
                                    <div class="px-2">
                                        <h5 class="m-0 cart-total">$1338.86</h5>
                                    </div>
                                </div>

                                <a href="apps-ecommerce-checkout.html" class="btn btn-info text-center w-100">
                                    Checkout
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                            data-toggle="fullscreen">
                            <i class='bi bi-arrows-fullscreen fs-lg'></i>
                        </button>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item">
                        <button type="button"
                            class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle mode-layout"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-sun align-middle fs-3xl"></i>
                        </button>
                        <div class="dropdown-menu p-2 dropdown-menu-end" id="light-dark-mode">
                            <a href="#!" class="dropdown-item" data-mode="light"><i
                                    class="bi bi-sun align-middle me-2"></i> Default (light mode)</a>
                            <a href="#!" class="dropdown-item" data-mode="dark"><i
                                    class="bi bi-moon align-middle me-2"></i> Dark</a>
                            <a href="#!" class="dropdown-item" data-mode="auto"><i
                                    class="bi bi-moon-stars align-middle me-2"></i> Auto (system default)</a>
                        </div>
                    </div>

                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-bell fs-2xl'></i>
                            <span
                                class="position-absolute topbar-badge fs-3xs translate-middle badge rounded-pill bg-danger"><span
                                    class="notification-badge">4</span><span class="visually-hidden">unread
                                    messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head rounded-top">
                                <div class="p-3 border-bottom border-bottom-dashed">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="mb-0 fs-lg fw-semibold"> Notifications <span
                                                    class="badge bg-danger-subtle text-danger fs-sm notification-badge">
                                                    4</span></h6>
                                            <p class="fs-md text-muted mt-1 mb-0">You have <span
                                                    class="fw-semibold notification-unread">3</span> unread
                                                messages</p>
                                        </div>
                                        <div class="col-auto dropdown">
                                            <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                                class="link-secondary fs-md"><i
                                                    class="bi bi-three-dots-vertical"></i></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">All Clear</a></li>
                                                <li><a class="dropdown-item" href="#">Mark all as read</a>
                                                </li>
                                                <li><a class="dropdown-item" href="#">Archive All</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="py-2 ps-2" id="notificationItemsTabContent">
                                <div data-simplebar="" style="max-height: 300px;" class="pe-2">
                                    <h6 class="text-overflow text-muted fs-sm my-2 text-uppercase notification-title">
                                        New</h6>
                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-info-subtle text-info rounded-circle fs-lg">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 fs-md mb-2 lh-base">Your <b>Elite</b> author
                                                        Graphic
                                                        Optimization <span class="text-secondary">reward</span> is
                                                        ready!
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> Just 30 sec
                                                        ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-base">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check01">
                                                    <label class="form-check-label"
                                                        for="all-notification-check01"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                        <div class="d-flex">
                                            <div class="position-relative me-3 flex-shrink-0">
                                                <img src="{{ secure_asset('/front/assets/images/users/32/avatar-2.jpg') }}"
                                                    class="rounded-circle avatar-xs" alt="user-pic">
                                                <span
                                                    class="active-badge position-absolute start-100 translate-middle p-1 bg-success rounded-circle">
                                                    <span class="visually-hidden">New alerts</span>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-md fw-semibold">Angela Bernier</h6>
                                                </a>
                                                <div class="fs-sm text-muted">
                                                    <p class="mb-1">Answered to your comment on the cash flow
                                                        forecast's graph 🔔.</p>
                                                </div>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 48 min ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-base">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check02">
                                                    <label class="form-check-label"
                                                        for="all-notification-check02"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3 flex-shrink-0">
                                                <span
                                                    class="avatar-title bg-danger-subtle text-danger rounded-circle fs-lg">
                                                    <i class='bx bx-message-square-dots'></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-2 fs-md lh-base">You have received <b
                                                            class="text-success">20</b> new messages in the
                                                        conversation
                                                    </h6>
                                                </a>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 2 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-base">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check03">
                                                    <label class="form-check-label"
                                                        for="all-notification-check03"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="text-overflow text-muted fs-sm my-2 text-uppercase notification-title">
                                        Read Before</h6>

                                    <div class="text-reset notification-item d-block dropdown-item position-relative">
                                        <div class="d-flex">

                                            <div class="position-relative me-3 flex-shrink-0">
                                                <img src="{{ secure_asset('/front/assets/images/users/32/avatar-8.jpg') }}"
                                                    class="rounded-circle avatar-xs" alt="user-pic">
                                                <span
                                                    class="active-badge position-absolute start-100 translate-middle p-1 bg-warning rounded-circle">
                                                    <span class="visually-hidden">New alerts</span>
                                                </span>
                                            </div>

                                            <div class="flex-grow-1">
                                                <a href="#!" class="stretched-link">
                                                    <h6 class="mt-0 mb-1 fs-md fw-semibold">Maureen Gibson</h6>
                                                </a>
                                                <div class="fs-sm text-muted">
                                                    <p class="mb-1">We talked about a project on linkedin.</p>
                                                </div>
                                                <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                    <span><i class="mdi mdi-clock-outline"></i> 4 hrs ago</span>
                                                </p>
                                            </div>
                                            <div class="px-2 fs-base">
                                                <div class="form-check notification-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="all-notification-check04">
                                                    <label class="form-check-label"
                                                        for="all-notification-check04"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="notification-actions" id="notification-actions">
                                    <div class="d-flex text-muted justify-content-center align-items-center">
                                        Select <div id="select-content" class="text-body fw-semibold px-1">0
                                        </div> Result <button type="button" class="btn btn-link link-danger p-0 ms-2"
                                            data-bs-toggle="modal"
                                            data-bs-target="#removeNotificationModal">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                <img class="rounded-circle header-profile-user"
                                    src="{{ secure_asset('/front/assets/images/users/32/avatar-1.jpg') }}"
                                    alt="Header Avatar">
                                <span class="text-start ms-xl-2">
                                    {{-- <span
                                        class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ Auth::user()->name }}</span> --}}
                                    {{-- @foreach (Auth::user()->getRoleNames() as $role)
                                        <span
                                            class="d-none d-xl-block ms-1 fs-sm user-name-sub-text">{{ $role }}</span>
                                    @endforeach --}}
                                </span>
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">Welcome Richard!</h6>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle">Profile</span></a>
                            <a class="dropdown-item" href="apps-chat.html"><i
                                    class="mdi mdi-message-text-outline text-muted fs-lg align-middle me-1"></i>
                                <span class="align-middle">Messages</span></a>
                            <a class="dropdown-item" href="apps-tickets-overview.html"><i
                                    class="mdi mdi-calendar-check-outline text-muted fs-lg align-middle me-1"></i>
                                <span class="align-middle">Taskboard</span></a>
                            <a class="dropdown-item" href="pages-faqs.html"><i
                                    class="mdi mdi-lifebuoy text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle">Help</span></a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="pages-profile.html"><i
                                    class="mdi mdi-wallet text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle">Balance : <b>$8451.36</b></span></a>
                            <a class="dropdown-item" href="pages-profile-settings.html"><span
                                    class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                                    class="mdi mdi-cog-outline text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle">Settings</span></a>
                            <a class="dropdown-item" href="{{ route('logout') }}"><i
                                    class="mdi mdi-lock text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle">Logout</span></a>
                            {{-- <a class="dropdown-item" href="{{ route('logout') }}"><i
                                    class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- removeNotificationModal -->
    <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="NotificationModalbtn-close"></button>
                </div>
                <div class="modal-body p-md-5">
                    <div class="text-center">
                        <div class="text-danger">
                            <i class="bi bi-trash display-4"></i>
                        </div>
                        <div class="mt-4 fs-base">
                            <h4 class="mb-1">Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes,
                            Delete It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- removeCartModal -->
    <div id="removeCartModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-cartmodal"></button>
                </div>
                <div class="modal-body p-md-5">
                    <div class="text-center">
                        <div class="text-danger">
                            <i class="bi bi-trash display-5"></i>
                        </div>
                        <div class="mt-4">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">Are you sure you want to remove this product ?</p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn w-sm btn-danger" id="remove-cartproduct">Yes, Delete
                            It!</button>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">
        {{-- @yield('content') --}}

        <div class="page-content">
            @yield('content')
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Ogeny.net
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Ogeny Team
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="addAmount" tabindex="-1" aria-labelledby="addAmountLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title" id="addAmountLabel">Add Amount</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="#!">
                        <div class="row g-3">
                            <div class="col-lg-12">
                                <div>
                                    <label for="AmountInput" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="AmountInput"
                                        placeholder="$000.00">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label">Select Method</label>
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label class="border rounded w-100 form-label p-2">
                                            <input class="form-check-input me-1" name="exampleRadios" type="radio"
                                                value="" checked="">
                                            Visa
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="border rounded w-100 form-label p-2">
                                            <input class="form-check-input me-1" name="exampleRadios" type="radio"
                                                value="">
                                            Mastercard
                                        </label>
                                    </div>
                                    <div class="col-lg-4">
                                        <label class="border rounded w-100 form-label p-2">
                                            <input class="form-check-input me-1" name="exampleRadios" type="radio"
                                                value="">
                                            Credit Card
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="cardNumber" class="form-label">Card Number</label>
                                    <input type="number" class="form-control" id="cardNumber"
                                        placeholder="xxxx xxxx xxxx xxxx">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div>
                                    <label for="month" class="form-label">Expiry Date</label>
                                    <div class="row g-3">
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" id="month"
                                                placeholder="MM">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" id="years"
                                                placeholder="YYYY">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    <label for="cvv/cvc" class="form-label">CVV/CVC</label>
                                    <input type="number" class="form-control" id="cvv/cvc" placeholder="***">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <label for="cardHoldersName" class="form-label">Cardholders Name</label>
                                    <input type="text" class="form-control" id="cardHoldersName"
                                        placeholder="Enter name">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                            class="ph-x align-middle"></i> Close</button>
                    <button type="button" class="btn btn-primary">Add Amount</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 overflow-hidden">
                <div class="modal-body p-0 ribbon-box">
                    <div class="ribbon ribbon-danger ribbon-shape trending-ribbon">
                        <span class="trending-ribbon-text">Trending</span> <i
                            class="ri-flashlight-fill text-white align-bottom float-end ms-1"></i>
                    </div>
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="bg-primary-subtle p-5 h-100">
                                <div class="p-lg-4">
                                    <img src="{{ secure_asset('/front/assets/images/products/img-3.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div><!--end col-->
                        <div class="col-lg-7">
                            <div class="p-4 h-100">
                                <button type="button" class="btn-close float-end" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                <a href="#!">
                                    <h5 class="mb-1">Craft Women Black Sling Bag</h5>
                                </a>
                                <p class="text-muted">Fashion & Clothing</p>

                                <h5 class="mb-3">$199.99 <del class="text-muted fs-sm fw-normal">$299.99</del>
                                </h5>

                                <ul class="list-unstyled hstack gap-2 mb-4">
                                    <li>
                                        Available Colors
                                    </li>
                                    <li>
                                        <div class="avatar-xxs">
                                            <div class="avatar-title rounded bg-primary-subtle"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar-xxs">
                                            <div class="avatar-title rounded bg-success-subtle"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar-xxs">
                                            <div class="avatar-title rounded bg-danger-subtle"></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="avatar-xxs">
                                            <div class="avatar-title rounded bg-dark-subtle"></div>
                                        </div>
                                    </li>
                                </ul>

                                <ul class="list-unstyled vstack gap-2 mb-4">
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>In stock
                                    </li>
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>Free
                                        delivery available</li>
                                    <li class=""><i
                                            class="bi bi-check2-circle me-2 align-middle text-success"></i>Sales 10%
                                        Off Use Code: <b>STEEX10</b></li>
                                </ul>

                                <div class="hstack gap-2 justify-content-end">
                                    <button class="btn btn-primary"><i class="bi bi-cart align-baseline me-1"></i>
                                        Add To Cart</button>
                                    <button class="btn btn-subtle-secondary">View Details <i
                                            class="bi bi-arrow-right align-baseline ms-1"></i></button>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Modal -->

    <!--start back-to-top-->
    <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ secure_asset('/front/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ secure_asset('/front/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <!-- apexcharts -->
    <script src="{{ secure_asset('/front/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ secure_asset('/front/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ secure_asset('/front/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ secure_asset('/front/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <script src="{{ secure_asset('/front/assets/libs/list.js/list.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ secure_asset('/front/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    {{-- <script src="{{ secure_asset('/front/assets/js/pages/ecommerce-product-list.init.js"></script> --}}

    <!-- App js -->
    <script src="{{ secure_asset('/front/assets/js/app.js') }}"></script>

    {{-- Config sweetalert2 --}}
    <script src="{{ secure_asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js" rel='preload' defer='true'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" rel='preload' defer='true'>
    </script>

    {{-- Thêm JS cho Select2  --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- Thêm JS cho summernote --}}
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>

    {{-- Thêm JS cho bootstrap-tagsinput --}}
    <script src="{{ secure_asset('vendor/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>

    <!-- Thêm JS cho dropzone -->
    {{-- <script src="{{ asset('vendor/dropzone/dropzone-min.js') }}"></script>
    <script src="{{ asset('vendor/dropzone/form-file-upload.init.js') }}"></script> --}}

    @livewireScripts

    <script>
        document.addEventListener('livewire:init', () => {
            // Lắng nghe sự kiện 'show-alert' từ Livewire components
            Livewire.on('show-alert', (eventDetail) => { // eventDetail là một object { title, message, type, ... }
                // console.log('Received show-alert event:', eventDetail);

                Swal.fire({
                    title: eventDetail.title || 'Thông báo!',
                    text: eventDetail.message,
                    icon: eventDetail.type || 'info', // success, error, warning, info, question
                    confirmButtonText: eventDetail.confirmButtonText || 'OK'
                });
            });

            // Lắng nghe các sự kiện để mở/đóng modal (ví dụ với Bootstrap Modals)
            // Livewire.on('show-delete-user-modal', (eventDetail) => {
            //     var modal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
            //     modal.show();
            // });
            // Livewire.on('show-view-user-modal', (eventDetail) => {
            //     var modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
            //     modal.show();
            // });
            // Livewire.on('show-user-modal', (eventDetail) => { // Modal chỉnh sửa role/permission
            //     var modal = new bootstrap.Modal(document.getElementById('userModal'));
            //     modal.show();
            // });
            // Livewire.on('close-modal', (eventDetail) => {
            //     // Tìm tất cả các modal đang mở và đóng chúng
            //     document.querySelectorAll('.modal.show').forEach((modalElement) => {
            //         var modalInstance = bootstrap.Modal.getInstance(modalElement);
            //         if (modalInstance) {
            //             modalInstance.hide();
            //         }
            //     });
            // });
            autoHideSessionMessages();
        });

        // Sử dụng hook 'commit' với callback 'respond'
        Livewire.hook('commit', ({
            component,
            commit,
            respond,
            succeed,
            fail
        }) => {
            // Callback 'succeed' chạy sau khi nhận phản hồi thành công, TRƯỚC KHI DOM được vá.
            // Không nên gọi autoHideSessionMessages() ở đây.
            succeed(({
                snapshot,
                effect
            }) => {
                console.log('Commit hook - succeed: Response received for component: ' + component.name +
                    '. DOM not yet patched.');
                // autoHideSessionMessages();
                setTimeout(() => {
                    autoHideSessionMessages();
                }, 1000);
            });
            fail(() => {
                console.console.error('Commit hook - fail: Request failed for component: ' + component
                    .name +
                    '. Calling autoHideSessionMessages.');
            });
        });

        // Trong file portal/layouts/app.blade.php của bạn
        function autoHideSessionMessages() {
            const autoHide = (selector, timeout) => {
                document.querySelectorAll(selector).forEach(function(alertElement) {
                    if (alertElement.dataset.autohideInitialized) return;
                    alertElement.dataset.autohideInitialized = 'true';

                    setTimeout(() => {
                        const bsAlert = bootstrap.Alert.getInstance(alertElement);
                        if (bsAlert) {
                            bsAlert.close();
                        } else if (window.jQuery) {
                            window.jQuery(alertElement).fadeOut('slow', function() {
                                window.jQuery(this).remove();
                            });
                        } else {
                            alertElement.style.transition = 'opacity 0.5s ease';
                            alertElement.style.opacity = '0';
                            setTimeout(() => {
                                if (alertElement.parentNode) {
                                    alertElement.parentNode.removeChild(alertElement);
                                }
                            }, 500);
                        }
                    }, timeout);
                });
            };

            autoHide('.alert-success', 3000);
            autoHide('.alert-danger', 3000);
            autoHide('.text-danger', 3000);
        }
    </script>
</body>

</html>
