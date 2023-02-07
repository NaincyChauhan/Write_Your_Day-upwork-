@extends('layouts.admin')

@section('title')
Update Refund Policy
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('js')    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.18/dist/sweetalert2.all.min.js"></script>
    <!-- jquery-validation -->
    <script src="{{ asset('app-assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script src="{{ asset('app-assets/masterX/js/custom.js') }}"></script>
    <script src="{{ asset('app-assets/masterX/js/policies.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="col-xl-6 grid-margin stretch-card flex-column">
        <div class="d-flex align-items-baseline">
            <p class="mb-0"><a href="">Policies</a></p>
            <i class="typcn typcn-chevron-right"></i>
            <p class="mb-0">Update Policy</p>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Update Refund Policy</h4>
                <form id="request-form" class="forms-sample" action="{{route('refund.update.refund-update')}}"
                    method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="exampleTextarea1">Policy</label>
                        <textarea class="form-control" name="content" id="content" rows="10">{{$refund}}</textarea>
                    </div>
                    <button type="submit" id="request-btn" class="btn btn-primary mr-2 float-right">
                        <i class="mdi mdi-plus-circle-outline"></i> Save
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection