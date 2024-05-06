@extends('front-end.layouts.front-layout') 
@section('content')
@php
use App\Models\Model_image;
@endphp
<style>
    .ui-timepicker-standard{z-index:10000 !important;}
</style>

    <div class="rental-wrapper car-list-pg car-single-pg car-summary-pg reservation-pg histry-pg">
       <div class="filter-bar">
      <div class="container">

        <!--<h2 style="margin: auto; margin-top: 10px; text-align: center; color: #fff;">Rental History</h2>-->

        

      </div>
      </div>
          
    <div class="divmain">
<div class="sidemenu-div">
@include('front-end.includes.profile-side-menu')
</div> 
     
      
      <div class="histry-side" style="">
      <div class="Reservation-txt">
        <h2>{{__('Your Rental History')}}</h2>
        <p>{{__('Below you see all the rental history made through our Car Rental System.')}}</p>
        
      </div>
      @if(!$fetchBooking->isEmpty())
      @foreach($fetchBooking as $fetchBookings)
       @if(session('status'))
   <div class="alert alert-danger" id="err_msg">
      <p>{{session('status')}}</p>
   </div>
   @endif 
       <div class="car-single-sec">
        <div class="container">
          <div class="row">
            <div class="col-12 col-sm-4 car-single-img">
               @php
               $fetchImage = Model_image::where('model_id','=',$fetchBookings->book_car_model)->where('model_image_flag','=',0)->first();
               $fetchMainImg = $fetchImage->model_image;
               @endphp
              <img src="{{url('/assets/uploads/models/'.$fetchMainImg)}}">
            </div>
            <div class="col-12 col-sm-5 car-single-txt">
              <div class="titl">
                <h2>@if(@$fetchBookings->model->modal_name){{__(@$fetchBookings->model->modal_name)}}@else Car Removed @endif<small><i>{{__('Status:')}} {{__($fetchBookings->status->status)}}</i></small></h2>
                <p>{{__('Booking Reference:')}} {{$fetchBookings->book_ref_id}}</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                {{-- <p><span>Pick Up: </span> Rent Solutions Office, D-Ring Road</p> --}}
                @php
                $fromDt = $fetchBookings->book_from_date;
                $parseFrmDt = Helper::parseCarbon($fromDt); 
                $toDt = $fetchBookings->book_to_date;
                $parseToDt = Helper::parseCarbon($toDt);
                @endphp
                <p><span>{{__('Pickup Date')}}: </span> {{$parseFrmDt->format('d-M-Y')}}</p>
                <p><span>{{__('Return Date')}}: </span> {{$parseToDt->format('d-M-Y')}}</p>
                <p><span>{{__('Booking')}}: </span> {{$fetchBookings->book_total_days}} {{__('Days')}}</p>              
              </div>
            </div>
            <div class="col-12 col-sm-3 btns">
              <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-toggle="modal" data-target="#billing-addrs{{$fetchBookings->book_id}}" id="sub1" class="btn btn-warning btn-lg btn-block mx-auto text-white" >{{__('Book Again')}}</a>
            </div>
          </div>
        </div>
      </div>
       <!-- billing address Modal -->
<!-- billing address Modal -->
<div class="modal " id="billing-addrs{{$fetchBookings->book_id}}" role="dialog">
   <!-- fade -->
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h2 style="color: #0047bb;" class="modal-title">{{__('Book')}} {{@$fetchBookings->model->modal_name}}</h2>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
         </div>
         <div class="modal-body">
        <form action="{{route('user.car.book2')}}" method="POST" id="vehicle-search" class="row shadow mx-0">
         @csrf
         <input type="hidden" value="{{$fetchBookings->book_car_model}}" name="model_id">
          <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">
          <div class="form-group col-md-6">
            <label for="SelectCity">{{ __('Select City') }}</label>
            <select class="form-control" id="SelectCity" name="city_id" required="">
             
               <option value="" disabled selected hidden>{{__('Please choose city')}}</option>
               @foreach($fetchCity as $fetchCitys)
               <option value="{{$fetchCitys->city_id}}">{{$fetchCitys->city_name}}</option>
              @endforeach
            </select>
             <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
         </div>
         <div class="form-group col-md-6">
            <label for="SelectLocation">{{__('Select Location')}}</label>
            <select class="form-control" id="SelectLocation" name="city_loc_id" required="" readonly>
               <option value="">{{__('Please choose location')}}</option>
            </select>
         </div>
         <div class="form-group col-md-6  date time-picker">
            <label for="FromDate">{{__('From Date')}} </label>
            <input id="" class="form-control txt inp-select input_1_24history" type="text" autocomplete="off" placeholder="{{__('Select from date')}}" name="from_date" required="">
         </div>
          <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{__('Pickup Time')}} </label>
            <input id="" class="form-control txt inp-select picktimehistory" type="text" placeholder="{{__('Select from date')}}" name="pickup_time" required="">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{__('To Date')}}</label>
            <input id="input_1_25" class="form-control txt inp-select input_1_25history" type="text" autocomplete="off" placeholder="{{__('Select from date')}}" name="to_date" required="">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{__('Return Time')}} </label>
            <input  id="" class="form-control txt inp-select rettimehistory" type="text" placeholder="{{__('Select from date')}}" name="return_time" required="">
         </div>  
         </div>
         <div class="modal-footer">
            <input type="submit" value="{{__('Submit')}}" class="btn btn-warning btn-lg btn-block mx-auto text-white">
            <button type="button" class="btn-cancel btn btn-lg btn-block mx-auto" data-dismiss="modal">{{__('Cancel')}}</button>
         </div>
      </div>
    </form>
   </div>
</div>
<!-- end billing address Modal -->
<!-- end billing address Modal -->
      @endforeach
      @else
       <div class="Reservation-txt">
        <h2>{{__('No History Yet!')}}</h2>
       
        
      </div>
      @endif



      

</div>

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
                /*$.each(res,function(city_loc_id,location_name){
                    $("#SelectLocation").append('<option value="'+city_loc_id+'">'+location_name+'</option>');
                });*/
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