@extends('layouts.site')
@section('meta')
<title>Edit Day</title>

<meta name="title" content="{{ config('app.name') }}" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="all" />

<meta property="og:site_name" content="{{ config('app.name') }}" />
<meta property="og:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
<meta property="og:image:width" content="180" />
<meta property="og:image:height" content="50" />

<meta property="og:type" content=website />
<meta property="og:title" content="{{ config('app.name') }}" />
<meta property="og:description" content="" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:site" content="idigitalgroups.com" />
<meta name="twitter:title" content="{{ config('app.name') }}" />
<meta name="twitter:description" content="" />
<meta name="twitter:image" content="{{ asset('storage/products/writeyourday.jpeg') }}" />
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('assets/css/snippet.css') }}" type="text/css" data-cke="true">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/css/write-page.css') }}">
@endsection
@section('content')
<!---- Write Post Section ---->
<section class="write-page-outer">
    <div class="container">
        <div>
        </div>
        <div class="row">
            <div class="col-12">
                    <form id="create-post-form" action="{{route('update-post-view',['type'=>$post->type,'id'=>$post->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="write-page-btn">
                            <button type="button" class="preview-btn">Preview</button>
                            <div class="d-flex dropdown-toggle-1">
                                <button class="my_drop_down_button" type="submit" id="main-edit-form-btn">
                                    <span>
                                        @if ($post->type==0)
                                            Public
                                        @elseif($post->type==1)
                                            Private
                                        @else
                                            Draft
                                        @endif
                                    </span>
                                </button>  
                                <div class="dropdown">
                                    <div class="dropdown-toggle">                                
                                        <button class="my_drop_down_button" type="button">
                                            <img width="15" height="15"  id="dropdownMenuButton1" onclick="$('#type-dropdown-menu').toggleClass('show');" src="{{asset('assets/images/next-white.png') }}">
                                        </button>
                                    </div>
                                    <ul class="dropdown-menu" id="type-dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item post-type-button {{$post->type==0 ? 'selected' : ''}}"  type-string="Public"  type-value="0" href="#">Public</a></li>
                                        <li><a class="dropdown-item post-type-button {{$post->type==1 ? 'selected' : ''}}"  type-string="Private" type-value="1" href="#">Private</a></li>
                                        <li><a class="dropdown-item post-type-button {{$post->type==2 ? 'selected' : ''}}" type-string="Draft" type-value="2" href="#">Draft</a></li>
                                    </ul>
                                </div>  
                            </div>
                        </div>
                        <input type="hidden" name="type" id="inputType" value="{{$post->type}}">
                        <h4>Type your day title <span class="required">*</span></h4>
                        <div class="write-page-title-outer">
                            <div class="write-page-title">
                                <ul class="date_time d-flex ">
                                    <li><p id="preview-time" class="date-time-text-edit"><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}</p></li>
                                </ul>
                                <textarea minlength="30" name="title" rows="1" maxlength="55" placeholder="Type your title" id="blog-title">{{$post->title}}</textarea>
                                <span id="title_max_length">55 Charcter</span>
                            </div>
                            <div id="title_error" class="text-danger d-block">
                            </div>
                        </div>
                        <div class="write-page-title-editor">
                            <h4>Type your day description <span class="required">*</span></h4>
                            <textarea minlength="30" class="w-100 ckeditor-placeholder" cols="0" id="toolbar-grouping" name="desc" rows="0">
                                {!! $post->desc !!}
                            </textarea>
                            <div id="demo-word-count" class="word-count">
                            </div>
                            <div id="desc_error" class="text-danger d-block">
                            </div>
                        </div>
                    </form>
                    <div class="post-preview">
                        <h4>Post Preview</h4>
                    </div>
                    <div class="box_group">
                        <ul class="msg_box mb-3 mb-sm-5">
                            <li class="days-ago">
                                <p>
                                    @if ($post->type==0)
                                    @if ($post->post_number==1)
                                    {{$post->post_number}}
                                    <sup>st</sup>
                                    @elseif ($post->post_number==2)    
                                    {{$post->post_number}}
                                    <sup>nd</sup>
                                    @elseif ($post->post_number==3)    
                                    {{$post->post_number}}
                                    <sup>rd</sup>
                                    @else
                                    {{$post->post_number}}
                                    <sup>th</sup>
                                    @endif
                                    @else
                                    Your
                                    @endif
                                <br />day</p>
                            </li>
                            <li class="row align-items-center">
                                <div class="col-lg-12">
                                    <div class="msg_extras_container d-flex">
                                        <a class="heart">
                                            <img class="simple-heart" src="{{asset('assets/images/bookmark.png')}}" />
                                            <img class="red-heart" src="{{asset('assets/images/bookmark-blue.png')}}" />
                                        </a>
                                        <button type="button" class="msg_extras_btn d-flex flex-column">
                                            <span class="caret"></span>
                                            <span class="caret"></span>
                                            <span class="caret"></span>
                                        </button>
                                    </div>
                                    <div class="right_part">
                                        <ul class="date_time d-flex">
                                            <li>
                                                <p>
                                                    <i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}
                                                </p>
                                            </li>
                                        </ul>
                                        <h3>
                                            <a id="post-title-preview">{{isset($post->seo_title) ? $post->seo_title : "Write Your Today's Day Title"}}</a>
                                        </h3>
                                        <p id="post-preview-desc-text">{{isset($post->meta_desc) ? $post->meta_desc : "Write Your Day Custom Description"}}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <form id="save-meta-data-form" action="{{route('store-post-meta-data',['type'=>$post->type,'id'=>$post->id])}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="write-page-input-box">
                            <div class="write-page-input">
                                <label>SEO TITLE</label>
                                <input minlength="30" value="{{$post->seo_title}}" type="text" maxlength="55" name="seo_title"  id="seo_title">
                                <div id="seo_title_error" class="text-danger d-block">
                                </div>
                            </div>
                            <div class="write-page-input">
                                <label>SLUG URL</label>
                                <input value="{{$post->slug_url}}" readonly type="text" maxlength="55" id="slug_url">
                                <div id="slug_url_error" class="text-danger d-block">
                                </div>
                            </div>
                            <div>
                                <div class="write-page-input">
                                    <label>Meta description </label>
                                    <textarea minlength="60" id="meta_desc"  name="meta_desc" maxlength="165">{{$post->meta_desc}}</textarea>
                                    <span id="meta_desc_max_length">165 charcter</span>
                                </div>
                                <div id="meta_desc_error" class="text-danger d-block">
                                </div>
                            </div>
                            <button type="submit" id="save-meta-data-btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        
    </div>
