@extends('front-end.layouts.front-layout') 
@section('content')
<style>
.mobilecode .select2-container{margin-top: -52px;margin-left: 1px;position: absolute;left: 15px;top: 36px;margin:0;width: 80px!important;}
.mobilecode .select2-container .select2-selection{border:none !important;background: transparent!important;}
.select2-container .select2-selection--single {height: 23px;margin-bottom:4px;}
#select2-Nationality-container.focusdiv{box-shadow: 0 0 0 .4rem rgba(0,123,255,.25);border-radius: .25rem;}
 .select2-container--default .select2-selection--single{height: auto!important;
border: 1px solid #ced4da!important;margin-bottom: 0;}
.select2-container--default .select2-selection--single .select2-selection__rendered{font-family: 'Roboto', sans-serif !important;font-size: 16px;padding: .375rem .75rem!important;line-height: 1.5!important;}
.select2-container--default .select2-selection--single .select2-selection__arrow{height:30px!important;}
label.error {font-size: 9px;color: red;}
#Nationality-error{position: absolute;left: 15px;bottom: 0;}
.selectntn .select2-container{width:100% !important;}
</style>

    <div class="login-wrapper signup-pg row mx-0">
      <div class="login-sec signup-sec row mx-0 shadow">

        <div class="col-md-6">
          <a class="login-with btn btn-lg btn-primary mb-3" href="#" style="display: none;"><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp; Connect With Facebook</a>
        </div>
        <div class="col-md-6">
          <a class="login-with btn btn-lg btn-danger mb-3" href="#" style="display: none;"><i class="fa fa-google" aria-hidden="true"></i>&nbsp; Connect With Google</a>
        </div>

        <div class="col-md-12" style="display: none;">
          <h3 class="mb-5 text-center text-muted"><small>or</small></h3>
        </div>
        
        <div class="col-md-12">
              @if(session('status'))
         <h5 class="mb-5" style="text-align: center;color: green;"> {{session('status')}} </h5>
         @endif
         @if (count($errors) > 0)
  @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
  @endforeach
@endif

@if (session()->has('message'))
  <p class="alert alert-success">{{ session('message') }}</p>
@endif
@if (session()->has('status-error'))
  <p class="alert alert-danger">{{ session('status-error') }}</p>
@endif
          <form action="{{route('user.save')}}" method="POST" id="login-form" class="row mx-0">
            @csrf
            <div class="form-group col-md-6">
              <label for="FirstName">{{__('First Name')}}</label>
              <input type="text" class="form-control" id="FirstName" placeholder="{{__('Enter Your')}} {{__('First Name')}}" name="cust_fname" required value="{{ old('cust_fname') }}">
            </div>
            <div class="form-group col-md-6">
              <label for="LastName">{{__('Last Name')}}</label>
              <input type="text" class="form-control" id="LastName" placeholder="{{__('Enter Your')}} {{__('Last Name')}}" name="cust_lname" required value="{{ old('cust_lname')}}" value="{{__('Enter Your')}}{{__('Last Name')}}">
            </div>
            <div class="form-group col-md-6 mobilecode">
              <label for="MobileNumber">{{__('Mobile Number')}}</label>
            {{--   <input type="hidden" class="form-control" id="MobileNumber" placeholder="" value="+971" name="cust_mobile_code">
              --}}
               
              
              <input type="text" class="form-control" id="usermobile" placeholder="{{__('Enter Your')}} {{__('Mobile Number')}}" name="cust_mobile_number" value="{{ old('cust_mobile_number')}}" style="text-align: left;
padding-left: 80px;" required>
               <select class="form-control select2 col-md-3" style="margin-top: -33px;" name="cust_mobile_code" id="mobCode" required="">
                {{-- <option value="">ISD</option> --}}
                @foreach($fetchCont as $fetchContmc)
                  <option value="+{{$fetchContmc->phonecode}}" {{ $fetchContmc->country_id == "174" ? 'selected' : '' }}>+{{$fetchContmc->phonecode}}</option>
                 {{--  <option value="{{$custmLists->customer_id}}" {{ $fetchContmc->customer_id == $custId ? 'selected' : '' }}>{{$custmLists->cust_fname}} {{$custmLists->cust_lname}}</option> --}}
                @endforeach
                </select>
               <span  role="alert" style="color:green;display:none;font-size: 13px;" id="usermob">
                              {{ __('Email accepted') }}
                              </span>
            </div>
            <div class="form-group col-md-6">
              <label for="EmailAddress">{{__('Email Address')}}</label>
              <input type="text" class="form-control" id="useremail" value="{{ old('email')}}" placeholder="{{__('Enter Your')}} {{__('Email Address')}}" name="email" required>
              <span  role="alert" style="color:green;display:none;font-size: 13px;" id="emailmsg">
                              {{ __('Email accepted') }}
                              </span>
            </div>
            <div class="form-group col-md-6">
              <label for="Password">{{__('Password')}}</label>
              <input type="password" class="form-control" id="password" placeholder="{{__('Enter Your')}} {{__('Password')}}" name="password" required autocomplete="new-password">
               <!--<span id="rule"></span>-->
            </div>
            <div class="form-group col-md-6">
              <label for="ConfirmPassword">{{__('Confirm Password')}}</label>
              <input type="password" class="form-control" id="password-confirm" placeholder="{{__('Confirm Password')}}" required autocomplete="new-password" name="password_confirmation">
               <!--<span id="message"></span>-->
            </div>

            <div class="form-group col-md-6 date time-picker">
              <label for="DOB">{{__('Date of Birth')}} </label>
              <input id="input_1_26" class="form-control" type="text" readonly="" placeholder="{{__('Date of Birth')}}" name="cust_dob" required="" value="{{ old('cust_dob')}}">
            </div>

            <div class="form-group col-md-6">
              <label for="QatarID">{{__('Qatar ID')}}</label>
              <input type="text" class="form-control" id="QatarID" name="cust_qatar_id" value="{{old('cust_qatar_id')}}" placeholder="{{__('Qatar ID')}}" required>
            </div>

            <div class="form-group col-md-6">
              <label for="PassportNumber">{{__('Passport Number')}}</label>
              <input type="text" class="form-control" id="PassportNumber" name="cust_passport_number" placeholder="{{__('Enter Your')}} {{__('Passport Number')}}" value="{{ old('cust_passport_number')}}" required>
            </div>

            <div class="form-group col-md-6 selectntn">
              <label for="Nationality">{{__('Nationality')}}</label> <!--select2-->
              
              <select class="form-control select2"  id="Nationality" required name="cust_nationality" val
              {{ old('cust_nationality')}}>
                <option value="">--{{__('Choose a country')}}--</option>
                @foreach($fetchCont as $fetchConts)
                <option value="{{$fetchConts->country_id}}" {{old('cust_nationality') == $fetchConts->country_id ? 'selected':''}}>{{$fetchConts->nicename}}</option>
                @endforeach
              </select>
            </div>
            
            <button type="submit" id="submit1" class="mt-3 btn btn-warning btn-lg btn-block mx-auto text-white col-md-6">{{__('Sign up now')}}</button>
          </form>
        </div>

      </div>

      

    </div>

    <script type="text/javascript">
         $(document).ready(function(){

  // email unique
         $('#useremail').bind("keyup change", function(){

            var email = $(this).val();
            if($('#useremail').val() == ''){
                $("#emailmsg").css("display", "");
  $("#emailmsg").css("color", "red");
  $('#emailmsg').html('Email Address cannot be left Blank!');
  // $('#submit1"]').prop('disabled', true);
  $('#submit1').attr("disabled", "disabled");
            }else{
                         $.ajax({
           type:"GET",
           url:"{{url('/check-email')}}?email="+email,
           success:function(res){  
 if(res.length > 0){

  $("#emailmsg").css("display", "");
  $("#emailmsg").css("color", "red");
  $('#emailmsg').html('This Email Address is already taken!');
  // $('#submit1"]').prop('disabled', true);
  $('#submit1').attr("disabled", "disabled");

}else{

  $("#emailmsg").css("display", "");
  $("#emailmsg").css("color", "green");
  $('#emailmsg').html('Email Address accepted');
  // $('#submit1"]').prop('disabled', false);
  $("#submit1").removeAttr( "disabled");
}

           }

         });
            }

          });

         //mobile number unique
          $('#usermobile').bind("keyup change", function(){
           

            var mobNumber = $(this).val();
            var mobCode = $("#mobCode").val();
            
            if($('#usermobile').val() == ''){
       $("#usermob").css("display", "");
  $("#usermob").css("color", "red");
  $('#usermob').html('Mobile Number cannot be left Blank!');
  // $('#submit1"]').prop('disabled', true);
  $('#submit1').attr("disabled", "disabled");
   }else{
      $.ajax({
           type:"GET",
           url:"{{url('/check-mobile')}}?mobNumber="+mobNumber,
        //   data: {
        //         mobilecode: mobCode
        //     },
           success:function(res){  
 if(res.length > 0){
  $("#usermob").css("display", "");
  $("#usermob").css("color", "red");
  $('#usermob').html('This Mobile Number is already taken!');
  // $('#submit1"]').prop('disabled', true);
  $('#submit1').attr("disabled", "disabled");

}else{

  $("#usermob").css("display", "");
  $("#usermob").css("color", "green");
  $('#usermob').html('Mobile Number accepted');
  // $('#submit1"]').prop('disabled', false);
  $("#submit1").removeAttr( "disabled");
}

           }

         }); 
   }
         
          });

         //mobile number unique ends
         
         
         //allow only numbers
           $("#usermobile").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
               return false;
    }
   });
         //numbers end

         //password match
         $('#password-confirm').on('keyup', function () {
  if ($('#password').val() == $('#password-confirm').val()) {
    $('#message').html('Password Matching').css('color', 'green');
     
  } else 
    $('#message').html('Password does not match').css('color', 'red');

});


         //password match ends

          //check minlength of password
         var minLength = 8;


$("#password").on("keydown keyup change", function(){
    var value = $(this).val();
    if (value.length < minLength && value != '')
        $("#rule").html("Password length must be atleast 8").css('color', 'red');
    else
        $("#rule").html("Password accepted").css('color', 'green');
});
//minlength check ends





         });
       </script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
       <script>
    $('.select2').select2();
</script>
<script>
// nationality focus
$(document).on('keydown', 'input#PassportNumber', function(e) { 
    var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { 
    //   e.preventDefault(); 
    // call custom function here
   $('#select2-Nationality-container').addClass('focusdiv');
   $("#select2-Nationality-container").attr("contenteditable",true);
   
    
    }
    $("body").click(function(){
              $('#select2-Nationality-container').removeClass('focusdiv');
       });
  });
// end nationality focus

$(document).on('keydown', '#select2-Nationality-container', function(e) { 
    var keyCode = e.keyCode || e.which; 

    if (keyCode == 9) { 
    //   e.preventDefault(); 
    // call custom function here
     $("#select2-Nationality-container").attr("contenteditable",false);
   $('#select2-Nationality-container').removeClass('focusdiv');
    
    }
   
  });
  
</script>
  


@endsection