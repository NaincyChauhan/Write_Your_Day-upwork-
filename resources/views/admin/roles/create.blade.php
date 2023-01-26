@extends('layouts.admin')
@section('title')
  Add Role
@endsection

@section('css') 
    
@endsection

@section('js')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/add-roles.js') }}"></script>
@endsection

@section('content')
  <div class="row">
    <div class="col-xl-6 grid-margin stretch-card flex-column">
        <div class="d-flex align-items-baseline">
            <p class="mb-0"><a href="{{route('role.index')}}">Roles</a></p>
            <i class="typcn typcn-chevron-right"></i>
            <p class="mb-0">Add Role</p>
        </div>
    </div>
  </div>
  <form action="{{ route('role.store') }}" id="request-form" method="POST" enctype="multipart/form-data">
    <div class="row">
      <div class="col-12 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              @csrf
              <div class="row">
                <div class="col-lg-10 col-md-10 col-12">
                    <div class="form-group">
                        <label class="control-label" role="button">Role Name<sup style="color:red;">*</sup></label>
                        <input type="text" name="name" class="form-control" placeholder="Role Name" >
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group mb-2 bg-light p-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkAll">
                            <label class="custom-control-label" for="checkAll" role="button" style="cursor: pointer">Check All</label>
                        </div>
                    </div>
                    <div class="row p-4">
                        @foreach($permissions as $permission)
                            <div class="col-lg-3 col-md-3 col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="custom-control-input" id="per{{ $permission->id }}">
                                        <label class="custom-control-label" for="per{{ $permission->id }}" style="cursor: pointer">{{ ucwords($permission->name) }}</label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
              </div>
              <button type="submit" class="btn btn-primary mr-2 float-right" id="request-btn">
                <i class="mdi mdi-plus-circle-outline"></i> Add
              </button>
            </div>
          </div>
      </div>
    </div>
  </form>
@endsection