</section>

<!---- Preview Post Section ---->
<section class="preview-modal">
    <div class="content-container">
        <div class="preview-modal-content">
            <div class="preview-custmor-detail">
                <div class="preview-custmor-detail-img">
                    <img class="rounded-circle" src="{{asset('storage/users/'.$user->image) }}">
                </div>
                <div class="profile-info">
                    <h4>By: {{$user->name}}</h4>
                    <button type="button" class="main_btn" id="edit_btn">Edit</button>
                </div>
                <a @if($post->type==0)
                 target="_blank"   href="{{route('print-post',['username'=>$post->user->username,'post_number'=>$post->post_number,'slug'=>$post->slug_url])}}"
                @endif class="active folder-img"><img src="{{asset('assets/images/folder.png') }}"></a>
            </div>
            <div class="review-detail ">
                <ul class="date_time d-flex ">
                    <li><p class="date-time-text-edit"><i class="far fa-clock"></i>{{ date("h:i A - M d, Y", strtotime($post->created_at)) }}</p></li>
                </ul>
                <h4 data-placeholder="Title of Story"></h4>
            </div>
            <div class="review-detail-content ck-content" data-placeholder="Description of your story"></div>
            <div class="review-detail-content-view">
                <ul class="like_comment d-flex justify-content-between align-items-center mt-0">
                    <li>
                        <small><img src="{{asset('assets/images/eye.png') }}"><span><span>
                           {{ $post->views_count}}
                        </span> Views</span></small>
                    </li>
                    <li>
                        <a class="heart">
                            <img class="simple-heart" src="{{asset('assets/images/heart.png') }}">
                            <img class="red-heart" src="{{asset('assets/images/red-heart.png') }}">
                            <span><span>
                                {{ $post->likes_count}}
                            </span> Likes</span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('assets/images/share.png') }}"><span><span>
                            {{ $post->shares_count}}
                        </span> Shares</span> </a>
                    </li>
                    <li>
                        <a href="#"><img src="{{asset('assets/images/messsage.png') }}"><span><span>
                            {{ $post->comments_count}}
                        </span> Comments</span>	</a>

                    </li>
                </ul>
            </div>
        </div>
        <p class="label">Preview</p>
    </div>
</section>
@endsection

@section('js')
    <script src="{{ asset('app-assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{asset('assets/js/snippet.js') }}"></script>
    <script src="{{asset('assets/js/toolbar-grouping.js') }}"></script>
    <script src="{{asset('assets/js/write-page.js') }}"></script>
@endsection