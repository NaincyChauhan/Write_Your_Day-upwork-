@extends('layouts.admin')

@section('title')
  Update Password
@endsection

@section('css')
  <style>
    .main-panel {
        width: calc(100% - 236px);
        min-height: auto !important;
    }
  </style>
@endsection

@section('js')
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script>
        //validate
        $(function (){
            $('#request-form').validate(
            {
                rules: {
                    old_password: "required",
                    new_password: "required",
                    confirm_password: "required",
                },
                messages: {
                    old_password: "Oops.! The old password field is required.",
                    new_password: "Oops.! The new password field is required.",
                    confirm_password: "Oops.! The confirm password field is required.",
                },          
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(f) {
                    var btn = $('#request-btn'), form = $('#request-form');
                    btn.attr('disabled', true) ;
                    btn.html('Requesting <i class="mdi mdi-cloud-circle"></i>');
                    $.ajax({
                        type: "POST",
                        url: form.attr('action'),
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data) {
                            if(parseInt(data.status) == 1)
                            {
                                ajaxMessage(1, data.message);
                            }else{
                                ajaxMessage(0, data.message);
                            }                     
                            btn.attr("disabled", false);
                            form[0].reset();                            
                            btn.html('Update');
                        },
                        error: function(data) {
                            var msg = data.responseJSON.message, error = "<ul>"; 

                            $.each(data.responseJSON.errors, function(key, value){
                                error += "<li>"+value+"</li>";
                            });
                            error += "</ul>";
                            errorsHTMLMessage(msg+"<br>"+error);
                            btn.attr("disabled", false);
                            btn.html('Update');
                        }
                    });

                    return false;
                }
            });
        });
    </script>
@endsection


@section('content')
<div>        
    <div>
      <div class="row">
        <div class="col-xl-6 grid-margin stretch-card flex-column">
          <div class="d-flex align-items-baseline">
            <p class="mb-0"><a href="{{route('dashboard')}}">Dashboard</a></p>
            <i class="typcn typcn-chevron-right"></i>
            <p class="mb-0">Update Password</p>
          </div>
        </div>  
      </div>
      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Update Password</h4>
              <p class="card-description">
                {{-- Basic form layout --}}
              </p>
              <form id="request-form" class="form-horizontal" method="POST" action="{{ route('update-password') }}">
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="old_password" class="col-sm-4 col-form-label">Old Password :</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="old_password" placeholder="Old Password" autofocus >
                            @if($errors->has('old_password'))
                                <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                                    <strong>{{ $errors->first('old_password') }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="new_password" class="col-sm-4 col-form-label">Password :</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="new_password" placeholder="Password" >
                            <div style="width: 100%;">
                                @if($errors->has('new_password'))
                                    <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="confirm_password" class="col-sm-4 col-form-label">Confirm Password :</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" >
                            @if($errors->has('confirm_password'))
                                <p class="invalid-feedback text-danger" style="display:block!important;" role="alert">
                                    <strong>{{ $errors->first('confirm_password') }}</strong>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-footer" style="height: 72px;">
                    <button type="submit" id="request-btn" class="btn btn-primary float-right" >Update</button>
                </div>
            </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection



