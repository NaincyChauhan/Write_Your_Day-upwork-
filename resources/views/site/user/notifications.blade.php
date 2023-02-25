@extends('layouts.site')
@section('meta')
<title>notifications</title>
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
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min4.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/customstyle.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/notifications.css') }}">
@endsection
@section('content')
<section class="section-50">
    @php
    $user = Auth::user();
    @endphp
    <div class="container">
        <h3 class="m-b-50 heading-line">Notifications <i class="fa fa-bell text-muted"></i></h3>
        <div class="notification-ui_dd-content" id="notification-main-container">
            {{-- Unread Notifications --}}
            {{-- @php
                $user_unreadnotification = $user->unreadNotifications;
            @endphp
            @foreach ( $user_unreadnotification as $notification)
                <div class="notification-list notification-list--unread" id="user_notification_{{$notification->id}}">
                    <div class="notification-list_content">
                        <div class="notification-list_img">
                            <img src="{{asset('storage/users/'.$notification->data['user_image'])}}" alt="user">
                        </div>
                        <a onclick="SetNotificationToRead($(this))" data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}" href="{{$notification->data['link']}}">
                            <div class="notification-list_detail">
                                <p><b>{{$notification->data['user_name']}} </b>{{$notification->data['subject']}}</p>
                                <p class="text-muted">
                                    @if ($notification->data['comment_title'] != "")
                                        <b style="font-size: 15px;">{{$notification->data['comment_title']}}..</b>
                                    @endif
                                    {{$notification->data['desc']}}
                                </p>
                                <p class="text-muted"><small>{{$notification->created_at->diffForHumans()}}</small></p>
                            </div>
                        </a>
                    </div>
                    <div class="notification-list_feature-img">
                        <a onclick="SetNotificationAsRead('{{$notification->id}}',$(this))" data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}"><p class="text-muted"><small>Mark as read</small>
                        </p></a>
                    </div>
                </div>
            @endforeach

            @if ($user_unreadnotification->count() < 10)                
                <div id="user_read_notification_container">
                    @php
                        $user_readnotifications = $user->readNotifications;
                    @endphp
                    @foreach ($user_readnotifications as $notification)
                        <div class="notification-list" id="user_notification_{{$notification->id}}">
                            <div class="notification-list_content">
                                <div class="notification-list_img">
                                    <img src="{{asset('storage/users/'.$notification->data['user_image'])}}" alt="user">
                                </div>
                                <a href="{{$notification->data['link']}}">
                                    <div class="notification-list_detail">
                                        <p><b>{{$notification->data['user_name']}} </b>{{$notification->data['subject']}}</p>
                                        <p class="text-muted">
                                            @if ($notification->data['comment_title'] != "")
                                                <b style="font-size: 15px;">{{$notification->data['comment_title']}}..</b>
                                            @endif
                                            {{$notification->data['desc']}}
                                        </p>
                                        <p class="text-muted"><small>{{$notification->created_at->diffForHumans()}}</small></p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif --}}
            {{-- @foreach ($notifications as $notification)
                @if ($notification->read_at != null)                
                    <div class="notification-list" id="user_notification_{{$notification->id}}">
                        <div class="notification-list_content">
                            <div class="notification-list_img">
                                <img src="{{asset('storage/users/'.$notification->data['user_image'])}}" alt="user">
                            </div>
                            <a href="{{$notification->data['link']}}">
                                <div class="notification-list_detail">
                                    <p><b>{{$notification->data['user_name']}} </b>{{$notification->data['subject']}}</p>
                                    <p class="text-muted">
                                        @if ($notification->data['comment_title'] != "")
                                            <b style="font-size: 15px;">{{$notification->data['comment_title']}}..</b>
                                        @endif
                                        {{$notification->data['desc']}}
                                    </p>
                                    <p class="text-muted"><small>{{$notification->created_at->diffForHumans()}}</small></p>
                                </div>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="notification-list notification-list--unread" id="user_notification_{{$notification->id}}">
                        <div class="notification-list_content">
                            <div class="notification-list_img">
                                <img src="{{asset('storage/users/'.$notification->data['user_image'])}}" alt="user">
                            </div>
                            <a onclick="SetNotificationToRead($(this))" data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}" href="{{$notification->data['link']}}">
                                <div class="notification-list_detail">
                                    <p><b>{{$notification->data['user_name']}} </b>{{$notification->data['subject']}}</p>
                                    <p class="text-muted">
                                        @if ($notification->data['comment_title'] != "")
                                            <b style="font-size: 15px;">{{$notification->data['comment_title']}}..</b>
                                        @endif
                                        {{$notification->data['desc']}}
                                    </p>
                                    <p class="text-muted"><small>{{$notification->created_at->diffForHumans()}}</small></p>
                                </div>
                            </a>
                        </div>
                        <div class="notification-list_feature-img">
                            <a onclick="SetNotificationAsRead('{{$notification->id}}',$(this))" data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}"><p class="text-muted"><small>Mark as read</small>
                            </p></a>
                        </div>
                    </div>
                @endif
            @endforeach --}}
            @include('partial.notifications', ['notifications' => $notifications])
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{asset('assets/js/notifications.js') }}"></script>
<script>
    
function AppendNotifications(data){
    console.log("debbuging2222",data);
    data.forEach(notification => {                    
        console.log("this is user notification is here",notification);
        
    });
}
</script>
@endsection