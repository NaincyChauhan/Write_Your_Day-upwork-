@extends('layouts.site')
@section('meta')

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
<section class="search_box">
    <div class="container">
        <form class="search_bar huge">
            <div class="search_dropdown">
                <span><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                <ul style="z-index: 2;">
                    <li class="selected"><i class="fa fa-user-friends side_icon"></i> Friend</li>
                    <li><i class="fa fa-sticky-note side_icon"></i> Post</li>
                </ul>
            </div>
            <input type="text" placeholder="Search for anything" />
            <button type="submit" value="Search">Search</button>
        </form>
    </div>
</section>

<section class="serch-profile-box-outer">
    <div class="container">
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>
        <div class="serch-profile-box">
            <div class="serch-profile-box-img">
                <img src="{{ asset('assets/images/radious-img.png') }}">
            </div>
            <div class="serch-profile-box-content">
                <h4>Birget Marrie</h4>
                <p class="followers">Followers: <span>1000</span></p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</p>
            </div>
            <div class="serch-profile-box-button">
                <button class="main_btn">Follow</button>
            </div>

        </div>

    </div>
</section>
@endsection