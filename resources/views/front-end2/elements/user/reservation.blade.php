@extends('front-end.layouts.front-layout') 
@section('content')
@php
use App\Models\Model_image;
@endphp

    <div class="rental-wrapper car-list-pg car-single-pg car-summary-pg reservation-pg">
       <div class="filter-bar">
           
      <div class="container">

        <!--<h2 style="margin: auto; margin-top: 10px; text-align: center; color: #fff;">Reservations</h2>-->

      </div>
      </div>
      
      
             
    <div class="divmain feedback">
<div class="sidemenu-div">
@include('front-end.includes.profile-side-menu')
</div> 
     
      
      <div class="resrvdiv" >
      <div class="Reservation-txt">
        <h2>Manage Your Reservations</h2>
        <p>Below you see all the reservations made through our Car Rental System.</p>
        <p>To view or cancel your booking click the button.</p>
       {{--  <p><small><i>Note: If you cancel your confirmed booking within 24 hours, there will be a cancellation charge.</i></small></p> --}}
         @if(session('cancel-error'))
   <div class="alert alert-danger" id="err_msg">
      <p>{{session('cancel-error')}}</p>
   </div>
   @endif 
     @if(session('cancel-success'))
   <div class="alert alert-success" id="err_msg">
      <p>{{session('cancel-success')}}</p>
   </div>
   @endif 
      </div>
      @if(!$fetchBooking->isEmpty())
      @foreach($fetchBooking as $fetchBookings)
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
                <h2>{{$fetchBookings->model->modal_name}}<small><i>Status: {{$fetchBookings->status->status}}</i></small></h2>
                <p>Booking Reference: {{$fetchBookings->book_ref_id}}</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                {{-- <p><span>Pick Up: </span> Rent Solutions Office, D-Ring Road</p> --}}
                @php
                $fromDt = $fetchBookings->book_from_date;
                $parseFrmDt = Helper::parseCarbon($fromDt); 
                $toDt = $fetchBookings->book_to_date;
                $parseToDt = Helper::parseCarbon($toDt);

                @endphp
                {{-- <p><span>Mobile Number: </span> {{$fetchBookings->book_bill_cust_mobile}}</p> --}}
                <p><span>Pickup Address: </span> Rental Solutions, <br>D Ring Road,<br> Doha, QATAR</p>
                <p><span>Pickup Date & Time: </span>{{$parseFrmDt->format('d-M-Y')}} , {{$fetchBookings->book_pickup_time->format('H:i:s')}}</p>
                <p><span>Return Date & Time: </span>{{$parseToDt->format('d-M-Y')}} , {{$fetchBookings->book_return_time->format('H:i:s')}}</p>
                <p><span>Booking: </span> {{$fetchBookings->book_total_days}} Days</p>
                <p><span>Total Rate: </span> {{$fetchBookings->book_total_rate}} {{$fetchBookings->currency_id}}</p>              
              </div>
            </div>
            <div class="col-12 col-sm-3 btns">
              <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-toggle="modal" data-target="#billing-addrs{{$fetchBookings->book_id}}" id="sub1" class="btn btn-warning btn-lg btn-block mx-auto text-white" >View</a>
             @if($fetchBookings->book_status==5)
             <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="cursor: not-allowed;">Booking Cancelled</a>
             
              @else
               <a href="{{url('user/cancel/booking/'.Crypt::encryptString($fetchBookings->book_id))}}" class="btn btn-warning btn-lg btn-block mx-auto text-white" onclick="return confirm('Do you want to cancel this booking?');">Cancel</a>
              @endif
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
            <h2 style="color: #0047bb;" class="modal-title">Booking Information of {{$fetchBookings->model->modal_name}}</h2>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
         </div>
         <div class="modal-body">
       
         <input type="hidden" value="{{$fetchBookings->book_car_model}}" name="model_id">
          <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">
          <div class="form-group col-md-6">
            <p>{{ __('Booking Date') }} : {{$fetchBookings->created_at->format('d-m-Y')}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Reference Id') }} : {{$fetchBookings->book_ref_id}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Pickup Date') }} : {{$fetchBookings->book_from_date}} - {{$fetchBookings->book_pickup_time->format('H:i:s')}}</p>
         </div>
         <div class="form-group col-md-6">
            <p>{{ __('Rate Per Day') }} : {{$fetchBookings->book_daily_rate}} {{$fetchBookings->currency_id}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Return Date') }} : {{$fetchBookings->book_to_date}} - {{$fetchBookings->book_return_time->format('H:i:s')}}</p>
         </div>
         <div class="form-group col-md-6">
            <p>{{ __('Total Rate') }} : {{$fetchBookings->book_total_rate}} {{$fetchBookings->currency_id}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Total Days') }} : {{$fetchBookings->book_total_days}} Days</p>
         </div>
          
         
          <div class="form-group col-md-6">
            <p>{{ __('Billing Name') }} : {{$fetchBookings->book_bill_cust_fname}} {{$fetchBookings->book_bill_cust_lname}}</p>
         </div>
         <div class="form-group col-md-6">
            <p>{{ __('Mobile Number') }} : {{$fetchBookings->book_bill_cust_mobile}}</p>
         </div>
         <div class="form-group col-md-6">
            <p>{{ __('Date of Birth') }} : {{$fetchBookings->book_bill_cust_dob}}</p>
         </div>
         <div class="form-group col-md-6">
            <p>{{ __('Zipcode') }} : {{$fetchBookings->book_bill_cust_zipcode}}</p>
         </div>
         

          <div class="form-group col-md-6">
            <p>{{ __('Qatar Id') }} : {{$fetchBookings->book_bill_cust_qatar_id}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Billing Address') }} : {{$fetchBookings->book_bill_cust_address_1}}<br>
            {{$fetchBookings->book_bill_cust_address_2}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Location') }} : {{$fetchBookings->city['city_name']}},{{$fetchBookings->state['location_name']}},{{$fetchBookings->country['country_name']}}</p>
         </div>
          
            </div>
         <div class="modal-footer">
            
            <button type="button" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-dismiss="modal">Close</button>
         </div>
     
    </div>
    
   </div>
</div>
<!-- end billing address Modal -->
<!-- end billing address Modal -->
      @endforeach
      @else
       <div class="Reservation-txt">
        <h2>No Reservations Yet!</h2>
       
        
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
           url:"{{url('/get-location-list')}}?city_id="+city_id,
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