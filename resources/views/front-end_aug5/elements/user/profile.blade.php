@extends('front-end.layouts.front-layout') 
@section('content')

<!-- banner -->
{{-- <div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('assets/front/themes/rental/images/buisness-bg.jpg')!important;">
   <!-- img src="" alt=""> -->
   <div class="slider_overLay"></div>
   <div class="container">
      <div class="banner-title aos-init aos-animate" data-aos="zoom-in" data-aos-duration="1200">
         <h1>{{ __('Car Rental' ) }}</h1>
         <h5>{{ __('Our experts are ready to provide tailor-made') }}<br> {{ __('packages to meet your transportation needs') }}</h5>
         <!-- <h1>Select your car<span>drive like a king</span></h1> -->
      </div>
   </div>
</div> --}}
<!-- end banner -->
 <div class="rental-wrapper car-list-pg pdbb">
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
      
      
    <div class="divmain">
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
   @if (count($errors) > 0)
   <div class="alert alert-danger" id="err_msg">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
      <form action="{{route('user.profile.update')}}" method="POST" id="vehicle-search" class="row shadow mx-0">
         @csrf
        
   <input type="hidden" name="customer_id" value="{{$fetchCust->customer_id}}">
         <div class="form-group col-md-6 time-picker">
            <label for="SelectCity">{{ __('First Name')}}</label>
             <input id="cust_fname" type="text" value="{{$fetchCust->customer['cust_fname']}}" class="form-control" name="cust_fname" required>
         </div>
         <div class="form-group col-md-6 time-picker">
            <label for="SelectLocation">{{ __('Last Name')}}</label>
             <input id="cust_lname" type="text" value="{{$fetchCust->customer['cust_lname']}}" class="form-control" name="cust_lname" required>
           
         </div>
         
         <div class="form-group col-md-6 date" id="sandbox-container">
            <label for="FromDate">{{ __('Email Address')}} <i class="fa fa-calendar" aria-hidden="true"></i></label>
          <input id="email" type="email" value="{{$fetchCust->customer['email']}}" class="form-control" name="email" required>
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{ __('Mobile Number') }} </label>
          <input type="text" id="cust_mobile_number" value="{{$fetchCust->customer['cust_mobile_number']}}" name="cust_mobile_number" required="required" readonly="" class="form-control ">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{ __('Date of Birth') }}</label>
            <input type="date" id="cust_dob" value="{{$fetchCust->customer['cust_dob']}}" name="cust_dob" class="form-control ">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{ __('Nationality') }}</label>
           <select class="form-control" name="cust_nationality">
             @foreach($getCont as $getConts)
            <option value="{{$getConts->country_id}}" {{ $getConts->country_id == $fetchCust->customer['cust_nationality'] ? 'selected' : '' }}>{{$getConts->country_name}}</option>
            @endforeach
         </select>
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{ __('Billing Address Line 1') }}</label>
            <textarea class="form-control" name="cust_address_line_1" rows="4" col="2" placeholder="">{{$fetchCust->customer['cust_address_line_1']}}</textarea>
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{ __('Billing Address Line 2') }}</label>
           <textarea class="form-control" name="cust_address_line_2" rows="4" col="2" placeholder="">{{$fetchCust->customer['cust_address_line_2']}}</textarea>
         </div>
         <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('Country') }}</label>
           <select class="form-control" name="cust_bill_country">
               @if($fetchCust->customer['cust_bill_country'] != "")
             @foreach($getCont as $getConts)
            <option value="{{$getConts->country_id}}" {{ $getConts->country_id == $fetchCust->customer['cust_bill_country'] ? 'selected' : '' }}>{{$getConts->country_name}}</option>
            @endforeach
            @else
            <option value="">--Select a country--</option>
            @foreach($getCont as $getConts)
            <option value="{{$getConts->country_id}}">{{$getConts->country_name}}</option>
            @endforeach
            @endif
            
         </select>
         </div>
         <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('City') }}</label>
           <select class="form-control" name="cust_city" id="SelectCity">
            <option value="">--Please choose city--</option>
            @foreach($fetchCity as $fetchCitys)
               <option value="{{$fetchCitys->city_id}}" {{ $fetchCitys->city_id == $fetchCust->customer['cust_city'] ? 'selected' : '' }}>{{$fetchCitys->city_name}}</option>
              @endforeach
         </select>
         </div>
         <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('Location') }}</label>
           <select class="form-control" name="cust_state" id="SelectLocation">
               @if($fetchCust->customer['cust_state'])
               <option value="{{$fetchCust->customer['cust_state']}}" selected="">{{$fetchCust->customer->location['location_name']}}</option>
               @else
               <option value="">--Choose a location--</option>
               @endif
           
         </select>
         </div>
          <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('Driving License Number') }}</label>
           <input type="text" id="cust_driving_license_no" value="{{$fetchCust->customer['cust_driving_license_no']}}" name="cust_driving_license_no" class="form-control">
         </div>
          <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('License Country Issued') }}</label>
           <select class="form-control" name="cust_license_issued_country">
             @foreach($getCont as $getConts)
            <option value="{{$getConts->country_id}}" {{ $getConts->country_id == $fetchCust->customer['cust_license_issued_country'] ? 'selected' : '' }}>{{$getConts->country_name}}</option>
            @endforeach
         </select>
         </div>
          <div class="form-group col-md-4 date time-picker">
            <label for="ToDate">{{ __('Date Issued') }}</label>
          <input type="date" id="cust_license_issued_date" value="{{$fetchCust->customer['cust_license_issued_date']}}" name="cust_license_issued_date" class="form-control">
         </div>
          
         <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">

   <button type="submit" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">{{__('Update')}} </button>
   </div>
   </form>
</div>

</div>
<div style="clear: both;"></div>
</div>
<hr />

<script type="text/javascript">
         $(document).ready(function(){

 
//change location when selecting city

$('#SelectCity').change(function(){

  
   var city_id = $(this).val();
   
   
if(city_id){

   $(document).ajaxStart(function(){
       $(".htl").css("display", "block");
   });
   
   $(document).ajaxComplete(function(){
       $(".htl").css("display", "none");
   });

    $.ajax({
           type:"GET",
           url:"{{url('/get-location-list-profile')}}?city_id="+city_id,
           success:function(res){               
            if(res){
               $('#SelectLocation').prop("disabled", false);
                $("#SelectLocation").empty();
                $("#SelectLocation").append('<option value="">Select a location</option>');
                $.each(res,function(city_loc_id,location_name){
                    $("#SelectLocation").append('<option value="'+city_loc_id+'">'+location_name+'</option>');
                });
           
            }else{
               $("#SelectLocation").empty();
            }
           }
        });
}


});
//change location ends



 




});
      </script>

@endsection