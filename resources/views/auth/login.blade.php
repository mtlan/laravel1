<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang quản lý dịch vụ - VPSServer</title>

    <!-- Css -->
    <!-- Bootstrap Css -->
    <link href="{{ url('client') }}/assets/css/bootstrap.min.css" id="bootstrap-style" class="theme-opt" rel="stylesheet"
        type="text/css">

    <!-- Icons Css -->
    <link href="{{ url('client') }}/assets/libs/%40mdi/font/css/materialdesignicons.min.css" rel="stylesheet"
        type="text/css">
    <link href="{{ url('client') }}/assets/libs/%40iconscout/unicons/css/line.css" type="text/css" rel="stylesheet">
    <!-- Style Css-->
    <link href="{{ url('client') }}/assets/css/style.min.css" id="color-opt" class="theme-opt" rel="stylesheet"
        type="text/css">

    <!-- Font awesome  -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- Jquery  -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
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

@if (session()->has('message'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Thành công',
                html: "{!! session()->get('message') !!}",
                icon: "success"
            });
        });
    </script>
@endif

@if (session()->has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                title: 'Thất bại',
                html: "{!! session()->get('error') !!}",
                icon: "error"
            });
        });
    </script>
@endif

<body>
    <div class="back-to-home">
        <a href="" class="back-button btn btn-icon btn-primary"><i data-feather="arrow-left"
                class="icons"></i></a>
    </div>

    <!-- Hero Start -->
    <section class="bg-home d-flex align-items-center">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-6">
                    <div class="me-lg-5">
                        <img src="{{ url('client') }}/assets/images/user/login.svg" class="img-fluid d-block mx-auto"
                            alt="">
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="card login-page shadow rounded border-0">
                        <div class="card-body">
                            <h4 class="card-title text-center">ĐĂNG NHẬP</h4>
                            <form class="login-form mt-4" action="{{ route('login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Địa chỉ email <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="user" class="fea icon-sm icons"></i>
                                                <input type="email" class="form-control ps-5" placeholder="Email"
                                                    name="email">
                                                @error('email')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label">Mật khẩu <span
                                                    class="text-danger">*</span></label>
                                            <div class="form-icon position-relative">
                                                <i data-feather="key" class="fea icon-sm icons"></i>
                                                <input type="password" class="form-control ps-5" name="password"
                                                    id="password" placeholder="Password">
                                                <p class="text-danger mt-3" id="capslock-warning" hidden>Caps Lock is
                                                    on.</p>
                                                @error('password')
                                                    <p class="text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">Ghi nhớ đăng
                                                        nhập</label>
                                                </div>
                                            </div>
                                            <p class="forgot-pass mb-0"><a href="{{ route('password.request') }}"
                                                    class="text-dark fw-bold">Quên mật khẩu ?</a></p>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-lg-12 mt-4 text-center">
                                        <h6>Hoặc đăng nhập qua</h6>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-light"><i
                                                            class="mdi mdi-facebook text-primary"></i> Facebook</a>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-6 mt-3">
                                                <div class="d-grid">
                                                    <a href="javascript:void(0)" class="btn btn-light"><i
                                                            class="mdi mdi-google text-danger"></i> Google</a>
                                                </div>
                                            </div><!--end col-->
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-12 text-center">
                                        <p class="mb-0 mt-3"><small class="text-dark me-2">Bạn chưa có tài khoản
                                                ?</small> <a href="{{ route('register') }}"
                                                class="text-dark fw-bold">Đăng ký
                                                ngay</a></p>
                                    </div><!--end col-->
                                </div><!--end row-->
                            </form>

                            <script>
                                const passwordInput = document.getElementById('password');
                                const capslockWarning = document.getElementById('capslock-warning');

                                // Lắng nghe sự kiện
                                // passwordInput.addEventListener('keyup', (event) => {
                                //     if (event.getModifierState('CapsLock')) {
                                //         capslockWarning.hidden = false;
                                //     } else {
                                //         capslockWarning.hidden = true;
                                //     }
                                // })

                                passwordInput.addEventListener('keyup', function(event) {
                                    if (event.getModifierState('CapsLock')) {
                                        capslockWarning.hidden = false;
                                    } else {
                                        capslockWarning.hidden = true;
                                    }
                                })
                            </script>
                        </div>
                    </div><!---->
                </div> <!--end col-->
            </div><!--end row-->
        </div> <!--end container-->
    </section><!--end section-->
    <!-- Hero End -->

    <!-- Config sweetalert2  -->
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Main Js -->
    <script src="{{ url('client') }}/assets/libs/feather-icons/feather.min.js"></script>
    <script src="{{ url('client') }}/assets/js/plugins.init.js"></script>
    <!--Note: All init js like tiny slider, counter, countdown, maintenance, lightbox, gallery, swiper slider, aos animation etc.-->
    <script src="{{ url('client') }}/assets/js/app.js"></script>
    <!--Note: All important javascript like page loader, menu, sticky menu, menu-toggler, one page menu etc. -->
</body>

</html>
