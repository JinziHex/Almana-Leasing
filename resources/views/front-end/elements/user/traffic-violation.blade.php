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
             
    <div class="divmain feedback">
<div class="sidemenu-div">
@include('front-end.includes.profile-side-menu')
</div> 
     
      
      
      
      
<div class="rental-wrapper car-list-pg yellowbar traffic">
   <div class="search-form">
   
      <form id="vehicle-search" class="row shadow mx-0">
         <span style="text-align: center;margin:auto;">
           <h2>{{__('TRAFFIC VIOLATION INQUIRY')}}</h2>
        <h4>{{__('To check MOI traffic violation,Please click the button below')}}</h4>
         </span><br>
        
   <a href="https://portal.moi.gov.qa/wps/portal/MOIInternet/services/inquiries/trafficservices" target="_blank" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">{{__('Visit MOI Website')}} </a>

   <!--<button type="button" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">{{__('Visit MOI Website')}} </button>-->
   </div>
   </form>
</div>

</div>
<div style="clear: both;"></div>
</div>
<hr />

@endsection