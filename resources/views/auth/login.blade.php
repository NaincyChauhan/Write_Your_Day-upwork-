<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>

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
</head>

<body>
    <div class="container-fluid">

        <div class="d-flex flex-column flex-sm-row">
            <main>
                <section class="main">
                    <p id="message"></p>
                    <h1 class="title"><i class="fa fa-link"></i> Sign In</h1>
                    <form id="LogInForm" class="form" method="POST" action="{{route('login')}}">
                        @csrf
                        <legend class="legend">
                            <label for="user-email">Email/Username/Phone</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-envelope icon"></i>
                                <input type="text" name="email" id="user-email"
                                    placeholder="Email/Username/Phone">
                            </div>
                            <p id="email_error" class="error"></p>
                        </legend>
                        <legend class="legend">
                            <label for="user-password">Password:</label>
                            <div class="input-group d-flex align-items-center">
                                <i class="fa fa-key icon"></i>
                                <input type="password" class="password" name="password" id="user-password"
                                    placeholder="Password">
                                <i class="fa fa-eye-slash password-toogle"></i>
                            </div>
                            <p id="password_error" class="error"></p>
                        </legend>
                        <p class="forgot"><a href="{{route('forget-password-view')}}">Forgot Password</a></p>

                        <legend class="d-flex flex-column flex-sm-row justify-content-sm-between confirm">
                            <label for="rememberpass"><input type="checkbox" name="remember" id="remeberpass">
                                Remember me</label>
                            <button id="login" type="submit" class="submit">Sign In</button>
                        </legend>
                        <p class="external-link">Don't have an account? <a href="{{route('register')}}">Create one <i
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
                        <img src="{{ asset('assets/images/signin.jpg') }}" alt="login_img" srcset="{{ asset('assets/images/signin.jpg') }}">
                    </div>
                    <h3>Welcome back :)</h3>
                    <p>We really missed you. Just login and let's get connected to enjoy your surfing on our site.</p>

                </div>
            </aside>

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