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
    <div class="wrapper d-md-flex">
        <!--- User Profile Links --->
        <aside class="categories hide">
            <button class="fa fa-times close-categories-btn sm-btn"></button>
            <div class="user-info">
                <div class="user-photo">
                    <img src="{{ asset('assets/images/images.png') }}" class="photo img-fluid" />
                </div>
                <div class="user-details">
                    <h3 class="user">Steve Junior</h3>
                    <p class="username">@stevejunior</p>
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
            <div class="setting-head align-items-center mb-4 px-2">
                <button class="open-categories-btn fa fa-list-dots sm-btn"></button>
                <h2 class="title">My Profile</h2>
            </div>
            <section class="content">
                <form id="edit-profile-form" method="POST" action="{{route('edit-profile')}}" enctype="multipart/form-data">
                    <fieldset>
                        <div class="grid-35">
                            <label for="setting-pic">Profile Picture <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="file" name="setting-pic" id="setting-pic" required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="fname">Name <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="fname" tabindex="1" placeholder="First Name" required />
                        </div>
                    </fieldset>

                    <fieldset>
                        <div class="grid-35">
                            <label for="uname">Username <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="uname" tabindex="2" placeholder="username" required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="uname">Thought of the Day <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="tod" tabindex="3" placeholder="today is like..." required />
                        </div>
                    </fieldset>
                    <!-- Phone number -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <div class="d-flex">
                                <input type="text" id="phone" tabindex="9" placeholder="(XXX)-XXX-XXXX" required />
                                <button class="edit-email-phone" type="button" id="edit-phone-btn" >
                                    Edit
                                </button>
                            </div>
                            {{-- <input type="text" id="phone-otp" placeholder="Enter OTP" required /> --}}
                        </div>
                    </fieldset>
                    <!-- Website URL -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="website">Website</label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="website" tabindex="4" placeholder="www.writeyourday.com" />
                        </div>
                    </fieldset>
                    <!-- Email -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="email">Email <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <div class="d-flex">
                                <input type="email" id="user-email" tabindex="6" placeholder="contact@writeyourday.com"
                                    required name="user-email" />
                                <button class="edit-email-phone" type="button" id="edit-email-btn" 
                                    onclick="event.preventDefault(); ChangeUserEmail()">
                                    Edit
                                </button>
                            </div>
                            <input type="text" id="email-otp-box" placeholder="Enter OTP" style="display:none;" />
                            <p class="email-message error" id="email_message"></p>
                        </div>
                    </fieldset>
                    <!-- Gender -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="gender">Gender <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <select name="gender" id="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </fieldset>
                    <!-- Description about User -->
                    <fieldset>
                        <div class="grid-35">
                            <label for="description">Bio <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <textarea name="" id="description" cols="30" rows="auto" tabindex="3" placeholder="Bio"
                                required></textarea>
                        </div>
                    </fieldset>

                    <fieldset>
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" class="submit-btn" value="Save Profile" />
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
                <form action="">
                    <fieldset>
                        <div class="grid-35">
                            <label for="old-password">Old Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="password" name="old-password" id="old-password" placeholder="Password"
                                required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="confirm-password">Confirm Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="confirm-password" tabindex="1" placeholder="Password" required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="new-password">New Password <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="new-password" tabindex="1" placeholder="Password" required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" class="submit-btn" value="Update" />
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
                <form action="">
                    <fieldset>
                        <div class="grid-35">
                            <label for="name">Name <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" name="name" id="name" placeholder="Username" required />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="confirm-password-help">Email Id <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <input type="text" id="confirm-password-help" tabindex="1" placeholder="Password"
                                required />                            
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="phone">Phone Number (optional)</label>
                        </div>
                        <div class="grid-65">
                            <input type="number" id="phone" tabindex="1" placeholder="Phone" />
                        </div>
                    </fieldset>
                    <fieldset>
                        <div class="grid-35">
                            <label for="message">Message <span class="required">*</span></label>
                        </div>
                        <div class="grid-65">
                            <textarea id="message" tabindex="1" placeholder="Write your message" required></textarea>
                        </div>
                    </fieldset>

                    <fieldset>
                        <!-- <input type="button" class="Btn cancel" value="Cancel" /> -->
                        <div class="d-flex justify-content-start align-items-center text-center btns">
                            <input type="submit" class="submit-btn" value="Send" />
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
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
                <div>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint illo
                    ut nihil aspernatur perspiciatis distinctio. Perspiciatis
                    doloremque, earum porro tempora, quis sunt deleniti saepe optio
                    aliquid magni libero sapiente ab? Lorem ipsum dolor sit amet
                    consectetur adipisicing elit. Sint illo ut nihil aspernatur
                    perspiciatis distinctio. Perspiciatis doloremque, earum porro
                    tempora, quis sunt deleniti saepe optio aliquid magni libero
                    sapiente ab? Lorem ipsum dolor sit amet consectetur adipisicing
                    elit. Sint illo ut nihil aspernatur perspiciatis distinctio.
                    Perspiciatis doloremque, earum porro tempora, quis sunt deleniti
                    saepe optio aliquid magni libero sapiente ab?
                </div>
            </section>
        </main>
    </div>
</div>
<div class="overlay hide logout_container">
    <div class="ques_box">
        <p class="ques_txt">Do you really want to leave us :( ?</p>
        <div class="d-flex justify-content-between">
            <button class="ques_btn" id="logout">Yes, I'm sorry</button>
            <button class="ques_btn cancel_btn" id="cancel_logout">
                No, I'm here
            </button>
        </div>
    </div>
</div>
<div class="overlay hide" id="delete_container">
    <div class="ques_box">
        <p class="ques_txt">Are you sure you want to delete this account?</p>
        <div class="d-flex justify-content-between mx-4">
            <button class="ques_btn" id="delete_btn" onclick="proceedDeletion()">
                Yes
            </button>
            <button class="ques_btn suggested_btn" onclick="closeBox()">
                No
            </button>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="{{ asset('assets/js/edit.js') }}" type="text/javascript"></script>
@endsection