<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>

    <!-- fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,800;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="shortcut icon" href="{{ asset('assets/images/1.png') }}" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
</head>

<body>
    <div class="container-fluid">

        <div class="d-flex flex-column flex-sm-row">
            <main>
                <section class="main">
                    <p id="message" class="text-center"></p>
                    <h1 class="title"><i class="fa fa-link"></i> Sign Up</h1>
                    <form class="form" id="registerform" method="POST" action="{{route('registeruser')}}">
                        @csrf
                        <legend class="legend">
                            <label for="user-email">Email:</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-envelope icon"></i>
                                <input type="email" maxlength="50" minlength="10" name="email" id="user-email"
                                    placeholder="youremail@address.aim" />
                            </div>
                            <p id="email_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="user-tel">Phone Number:</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-phone-alt icon"></i>
                                <input type="number" name="phone" id="user-tel" pattern="[0-9]{10}"
                                    placeholder="1234567890" />
                            </div>
                            <p id="phone_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="name">Full Name:</label>
                            <div class="input-group d-flex">
                                <i class="fa fa-user-alt icon"></i>
                                <input type="text" maxlength="20" name="name" id="name" placeholder="John Joe" />
                            </div>
                            <p id="name_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="username">Username:</label>
                            <div class="input-group d-flex">
                                <i class="fa fa-user-plus icon"></i>
                                <input type="text"  pattern=[a-z] maxlength="20" required name="username" id="username" placeholder="@Jonny" />
                            </div>
                            <p id="username_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="name">Date Of Birth:</label>
                            <div class="input-group d-flex">
                                <i class="fas fa-calendar-check icon"></i>
                                <input type="date" name="dob" id="DOB" pattern="dd/mm/yy" />
                            </div>
                            <p id="dob_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="user-password">Password:</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-key icon"></i>
                                <input autocomplete="true" type="password" name="password" class="password" id="user-password"
                                    placeholder="Password" />
                                <i class="fa fa-eye-slash password-toogle"></i>
                            </div>
                            <p id="password_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="confirm-password">Confirm Password:</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-key-skeleton icon"></i>
                                <input type="password" class="password" name="password_confirmation" id="confirm-password"
                                    placeholder="Confirm Password" />
                                <i class="fa fa-eye-slash password-toogle"></i>
                            </div>
                            <p id="password_confirmation_error" class="error"></p>
                        </legend>
                        <hr>
                        <legend class="legend verify" id="verify-otp" style="display: none;">
                            <label for="user-otp">OTP:</label>
                            <div class="input-group d-flex justify-content-end">
                                <i class="fa fa-envelope icon"></i>
                                <input type="text" name="otp" maxlength="6" id="user-otp"
                                    placeholder="Enter OTP" />
                                <button class="code_btn" type="button" id="send_otp" onclick="event.preventDefault(); resendOTP($('#registerBtn'), 0)"><span id="code_btn_txt">Resend OTP</span> <span id="countdown"></span></button>
                            </div>
                        </legend>

                        <legend class="d-flex flex-column flex-sm-row justify-content-sm-between confirm legend">
                            <label for="agreement"><input required type="checkbox" name="privacypolicy" id="agreement" />
                                I agree to the <span class="privacy_link">Privacy Policy</span></label>
                                <br>
                            <p id="privacypolicy_error" class="error"></p>
                        </legend>
                        <legend class="d-flex justify-content-end">
                            <button id="registerBtn" type="submit" class="submit">Sign Up</button>
                        </legend>
                        
                        <p class="external-link">Already have an account? <a href="{{route('login')}}">Login <i
                                    class="fa fa-external-link-alt"></i></a></p>
                    </form>
                </section>
            </main>
            <div class="alert hide"></div>
            <aside class="d-flex flex-column justify-content-center align-items-center">
                <nav>
                    <p class="navbar-brand" href="{{route('home')}}">write <span>your</span> day ...</p>
                </nav>
                <div>
                    <div class="login_img">
                        <img src="{{asset('assets/images/signup.jpg')}}" alt="login_img" srcset="{{asset('assets/images/signup.jpg')}}">
                    </div>
                    <h3>Hi! You seem new.</h3>
                    <p>Quickly signup to our site to know more about us and start enjoing your surfing.</p>

                </div>
            </aside>

        </div>
    </div>

    <div class="overlay hide privacy_container">
        <div class="privacy_box">
            <h3 class="title">Privacy Policy</h3>
            <div class="content">
                Privacy Policy Descripation
            </div>
            <button class="cancel_btn">Close</button>
        </div>
    </div>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/js/swal.min.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/register.js') }}"></script>
    <script src="{{ asset('assets/js/messages.js') }}"></script>
</body>

</html>