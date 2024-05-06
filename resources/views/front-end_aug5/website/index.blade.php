@extends('front-end.layouts.web-layout')
@section('content')
@php
use Carbon\Carbon;
@endphp
@php
$curDt = Carbon::now();
$frmdt  = $curDt->format('m/d/Y');
$toDat = $curDt->addDays(1);
$formatToDat = $toDat->format('m/d/Y');
@endphp
<style type="text/css">
	div#bulletS {margin: 18px 0;}div#bulletS ul {list-style-image: url('/assets/front/website/images/bullet.png');}div#bulletS ul li{padding: 13px 9px;font-size: 15px;}
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
.mdlclas .mdlimg img{height: 200px !important;width: 100% !important; object-fit: contain !important;object-position: center !important;background-color: #fff; }
</style>
<div class="bg-white" style="display: inline-block;vertical-align: top;">
	<div class="banner">
	
			<img src="{{URL::TO('assets/front/website/images/banner-img.jpg')}}" class="img-fluid" id="myVideo" alt="">

		
	
		<div class="slider_overLay"></div>
		<div class="container">
			<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			</div>
		</div>
	</div>

	<div id="wrapper">
		<div class="container">
		<!--	<input type="text" id="sessionLocale" value="{{session()->get('locale')??'en'}}">-->
			<form id="contactForm" action="{{route('car.search')}}" method="GET" data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500" class="vehicle-search">
				@csrf
				<div class="row arbv">
					<div class="form-group  col-sm-12 col-md-6 col-lg-5">
						<label>{{__('Select City')}}</label>
						<div class="input-container cc1">
							<select class="input-field" id="SelectCity" name="city_id" required="required">
								<option value="" disabled selected hidden>{{__('Please choose city')}}</option>
								@foreach($fetchCity as $fetchCitys)
								<option {{old('city_id') == $fetchCitys->city_id ? 'selected':''}} value="{{$fetchCitys->city_id}}">{{__($fetchCitys->city_name)}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group  col-sm-12 col-md-6 col-lg-5">
						<label>{{__('Select Location')}}</label>
						<div class="input-container cc1" id="hexLocationOuter">
							<select class="input-field" id="SelectLocation" data-selected-state="{{old('city_loc_id') }}" name="city_loc_id" required="required">
								<option value="">{{__('Select Location')}}</option>
							</select>
						</div>
					</div>
					<div class="form-group  col-sm-12 col-md-6 col-lg-5  date time-picker" >
						<label>{{__('From Date')}}</label>
						<div class="input-containerd">
							<input @if(session()->get('locale')=='ar') dir="rtl" @endif  id="input_1_24" class="input-field dttymfld" type="text" autocomplete="off" placeholder="Select from date" name="from_date" required="" value="{{@$frmdt}}">
							<input @if(session()->get('locale')=='ar') dir="rtl" @endif  id="picktime" class="input-field dttymfld" type="text" placeholder="Select pick up time" name="pickup_time" required="">
						</div>
						
					</div>
					<div class="form-group  col-sm-12 col-md-6 col-lg-5  date time-picker" >
						<label>{{__('To Date')}}</label>
						<div class="input-containerd">
							<input @if(session()->get('locale')=='ar') dir="rtl" @endif  id="input_1_25" class="input-field dttymfld" type="text" autocomplete="off" placeholder="Select to date" name="to_date" required="" value="{{@$formatToDat}}">
							<input @if(session()->get('locale')=='ar') dir="rtl" @endif  id="rettime" class="input-field dttymfld" type="text" placeholder="Select return time" name="return_time" required="">
							<input  type="hidden" name="cur_type" value="{{session()->get('cur_type')}}">
						</div>
						
					</div>
					<div class="form-group  col-sm-12 col-md-12 col-lg-2">
						<input type="submit" class="btn btn-snd" value="{{__('Send')}}" name="submit">
					</div>
					
				</div>
			</form>
		</div>
		</div>
		<!-- *********** -->
		<div class="section2" data-aos="fade-up" data-aos-duration="3000">
			<div class="container">
				<div class="row text-center">
					
					@foreach($fetchService as $fetchServices)
					
					<div class="col-sm-12 col-md-6 col-lg-4" data-aos-duration="1200">
						<div class="thumbnail">
							<img src="{{url('/assets/uploads/service/icons/'.@$fetchServices->service_icon)}}" alt="h" class="serv-img">
							<div class="caption">
								<h2>{{ __(@$fetchServices->service_title) }}</h2>
								<p>{!! __(substr(@$fetchServices->service_description,0,180)) !!}</p>
								<p><a href="#" class="btn btn-primary" role="button"><img src="{{URL::TO('assets/front/website/images/arrow-r.png')}}" alt=""></a></p>
							</div>
						</div>
					</div>
					@endforeach
					
				</div>
			</div>
		</div>
		<div class="section3" style="background: transparent;">
			<div class="container">
				<h3 class="text-center">{{__('List Of Cars')}}</h3>
				<div class="list-cars">
					<div class="row">
						@foreach($fetchCarList['Models'] as $fetchCarLists)
						<div class="col-sm-12 col-md-6 col-lg-4 blocks mdlclas" data-aos-duration="2000">
							<div class="thumbnail hm-im mdlimg">
								<img src="{{url('/assets/uploads/models/'.@$fetchCarLists['Model_image'])}}" alt="">
							</div>
							<div class="caption flss">
								<div class=" flsr">
									<div class="left-wrap">
										<h4>{{ @$fetchCarLists['Model_name'] }}</h4>
									</div>
									<div class="middle-wrap bjs">
										<h5>{{__('Price')}}</h5>
										<p> QAR {{number_format(@$fetchCarLists['Rate_per_day'], 3, '.', '')}}</p>
										
									</div>
								</div>
								<div class="right-wrap ww">
									@if(Auth::guard('main_customer')->check())
									<a href="#">
										<img class="diplay-block" src="{{URL::TO('assets/front/website/images/carslct-icon.png')}}" alt="">
										<img class="diplay-none" src="{{URL::TO('assets/front/website/images/carpln-icon.png')}}" alt="" style="display: none;">
										
										<p>{{__('Book Your')}} <span>{{__('Ride Now')}}</span></p>
									</a>
									@else
									<a href="{{route('user.login')}}">
										<img class="diplay-block" src="{{URL::TO('assets/front/website/images/carslct-icon.png')}}" alt="">
										<img class="diplay-none" src="{{URL::TO('assets/front/website/images/carpln-icon.png')}}" alt="" style="display: none;">
										
										<p>{{__('Book Your')}} <span>{{__('Ride Now')}}</span></p>
									</a>
									@endif
								</div>
								
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<!-- *********** -->
		<div class="section4">
			<div class="container">
				<h2 class="text-center">{{ @$whyChooseUs->page_title  }}</h2>
				<div class="row">
					<div class="col-sm-12 col-md-7 left-content" data-aos="fade-right" data-aos-duration="1500">
						<p>{!! @$whyChooseUs->page_content !!}</p>
					</div>
					<div class="col-sm-12 col-md-5 right-content" id="bulletS" data-aos="fade-left" data-aos-duration="2000">
						{!! @$whyChooseUs->page_content_2 !!}
						
						
					</div>
				</div>
			</div>
		</div>
		<!-- ** -->
		<!-- *** -->
		<div class="section6">
			<div class="container">
				<div class="row">
				    <div class="mbdiv">
					<div class="col-sm-12 col-md-4 col-lg-5" data-aos="zoom-out-left" data-aos-duration="1500">
						<img src="{{URL::TO('assets/front/website/images/left1.png')}}" alt="" usemap="#planetmap">
						<map name="planetmap">
						<area href="http://rentsolutions.hexeam.in" target="_gryn" shape="poly" coords="209,140,217,254,399,251,394,138" alt="Rent Solutions">
							<area href="http://www.playstore.com" target="_gryn" shape="poly" coords="201,296,202,359,417,356,416,296" alt="Android">
								<area href="http://www.iphone.com" target="_gryn" shape="poly" coords="201,376,202,437,418,435,417,375" alt="Iphone">
									
									</map>
									</map>
								</div>
								<div class="col-sm-12 col-md-8 col-lg-7 content-wrap" data-aos="zoom-out-right" data-aos-duration="1500">
									<h4>{{__('Download the app now &')}}</h4>
									<h5>{{__('Get exciting new offer')}}</h5>
									<p>{{__('Best Price Car Rental - Guaranteed. Low-Cost Rental with affordable, Quality,Friendly And Legally Compliant Services and Competitive Rates')}}
</p>
								</div>
								</div>
							</div>
						</div>
					</div>
					<div class="section5" data-aos="fade-up" data-aos-easing="linear" data-aos-duration="1500">
						<div class="container">
							<div id="strip">
								<h1>we are ready to take your call 24 hours , 7 days! <br /> D Ring Rd, Doha, Qatar , +974 4441 4449</h1>
							</div>
						</div>
					</div>
					<!-- *** -->
				</div>
			</div>
			<!-- **************** -->
			<div id="dialog" style="display: none">
				You have selected to pick-up/drop-off on a Friday, which is a public holiday in Qatar.<br>Should you continue with your selected dates? We will endeavour to satisfy your request.
			</div>
			{{-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> --}}
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
			<script type="text/javascript">
// 			$('.vehicle-search').submit(function(){
			
// 			var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
// 			var fromdate = $('#input_1_24').val();
// 			var loIsDate = new Date(fromdate);
// 			var fromDay = weekday[loIsDate.getDay()];
// 			var todate = $('#input_1_25').val();
// 			var loIsDateTo = new Date(todate);
// 			var toDay = weekday[loIsDateTo.getDay()];
// 			if(fromDay == "Friday" || toDay == "Friday")
// 			{
// 			// return confirm('Out of Office Hours! You have selected to pickup/drop-off on a Friday which is a public holiday in Qatar.Should you continue with your selected dates?');
// 			$("#dialog").dialog({
// 			title: "Out of Office Hours",
// 			resizable: false,
// 			height: 200,
// 			width: 400,
// 			modal: true,
// 			buttons: {
// 			"Yes": function() {
// 			$('.vehicle-search').submit();
// 			},
// 			No: function() {
// 			$(this).dialog("close");
// 			}
// 			}
// 			});
// 			return false;
// 			}else{
// 			return true;
// 			}
// 			});
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
			url:"{{url('/get-location-list-profile')}}?city_id="+city_id,
			success:function(res){
			if(res){
			$('#SelectLocation').prop("disabled", false);
			$("#SelectLocation").empty();
			$("#SelectLocation").append('<option value="">{{__('Select Location')}}</option>');
			console.log(res);
			if(locale=='en')
			{
				//alert('1');
				 $.each(res,function(city_loc_id,location_name){
                    $("#SelectLocation").append('<option value="'+city_loc_id+'">'+location_name+'</option>');
                });

			}
			else
			{
				//alert(2);
				 $.each(res,function(city_loc_id,location_name){
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
			@endsection