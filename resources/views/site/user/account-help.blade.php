@extends('layouts.site_2')
@section('meta')
<title>Edit Profile</title>

<meta name="title" content="{{ config('app.name') }}" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:description" content="" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="wirteyourday.com" />
<meta name="twitter:title" content="{{ config('app.name') }}" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="" />
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/edit.css') }}">
@endsection
@section('content')
<div class="container-fluid">
    <div class="wrapper d-md-flex" id="inner-div">
        <!--- User Profile Links --->
        <aside class="categories hide">
            <button class="fa fa-times close-categories-btn sm-btn"></button>
            <div class="user-info">
                <div class="user-photo" id="user-photo">
                    <img src="{{ isset($user->image) ? asset('storage/users/'.$user->image) : asset('assets/images/images.png') }}" class="photo img-fluid" />
                </div>
                <div class="user-details">
                    <h3 class="user">{{$user->name}}</h3>
                    <p class="username">{{$user->username}}</p>
                </div>
            </div>
            <ul class="categories-list p-0">
                <li>
                    Profile               
                </li>
                <li>
                    Change Password
                </li>
                <li>                    
                    Privacy and Security
                </li>
                <li class="active">Help</li>
                <li>
                    Blocked
                </li>
            </ul>
        </aside>

        <!--- Update Profile Container --->
        <main class="setting" id="profile-setting">
        </main>

        <!--- Change Password Container --->
        <main class="setting" id="password-settings">
        </main>

        <!--- Help Request Container --->
        <main class="setting active" id="help">
            <div  class="success-box"></div>
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">Help Center</h2>
            </div>
            <section class="content">
                <form method="POST" id="help-form" action="{{route('help-center')}}">
                    @csrf
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="name">Name <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input  type="text" name="name" value="{{$user->name}}" id="name" placeholder="Full Name" />
                            <p id="name_help_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="confirm-password-help">Email Id <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input value="{{$user->email}}" name="email"  type="text" id="confirm-password-help" tabindex="1" placeholder="Email Id"
                                 />                            
                            <p id="email_help_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="phone">Phone Number (optional)</label>
                        </div>
                        <div class="grid-65">
                            <input type="number" name="phone" value="{{$user->phone}}"  id="phone" tabindex="1" placeholder="Phone" />
                            <p id="phone_help_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="message">Message <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <textarea id="message" name="message" tabindex="1" placeholder="Write your message"></textarea>
                            <p id="message_help_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>

                    <fieldset class="fieldset">
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" id="help-btn" class="submit-btn" value="Send" />
                        </div>
                    </fieldset>
                </form>
            </section>
        </main>

        <!--- Privacy Policy Container --->
        <main class="setting" id="privacy">
        </main>
    </div>
</div>
<a class="d-none disable-link"></a>
<div class="overlay hide" id="delete_container">
</div>
@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>    <!-- endinject -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/edit.js') }}" type="text/javascript"></script>
@endsection