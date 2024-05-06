@extends('front-end.layouts.front-layout') 
@section('content')
@php
use App\Models\Model_image;
@endphp
<style type="text/css">
    .vodiapicker{
  display: none; 
}

#a{
  padding-left: 0px;
}

#a img, .btn-select img{
  width: 12px;
  
}

#a li{
  list-style: none;
  padding-top: 5px;
  padding-bottom: 5px;
}

#a li:hover{
 background-color: #F4F3F3;
}

#a li img{
  margin: 5px;
}

#a li span, .btn-select li span{
  margin-left: 30px;
}

/* item list */

.b{
  display: none;
  width: 100%;
  max-width: 350px;
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  border: 1px solid rgba(0,0,0,.15);
  border-radius: 5px;
  
}

.open{
  display: show !important;
}

.btn-select{
  margin-top: 10px;
  width: 100%;
  max-width: 350px;
  height: 34px;
  border-radius: 5px;
  background-color: #fff;
  border: 1px solid #ccc;
 
}
.btn-select li{
  list-style: none;
  float: left;
  padding-bottom: 0px;
}

.btn-select:hover li{
  margin-left: 0px;
}

.btn-select:hover{
  background-color: #F4F3F3;
  border: 1px solid transparent;
  box-shadow: inset 0 0px 0px 1px #ccc;
  
  
}

.btn-select:focus{
   outline:none;
}

.lang-select{
  margin-left: 50px;
}
</style>
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
        <h2>{{__('MANAGE YOUR RESERVATIONS')}}</h2>
        <p>{{__('Below you see all the reservations made through our Car Rental System.')}}</p>
        <p>{{__('To view or cancel your booking click the button.')}}</p>
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
    @if(session('error'))
   <div class="alert alert-danger" id="err_msg">
      <p>{{session('error')}}</p>
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
                <h2>{{__(@$fetchBookings->model['modal_name'])}} <small><i>{{__('Status:')}} {{__($fetchBookings->status->status)}}</i></small></h2>
                <p>{{__('Booking Reference:')}} {{$fetchBookings->book_ref_id}}</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                {{-- <p><span>Pick Up: </span> Almana rentals Office, Doha, Qatar</p> --}}
                @php
                $fromDt = $fetchBookings->book_from_date;
                $parseFrmDt = Helper::parseCarbon($fromDt); 
                $toDt = $fetchBookings->book_to_date;
                $parseToDt = Helper::parseCarbon($toDt);

                @endphp
                {{-- <p><span>Mobile Number: </span> {{$fetchBookings->book_bill_cust_mobile}}</p> --}}
                <!--<p><span>{{__('Pickup Address:')}} </span> {{__('Almana rentals Office,')}} <br>{{__('S.H. AL MANA GROUP, PO Box 9440,')}}<br> {{__('QATAR')}}</p>-->
                <p><span>{{__('Pickup Date & Time:')}} </span>{{$parseFrmDt->format('d-M-Y')}} , {{$fetchBookings->book_pickup_time->format('H:i:s')}}</p>
                <p><span>{{__('Return Date & Time:')}} </span>{{$parseToDt->format('d-M-Y')}} , {{$fetchBookings->book_return_time->format('H:i:s')}}</p>
                <p><span>{{__('Booking:')}} </span> {{$fetchBookings->book_total_days}} {{__('Days')}}</p>
                <p><span>{{__('Total Rate:')}} </span> {{$fetchBookings->book_total_rate}} QAR</p>              
              </div>
            </div>
            <div class="col-12 col-sm-3 btns">
              <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-toggle="modal" data-target="#billing-addrs{{$fetchBookings->book_id}}" id="sub1" class="btn btn-warning btn-lg btn-block mx-auto text-white" >{{__('View')}}</a>
            @if($fetchBookings->book_status<4)
            @php
            
            $day_before=date( 'Y-m-d', strtotime($fetchBookings->book_to_date . ' -1 day' ) );
            //echo $day_before;
            $curr_date=date('Y-m-d');
            @endphp
            @if($curr_date<$day_before)
              <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-toggle="modal" data-target="#billing-addrs2{{$fetchBookings->book_id}}" id="sub2" class="btn btn-warning btn-lg btn-block mx-auto text-white edit-button" reference="{{$fetchBookings->book_ref_id}}" >{{__('Edit')}}</a>
              
              
              @endif
              <br>
              <!-- billing address Modal -->
