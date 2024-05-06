@extends('front-end.layouts.front-layout') 
@section('content')
    <div class="login-wrapper signup-pg row mx-0">

      <div class="login-sec signup-sec row mx-0 shadow">


        <div class="col-md-12">
          <h3 class="mb-5 text-center">Please enter the verification code<br><small>that we've sent to your phone&nbsp;
           {{--  <a href="{{url('resend/otp/'.$decrUsrId)}}" style="color: blue;" class="btn btn-link">Resend OTP</a> --}}
          </small></h3>
          
        </div>
       
        
       
        <div class="col-md-12">
        	
          <form action="{{route('check.otp')}}" method="POST" id="login-form" class="verify-sec row mx-0">
          	@csrf
          	<input type="hidden" value="{{$decrUsrId}}" name="user_id">
            <div class="form-group col-6 mb-0">
            	
              <!-- <label for="VerificationCode">Verification Code</label> -->
              <input type="text" class="form-control" id="VerificationCode" name="otp" placeholder="Enter 4 Digit OTP">
             
            </div>

            <div class="form-group col-3 mb-0">
            <button type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">Verify</button>
          </div>
          <div class="form-group col-3 mb-0">
            <a href="{{url('resend/otp/'.$decrUsrId)}}" class="btn btn-warning btn-lg btn-block mx-auto text-white resent">Resend OTP</a>
          </div>
           @if(session('status'))
              <strong style="margin-left: 140px; color: red;">{{session('status')}}</strong>
               @endif
               @if(session('resend-success'))
              <strong style="margin-left: 140px; color: red;">{{session('resend-success')}}</strong>
              @endif
          </form>
        </div>

      </div>

      

    </div>
@endsection