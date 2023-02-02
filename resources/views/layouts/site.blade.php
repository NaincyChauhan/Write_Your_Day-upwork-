<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home page</title>

    <!-- fonts CSS -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,800;1,400;1,500;1,600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css') }}"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <header class="header bg-white">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light p-0">
                <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="./index.html">write <span>your</span> day ...</a>
                <div class="header-search mbl-search">
                    <div class="dropdown">
                        <span class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                            aria-expanded="false"><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li class="selected"> <i class="fa fa-cab"></i> Friend</li>
                            <li> <i class="fa fa-blog"></i> Post</li>
                        </ul>
                    </div>
                    <div class="enter-search">
                        <input type="text" placeholder="search....">
                    </div>
                    <button>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="14" height="14" role="img">
                            <path
                                d="M13.65 12L10.4 8.75A5.64 5.64 0 0 0 5.66 0a5.67 5.67 0 1 0 3.1 10.4L12 13.66a1.15 1.15 0 0 0 1.64 0 1.16 1.16 0 0 0 0-1.65zM5.66 9.55a3.89 3.89 0 1 1 .01-7.78 3.89 3.89 0 0 1 0 7.78z">
                            </path>
                        </svg>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item search-by">
                            <div class="header-search">
                                <div class="dropdown">
                                    <span class="dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                        aria-expanded="false"><img src="{{ asset('assets/images/dropdown-next.svg') }}"></span>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li class="selected"><i class="fa fa-user-friends side_icon"></i> Friend</li>
                                        <li><i class="fa fa-sticky-note side_icon"></i> Post</li>
                                    </ul>
                                </div>
                                <input type="text" placeholder="search....">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="14" height="14"
                                        role="img">
                                        <path
                                            d="M13.65 12L10.4 8.75A5.64 5.64 0 0 0 5.66 0a5.67 5.67 0 1 0 3.1 10.4L12 13.66a1.15 1.15 0 0 0 1.64 0 1.16 1.16 0 0 0 0-1.65zM5.66 9.55a3.89 3.89 0 1 1 .01-7.78 3.89 3.89 0 0 1 0 7.78z">
                                        </path>
                                    </svg>
                                </button>
                            </div>
                        </li>
                        <li class="nav-item write-btn">
                            <a href="./write-page.html"><span class="header-btn" href="./write-page.html">Write
                                    Now</span></a>
                        </li>
                        <li class="nav-item saved d-lg-none">
                            <a class="header-message-box" href="#">
                                <small> Saved</small>
                            </a>
                        </li>
                        <li class="nav-item messages">
                            <a class="header-message-box" href="./chat.html">
                                <small>Message</small>
                                <span class="header-message d-none" href="#">2</span>
                            </a>
                        </li>
                        <li class="nav-item profile">
                            <a href="./profile.html">
                                <div class="nav-link">
                                    <img class="header-img" src="{{ asset('assets/images/radious-img.png') }}">
                                    <h4>Birget Marrie</h4>

                                </div>
                            </a>
                        </li>
                        <li class="nav-item notifiction">
                            <a href="./Notification.html">
                                <span class="header-notifiction" href="./Notification.html">
                                    <small class="d-block d-lg-none">Notification</small>
                                    <img src="{{ asset('assets/images/bell.png') }}" alt="bell.png') }}">
                                    <p>2</p>
                                </span>
                            </a>
                        </li>
                        <li class="nav-item user-icon">
                            <div class="nav-link">
                                <img class="header-img" src="{{ asset('assets/images/radious-img.png') }}">
                                <h4 class="d-lg-none">Birget Marrie</h4>
                            </div>
                            <ul class="submenu">
                                <li>
                                    <a href="./profile.html">
                                        <img class="header-img" src="{{ asset('assets/images/radious-img.png') }}">
                                        <h4>Birget Marrie</h4>
                                    </a>
                                </li>
                                <li><a href="./edit.html">Settings</a></li>
                                <li><a href="./profile-search.html">Saved</a></li>
                                <li class="logout_link"><a href="#">Logout</a></li>
                            </ul>
                        </li>

                        <li class="nav-item settings d-lg-none">
                            <a class="header-message-box" href="./edit.html">
                                <small>Settings</small>
                            </a>
                        </li>
                        <li class="nav-item logout d-lg-none ">
                            <a class="header-message-box logout_link" href="#">
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
    <div class="logout_container overlay hide">
        <div class="logout_box">
            <p class="logout_ques">Do you really want to leave us :( ?</p>
            <div class="d-flex justify-content-between">
                <button class="logout_btn" id="logout">Yes, I'm sorry</button>
                <button class="logout_btn cancel_btn" id="cancel_logout">No, I'm here</button>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer text-center">
        <div class="container">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/msg_extras.js') }}"></script>
    <script>
        $('.simple-heart').click(function (e) {
            $(this).hide();
        })

        $(function () {
            $('.simple-heart').click(function () {
                $(this).siblings('.red-heart').show('fast')
            })
        })
    </script>
    <script>
        $('.red-heart').click(function (e) {
            $(this).hide();
        })

        $(function () {
            $('.red-heart').click(function () {
                $(this).siblings('.simple-heart').show('fast')
            })
        })
    </script>
    <script>
        $('.dropdown-toggle').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).closest('.search-dropdown').toggleClass('open');
        });

        $('.dropdown-menu > li > a').click(function (e) {
            e.preventDefault();
            var clicked = $(this);
            clicked.closest('.dropdown-menu').find('.menu-active').removeClass('menu-active');
            clicked.parent('li').addClass('menu-active');
            clicked.closest('.search-dropdown').find('.toggle-active').html(clicked.html());
        });
    </script>
    <script>
        // $(document).ready(function () {
        /* Search bar */

        var resizeElements;

        $(document).ready(function () {

            // Set up common variables
            // --------------------------------------------------

            var bar = ".search_bar";
            var input = bar + " input[type='text']";
            var button = bar + " button[type='submit']";
            var dropdown = bar + " .search_dropdown";
            var dropdownLabel = dropdown + " > span";
            var dropdownList = dropdown + " ul";
            var dropdownListItems = dropdownList + " li";


            // Set up common functions
            // --------------------------------------------------

            resizeElements = function () {
                var barWidth = $(bar).outerWidth();

                var labelWidth = $(dropdownLabel).outerWidth();
                $(dropdown).width(labelWidth);

                var dropdownWidth = $(dropdown).outerWidth();
                var buttonWidth = $(button).outerWidth();
                var inputWidth = barWidth - dropdownWidth - buttonWidth;
                var inputWidthPercent = inputWidth / barWidth * 100 + "%";

                $(input).css({
                    'margin-left': dropdownWidth,
                    'width': inputWidthPercent
                });
            }

            function dropdownOn() {
                $(dropdownList).fadeIn(25);
                $(dropdown).addClass("active");
            }

            function dropdownOff() {
                $(dropdownList).fadeOut(25);
                $(dropdown).removeClass("active");
            }


            // Initialize initial resize of initial elements
            // --------------------------------------------------
            resizeElements();


            // Toggle new dropdown menu on click
            // --------------------------------------------------

            $(dropdown).click(function (event) {
                if ($(dropdown).hasClass("active")) {
                    dropdownOff();
                } else {
                    dropdownOn();
                }

                event.stopPropagation();
                return false;
            });

            $("html").click(dropdownOff);


            // Activate new dropdown option and show tray if applicable
            // --------------------------------------------------

            $(dropdownListItems).click(function () {
                $(this).siblings("li.selected").removeClass("selected");
                $(this).addClass("selected");

                // Focus the input
                $(this).parents("form.search_bar:first").find("input[type=text]").focus();

                var labelText = $(this).text();
                $(dropdownLabel).text(labelText);

                resizeElements();

            });


            // Resize all elements when the window resizes
            // --------------------------------------------------

            $(window).resize(function () {
                resizeElements();
            });

        });
        // });
    </script>
</body>

</html>