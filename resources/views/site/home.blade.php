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

{{-- Box Group --}}
<section class="box_group">
    <div class="container">
        <!-- <------- main Li --------->
      
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
        <ul class="msg_box mb-3 mb-sm-5">
            <li class="msg_extras_container d-flex align-items-center">
                <a class="heart">
                    <img class="simple-heart" src="{{ asset('assets/images/bookmark.png') }}">
                    <img class="red-heart" src="{{ asset('assets/images/bookmark-blue.png') }}">
                </a>
                <button class="msg_extras_btn d-flex flex-column">
                    <span class="caret"></span>
                    <span class="caret"></span>
                    <span class="caret"></span>
                </button>
                <ul class="msg_extras_list d-flex flex-column hide">
                    <li class="msg_extra p-1 px-3 pt-2"><i class="fa fa-eye-slash side_icon"></i> Hide</li>
                    <li class="msg_extra p-1 px-3 report"><i class="fa fa-user-alt-slash side_icon"></i> Report</li>
                    <li class="msg_extra p-1 px-3 pb-2"><i class="fa fa-times-circle side_icon"></i> Cancel</li>
                </ul>
            </li>
            <li class="days-ago">
                <p>5<sup>th</sup><br>day</p>
            </li>
            <li class="row align-items-center">
                <div class="col-lg-3 mb-3 mb-lg-0 pe-lg-0">
                    <div class="left_part">
                        <div class="radious_img">
                            <img src="{{ asset('assets/images/radious-img.png') }}">
                            <h4 class="post_owner"><a href="./friendprofile.html">Birget Marrie</a></h4>
                            <p>Followers:1000</p>
                        </div>
                        <div class="content_part">
                            <button class="main_btn follow_btn">Follow</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 ">
                    <div class="right_part">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>10:00 AM - 20 feb, 2020 - Las Vegas, USA</p>
                            </li>
                        </ul>
                        <h3><a href="./friendprofile.html">Loretm Ipsum is simply dummy text of the printing</a></h3>
                        <p>
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                            has been the industry's standard dummy text ever since the 1500s, when an unknown
                            printer took a galley of type and scrambled it to make a type specimen book. It has
                            survived not centuries,Lorem Ipsum is simply dummy Lorem Ipsum is simply dummy text.
                        </p>

                        <ul class="like_comment d-flex justify-content-md-between align-items-center ">
                            <li>
                                <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>1000</span> Views</span></small>
                                <a class="heart">
                                    <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                    <img class="red-heart" src="{{ asset('assets/images/red-heart.png') }}">
                                    <span><span>1000</span> Likes</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/messsage.png') }}"><span><span>1000</span> Comments</span>
                                </a>
                                <a href="#"><img src="{{ asset('assets/images/share.png') }}"><span><span>1000</span> Shares</span> </a>
                            </li>

                        </ul>
                    </div>
                </div>
            </li>
            
        </ul>
    </div>
</section>

{{-- <form id="logout-form" action="{{ url('logout') }}" method="POST" >
    @csrf 
    <div class="overlay hide logout_container">
        <div class="ques_box">
          <p class="ques_txt">Do you really want to leave us :( ?</p>
          <div class="d-flex justify-content-between">
            <button type="submit" class="ques_btn" id="logout">Yes, I'm sorry</button>
            <button type="button" onclick="$('.logout_container').hide();" class="ques_btn cancel_btn" id="cancel_logout">
              No, I'm here
            </button>
          </div>
        </div>
      </div>
</form> --}}
@endsection