<div class="modal " id="billing-addrs2{{$fetchBookings->book_id}}" role="dialog">
   <!-- fade -->
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h2 style="color: #0047bb;" class="modal-title">{{__('Edit')}}-{{__('Booking Reference:')}}{{@$fetchBookings->book_ref_id}}</h2>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
         </div>
         <div class="modal-body">
             <div class="alert alert-danger errorAreaMain" id="errorArea{{@$fetchBookings->book_ref_id}}"></div>
        <form action="{{route('user.car.bookedit')}}" method="POST" id="vehicle-search" class="row shadow mx-0">
         @csrf
          <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">
          <input type="hidden" value="{{@$fetchBookings->book_ref_id}}" class="refNo" name="reference_number" id="refNumber{{@$fetchBookings->book_ref_id}}">
          <div class="form-group col-md-6">
            <label for="SelectCity">{{ __('Select City') }}</label>
            <select class="form-control city-cls{{@$fetchBookings->book_ref_id}} SelectCity{{@$fetchBookings->book_ref_id}} SelectCityMain"  name="city_id" required="" reference-no="{{@$fetchBookings->book_ref_id}}">
             
               <option value="0"  selected hidden>{{__('Please choose city')}}</option>
               @foreach($fetchCity as $fetchCitys)
               <option value="{{$fetchCitys->city_id}}" @if($fetchBookings->city['city_id']==$fetchCitys->city_id) selected @endif>{{$fetchCitys->city_name}}</option>
              @endforeach
            </select>
             <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
         </div>
         <div class="form-group col-md-6">
            <label for="SelectLocation">{{__('Select Location')}}</label>
            <select class="form-control loc-cls{{@$fetchBookings->book_ref_id}} SelectLocation{{@$fetchBookings->book_ref_id}}"  name="city_loc_id" required="" readonly>
               <option value="0">{{__('Please choose location')}}</option>
                @foreach($fetchLocation as $fetchLocations)
                @if($fetchLocations->city_id==$fetchBookings->city['city_id'])
               <option value="{{$fetchLocations->city_loc_id}}" @if($fetchBookings->state['city_loc_id']==$fetchLocations->city_loc_id) selected @endif>{{$fetchLocations->location_name}}</option>
               @endif
              @endforeach
            </select>
         </div>
         <div class="form-group col-md-6  date time-picker">
            <label for="FromDate">{{__('From Date')}} </label>
            <input id="input_1_24history" class="form-control txt inp-select input_1_24history from-date{{@$fetchBookings->book_ref_id}} from-date-main" type="text" autocomplete="off" placeholder="{{__('Select Pickup date')}}" name="from_date" value="{{date('m/d/Y',strtotime($fetchBookings->book_from_date))}}" required="">
         </div>
          <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{__('Pickup Time')}} </label>
            <input id="" class="form-control txt inp-select picktimehistory pickup-time{{@$fetchBookings->book_ref_id}} pickup-time-main" type="text" placeholder="{{__('Select Pickup Time')}}" name="pickup_time" required="" value="{{date('H:i',strtotime($fetchBookings->book_pickup_time))}}">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="ToDate">{{__('To Date')}}</label>
            <input id="input_1_25" class="form-control txt inp-select input_1_25history to-date{{@$fetchBookings->book_ref_id}} to-date-main" type="text" autocomplete="off" placeholder="{{__('Select Return date')}}" name="to_date" required="" value="{{date('m/d/Y',strtotime($fetchBookings->book_to_date))}}">
         </div>
         <div class="form-group col-md-6 date time-picker">
            <label for="FromDate">{{__('Return Time')}} </label>
            <input  id="" class="form-control txt inp-select rettimehistory return-time{{@$fetchBookings->book_ref_id}} return-time-main" type="text" placeholder="{{__('Select Return date')}}" name="return_time" required="" value="{{date('H:i',strtotime($fetchBookings->book_return_time))}}">
         </div> 
         <input type="hidden" id="preAmount{{@$fetchBookings->book_ref_id}}" name="preAmount" value="{{$fetchBookings->book_total_rate}}">
          <div class="form-group col-md-12">
            <label for="model">{{__('Model')}} </label>
          
            <select class="form-control model-cls select2 mdl{{@$fetchBookings->book_ref_id}}" name="model_id" reference="{{@$fetchBookings->book_ref_id}}" required>
                <option value="">Select A model</option>
                @foreach($fetchCarList['Models'] as $fetchCarLists)
                @if($fetchCarLists['Model_available']!="0.00")
                <option @if($fetchCarLists['Model_id']==$fetchBookings->book_car_model) selected @endif value="{{$fetchCarLists['Model_id']}}" data-thumbnail="{{asset('assets/uploads/models/'.$fetchCarLists['Model_image'])}}"><img src="{{asset('assets/uploads/models/'.$fetchCarLists['Model_image'])}}">{{__(@$fetchCarLists['Maker_name'])}} {{__(@$fetchCarLists['Model_name'])}}</option>
                @endif
                @endforeach
            </select>
            <!-- <div class="lang-select">
            <button type="button" class="btn-select" value=""></button>
            <div class="b">
            <ul id="a"></ul>
            </div>
            </div>-->
            <p><span class="rateCurr">{{ __('Previous Booking Rate') }} :</span>{{$fetchBookings->book_total_rate}} </p>
            
            <div class="rateArea">
                <div >
                <br>
                 {{__('Total Rate')}}<p id="modelTotalRate{{@$fetchBookings->book_ref_id}}"></p> <br>
                     <img src="" id="modelImage{{@$fetchBookings->book_ref_id}}" width="250"></img>
                 </div>
                 <p id="modelEditName{{@$fetchBookings->book_ref_id}}"></p> 
                <br>
               {{--  {{__('Daily Rate')}}:<p id="modelDailyRate{{@$fetchBookings->book_ref_id}}"></p> <br>
                 {{__('Offer Rate')}}:<p id="modelOfferRate{{@$fetchBookings->book_ref_id}}"></p> <br>
                 {{__('Total Days')}}:<p id="modelTotalDays{{@$fetchBookings->book_ref_id}}"></p> <br>--}}
                
                 
                
                
            </div>
           <!-- <div class="lang-select">
            <button type="button" class="btn-select" value=""></button>
            <div class="b">
            <ul id="a"></ul>
            </div>
            </div>-->
         </div>  
         </div>
         <div class="modal-footer">
            <input type="submit" value="{{__('Submit')}}" class="btn btn-warning btn-lg btn-block mx-auto text-white">
            <button type="button" class="btn-cancel btn btn-lg btn-block mx-auto can-model" data-dismiss="modal">{{__('Cancel')}}</button>
         </div>
      </div>
    </form>
   </div>
