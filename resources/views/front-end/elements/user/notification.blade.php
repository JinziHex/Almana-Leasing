@extends('front-end.layouts.front-layout') 
@section('content')

 <div class="rental-wrapper car-list-pg ntfictn">
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
      
      
      
<div class="rental-wrapper car-list-pg yellowbar notfictn">
    @if(!$fetchNot->isEmpty())
          @foreach($fetchNot as $fetchNots)
   <div class="search-form">
   
      <form id="vehicle-search" class="row shadow mx-0">
          
         <span style="text-align: center;margin:auto;">
           <h1 class="Reservation-txt" style="color: #e61e26;">{{__($fetchNots->notification_title)}}</h1>
           <h3 class="Reservation-txt">{{__($fetchNots->notification_content)}}</h3>
         </span><br>
        
         </form>
   </div>
   @endforeach
         @else
         <div class="search-form">
   
      <form id="vehicle-search" class="row shadow mx-0">
          
         <span style="text-align: center;margin:auto;">
           <h2 class="Reservation-txt">{{__('No Recent Notifications')}}</h2>
         </span><br>
       
         </form>
   </div>
    @endif
   
</div>
</div>
<div style="clear: both;"></div>
</div>
<hr />

@endsection