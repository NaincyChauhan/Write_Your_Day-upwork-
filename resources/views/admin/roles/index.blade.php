@extends('layouts.admin')
@section('title')
    Roles Management
@endsection

@section('css') 
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/roles.js') }}"></script>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row" id="headerRow">
                    <h4 class="card-title">Role Management</h4>
                    @can('create-role')
                      <a class="btn btn-primary btn-rounded btn-fw float-right text-white" href="{{ route('role.create') }}">
                          <i class="mdi mdi-plus-circle-outline"></i> Role
                      </a>
                    @endcan
                </div>
                <div class="table-responsive pt-3"  id="ajax_data_table">
                  <table id="shivadatatable" class="table table-bordered table-striped mb-5">
                    <thead>
                      <th>#</th>
                      <th>Name</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$role->name}}</td>
                                <td>
                                  <div class="d-flex align-items-center">
                                    @can('update-role')
                                      <a class="btn btn-success btn-sm btn-icon-text mr-3 text-white" href="{{ route('role.edit', $role->id) }}">
                                        <i class="mdi mdi-table-edit"></i> Edit
                                      </a>
                                    @endcan
                                    @can('delete-role')
                                      <a class="btn btn-danger btn-sm btn-icon-text" onclick="event.preventDefault(); callDelete($(this))" href="{{ route('role.destroy', $role->id) }}">
                                        <i class="mdi mdi-delete-variant"></i> Delete
                                      </a>
                                    @endcan
                                  </div>
                                </td>
                            </tr>
                        @endforeach                                            
                    </tbody>
                    <tfoot>
                        <th>#</th>
                        <th>Name</th>
                        <th>Role</th>
                    </tfoot>
                  </table>
                </div>
            </div>
        </div>
    </div>
  </div>
@endsection