</div>
             @endif
             @if($fetchBookings->book_status==5)
             <a href="#" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="cursor: not-allowed;">{{__('Booking Cancelled')}}</a>
             
              @else
              @if($fetchBookings->book_status!=6)
               <a href="{{url('user/cancel/booking/'.Crypt::encryptString($fetchBookings->book_id))}}" class="btn btn-warning btn-lg btn-block mx-auto text-white" onclick="return confirm('Do you want to cancel this booking?');">{{__('Cancel')}}</a>
              @endif
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
            <h2 style="color: #0047bb;" class="modal-title">{{__('Booking Information of')}} {{__(@$fetchBookings->model['modal_name'])}}</h2>
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
            <p> <span class="rateCurr">{{ __('Rate Per Day') }} :</span>{{$fetchBookings->book_daily_rate}} QAR</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Return Date') }} : {{$fetchBookings->book_to_date}} - {{$fetchBookings->book_return_time->format('H:i:s')}}</p>
         </div>
         <div class="form-group col-md-6">
            <p><span class="rateCurr">{{ __('Total Rate') }} :</span>{{$fetchBookings->book_total_rate}} QAR</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{ __('Total Days') }} : {{$fetchBookings->book_total_days}} {{__('Days')}}</p>
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
            <p>{{__('Zipcode') }} : {{$fetchBookings->book_bill_cust_zipcode}}</p>
         </div>
         

          <div class="form-group col-md-6">
            <p>{{__('Qatar Id') }} : {{$fetchBookings->book_bill_cust_qatar_id}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{__('Billing Address') }} : {{$fetchBookings->book_bill_cust_address_1}}<br>
            {{$fetchBookings->book_bill_cust_address_2}}</p>
         </div>
          <div class="form-group col-md-6">
            <p>{{__('Location') }} : {{__($fetchBookings->city['city_name'])}},{{__($fetchBookings->state['location_name'])}},{{__($fetchBookings->country['country_name'])}}</p>
         </div>
          
            </div>
         <div class="modal-footer">
            
            <button type="button" class="btn btn-warning btn-lg btn-block mx-auto text-white" data-dismiss="modal">{{__('Close')}}</button>
         </div>
     
    </div>
    
   </div>
