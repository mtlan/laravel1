@extends('layouts.app')

@section('content')
    <!------------------------------>
    <!-- Pricing section Start------>
    <!------------------------------>
    <section class="pricing position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                @role('distributor')
                    <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                        <small class="fs-7 d-block text-danger">Hey nhà phân phối boybet97</small>
                    </div>
                @endrole
            </div>
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
                    <small class="fs-7 d-block">Pricing Plan</small>
                    <h2 class="fs-3 pricing-head text-black mb-0 position-relative">What’s About Our Pricing Subscription
                    </h2>
                </div>
            </div>
            <div class="row plans">
                <div class="col-12 text-center">
                    <div class="form-check form-switch d-flex justify-content-center ps-0 align-items-center">
                        <label class="form-check-label text-black fs-7" for="flexSwitchCheckChecked">Monthly</label>
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                        <label class="form-check-label text-black fs-7" for="flexSwitchCheckChecked">Yearly</label>
                    </div>
                    <div class="save d-inline-block position-relative text-warning fw-500 fs-9 text-center">Save Up To 58%
                    </div>
                </div>
            </div>
            <div class="row justify-content-center price-plan">
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card position-relative shadow border-0 h-100">
                        <div class="card-body pb-4">
                            <small class="fs-7 d-block text-warning text-center">Personal</small>
                            <h2 class="mb-4 text-center position-relative"><sub class="fs-2 text-black">0</sub><sup
                                    class="fs-6 position-absolute">$</sup></h2>
                            <small class="fs-7 d-block text-center">Free</small>
                            <p class="fs-7 text-center fw-500">For individuals looking for a simple CRM solution</p>
                            <ul class="list-unstyled mb-0 pl-0">
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Basic CRM features</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Unlimited Personal Pipelines</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Email Power Tools</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-action text-center pb-xxl-5 pb-xl-5 pb-lg-5 pb-md-4 pb-sm-4 pb-4">
                            <a href="#" class="btn btn-warning btn-hover-secondery text-capitalize">Set Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card position-relative shadow border-0 h-100">
                        <div class="position-absolute badge bg-warning d-inline-block mx-auto">
                            Most Popular
                        </div>
                        <div class="card-body pb-4">
                            <small class="fs-7 d-block text-warning text-center">Professional</small>
                            <h2 class="mb-4 text-center position-relative"><sub class="fs-2 text-black">49</sub><sup
                                    class="fs-6 position-absolute">$</sup></h2>
                            <small class="fs-7 d-block text-center">Free</small>
                            <p class="fs-7 text-center fw-500">For individuals looking for a simple CRM solution</p>
                            <ul class="list-unstyled mb-0 pl-0">
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Basic CRM features</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Unlimited Personal Pipelines</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Email Power Tools</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Unlimited Shared Pipelines</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-action text-center pb-xxl-5 pb-xl-5 pb-lg-5 pb-md-4 pb-sm-4 pb-4">
                            <a href="#" class="btn btn-warning btn-hover-secondery text-capitalize">Set Started</a>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12">
                    <div class="card position-relative shadow border-0 h-100">
                        <div class="card-body pb-4">
                            <small class="fs-7 d-block text-warning text-center">Enterprise</small>
                            <h2 class="mb-4 text-center position-relative"><sub class="fs-2 text-black">99</sub><sup
                                    class="fs-6 position-absolute">$</sup></h2>
                            <small class="fs-7 d-block text-center">Free</small>
                            <p class="fs-7 text-center fw-500">For individuals looking for a simple CRM solution</p>
                            <ul class="list-unstyled mb-0 pl-0">
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Basic CRM features</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Unlimited Personal Pipelines</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Email Power Tools</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black">Unlimited Shared Pipelines</span>
                                </li>
                                <li class="d-flex align-items-start">
                                    <i class="ti ti-circle-check fs-4 pe-2"></i>
                                    <span class="fs-7 text-black"> Full API Access</span>
                                </li>
                            </ul>
                        </div>
                        <div class="card-action text-center pb-xxl-5 pb-xl-5 pb-lg-5 pb-md-4 pb-sm-4 pb-4">
                            <a href="#" class="btn btn-warning btn-hover-secondery text-capitalize">Set Started</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------------------>
    <!-- Pricing section End-------->
    <!------------------------------>

    <!------------------------------>
    <!------ FAQ section Start------>
    <!------------------------------>
    <section class="faq position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <small class="fs-7 d-block">Frequently Asked Questions</small>
                    <h2 class="fs-3 text-black mb-0">Want to ask something from us?</h2>
                </div>
            </div>
            <div class="accordion-block">
                <div class="accordion row" id="accordionPanelsStayOpenExample">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button text-black fs-7" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true"
                                    aria-controls="panelsStayOpen-collapseOne">
                                    Letraset sheets containing sum passages ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseTwo">
                                    There are many variations ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapseThree">
                                    Lorem Ipsum generators on the Internet tend ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingfour">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefour"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsefour">
                                    Various versions have evolved over the ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsefour" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingfour">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingfive">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsefive"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsefive">
                                    Finibus bonorum et malorum ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsefive" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingfour">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header" id="panelsStayOpen-headingsix">
                                <button class="accordion-button collapsed text-black fs-7" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapsesix"
                                    aria-expanded="false" aria-controls="panelsStayOpen-collapsesix">
                                    Many desktop publishing packages ?
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapsesix" class="accordion-collapse collapse"
                                aria-labelledby="panelsStayOpen-headingsix">
                                <div class="accordion-body fs-7 fw-500 pt-0">
                                    Seamlessly see the tasks that need your attention, check when your next meeting is
                                    coming up, and keep up with your progress.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!------------------------------>
    <!------ FAQ section End------>
    <!------------------------------>

    <!------------------------------>
    <!-----Contact section Start---->
    <!------------------------------>
    <section class="contact bg-primary position-relative overflow-hidden">
        <div class="container position-relative">
            <div class="dots-shape-left position-absolute"><img src="../assets/images/icons/dot-shape.png"></div>
            <div class="dots-shape-right position-absolute"><img src="../assets/images/icons/dot-shape.png"></div>
            <div class="row">
                <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-12 col-sm-12 col-12">
                    <small class="fs-7 d-block text-warning">Join us Now</small>
                    <h2 class="fs-3 text-white mb-0">Ready to try the product for free?</h2>
                    <div class="owl-carousel owl-theme testimonial">
                        <div class="item">
                            <div class="details position-relative">
                                <p class="fs-5 fw-light blue-light mb-4">
                                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                                    piece”
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avtar-img rounded-circle overflow-hidden"><img
                                            src="../assets/images/contact/testimonial-image.png" class="img-fluid"></div>
                                    <div class="name ps-3">
                                        <h6 class="text-white">Merky Lester</h6>
                                        <small class="d-block blue-light fw-500 fs-10 pb-0">Managers</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="details position-relative">
                                <p class="fs-5 fw-light blue-light mb-4">
                                    Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a
                                    piece”
                                </p>
                                <div class="d-flex align-items-center">
                                    <div class="avtar-img rounded-circle overflow-hidden"><img
                                            src="../assets/images/contact/testimonial-image.png" class="img-fluid"></div>
                                    <div class="name ps-3">
                                        <h6 class="text-white">Merky Lester</h6>
                                        <small class="d-block blue-light fw-500 fs-10 pb-0">Managers</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-12 col-sm-12 col-12">
                    <form class="position-relative">
                        <div class="row ps-xxl-5 ps-xl-5 ps-lg-3 ps-md-0 ps-sm-0 ps-0">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-white fs-7 mb-3">Full Name</label>
                                    <input type="text" class="form-control border-0" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-white fs-7 mb-3">User Name</label>
                                    <input type="text" class="form-control border-0"
                                        placeholder="Enter your username">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label text-white fs-7 mb-3">Email address</label>
                                    <input type="email" class="form-control border-0"
                                        placeholder="Enter your email address">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label text-white fs-7 mb-3">Email Password</label>
                                    <input type="text" class="form-control border-0"
                                        placeholder="Enter your password">
                                </div>
                            </div>

                            <div class="agree fs-7 fw-500">
                                By clicking on the Sign Up button, you agree to Rakon.<br><a href="#"
                                    class="text-warning text-decoration-none">terms and conditions of use.</a>
                            </div>
                            <div class="col-12">
                                <button
                                    class="btn btn-warning btn-hover-secondery text-capitalize mt-2 w-auto contact-btn">Try
                                    for Free</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="trusted-companies">
                <div class="row justify-content-center">
                    <div class="col-xx-8 col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                        <h3 class="fs-7 mb-0 text-white text-center">Trusted by content creators across the world</h3>
                        <ul
                            class="d-flex flex-wrap align-items-center list-unstyled mb-0 pl-0 owl-carousel owl-theme trusted-logos">
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/google.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/microsoft.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/amazon.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/unique.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/google.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/microsoft.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/amazon.svg"></a></li>
                            <li class="text-center item"><a href="#"><img
                                        src="../assets/images/contact/unique.svg"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
