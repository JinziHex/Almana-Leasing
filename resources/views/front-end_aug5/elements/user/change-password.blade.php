@extends('front-end.layouts.front-layout') 
@section('content')

 <div class="rental-wrapper car-list-pg trafc">
      <div class="filter-bar">
      <div class="container">

        <!--<div class="dropdown Choose">-->
        <!--  @if(Auth::guard('main_customer')->check())-->
        <!--  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">-->
        <!--    <img src="{{url('assets/uploads/avatar2.png')}}" width="20" />-->
        <!--    {{Auth::guard('main_customer')->user()->customer->cust_fname}}&nbsp;{{Auth::guard('main_customer')->user()->customer->cust_lname}}, {{Auth::guard('main_customer')->user()->customer->email}}-->
            <!-- <span class="caret"></span> -->
        <!--  </button>-->
        <!--   <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">-->
        <!--    <li><a href="{{route('user.profile')}}">{{ __('Profile')}}</a></li>-->
        <!--    <li><a href="{{route('user.change.password')}}">{{ __('Change Password')}}</a></li>-->
        <!--     <li><a href="{{route('user.logout')}}" onclick="event.preventDefault();-->
        <!--                   document.getElementById('logout-form1').submit();">{{ __('Signout')}}</a></li>-->
        <!--      <form id="logout-form1" action="{{ route('user.logout') }}" method="POST" style="display: none;">-->
        <!--                      @csrf-->
        <!--      </form>-->
        <!--  </ul>-->
          
        <!--</div>-->
        <!--@endif-->


      </div>
      </div>
      </div>
              <div class="divmain changepsrd">
<div class="sidemenu-div">
@include('front-end.includes.profile-side-menu')
</div> 
      
      
      
<div class="rental-wrapper car-list-pg yellowbar">
   <div class="search-form">
     @if(session('status'))
   <div class="alert alert-success" id="err_msg">
      <p>{{session('status')}}</p>
   </div>
   @endif 
     @if(session('status-error'))
   <div class="alert alert-danger" id="err_msg">
      <p>{{session('status-error')}}</p>
   </div>
   @endif 
   @if (count($errors) > 0)
   <div class="alert alert-danger" id="err_msg">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
      <form action="{{route('user.change.password')}}" method="POST" id="vehicle-search" class="row shadow mx-0">
         @csrf
        
   <input type="hidden" name="customer_id" value="{{$custId}}">
         <div class="form-group col-md-12 time-picker">
            <label for="SelectCity">{{ __('Current Password')}}</label>
              <input id="current-password" type="password" class="form-control" name="current_password" required>
            
             <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
         </div>
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
       
          
         <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">

   <button type="submit" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">{{__('Update Password')}} </button>
   </div>
   </form>
</div>
</div>
<div style="clear: both;"></div>
</div>
<hr />
<script type="text/javascript">
         $(document).ready(function(){
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
    if (value.length < minLength)
        $("#rule").html("Password length must be atleast 8").css('color', 'red');
    else
        $("#rule").html("Password accepted").css('color', 'green');
});
//minlength check ends
             });
          </script>
@endsection