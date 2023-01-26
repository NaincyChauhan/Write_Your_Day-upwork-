@extends('layouts.admin')
@section('title')
    Dashboard
@endsection

@section('css')    
@endsection


@section('content')
@if(Auth::user()->hasRole('superadmin'))
  <div class="row">
    <div class="col-md-4 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
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
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
            <div>
              <p class="mb-2 text-md-center text-lg-left">Total Applications</p>
              <h1 class="mb-0">{{ $applications }}</h1>
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
          <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
            <div>
              <p class="mb-2 text-md-center text-lg-left">Total Income</p>
              <h1 class="mb-0">₹{{ number_format($income, 2) }}</h1>
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
          <h4>Latest Enquiries</h4>
        </div>
        <div class="table-responsive pt-3">
          <table class="table table-striped project-orders-table">
            <thead>
              <tr>
                <th class="ml-5">#</th>
                <th>Name</th>
                <th>Email</th>
                <th>mobile</th>
                <th>subject</th>
                <th>message</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($messages as $message)
                <tr id="row{{$message->id}}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$message->name}} </td>
                    <td>{{$message->email}} </td>
                    <td>{{$message->mobile}} </td>
                    <td>{{$message->subject}} </td>
                    <td>{{$message->message}} </td>
                </tr>
                @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@else
<div class="row">
  <div class="col-md-4 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
          <div>
            <p class="mb-2 text-md-center text-lg-left">Today Tasks</p>
            <h1 class="mb-0">{{ $today }}</h1>
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
        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
          <div>
            <p class="mb-2 text-md-center text-lg-left">Today Pending</p>
            <h1 class="mb-0">{{ $pending }}</h1>
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
        <div class="d-flex align-items-center justify-content-between justify-content-md-center justify-content-xl-between flex-wrap mb-4">
          <div>
            <p class="mb-2 text-md-center text-lg-left">Today Complete</p>
            <h1 class="mb-0">{{ $complete }}</h1>
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
        <h4>Latest Applications</h4>
      </div>
      <div class="table-responsive pt-3">
        <table class="table table-striped project-orders-table">
          <thead>
            <tr>
              <th class="ml-5">#</th>
              <th>Date</th>
              <th>Application ID</th>
              <th>Application For</th>
              <th>Notification Link</th>
              <th>Official Link</th>
              <th>Payment Status</th>
              <th>Mobile</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($applications as $application)
              <tr id="row{{ $application->id }}">
                  <td>
                      <input type="checkbox" class="checkbox" data-id="{{ $application->id }}">
                  </td>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ date("M d, Y", strtotime($application->created_at)) }}</td>
                  <td>{{$application->application_id}} </td>
                  
                  <td>
                      <a target="_blank" href="{{ route('listing-detail', $application->listing->slug) }}">
                          {{$application->listing->name}} 
                      </a>
                  </td>
                  <td>
                      <a target="_blank" href="{{ $application->listing->notification_link }}">
                          Notification Link 
                      </a>
                  </td>
                  <td>
                      <a target="_blank" href="{{  $application->listing->main_link }}">
                          Oficial Link 
                      </a>
                  </td>
                  <td>
                      {{$application->payment_status == 1 ? 'Success' : 'Pending'}} 
                  </td>
                  <td>
                      <a href="tel:{{$application->user->mobile}}">
                          {{$application->user->mobile}} 
                      </a>
                  </td>
                  <td>
                      @if($application->status == 0)
                          <span onclick="callStatusModal('{{ route('change-application-status',['id' => $application->id]) }}')" role="button" class="p-1 rounded text-white bg-danger">Pending</span>
                      @elseif($application->status == 1)
                          <span onclick="callStatusModal('{{ route('change-application-status',['id' => $application->id]) }}')" role="button" class="p-1 rounded text-white bg-success">Success</span>
                      @elseif($application->status == 2)
                          <span onclick="callStatusModal('{{ route('change-application-status',['id' => $application->id]) }}')" role="button" class="p-1 rounded text-white bg-warning">Processing</span>
                      @elseif($application->status == 3)
                          <span onclick="callStatusModal('{{ route('change-application-status',['id' => $application->id]) }}')" role="button" class="p-1 rounded text-white bg-danger">Profile Update Required</span>
                      @endif
                  </td>
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

