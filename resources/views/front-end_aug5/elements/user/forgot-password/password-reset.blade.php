@extends('front-end.layouts.front-layout') 
@section('content')
    <div class="login-wrapper signup-pg row mx-0">

      <div class="login-sec signup-sec row mx-0 shadow">


        <div class="col-md-12">
          <h3 class="mb-5 text-center">Reset Password&nbsp;
          
          </small></h3>
          
        </div>
       
        
       
        <div class="col-md-12">
        	 @if (count($errors) > 0)
   <div class="alert alert-danger" id="err_msg">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
          <form action="{{route('customer.password-reset.update')}}" method="POST" id="login-form" class="verify-sec row mx-0" style="justify-content: center;">
          	@csrf
          	<input type="hidden" value="{{$custId}}" name="customer_id">
            <div class="form-group col-6 mb-0">
            	
              <div class="form-group col-md-12 time-picker">
            <label for="SelectLocation">{{ __('New Password')}}</label>
             <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
              <span id="rule"></span>
               @error('password')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
           
         </div>
         
         
         <div class="form-group col-md-12 date time-picker">
            <label for="FromDate">{{ __('Confirm Password')}} </label>
           <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <span id="message"></span>
         </div>
         <div class="form-group col-md-12 date time-picker">
             <button type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">Reset Password</button>
             </div>
             
            </div>

          
          
           @if(session('status'))
              <strong style="margin-left: 140px; color: red;">{{session('status')}}</strong>
               @endif
                @if(session('error-cust'))
              <strong style="margin-left: 140px; color: red;">{{session('error-cust')}}</strong>
               @endif
               @if(session('resend-success'))
              <strong style="margin-left: 140px; color: red;">{{session('resend-success')}}</strong>
              @endif
          </form>
        </div>

      </div>

      

    </div>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
       <script>
    $('.select2').select2();
</script>
@endsection