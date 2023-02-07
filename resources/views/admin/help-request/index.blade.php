@extends('layouts.admin')

@section('title')
Help Requests
@endsection
@section('css') 
<!-- DataTables -->
    <link rel="stylesheet" href="{{asset('app-assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <style>
        #shivadatatable td{
            white-space:initial;
        }
    </style>
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
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/helprequest.js') }}"></script>
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between" id="headerrow">
                    <h4 class="card-title">Help Requests</h4>
                    @can('delete-Enquiry')
                        <div class="float-right">
                            <div class="form-group">
                                <input type="checkbox" id="allCheck"> 
                                <label for="allCheck" role="button">Check All</label>
                                <select class="form-control" onchange="deleteAll($('option:selected', this).attr('value'))">
                                    <option value="">Bulk Action</option>
                                    <option value="DELETE">Delete</option>
                                </select>
                            </div>        
                        </div>
                    @endcan
                </div>
                <div class="table-responsive pt-3" id="ajax_data_table">
                    <table id="shivadatatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="ml-5">#</th>
                                <th class="ml-5"></th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>message</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($messages as $message)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <input type="checkbox" class="checkbox" data-id="{{ $message->id }}">
                                </td>
                                <td>{{ date("d M Y", strtotime($message->created_at)) }}</td>
                                <td>{{$message->name}} </td>
                                <td>{{$message->email}} </td>
                                <td>{{$message->phone}} </td>
                                <td>{{$message->message}} </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @can('delete-Enquiry')                                        
                                            <a class="btn btn-danger btn-sm btn-icon-text"
                                                onclick="event.preventDefault(); callDelete($(this))"
                                                href="{{ route('helpcenter.destroy', $message->id) }}">
                                                Delete
                                                <i class="typcn typcn-delete-outline btn-icon-append"></i>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection