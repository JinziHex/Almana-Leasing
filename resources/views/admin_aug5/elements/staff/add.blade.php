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
          @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
         <form action="{{ route('staff.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
           
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Staff Name') }}</label>
                          <input type="text" id="staff_name" name="staff_name" required="required" autofocus class="form-control " value="{{old('staff_name')}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Employee Code')}}</label>
                       <input type="text" id="staff_code"  required="required" class="form-control  @error('staff_code') is-invalid @enderror" name="staff_code"  value="{{old('staff_code')}}" required autocomplete="staff_code">
                       @error('staff_code')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                        @enderror
                     </div>
                  </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Mobile Number')}}</label>
                        <input  onkeypress='validate(event)' type="text" id="mobile_number" name="mobile_number" class="form-control" required="required" value="{{ old('mobile_number') }}">
                     </div>
                  </div>

                   <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Email')}}</label>
                       <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required="required" value="{{ old('email') }}" autocomplete="email">
                           @error('email')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                     </div>
                  </div>
                 

                 <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Username')}}</label>
                       <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" >
                           @error('name')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                     </div>
                  </div>

                   <div class="col-md-6">
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

                   <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Confirm Password')}}</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <span id="message"></span>
                     </div>
                  </div>





                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="submit" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.staffs') }}">Cancel</a>
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </form>
   </div>
</div>
</div>
<script>
    function validate(evt) {
                        var theEvent = evt || window.event;
                        var key = theEvent.keyCode || theEvent.which;
                        key = String.fromCharCode( key );
                        var regex = /[0-9]|\./;
                        if( !regex.test(key) ) {
                           theEvent.returnValue = false;
                           if(theEvent.preventDefault) theEvent.preventDefault();
                        }
                        }
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