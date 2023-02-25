@foreach ($notifications as $notification)
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
                <a onclick="SetNotificationToRead($(this))"
                    data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}"
                    href="{{$notification->data['link']}}">
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
                <a onclick="SetNotificationAsRead('{{$notification->id}}',$(this))"
                    data-url="{{ route('notifications-mark-as-read', ['id' => $notification->id]) }}">
                    <p class="text-muted"><small>Mark as read</small>
                    </p>
                </a>
            </div>
        </div>
    @endif
@endforeach