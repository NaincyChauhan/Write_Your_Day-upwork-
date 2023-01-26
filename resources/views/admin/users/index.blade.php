@extends('layouts.admin') @section('title') Users @endsection 
@section('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/css/switch-toggle.css') }}">
@endsection

@section('js')
    <script src="{{ asset('app-assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('app-assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/users.js') }}"></script>
@endsection 
@section('content')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row" id="headerRow">
                    <h4 class="card-title">Users</h4>
                    @can('create-user')
                        <a class="btn btn-primary btn-rounded btn-fw float-right text-white" data-toggle="modal"
                            data-target="#addUser">
                            <i class="mdi mdi-plus-circle-outline"></i> User
                        </a>
                    @endcan
                </div>
                <div class="table-responsive pt-3"  id="ajax_data_table">
                    <table id="shivadatatable" class="table table-striped mb-5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->roles()->exists() ? $user->roles()->first()->name : '' }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>                                            
                                    <td>{{ $user->mobile }}</td>                                            
                                    <td>
                                        @can('update-user')
                                            <label class="switch">
                                                <input type="checkbox" onchange="changeStatus($(this))" href="{{ route('change-staff-status', $user->id) }}" {{ $user->status == 1 ? 'checked' : '' }}>
                                                <span class="slider round"></span>
                                            </label>
                                        @endcan
                                    </td>                                            
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @can('update-user')
                                                <a class="btn btn-success btn-sm btn-icon-text mr-3 text-white" onclick="event.preventDefault(); callUpdate($(this))" href="{{ route('user.edit', $user->id) }}">
                                                    <i class="mdi mdi-table-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @can('delete-user')
                                                <a class="btn btn-danger btn-sm btn-icon-text" onclick="event.preventDefault(); callDelete($(this))" href="{{ route('user.destroy', $user->id) }}">
                                                    <i class="mdi mdi-delete-variant"></i> Delete
                                                </a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Role</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Add discount Modal --}}
<div class="modal fade" id="addUser" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <form method="POST" action="{{ route('user.store') }}" id="request-form-add" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name" class="">Name<font color="red">*</font> :</label>
                                <input type="text" class="form-control" name="name" placeholder="Name" > 
                            </div>
                        </div>
                        {{-- <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone" class="">Phone<font color="red">*</font> :</label>
                                <input type="number" class="form-control" name="phone" placeholder="Phone" >
                            </div>
                        </div>  --}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="email" class="">Email<font color="red">*</font> :</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" >
                            </div>
                        </div> 
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="role_id" class="">Select Role<font color="red">*</font> :</label>
                                <select class="form-control" name="role_id" >
                                    <option value="" selected>Select Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="password" class="">Password<font color="red">*</font> :</label>
                                <input type="text" class="form-control" name="password" placeholder="Password" >
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="request-btn-add" type="button" type="submit" onclick="$('#request-form-add').submit()" class="btn btn-primary">
                  <i class="mdi mdi-plus-circle-outline"></i> Save
                </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Add discount Modal-->

{{-- Edit discount Modal --}}
<div class="modal fade" id="editUser" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>

            <div id="editData"></div>
        </div>
    </div>
</div>
<!-- End Edit discount Modal-->

@endsection