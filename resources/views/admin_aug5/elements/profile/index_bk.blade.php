@extends('admin.layouts.app')
@section('content')
@php
header('Content-Type: text/html; charset=utf-8');
@endphp
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<div class="row" style="min-height: 70vh;">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
      </div>
      @if (count($errors) > 0)
      <div class="alert alert-danger" id="err_msg">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(session('status-error'))
      <div class="alert alert-danger" id="err_msg">
        <p>{{session('status-error')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
      </div>
      @endif
      @if(session('status'))
      <div class="alert alert-danger" id="err_msg">
        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
      </div>
      @endif
      @php 
   $userId = Auth::user()->id;
   @endphp
      <form action="{{route('profile.change.passowrd')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" value="{{$userId}}" name="user_id">
        
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Current Password')}} </label>
                <input id="current-password" type="password" class="form-control" name="current_password" required>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Password')}}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <span id="rule"></span>
                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Confirm Password')}} </label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                <span id="message"></span>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                  <input type="submit" class="btn btn-success" value="Update">
                  
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ROW-1 CLOSED -->
@endsection