@extends('front-end.layouts.front-layout')
@section('content')
@php
use Carbon\Carbon;
@endphp
<style type="text/css">
  .ui-dialog-titlebar.ui-corner-all.ui-widget-header.ui-helper-clearfix.ui-draggable-handle {background-color: #ffc72c;font-size: 16px;font-family: 'Oswald', sans-serif !important;text-align: center;border: none;border-bottom-left-radius: 0;border-bottom-right-radius: 0;cursor: default !important;}
  .ui-widget.ui-widget-content{padding: 0px !important;}
  .ui-dialog .ui-dialog-title{width: 100% !important;}
  .ui-dialog .ui-dialog-titlebar-close, 
  .ui-dialog .ui-dialog-titlebar-close:focus,
  .ui-dialog .ui-dialog-titlebar-close:active{background: transparent;border: none;}
  .ui-dialog .ui-dialog-content{text-align: center;padding: 25px !important;min-height: 130px !important;height: auto !important;font-size: 12px;}
  .ui-dialog .ui-dialog-buttonpane{margin-top: 0 !important;padding: 10px 25px !important;}
  .ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset{float: none;text-align: center;}
  .ui-dialog .ui-dialog-buttonpane button,
  .ui-dialog .ui-dialog-buttonpane button:focus,
  .ui-dialog .ui-dialog-buttonpane button:active{background: #ffc72c;padding: 8px;min-width: 100px;font-size: 12px;}

</style>

{{-- <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css"> --}}
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
<div class="rental-wrapper car-list-pg" style="padding:0;">
  <div class="filter-bar">
    <div class="container">
      <!--<div class="dropdown Choose headrlog">-->
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
      <!--                   document.getElementById('logout-form1').submit();">{{ __('Sign Out')}}</a></li>-->
      <!--      <form id="logout-form1" action="{{ route('user.logout') }}" method="POST" style="display: none;">-->
      <!--                      @csrf-->
      <!--      </form>-->
      <!--  </ul>-->
      
      <!--</div>-->
      <!--@endif-->
    </div>
  </div>
</div>
<div class="rental-wrapper car-list-pg">
  <div class="search-form">
    <form action="{{route('car.search')}}" method="GET" id="vehicle-search" class="row shadow mx-0">
      @csrf
      {{-- <input type="hidden" value="1" name="cur_type"> --}}
      <div class="form-group col-md-6">
        <label for="SelectCity">{{ __('Select City') }}</label>
        <select class="form-control" id="SelectCity" name="city_id" required="">
          
          <option value="" disabled selected hidden>Please choose city</option>
          @foreach($fetchCity as $fetchCitys)
          <option {{old('city_id') == $fetchCitys->city_id ? 'selected':''}} value="{{$fetchCitys->city_id}}">{{__($fetchCitys->city_name)}}</option>
          @endforeach
        </select>
        <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
      </div>
      <div class="form-group col-md-6">
        <label for="SelectLocation">Select Location</label>
        <select class="form-control" id="SelectLocation" data-selected-state="{{old('city_loc_id') }}" name="city_loc_id" required=""> 
          <option value="">Choose a location</option>
        </select>
      </div>
      @php
      $curDt = Carbon::now();
      $frmdt  = $curDt->format('m/d/Y');
      $toDat = $curDt->addDays(1);
      $formatToDat = $toDat->format('m/d/Y');

      // $parseFrmDt = Helper::parseCarbon($frmDate); //parse from date to carbon format
      // $getFromDayName = $parseFrmDt->format('l');
      // $parseToDate = Helper::parseCarbon($toDate); //parse to date to carbon format
      // $getToDayName =  $parseToDate->format('l');
      
      @endphp
      <div class="form-group col-md-6 date time-picker">
        <label for="FromDate">From Date </label>
        <input type="hidden" id="sessionLocale" value="{{session()->get('locale')??'en'}}">
        <input id="input_1_24" class="form-control" type="text" autocomplete="off" placeholder="Select from date" name="from_date" required="" value="{{@$frmdt}}">
      </div>
      <div class="form-group col-md-6 date time-picker">
        <label for="FromDate">Pickup Time </label>
        <input id="picktime" class="form-control" type="text" placeholder="Select pick up time" name="pickup_time" required="">
      </div>
      <div class="form-group col-md-6 date time-picker">
        <label for="ToDate">To Date </label>
        <input id="input_1_25" class="form-control" type="text" autocomplete="off" placeholder="Select to date" name="to_date" required="" value="{{@$formatToDat}}">
      </div>
      <div class="form-group col-md-6 date time-picker">
        <label for="FromDate">Return Time </label>
        <input id="rettime" class="form-control" type="text" placeholder="Select return time" name="return_time" required="">
      </div>
      <input type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">
      <button type="submit" id="carsearchbtn" form="vehicle-search" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 70px;">Show Vehicles </button>
    </div>
  </form>
</div>
<div style="clear: both;"></div>
</div>
<hr />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<div id="dialog" style="display: none">
    You have selected to pick-up/drop-off on a Friday, which is a public holiday in Qatar.<br>Should you continue with your selected dates? We will endeavour to satisfy your request.
</div>
<script type="text/javascript">
//   $('#vehicle-search').submit(function(){
   
//     var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
//     var fromdate = $('#input_1_24').val();
//     var loIsDate = new Date(fromdate);
//     var fromDay = weekday[loIsDate.getDay()];

//     var todate = $('#input_1_25').val();
//     var loIsDateTo = new Date(todate);
//     var toDay = weekday[loIsDateTo.getDay()];

//     if(fromDay == "Friday" || toDay == "Friday")
//     {
//       // return confirm('Out of Office Hours! You have selected to pickup/drop-off on a Friday which is a public holiday in Qatar.Should you continue with your selected dates?');
//       $("#dialog").dialog({

//             title: "Out of Office Hours",
//             resizable: false,
//             height: 200,
//             width: 400,
//             modal: true,
//             buttons: {
//                 "Yes": function() {
//                     $('#vehicle-search').submit();
//                 },
//                 No: function() {
//                     $(this).dialog("close");
//                 }
//             }
//         });
//         return false;
//           }else{
//             return true;
//           }

//   });
</script>
<script type="text/javascript">
$(document).ready(function(){
$(function () {

var OldstateValue = '{{ old('city_loc_id') }}';

var locale=$('#sessionLocale').val();

if(OldstateValue !== '') {
$('#SelectLocation').val(OldstateValue);
$("#SelectLocation").change();
}



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
if(locale=='en')
			{
				//alert('1');
				$.each(res,function(ar_location_name,location_name,city_loc_id){
				$("#SelectLocation").append('<option value="'+city_loc_id+'">'+ar_location_name+'</option>');
				});

			}
			else
			{
				//alert(2);
				$.each(res,function(ar_location_name,location_name,city_loc_id){
				$("#SelectLocation").append('<option value="'+city_loc_id+'">'+location_name+'</option>');
			});
			}

// take subcategory value which has been selected in data attribute
var subCategoryVal = $("#SelectLocation").attr("data-selected-state");

if(subCategoryVal !== '')
{
// assign chosen data attribute value to select
$("#SelectLocation").val(subCategoryVal);
$("#SelectLocation").change();
}

}else{
$("#SelectLocation").empty();
}
}
});
}
});

});
//change location ends

});
</script>
{{--  <script src="http://code.jquery.com/jquery-1.9.1.js"></script> --}}
{{--   <script type="text/javascript">
var dateFormat = "dd-mm-yy",
from = $("#from")
.datepicker({
defaultDate: "+1w",
changeMonth: true,
dateFormat: dateFormat,
minDate: new Date(),
})
.on("change", function() {
var toMinDate = getDate(this);
toMinDate.setDate(toMinDate.getDate() + 1);
to.datepicker("option", "minDate", toMinDate);
}),
to = $("#to").datepicker({
defaultDate: "+1w",
changeMonth: true,
dateFormat: dateFormat,
minDate: new Date(),
})
.on("change", function() {
var fromMaxDate = getDate(this);
fromMaxDate.setDate(fromMaxDate.getDate() - 1);
from.datepicker("option", "maxDate", fromMaxDate);
});
function getDate(element) {
var date;
try {
date = $.datepicker.parseDate(dateFormat, element.value);
} catch (error) {
date = null;
}
return date;
}
</script>
--}}
@endsection