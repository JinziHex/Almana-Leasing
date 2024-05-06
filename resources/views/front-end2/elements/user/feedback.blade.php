@extends('front-end.layouts.front-layout') 
@section('content')

 <div class="rental-wrapper car-list-pg ntfictn ">
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
      <form action="{{route('user.feedback')}}" method="POST" id="vehicle-search" class="row shadow mx-0">
         @csrf
         <span style="text-align: center;margin:auto;">
           <h2>{{__($pageTitle)}}</h2>
        <h4>{{__($subTitle)}}</h4>
         </span><br>
        
   <input type="hidden" name="customer_id" value="{{$custId}}">
         <div class="form-group col-md-6 time-picker">
            <label for="SelectCity">{{ __('First Name')}}</label>
             <input id="feedback_fname" type="text" value="{{Auth::guard('main_customer')->user()->customer->cust_fname}}" class="form-control" name="feedback_fname" required>
            
             <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
         </div>
         <div class="form-group col-md-6 time-picker">
            <label for="SelectLocation">{{ __('Last Name')}}</label>
             <input id="feedback_fname" type="text" value="{{Auth::guard('main_customer')->user()->customer->cust_lname}}" class="form-control" name="feedback_lname" required>
           
         </div>
         
         <div class="form-group col-md-6 date" id="sandbox-container">
            <label for="FromDate">{{ __('Email Address')}} <i class="fa fa-calendar" aria-hidden="true"></i></label>
          <input id="feedback_fname" type="email" value="{{Auth::guard('main_customer')->user()->email}}" class="form-control" name="feedback_email" required>
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{ __('Feedback Type')}} </label>
          <select name="feedback_type" required="" class="form-control">
                           <option value="">--Select a type--</option>
                             <option value="1">{{__('Complaint')}}</option>
                             <option value="2">{{__('Suggestion')}}</option>      
                          </select>
         </div>
         <div class="form-group col-md-12 date time-picker">
            <label for="ToDate">{{ __('Message')}}</label>
            <textarea class="form-control" name="feedback_message" required="" rows="5" cols="20" placeholder="{{__('Message')}}"></textarea>
         </div>
          
         <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">

   <button type="submit" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">Submit </button>
   </div>
   </form>
</div>
</div>
<div style="clear: both;"></div>
</div>
<hr />

@endsection