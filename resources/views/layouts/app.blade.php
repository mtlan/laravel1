<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Website Chi hội Hướng dẫn viên du lịch Đà Nẵng</title>
    <link rel='stylesheet' id='bn_fonts-css'
        href='//fonts.googleapis.com/css?family=Roboto%3Aregular%2Citalic%2C500%2C700%26subset%3Dlatin%2C'
        media='screen' />

    <link type="image/x-icon" href="{{ secure_asset('frontend/images/logonew.png') }}" rel="shortcut icon" />

    <link rel="stylesheet" href="{{ secure_asset('frontend/css/bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ secure_asset('frontend/css/index.css') }}" />

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.13.1/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Begin Custom CSS -->
    <style id="bootnews-custom-css">
        .primary {
            color: #bc243c;
        }

        .secondary {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }

        :root {
            --bs-primary: #bc243c;
            --bs-secondary: #000000;
            --bs-primary-rgb: 23, 158, 0;
            --bs-secondary-rgb: 0, 0, 0;
            --bs-link-color: #bc243c;
            --bs-link-hover-color: #bc243c;
            border: none;
        }

        .btn-primary {
            --bs-btn-bg: #bc243c;
            --bs-btn-border-color: #bc243c;
            --bs-btn-hover-bg: #bc243c;
            --bs-btn-hover-border-color: #bc243c;
            --bs-btn-active-bg: #bc243c;
            --bs-btn-active-border-color: #bc243c;
            --bs-btn-disabled-bg: #bc243c;
            --bs-btn-disabled-border-color: #bc243c;
        }

        .btn-secondary {
            --bs-btn-bg: #000000;
            --bs-btn-border-color: #000000;
            --bs-btn-hover-bg: #000000;
            --bs-btn-hover-border-color: #000000;
            --bs-btn-active-bg: #000000;
            --bs-btn-active-border-color: #000000;
            --bs-btn-disabled-bg: #000000;
            --bs-btn-disabled-border-color: #000000;
        }

        .btn-outline-primary {
            --bs-btn-color: #bc243c;
            --bs-btn-border-color: #bc243c;
            --bs-btn-hover-bg: #bc243c;
            --bs-btn-hover-border-color: #bc243c;
            --bs-btn-active-bg: #bc243c;
            --bs-btn-active-border-color: #bc243c;
            --bs-btn-disabled-color: #bc243c;
        }

        .btn-outline-secondary {
            --bs-btn-color: #000000;
            --bs-btn-border-color: #000000;
            --bs-btn-hover-bg: #000000;
            --bs-btn-hover-border-color: #000000;
            --bs-btn-active-bg: #000000;
            --bs-btn-active-border-color: #000000;
            --bs-btn-disabled-color: #000000;
        }

        .dropdown-menu {
            --bs-dropdown-link-active-color: #bc243c;
        }

        .dropdown-menu-dark {
            --bs-dropdown-link-active-color: #bc243c;
        }

        .nav-pills {
            --bs-nav-pills-link-active-bg: #bc243c;
        }

        .navbar {
            --bs-navbar-brand-color: #bc243c;
            --bs-navbar-brand-hover-color: #bc243c;
        }

        .navbar-light {
            --bs-navbar-active-color: #bc243c;
        }

        .pagination {
            --bs-pagination-active-bg: #bc243c;
            --bs-pagination-active-border-color: #bc243c;
        }

        .progress {
            --bs-progress-bar-bg: #bc243c;
        }

        .list-group {
            --bs-list-group-active-bg: #bc243c;
            --bs-list-group-active-border-color: #bc243c;
        }

        .link-primary {
            color: #bc243c !important;
        }

        .link-primary:hover,
        .link-primary:focus {
            color: #bc243c !important;
        }

        .btn:focus,
        .btn:hover {
            opacity: .9 !important;
        }

        .font-family h1,
        .font-family h2,
        .font-family h3,
        .font-family h4,
        .font-family h5,
        .font-family h6,
        .font-family .h1,
        .font-family .h2,
        .font-family .h3,
        .font-family .h4,
        .font-family .h5,
        .font-family .h6,
        .font-family .navbar-nav,
        .menu-mobile a,
        .u-breadcrumb .breadcrumb-item,
        .post-content .tags-list li:first-child {
            font-family: "Roboto", sans-serif;
        }

        body {
            font-family: "sans-serif", sans-serif;
        }

        .bg-custom-footer {
            background-color: #31b1f9;
        }

        .bg-navcustom {
            background: #31b1f9 !important;
        }

        @media (min-width: 992px) {

            .showbacktop.is-fixed.bg-navcustom,
            .showbacktop.bg-navcustom.is-visible {
                background: #31b1f9 !important;
            }
        }
    </style>
    <!-- End Custom CSS -->
</head>

<body class="home blog wp-custom-logo full-width font-family hfeed">
    <div class="bg-image"></div>
    <!-- ========== WRAPPER ========== -->
    <div class="wrapper">
        @include('partials.header')
        @yield('space-work')
        @include('partials.footer')
    </div>
    <!-- ========== END WRAPPER ========== -->

    <!--Back to top-->
    <a class="back-top btn btn-light border position-fixed r-1 b-1" href="detail.html">
        <svg class="bi bi-arrow-up" width="1rem" height="1rem" viewBox="0 0 16 16" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M8 3.5a.5.5 0 01.5.5v9a.5.5 0 01-1 0V4a.5.5 0 01.5-.5z" clip-rule="evenodd">
            </path>
            <path fill-rule="evenodd"
                d="M7.646 2.646a.5.5 0 01.708 0l3 3a.5.5 0 01-.708.708L8 3.707 5.354 6.354a.5.5 0 11-.708-.708l3-3z"
                clip-rule="evenodd"></path>
        </svg>
    </a>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src='{{ secure_asset('frontend/js/bundle.min.js') }}'></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.6.1/toastify.js" rel='preload' defer='true'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" rel='preload' defer='true'>
    </script>
    @yield('scripts')
</body>

</html>
