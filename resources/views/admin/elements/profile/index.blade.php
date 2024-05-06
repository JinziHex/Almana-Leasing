@extends('admin.layouts.app')
@section('content')
@php
header('Content-Type: text/html; charset=utf-8');
@endphp
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

<style>
.passclass{
    position:absolute;
    right: 25px;
    bottom:18px;
    display:block;
}    
</style>

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
                <div class="input-group-addon passclass">
                  <a role="button" id="show_hide_current_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('New Password')}}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <div class="input-group-addon passclass">
                  <a role="button" id="show_hide_new_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
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
                <div class="input-group-addon passclass">
                  <a role="button" id="show_hide_confirm_password"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                </div>
                <span id="message"></span>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                  <button class="btn btn-primary" type="reset">Reset</button>
                  
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
<script>
 
    $("#show_hide_current_password").on('click', function(event) {
        event.preventDefault();
        if($('#current-password').attr("type") == "text"){
            $('#current-password').attr('type', 'password');
            $('#show_hide_current_password i').addClass( "fa-eye-slash" );
            $('#show_hide_current_password i').removeClass( "fa-eye" );
        }else if($('#current-password').attr("type") == "password"){
            $('#current-password').attr('type', 'text');
            $('#show_hide_current_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_current_password i').addClass( "fa-eye" );
        }
    });
    $("#show_hide_new_password").on('click', function(event) {
        event.preventDefault();
        if($('#password').attr("type") == "text"){
            $('#password').attr('type', 'password');
            $('#show_hide_new_password i').addClass( "fa-eye-slash" );
            $('#show_hide_new_password i').removeClass( "fa-eye" );
        }else if($('#password').attr("type") == "password"){
            $('#password').attr('type', 'text');
            $('#show_hide_new_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_new_password i').addClass( "fa-eye" );
        }
    });
    $("#show_hide_confirm_password").on('click', function(event) {
        event.preventDefault();
        if($('#password-confirm').attr("type") == "text"){
            $('#password-confirm').attr('type', 'password');
            $('#show_hide_confirm_password i').addClass( "fa-eye-slash" );
            $('#show_hide_confirm_password i').removeClass( "fa-eye" );
        }else if($('#password-confirm').attr("type") == "password"){
            $('#password-confirm').attr('type', 'text');
            $('#show_hide_confirm_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_confirm_password i').addClass( "fa-eye" );
        }
    });
    $("#password-confirm").on('keyup', function() {
      var password = $("#password").val();
      var confirmPassword = $("#password-confirm").val();
      if (password != confirmPassword)
        $("#message").html("Password does not match !").css("color", "red");
      else
        $("#message").html("Password match !").css("color", "green");
 });
 $("#password").on('keyup', function() {
      var password = $("#password").val();
      var confirmPassword = $("#password-confirm").val();
      if (password != confirmPassword)
        $("#message").html("Password does not match !").css("color", "red");
      else
        $("#message").html("Password match !").css("color", "green");
 });

</script>
@endsection