</div>
<!-- end billing address Modal -->
<!-- end billing address Modal -->
      @endforeach
      @else
       <div class="Reservation-txt">
        <h2>{{__('No Reservations Yet!')}}</h2>
       
        
      </div>
      @endif



      


      </div>
    </div>
</div>

   
    <div style="clear: both;"></div>
</div>

<hr />
<script type="text/javascript">
    
$(".edit-button").click(function(){
    $(".model-cls").trigger("change");
    
      /*var refNumber=$(this).attr("reference");
           alert(refNumber);  
              //alert(refNumber);
              var from_date=$('.from-date'+refNumber).val();
              var to_date=$('.to-date'+refNumber).val();
              var pickup_time=$('.pickup-time'+refNumber).val();
              var return_time=$('.return-time'+refNumber).val();
              var city_loc_id = $('.loc-cls'+refNumber).val();
              var city_id = $('.city-cls'+refNumber).val();
              //alert(city_id);
              var model_id=$('.mdl'+refNumber).val();
        $.ajax({
          type: "GET",
          url:"{{url('/get-model-rate')}}?city_id="+city_id+"&&city_loc_id="+city_loc_id+"&&from_date="+from_date+"&&to_date="+to_date+"&&pickup_time="+pickup_time+"&&return_time="+return_time+"&&model_id="+model_id,
          success: function(data) {
              console.log(data.data.Models);
            //alert(data.Models[0].Main_Rate);
            //$('#rateArea'+refNumber).html(data.data.Models[0].Total_Rate); 
            $('.rateArea').show();
            //$('#modelEditMaker'+refNumber).text(data.data.Models[0].Maker_name);
            //$('#modelEditName'+refNumber).text(data.data.Models[0].Maker_name+' '+data.data.Models[0].Model_name);
            //$('#modelDailyRate'+refNumber).text(data.data.Models[0].Main_Rate);
            //$('#modelOfferRate'+refNumber).text(data.data.Models[0].Offer_Rate);
            //$('#modelTotalDays'+refNumber).text(data.data.Days); 
            $('#modelTotalRate'+refNumber).text(data.data.Models[0].Total_Rate); 
            var previous_amount=$('#preAmount'+refNumber).val();
            $('#errorArea'+refNumber).hide();
            if(parseFloat(data.data.Models[0].Total_Rate)<parseFloat(previous_amount))
            {
                $('#errorArea'+refNumber).show();
                $('#errorArea'+refNumber).html('Total price less than the previous booking amount');
                //alert('test');
            }
            
            $('#modelImage'+refNumber).attr("src", "https://almanaleasing.com/assets/uploads/models/"+data.data.Models[0].Model_image);
        
            
          
           
          
    
          },
          error: function(data){
            alert("You tried to send data to ajax.php but it didn´t give a OK response");
          }

        });*/

});
    
 $('.errorAreaMain').hide();
 
//change location when selecting city

$('.can-model').click(function(){
    //$(".model-cls").val('');
   $('.rateArea').hide();
    
});
$('.from-date-main').click(function(){
    $(".model-cls").val('');
   $('.rateArea').hide();
    
});
$('.to-date-main').click(function(){
    $(".model-cls").val('');
   $('.rateArea').hide();
    
});
$('.pickup-time-main').click(function(){
    $(".model-cls").val('');
   $('.rateArea').hide();
    
});
$('.return-time-main').click(function(){
    $(".model-cls").val('');
   $('.rateArea').hide();
    
});
$('.SelectCityMain').change(function(){

  
   var city_id = $(this).val();
   var refN=$(this).attr("reference-no");
   $(".model-cls").val('');
   $('.rateArea').hide();
   
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
               $('.SelectLocation'+refN).prop("disabled", false);
                $(".SelectLocation"+refN).empty();
                $(".SelectLocation"+refN).append('<option value="">Select a location</option>');
                $.each(res,function(city_loc_id,location_name){
                    $(".SelectLocation"+refN).append('<option value="'+city_loc_id+'">'+location_name+'</option>');
                });
           
            }else{
               $(".SelectLocation"+refN).empty();
            }
           }
        });
}


});
//change location ends



 





