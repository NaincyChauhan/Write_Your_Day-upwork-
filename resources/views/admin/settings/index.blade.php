@extends('layouts.admin')

@section('title')
Update Settings
@endsection
@section('css')
@endsection
@section('js')    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/settings.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-6 grid-margin stretch-card flex-column">
        <div class="d-flex align-items-baseline">
            <p class="mb-0"><a href="{{route('dashboard')}}">Settings</a></p>
            <i class="typcn typcn-chevron-right"></i>
            <p class="mb-0">Update Settings</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update Settings</h4>
                <form id="request-form" class="forms-sample" action="{{route('setting-update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Site Title (Meta)</label>
                        <input type="text" name="title" class="form-control" id="title" placeholder="Site Title" tabindex="1" value="{{ $setting->title }}">
                    </div>
                    <div class="form-group">
                        <label for="keywords">Keywords (Meta)</label>
                        <input type="text" name="keywords" class="form-control" id="keywords" placeholder="Keywords" tabindex="2" value="{{ $setting->keywords }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="description">Description (Meta)</label>
                        <textarea rows="3" name="description" class="form-control" id="description" placeholder="Description" tabindex="3">{{ $setting->description }}</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="dark_logo">Site Dark Logo</label>
                        <input type="file" name="dark_logo" class="form-control" id="dark_logo" placeholder="Logo" tabindex="4" accept=".jpeg, .jpg, .png">
                        @if($setting->dark_logo != '')
                            <img src="{{ asset('/'.$setting->dark_logo) }}" style="width:100px;" class="rounded bg-light mt-2">
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="light_logo">Site Light Logo</label>
                        <input type="file" name="light_logo" class="form-control" id="light_logo" placeholder="Logo" tabindex="5" accept=".jpeg, .jpg, .png">
                        @if($setting->light_logo != '')
                            <img src="{{ asset('/'.$setting->light_logo) }}" style="width:100px;" class="rounded bg-light mt-2">
                        @endif
                    </div>                    

                    <div class="form-group">
                        <label for="company_profile">Company Profile</label>
                        <input type="file" name="company_profile" class="form-control" id="company_profile" placeholder="Company Profile" tabindex="6" accept=".pdf">
                        @if($setting->company_profile != '')
                            <a target="_blank" href="{{ asset('/'.$setting->company_profile) }}" class="btn btn-info mt-2">View Profile</a>
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label for="favicon">Site Favicon</label>
                        <input type="file" name="favicon" class="form-control" id="favicon" placeholder="Favicon" tabindex="7" accept=".jpeg, .jpg, .png, .ico">
                        @if($setting->favicon != '')
                            <img src="{{ asset('/'.$setting->favicon) }}" style="width:100px;" class="rounded">
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ $setting->email }}" class="form-control" id="Email" placeholder="Email" tabindex="8">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="number" name="mobile" value="{{ $setting->mobile }}" class="form-control" id="mobile" placeholder="Mobile" tabindex="9">
                    </div>
                    <div class="form-group">
                        <label for="whatsapp">Whatsapp</label>
                        <input type="number" name="whatsapp" value="{{ $setting->whatsapp }}" class="form-control" id="whatsapp" placeholder="Whatsapp" tabindex="10">
                    </div>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input type="text" name="facebook" value="{{ $setting->facebook }}" class="form-control" id="facebook" placeholder="Facebook" tabindex="11">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input type="text" name="instagram" value="{{ $setting->instagram }}" class="form-control" id="instagram" placeholder="instagram" tabindex="12">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input type="text" name="twitter" value="{{ $setting->twitter }}" class="form-control" id="twitter" placeholder="twitter" tabindex="13">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputlinkedin1">Linkedin</label>
                        <input type="text" name="linkedin" value="{{ $setting->linkedin }}" class="form-control"id="linkedin" placeholder="linkedin" tabindex="14">
                    </div>
                    <div class="form-group">
                        <label for="youtube">Youtube</label>
                        <input type="text" name="youtube" value="{{ $setting->youtube }}" class="form-control" id="youtube" placeholder="Youtube" tabindex="15">
                    </div>
                    <div class="form-group">
                        <label for="exampleTextarea1">Address</label>
                        <textarea class="form-control" name="address" value="{{ $setting->address }}"
                            id="exampleTextarea1" rows="5" tabindex="14">{{ $setting->address }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mr-2 float-right" id="request-btn" tabindex="16">
                        <i class="mdi mdi-cloud-upload"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection