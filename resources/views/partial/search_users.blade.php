@foreach ($users as $user)
<div class="serch-profile-box">
            <a href="{{route('search-user-profile',['username'=>$user->username])}}">
            <div class="serch-profile-box-img">
                <div class="search-user-image">
                    <img class="w-100 h-auto  rounded-0" src="{{ isset($user->image) ? asset('storage/users/'.$user->image) : asset('assets/images/images.png') }}">
                </div>
            </div>
        </a>
            <div class="serch-profile-box-content">
                <a href="{{route('search-user-profile',['username'=>$user->username])}}">
                    <h4>{{$user->name}}</h4>
                    <h6 class="text-secondary mt-1">{{$user->username}}</h6>
                </a>
                @php
                    $is_following  = Auth::user()->following()->where('following_user_id', $user->id)->exists();
                @endphp
                <p class="followers">Followers : <span>{{$user->followers()->count()}}</span></p>
                <p>{{$user->bio}}</p>
            </div>
            <div class="serch-profile-box-button mla">
                <button onclick="FollowUnFollowRequest({{$user->id}},$(this));" class="main_btn">
                    {{$is_following == false ? 'Follow' : 'Following'}}
                </button>
            </div>
        </div>            
    <form action="{{route('follow-unfollow-user')}}" id="follow_unfollow_user_form_{{$user->id}}" method="POST">
        @csrf
        <input type="hidden" name="username" value="{{$user->username}}">
    </form>
@endforeach