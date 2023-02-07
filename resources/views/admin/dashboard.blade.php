@extends('layouts.admin')
@section('title')
Dashboard
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('app-assets/plugins/fontawesome-free/css/all.min.css')}}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
<!-- SweetAlert2 -->
<script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
@endsection


@section('content')
@if(Auth::user()->hasRole('superadmin'))
<div class="row">
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                        <p class="mb-2 text-md-center text-lg-left">Total User</p>
                        <h1 class="mb-0">{{ $users }}</h1>
                    </div>
                    <i class="mdi mdi-account-multiple icon-xl text-secondary"></i>
                </div>
                <canvas id="expense-chart" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                        <p class="mb-2 text-md-center text-lg-left">Total Applications</p>
                        <h1 class="mb-0"></h1>
                    </div>
                    <i class="mdi mdi-file-check icon-xl text-secondary"></i>
                </div>
                <canvas id="budget-chart" height="80"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div
                    class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
                    <div>
                        <p class="mb-2 text-md-center text-lg-left">Total Income</p>
                        <h1 class="mb-0"></h1>
                    </div>
                    <i class="typcn typcn-clipboard icon-xl text-secondary"></i>
                </div>
                <canvas id="balance-chart" height="80"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Latest Help Enquiries</h4>
            </div>
            <div class="table-responsive pt-3" style="padding: 15px;">
                <table id="shivadatatable"  class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="ml-5">#</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                        <tr>
                            <td>{{ $loop->iteration }}</td>                            
                            <td>{{ date("d M Y", strtotime($message->created_at)) }}</td>
                            <td>{{$message->name}} </td>
                            <td>{{$message->email}} </td>
                            <td>{{$message->phone}} </td>
                            <td>{{$message->message}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
@endsection