<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Layout config Js -->
    {{-- <script src="{{ url('front') }}/assets/js/layout.js"></script> --}}
    <!-- Bootstrap Css -->
    {{-- <link href="{{ url('front') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <!-- Icons Css -->
    
    <!-- App Css-->
    <link href="{{ url('front') }}/assets/css/app.min.css" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ url('front') }}/assets/css/custom.min.css" rel="stylesheet" type="text/css"> --}}

    {{-- <link href="{{ url('front') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css"> --}}

    {{-- Bootstrap 5 css --}}
    {{-- <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}"> --}}

    {{-- <script src="{{ url('front') }}/assets/js/layout.js"></script> --}}

    <link href="{{ url('front') }}/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    {{-- CSS of theme in public/css/app.css --}}
    <link rel="stylesheet" href="{{ asset('css/themes/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themes/tabler-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themes/owl.carousel.min.css') }}">



    <!-- Sử dụng thư việc để tạo date và format tiếng việt -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    {{-- Jquery --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
</head>

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

@if (session()->has('guest_success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Thành công',
                html: "{!! session()->get('guest_success') !!}",
                icon: "success"
            })
        });
    </script>
@endif

@if (session()->has('guest_error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Lỗi',
                html: "{!! session()->get('guest_error') !!}",
                icon: "error"
            })
        });
    </script>
@endif

<body class="font-sans antialiased">
    <!------------------------------>
    <!-- Header Start -->
    <!------------------------------>
    <header class="main-header position-fixed w-100">
        <div class="container">
            <nav class="navbar navbar-expand-xl py-0">
                <div class="logo">
                    <a class="navbar-brand py-0 me-0" href="#"><img src="../assets/images/sasscandy-logo.svg"
                            alt=""></a>
                </div>
                <a class="d-inline-block d-lg-block d-xl-none d-xxl-none  nav-toggler text-decoration-none"
                    data-bs-toggle="offcanvas" href="#offcanvasExample" aria-controls="offcanvasExample">
                    <i class="ti ti-menu-2 text-warning"></i>
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" aria-current="page" href="#">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Pricing</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Pricing </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">Elements </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-capitalize" href="#">blog</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <div class="input-group  search">
                            <button class="btn border-0 p-0" type="button" id="button-addon1"><i
                                    class="ti ti-search text-white"></i></button>
                            <input type="text" class="form-control border-0 bg-transparent ps-2" placeholder="search"
                                aria-label="Example text with button addon" aria-describedby="button-addon1">
                        </div>
                        @if (Auth::user())
                            <a class="btn btn-warning btn-hover-secondery text-capitalize "
                                href="{{ route('logout') }}">Log out</a>
                        @else
                            <a class="btn btn-warning btn-hover-secondery text-capitalize "
                                href="{{ route('login') }}">Login</a>
                            <a class="btn btn-warning btn-hover-secondery text-capitalize "
                                href="{{ route('register') }}">register</a>
                        @endif
                    </div>
                </div>
            </nav>
        </div>

        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <div class="logo">
                    <a class="navbar-brand py-0 me-0" href="#"><img src="../assets/images/Creato-logo.svg"
                            alt=""></a>
                </div>
                <button type="button" class="btn-close text-reset  ms-auto" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="ti ti-x text-warning"></i></button>
            </div>
            <div class="offcanvas-body pt-0">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" aria-current="page" href="#">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Pricing </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">Elements </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-capitalize" href="#">blog </a>
                    </li>
                </ul>
                <div class="login d-block align-items-center mt-3">
                    <a class="btn btn-warning text-capitalize w-100" href="#">contact us</a>
                </div>
            </div>
        </div>
    </header>
    <!------------------------------>
    <!-- Header End  -->
    <!------------------------------>

    <section class="service position-relative overflow-hidden">
        @yield('content')
    </section>

    <!------------------------------>
    <!-----Footer Start------------->
    <!------------------------------>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-logo-col">
                        <a href="#"><img src="../assets/images/footer/Logo.svg"></a>
                        <p class="blue-light mb-0 fs-7 fw-500">Rakon is a simple, elegant, and secure way to build
                            your
                            bitcoin and crypto portfolio.</p>
                        <div class="callus text-white fw-500 fs-7">
                            1989 Don Jackson Lane
                            <div class="blue-light">Call us: <a href="#"
                                    class="text-warning fw-500 fs-7 text-decoration-none">808-956-9599</a></div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12">
                    <h5 class="text-white">Social</h5>
                    <ul class="list-unstyled mb-0 pl-0">
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Facebook</a></li>
                        <li><a href="#">Twitter</a></li>
                        <li><a href="#">Instagram</a></li>
                    </ul>
                </div>
                <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-12">
                    <h5 class="text-white">Company</h5>
                    <ul class="list-unstyled mb-0 pl-0">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Affiliates</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Legal & Privacy</a></li>
                    </ul>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="subscribe">
                        <h5 class="text-white">Subscribe</h5>
                        <p class="blue-light fw-500">Subscribe to get the latest news form us
                        </p>
                        <div class="input-group">
                            <input type="email" class="form-control br-15" placeholder="Enter email address"
                                aria-label="Enter email address" aria-describedby="button-addon2">
                            <a class="btn btn-warning btn-hover-secondery ms-xxl-2 ms-xl-2 ls-lg-0 ms-md-0 ms-sm-0 ms-0"
                                href="">Register</a>
                            {{-- <a class="btn btn-warning btn-hover-secondery ms-xxl-2 ms-xl-2 ls-lg-0 ms-md-0 ms-sm-0 ms-0"
                                href="">Login</a> --}}
                            {{-- <button
                                class="btn btn-warning btn-hover-secondery ms-xxl-2 ms-xl-2 ls-lg-0 ms-md-0 ms-sm-0 ms-0"
                                type="button" id="button-addon2">Register</button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyrights text-center blue-light  fw-500">@<span id="autodate">2023</span> - All Rights
                Reserved by <a href="https://adminmart.com/" class="blue-light text-decoration-none">adminmart.com</a>
                Dsitributed By <a href="https://themewagon.com" class="blue-light text-decoration-none">ThemeWagon</a>
            </div>
        </div>
    </footer>
    <!------------------------------>
    <!-------Footer End------------->
    <!------------------------------>

    {{-- Bootstrap 5 js --}}
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

    {{-- <script src="{{ url('front') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js" rel='preload' defer='true'>
    </script>

    {{-- Themes js --}}
    {{-- <script src="{{ asset('js/themes/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('js/themes/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/themes/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/themes/custom.js') }}"></script>

    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- JAVASCRIPT -->
    <script src="{{ url('front') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('front') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ url('front') }}/assets/js/plugins.js"></script>

    <!-- apexcharts -->
    {{-- <script src="{{ url('front') }}/assets/libs/apexcharts/apexcharts.min.js"></script> --}}

    <!-- Vector map-->
    {{-- <script src="{{ url('front') }}/assets/libs/jsvectormap/js/jsvectormap.min.js"></script>
    <script src="{{ url('front') }}/assets/libs/jsvectormap/maps/world-merc.js"></script> --}}

    <!--Swiper slider js-->
    {{-- <script src="{{ url('front') }}/assets/libs/swiper/swiper-bundle.min.js"></script>
    <script src="{{ url('front') }}/assets/libs/list.js/list.min.js"></script> --}}

    <!-- Dashboard init -->
    {{-- <script src="{{ url('front') }}/assets/js/pages/dashboard-ecommerce.init.js"></script> --}}

    <!-- App js -->
    <script src="{{ url('front') }}/assets/js/app.js"></script>

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
