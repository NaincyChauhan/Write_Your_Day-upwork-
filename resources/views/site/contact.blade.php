@extends('layouts.site')
@section('meta')
<title>Contact Us</title>

<meta name="title" content="{{ config('app.name') }}" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('storage/products/fabricator.jpeg') }}" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:description" content="" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ config('app.name') }}" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="{{ asset('storage/products/fabricator.jpeg') }}" />

@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('app-assets/masterX/css/captcha.css') }}">
@endsection

@section('js')   
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/captcha.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/send-message.js') }}"></script>
    <script>createCaptcha();</script>
@endsection

@section('content')
    <!-- Start Breadcrumb 
    ============================================= -->
    <div class="breadcrumb-area text-center shadow dark bg-fixed text-light" style="background-image: url(assets/img/banner/5.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <h1>Contact ENET Agri</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home') }}"><i class="fas fa-home"></i> Home</a></li>
                            <li class="active">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->


    <!-- Start Contact Us 
    ============================================= -->
    <div class="contact-area default-padding" style="background-image: url(assets/img/shape/28.png);">
        <div class="container">
            <div class="row align-center">
                
                <div class="col-tact-stye-one col-lg-7 mb-md-50">
                    <div class="contact-form-style-one">
                        <h5 class="sub-title">Have Questions?</h5>
                        <h2 class="heading">Send us a Massage</h2>
                        <form action="{{ route('send-message') }}" method="POST" id="contactform">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" id="name" name="name" placeholder="Name" type="text" required tabindex="1">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="email" name="email" placeholder="Email*" type="email" required tabindex="2">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <input class="form-control" id="phone" name="mobile" placeholder="+91XXXXXXXXXX" type="text" required tabindex="3">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input class="form-control" id="subject" name="subject" placeholder="Subject" type="text" required tabindex="4">
                                        <span class="alert-error"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group comments">
                                        <textarea class="form-control" id="comments" name="message" placeholder="Write a message..." required tabindex="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-12">                
                                    <div class="change-captcha">
                                      <a href="#" onclick="event.preventDefault();createCaptcha()">Change</a>
                                    </div>
                                    <div id="captcha" class="captcha"></div>
                                    <input type="text" class="form-control required mt-2" name="reCaptcha" id="reCaptcha" placeholder="Type The Captcha" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" name="submit" id="submitontact">
                                        <i class="fa fa-paper-plane"></i> Get in Touch
                                    </button>
                                </div>
                            </div>
                            <!-- Alert Message -->
                            <div class="col-lg-12 alert-notification">
                                <div id="message" class="alert-msg"></div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-tact-stye-one col-lg-5 pl-60 pl-md-15 pl-xs-15">
                    <div class="contact-style-one-info">
                        <h2>
                            Contact 
                            <span>
                                Information
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><path d="M14.4,111.6c0,0,202.9-33.7,471.2,0c0,0-194-8.9-397.3,24.7c0,0,141.9-5.9,309.2,0" style="animation-play-state: running;"></path></svg>
                            </span>
                        </h2>
                        <p>
                            At ENET AGRI, we are committed to providing our clients with the best possible service. If you have any questions or concerns, or if you would like to learn more about our products, please don't hesitate to contact us.
                        </p>
                        <ul>
                            <li class="wow fadeInUp">
                                <div class="icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="content">
                                    <h5 class="title">Mobile</h5>
                                    <a href="+91{{ $setting->mobile }}">+91{{ $setting->mobile }}</a>
                                </div>
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="300ms">
                                <div class="icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info">
                                    <h5 class="title">Our Location</h5>
                                    <p>
                                        {{ $setting->address }}
                                    </p>
                                </div>
                            </li>
                            <li class="wow fadeInUp" data-wow-delay="500ms">
                                <div class="icon">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <div class="info">
                                    <h5 class="title">Official Email</h5>
                                    <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Contact -->
@endsection