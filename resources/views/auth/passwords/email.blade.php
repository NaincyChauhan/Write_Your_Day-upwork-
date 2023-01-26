<html lang="en" class="" style="height: auto;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forget Password {{ env('APP_NAME') }}</title>
    <!-- fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,800;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="shortcut icon" href="{{ asset('assets/images/1.png') }}"" type="image/x-icon">

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
                    <h1 class="title"><i class="fa fa-link"></i> Password Recovery</h1>
                    <form class="form" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <fieldset class="verify">
                            <legend>
                                <label for="user-email">Email:</label>
                                <div class="input-group d-flex align-items-center">
                                    <i class="fa fa-envelope icon"></i>
                                    <input type="email" name="email" value="{{old('email')}}" id="user-email"
                                        placeholder="youremail@address.aim">
                                </div>
                                @if($errors->has('email'))
                                    <p id="email_error" class="error">{{ $errors->first('email') }}</p>
                                @endif
                            </legend>
    
                            <legend
                            class="d-flex hide justify-content-end flex-column flex-sm-row justify-content-sm-between confirm">
                            <button type="submit" class="submit">Send Request </button>
                        </legend>
                        </fieldset>
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
                        <img src="{{ asset('assets/images/password-r.jpg" alt="login_img') }}" srcset="{{ asset('assets/images/password-r.jpg') }}">
                    </div>
                    <h3>Forgot your Password?</h3>
                    <p>No need to worry. We've got your back. Set a new one in a jiffy and get online.</p>

                </div>
            </aside>

        </div>
    </div>
    <script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('app-assets/js/swal.min.js') }}"></script>
    <script src="{{ asset('assets/js/messages.js') }}"></script>
    {{-- Error Script --}}
    <script>
        $(function () {
            @if (!empty(Session:: get('success')))
                ajaxMessage(1, "{{Session::get('success')}}");
            @endif
            @if (!empty(Session:: get('status')))
                ajaxMessage(1, "{{Session::get('status')}}");
            @endif

            @if (!empty(Session:: get('error')))
                ajaxMessage(0, "{{Session::get('error')}}");
            @endif

            @if ($errors -> any())                
                ajaxMessage(0, "@foreach($errors->all() as $error) * {{ $error }} \n @endforeach");
            @endif
        });
    </script>
</body>

</html>
