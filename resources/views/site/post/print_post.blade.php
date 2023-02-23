<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
</head>

<body>
    <section class="preview">
        <div class="container">
            <div class="row">
                <div class="col-12" id="post-detail-main-container">
                    <div class="preview-custmor-detail">
                        <div class="preview-custmor-detail-img d-flex justify-content-center">
                            <a href="{{route('search-user-profile',['username'=>$post->user->username])}}">
                                <div class="user-photo-post">
                                    <img class="w-100 h-auto  rounded-0" style="border-radius: 0px;" src="{{ isset($post->user->image) ? asset('storage/users/'.$post->user->image) : asset('assets/images/images.png') }}">
                                </div>
                            </a>
                        </div>
                        <div class="profile-info">
                            <h4>By: {{$post->user->name}}</h4>                            
                        </div>
                    </div>
                    <div class="review-detail ">
                        <ul class="date_time d-flex ">
                            <li>
                                <p><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}</p>
                            </li>
                        </ul>
                        <h4>{{$post->title}}</h4>
                    </div>
                    <div class="review-detail-content">
                        {!! $post->desc !!}
                        <!-- Posst view,like,share and comment -->
                        <div class="review-detail-content-view">
                            <ul class="like_comment d-flex justify-content-between align-items-center mt-0">
                                <li>
                                    <small><img src="{{ asset('assets/images/eye.png') }}"><span><span>{{$post->views()->count()}}</span> Views</span></small>
                                </li>
                                <li>
                                    <a class="heart">
                                        <img class="simple-heart" src="{{ asset('assets/images/heart.png') }}">
                                        <span><span class="post_like_count">{{$post->likes()->count()}}</span> Likes</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="">
                                        <img src="{{ asset('assets/images/share.png') }}">
                                        <span><span class="share_count">{{$post->shares()->count()}}</span> Shares</span> 
                                    </a>
                                </li>
                                <li>
                                    <a><img src="{{ asset('assets/images/messsage.png') }}"><span><span>{{$post->comments()->count()}}</span> Comments</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="footer text-center">
        <div class="container">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>