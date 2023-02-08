@extends('layouts.site')
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
                <li class="active setting-link" data-target="profile-setting">
                    Profile
                </li>
                <li class="setting-link" data-target="password-settings">
                    Change Password
                </li>
                <li class="setting-link" data-target="privacy">
                    Privacy and Security
                </li>
                <li class="setting-link" data-target="help">Help</li>
                <li class="setting-link" data-target="blocked">Blocked</li>
            </ul>
        </aside>

        <!--- Update Profile Container --->
        <main class="setting active" id="profile-setting">
            <div  id="success-box"></div>
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">My Profile</h2>
            </div>
            <section class="content">
                <form id="edit-profile-form" method="POST" action="{{route('edit-profile')}}" enctype="multipart/form-data">
                    @csrf
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="setting-pic">Profile Picture <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="file" name="image" id="setting-pic" />
                            <p id="image_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="fname">Name <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" name="name" value="{{$user->name}}"  id="fname" tabindex="1" placeholder="Full Name" />
                            <p id="name_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>

                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="uname">Username <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" name="username" value="{{$user->username}}" id="uname" tabindex="2" placeholder="username" />
                            <p id="username_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="uname">Thought of the Day <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" name="thought_of_the_day" value="{{$user->thought_of_the_day}}" id="tod" tabindex="3" placeholder="today is like..." />
                            <p id="thought_of_the_day_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <!-- Phone number -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">                            
                            <div class="d-flex">
                                <input oldValue="{{$user->phone}}" name="user-phone" value="{{$user->phone}}" type="number" id="user-phone" readonly tabindex="9" placeholder="(XXX)-XXX-XXXX" required />
                                <button class="edit-email-phone" type="button" id="change-phone-btn" 
                                    onclick="event.preventDefault(); ChangeUserPhone()"
                                    style="display:none;">
                                    Change
                                </button>
                                <button class="edit-email-phone" type="button" id="edit-phone-btn" 
                                    onclick="event.preventDefault(); EditUserPhone()">
                                    Edit
                                </button>
                            </div>
                            <input type="text" id="phone-otp-box" placeholder="Enter OTP" style="display:none;" />
                            <p class="email-message error" id="phone_message"></p>
                            <button class="cancel-button" type="button" id="cancel-edit-phone"
                                onclick="event.preventDefault(); CancelEditPhone($(this))">
                                <span class="cancel-button-text">Cancel</span>
                            </button>
                        </div>
                    </fieldset>
                    <!-- Website URL -->
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="website">Website</label>
                        </div>
                        <div class="grid-65">
                            <input name="website" value="{{$user->website}}" type="text" id="website" tabindex="4" placeholder="www.writeyourday.com" />
                            <p id="website_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <!-- Email -->
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="email">Email <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <div class="d-flex">
                                <input oldValue="{{$user->email}}" type="email" name="user-email" value="{{$user->email}}" id="user-email" tabindex="6" readonly placeholder="contact@writeyourday.com"
                                    required name="user-email" />
                                <button class="edit-email-phone" type="button" id="change-email-btn" 
                                    onclick="event.preventDefault(); ChangeUserEmail()"
                                    style="display:none;">
                                    Change
                                </button>
                                <button class="edit-email-phone" type="button" id="edit-email-btn" 
                                    onclick="event.preventDefault(); EditUserEmail()">
                                    Edit
                                </button>
                            </div>
                            <input type="text" id="email-otp-box" placeholder="Enter OTP" style="display:none;" />
                            <p class="email-message error" id="email_message"></p>
                            <button class="cancel-button" type="button" id="cancel-edit-email"
                                onclick="event.preventDefault(); CancelEditEmail($(this))">
                                <span class="cancel-button-text">Cancel</span>
                            </button>
                        </div>
                    </fieldset>
                    <!-- Gender -->
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="gender">Gender <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <select name="gender" id="gender">
                                <option value="1" @selected($user->gender == 1)>Male</option>
                                <option value="2" @selected($user->gender == 2)>Female</option>
                                <option value="0" @selected($user->gender == 3)>Other</option>
                            </select>
                            <p id="gender_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <!-- Description about User -->
                    <fieldset class="fieldset">
                        <div class="grid-35">
                            <label for="description">Bio <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <textarea name="bio"  id="description" cols="30" rows="auto" tabindex="3" placeholder="Bio"
                                >{{$user->bio}}</textarea>
                                <p id="bio_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>

                    <fieldset class="fieldset">
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" id="update-profile-btn" class="submit-btn" value="Save Profile" />
                            {{-- <button >Save Profile</button> --}}
                            <a class="disable-link">Delete this account</a>
                        </div>
                    </fieldset>
                </form>
            </section>
        </main>

        <!--- Change Password Container --->
        <main class="setting" id="password-settings">
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">Password Settings</h2>
            </div>
            <section class="content">
                <form id="change-pass-form" method="POST" action="{{route('update-password')}}">
                    @csrf
                    <fieldset>
                        <div class="grid-35">
                            <label for="old-password">Old Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="password" name="old_password" id="old-password" placeholder="Password"
                                />
                            <p id="old_password_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="confirm-password">Confirm Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" name="confirm_password" id="confirm-password" tabindex="1" placeholder="Password" />
                            <p id="confirm_password_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label  for="new-password">New Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input name="new_password" type="text" id="new-password" tabindex="1" placeholder="Password" required />
                            <p id="new_password_error" class="error invalid-feedback"></p>
                        </div>
                    </fieldset>
                    <fieldset>
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" id="change-pass-btn"  class="submit-btn" value="Update" />
                        </div>
                    </fieldset>
                </form>
            </section>
        </main>

        <!--- Help Request Container --->
        <main class="setting" id="help">
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
                            <input type="text" name="name" value="{{$user->name}}" id="name" placeholder="Full Name" />
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

        <!--- Block and UnBlock Container --->
        <main class="setting" id="blocked">
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">Blocked Friends</h2>
            </div>
            <section class="content">
                <ul class="blocked_list">
                    <li class="blocked_friend d-flex align-items-center">
                        <div class="blocked_friend_img">
                            <img src="{{ asset('assets/images/profile-img.png') }}" class="img" />
                        </div>
                        <p class="blocked_friend_name">Bridget Marie</p>
                        <button id="unblock_btn">Unblock</button>
                    </li>
                </ul>
            </section>
        </main>

        <!--- Privacy Policy Container --->
        <main class="setting" id="privacy">
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">Privacy Policy</h2>
            </div>
            <section class="content">
                <div>
                    {!! $privacy !!}
                </div>
            </section>
        </main>
    </div>
</div>
<form id="logout-form" action="{{ route('user-delete-request') }}" method="POST" >
    @csrf 
    <div class="overlay hide" id="delete_container">
        <div class="ques_box">
            <p class="ques_txt">Are you sure you want to delete this account? <br> You can still recover your account within the next 14 days</p>
            <div class="d-flex justify-content-between mx-4">
                <input type="hidden" name="password" id="delete-confirm-password">
                <button type="submit" class="ques_btn" id="delete_btn" onclick="proceedDeletion()">
                    Yes
                </button>
                <button type="button" class="ques_btn suggested_btn text-primary" onclick="closeBox()">
                    No
                </button>
            </div>
        </div>
    </div>
</form>


@endsection
@section('js')
<script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>    <!-- endinject -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/edit.js') }}" type="text/javascript"></script>
@endsection