var langArray = [];
$('.vodiapicker option').each(function(){
  var img = $(this).attr("data-thumbnail");
  var text = this.innerText;
  var value = $(this).val();
  var item = '<li><img src="'+ img +'" alt="" value="'+value+'"/><span>'+ text +'</span></li>';
  langArray.push(item);
})

$('#a').html(langArray);

//Set the button value to the first el of the array
$('.btn-select').html(langArray[0]);
$('.btn-select').attr('value', 'en');

//change button stuff on click
$('#a li').click(function(){
   var img = $(this).find('img').attr("src");
   var value = $(this).find('img').attr('value');
   var text = this.innerText;
   var item = '<li><img src="'+ img +'" alt="" /><span>'+ text +'</span></li>';
  $('.btn-select').html(item);
  $('.btn-select').attr('value', value);
  $(".b").toggle();
  //console.log(value);
});

$(".btn-select").click(function(){
        $(".b").toggle();
    });

//check local storage for the lang
var sessionLang = localStorage.getItem('lang');
if (sessionLang){
  //find an item with value of sessionLang
  var langIndex = langArray.indexOf(sessionLang);
  $('.btn-select').html(langArray[langIndex]);
  $('.btn-select').attr('value', sessionLang);
} else {
   var langIndex = langArray.indexOf('ch');
  console.log(langIndex);
  $('.btn-select').html(langArray[langIndex]);
  //$('.btn-select').attr('value', 'en');
}
$('.rateArea').hide();

 $(".model-cls").change(function() {
              var refNumber=$(this).attr("reference");
              
              //alert(refNumber);
              var from_date=$('.from-date'+refNumber).val();
              var to_date=$('.to-date'+refNumber).val();
              var pickup_time=$('.pickup-time'+refNumber).val();
              var return_time=$('.return-time'+refNumber).val();
              var city_loc_id = $('.loc-cls'+refNumber).val();
              var city_id = $('.city-cls'+refNumber).val();
              //alert(city_id);
              var model_id=$(this).val();
        $.ajax({
          type: "GET",
          url:"{{url('/get-model-rate')}}?city_id="+city_id+"&&city_loc_id="+city_loc_id+"&&from_date="+from_date+"&&to_date="+to_date+"&&pickup_time="+pickup_time+"&&return_time="+return_time+"&&model_id="+model_id,
          success: function(data) {
              console.log(data.data.Models);
            //alert(data.Models[0].Main_Rate);
            //$('#rateArea'+refNumber).html(data.data.Models[0].Total_Rate); 
            $('.rateArea').show();
            //$('#modelEditMaker'+refNumber).text(data.data.Models[0].Maker_name);
            //$('#modelEditName'+refNumber).text(data.data.Models[0].Maker_name+' '+data.data.Models[0].Model_name);
            //$('#modelDailyRate'+refNumber).text(data.data.Models[0].Main_Rate);
            //$('#modelOfferRate'+refNumber).text(data.data.Models[0].Offer_Rate);
            //$('#modelTotalDays'+refNumber).text(data.data.Days); 
            $('#modelTotalRate'+refNumber).text(data.data.Models[0].Total_Rate); 
            var previous_amount=$('#preAmount'+refNumber).val();
            $('#errorArea'+refNumber).hide();
            if(parseFloat(data.data.Models[0].Total_Rate)<parseFloat(previous_amount))
            {
                $('#errorArea'+refNumber).show();
                $('#errorArea'+refNumber).html('Total price less than the previous booking amount');
                //alert('test');
            }
            
            $('#modelImage'+refNumber).attr("src", "https://almanaleasing.com/assets/uploads/models/"+data.data.Models[0].Model_image);
        
            
          
           
          
    
          },
          error: function(data){
            alert("You tried to send data to ajax.php but it didn´t give a OK response");
          }

        });
     
    });
      </script>
@endsection