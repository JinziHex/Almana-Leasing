@extends('front-end.layouts.front-layout') 
@section('content')
    <div class="login-wrapper signup-pg row mx-0 rest">

      <div class="login-sec signup-sec row mx-0 shadow">


        <div class="col-md-12">
          <h3 class="mb-5 text-center">{{__('Reset Password')}}&nbsp;
          
          </small></h3>
          
        </div>
       
        
        @if (count($errors) > 0)
   <div class="alert alert-danger" id="err_msg">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
   
   <style>
       .select2-container {position: absolute !important; top: 5px;left: 16px; }
       .select2-container .select2-selection--single { border:none !important; }
   </style>
    @if(session('status'))
              <strong style="margin-left: 140px; color: red;">{{session('status')}}</strong>
               @endif
                @if(session('error-cust'))
              <strong style="margin-left: 140px; color: red;">{{session('error-cust')}}</strong>
               @endif
               @if(session('resend-success'))
              <strong style="margin-left: 140px; color: red;">{{session('resend-success')}}</strong>
              @endif
        <div class="col-md-12">
        	
          <form action="{{route('customer.password-reset.verify-mobile')}}" method="GET" id="login-form" class="verify-sec row mx-0" style="justify-content: center;">
          	@csrf
          	
            <div class="form-group col-lg-8 col-md-6 col-sm-12 col-12 mb-4">
            	
              <!-- <label for="VerificationCode">Verification Code</label> -->
               <select class="form-control select2 col-md-3" style="margin-top: -33px;" name="cust_mobile_code" required="">
                {{-- <option value="">ISD</option> --}}
                @foreach($fetchCont as $fetchContmc)
                  <option value="+{{$fetchContmc->phonecode}}" {{ $fetchContmc->country_id == "174" ? 'selected' : '' }}>+{{$fetchContmc->phonecode}}</option>
                @endforeach
                </select>
              <input type="text" class="form-control" id="VerificationCode" name="mobile_number" placeholder="{{__('Enter Mobile Number')}}" style="padding-left: 95px;">
             
            </div>

            <div class="form-group col-lg-4 col-md-6 col-sm-12 col-12  mb-0">
            <button type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">Get OTP</button>
          </div>
          
          
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