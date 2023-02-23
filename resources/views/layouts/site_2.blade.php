<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('meta')
    <!-- fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,800;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    @yield('css')
    <style>
        #session_message_area{
            width: calc(100% - 25%) !important;            
        }
        #session_message_box_area{
            display: flex;
            justify-content: center;           
        }
        /* Tooltip container */
        #tooltip {
            position: relative;
            display: inline-block;
        }

        /* Tooltip text */
        #tooltip .tooltiptext {
            visibility: hidden;
            background-color: #4285f4;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            padding: 5px 14px;
            margin: -5px 0px 0px 5px;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        #tooltip:hover .tooltiptext {
            visibility: visible;    
        }

        #user-header-image{
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
        }
        #user-header-image > .header-img-1{
            max-width: 100%;
            height: auto;
            cursor: pointer;
        }
    </style>
</head>

<body>
    @php
        $logged_user = Auth::user();
        $name =  $logged_user->name;
        $image =  $logged_user->image;
    @endphp
    <header class="header bg-white">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{route('suspend_user_home')}}">write <span>your</span> day ...</a>
                <form action="" method="GET">
                    <div class="header-search mbl-search">
                        <div class="dropdown">
                            <span class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                aria-expanded="false"><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                            <ul class="dropdown-menu search-type" name="type" aria-labelledby="dropdownMenuButton1">
                                <li class="search_type_ selected" value="1"> <i class="fa fa-cab"></i> Friend</li>
                                <li class="search_type_" value="2"> <i class="fa fa-blog"></i> Post</li>
                            </ul>
                        </div>
                        <input type="hidden" name="type" class="search_type_input">
                        <div class="enter-search">
                            <input disabled name="search" required type="text" placeholder="search....">
                        </div>
                        <button disabled type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="14" height="14" role="img">
                                <path
                                    d="M13.65 12L10.4 8.75A5.64 5.64 0 0 0 5.66 0a5.67 5.67 0 1 0 3.1 10.4L12 13.66a1.15 1.15 0 0 0 1.64 0 1.16 1.16 0 0 0 0-1.65zM5.66 9.55a3.89 3.89 0 1 1 .01-7.78 3.89 3.89 0 0 1 0 7.78z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item search-by">                            
                            <form action="" method="GET">
                                <div class="header-search">
                                    <div class="dropdown">
                                        <span class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                            aria-expanded="false"><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                                        <ul class="dropdown-menu search-type" name="type" aria-labelledby="dropdownMenuButton1">
                                            <li class="search_type_" value="1"><i class="fa fa-user-friends side_icon"></i> Friend</li>
                                            <li class="search_type_ selected" value="2" ><i class="fa fa-sticky-note side_icon"></i> Post</li>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="type" class="search_type_input-1">
                                    <input disabled name="search" id="search_query" required type="text" placeholder="search....">
                                    <button disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="14" height="14"
                                            role="img">
                                            <path
                                                d="M13.65 12L10.4 8.75A5.64 5.64 0 0 0 5.66 0a5.67 5.67 0 1 0 3.1 10.4L12 13.66a1.15 1.15 0 0 0 1.64 0 1.16 1.16 0 0 0 0-1.65zM5.66 9.55a3.89 3.89 0 1 1 .01-7.78 3.89 3.89 0 0 1 0 7.78z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </li>
                        <li class="nav-item write-btn">
                            <a disabled><span class="header-btn" >Write
                                    Now</span></a>
                        </li>
                        <li class="nav-item saved d-lg-none">
                            <a disabled class="header-message-box">
                                <small> Saved</small>
                            </a>
                        </li>
                        <li class="nav-item messages">
                            <a class="header-message-box" disabled>
                                <small>Message</small>
                                <span class="header-message d-none">2</span>
                            </a>
                        </li>
                        <li class="nav-item profile">
                            <a disabled>
                                <div class="nav-link">
                                    <div  id="user-header-image" >
                                        <img disabled class="header-img-1" src="{{ isset($image) ? asset('storage/users/'.$image) : asset('assets/images/images.png') }}">
                                    </div>
                                    <h4>{!! Str::limit($name, 6, ' ...') !!}</h4>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item notifiction">
                            <a disabled>
                                <span class="header-notifiction" href="{{route('home')}}">
                                    <small class="d-block d-lg-none">Notification</small>
                                    <img src="{{ asset('assets/images/bell.png') }}" alt="bell.png">
                                    <p>2</p>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item user-icon">
                            <div class="nav-link">
                                <div id="user-header-image">                                    
                                    <img disabled class="header-img-1" src="{{ isset($image) ? asset('storage/users/'.$image) : asset('assets/images/images.png') }}">
                                </div>
                                <h4 class="d-lg-none user-name">{!! Str::limit($name, 6, ' ...') !!}</h4>
                            </div>
                        </li>

                        <li class="nav-item settings d-lg-none">
                            <a disabled class="header-message-box">
                                <small>Settings</small>
                            </a>
                        </li>
                        <li class="nav-item logout d-lg-none ">
                            <a disabled class="header-message-box logout_link">
                                <small>Logout</small>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    @yield('content')

    {{-- Logout Modal --}}
    <form id="logout-form" action="{{ url('logout') }}" method="POST" >
        @csrf 
        <div class="overlay hide logout_container">
            <div class="ques_box">
              <p class="ques_txt text-white">Do you really want to leave us :( ?</p>
              <div class="d-flex justify-content-around">
                <button type="submit" class="ques_btn" id="logout">Yes, I'm sorry</button>
                <button type="button" onclick="$('.overlay').hide();" class="ques_btn cancel_btn" id="cancel_logout">
                  No, I'm here
                </button>
                {{-- <button type="button" onclick="$('.overlay').hide();"  class="ques_btn" id="">Yes, I'm sorry</button> --}}
              </div>
            </div>
          </div>
    </form>
    
    {{-- Footer --}}
    <div class="footer text-center">
        <div class="container">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/custom.js') }}"></script>
    @yield('js')
    <script>
        $(function () {
            @if (!empty(Session:: get('success')))                
                $('#session_message_area').html(
                    `<div class="alert alert-success alert-dismissible fade show mb-0" role="alert">
                                <span id="success-message">${"{{Session::get('success')}}"}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                );
                window.scrollTo(0, 0);
                setTimeout(() => {
                    $('#session_message_area').html("")
                }, 5000);
            @endif

            @if (!empty(Session:: get('error')))
                $('#session_message_area').html(
                        `<div class="alert alert-danger alert-dismissible fade show mb-0"  role="alert">
                                    <span id="success-message">${"{{Session::get('error')}}"}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                    );
                window.scrollTo(0, 0);
                setTimeout(() => {
                    $('#session_message_area').html("")
                }, 5000);
            @endif

            @if ($errors -> any())                
                $('#session_message_area').html(
                    `<div class="alert alert-error alert-dismissible fade show mb-0" role="alert">
                                <span id="success-message">${"@foreach($errors->all() as $error) * {{ $error }} \n @endforeach"}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>`
                );
                window.scrollTo(0, 0);
                setTimeout(() => {
                    $('#session_message_area').html("")
                }, 5000);
            @endif
        });   
    </script>
    <script>
        $(document).ready(function() {
            $(".search-type li").click(function() {
                // Code to be executed when li is clicked
                $('.search_type_').each(function (index,element) {
                    $(element).removeClass('selected');
                })
                $(this).addClass('selected')
                $('.search_type_input').val($(this).val());
                $('.search_type_input-1').val($(this).val());
            });
        });
    </script>
</body>

</html>