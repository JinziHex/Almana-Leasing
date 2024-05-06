@extends('front-end.layouts.front-layout') 
@section('content')

@php
use App\Models\City;
use App\Models\City_location;
use App\Models\Country;
@endphp
<style type="text/css">
   #header.car-list-pg{background: #fff; position: static; float: none;}
   div#logo.car-list-pg{background: #fff;}
   .rental-wrapper.car-list-pg{padding: 0 0 50px;}
   .filter-bar{background: #e6e6e6; padding: 0 0 10px;}
   .filter-bar .dropdown.Choose{float: left; margin-top: 10px; margin-right: 10px;}
   .filter-bar .dropdown.Choose.sort{float: right; margin-top: 10px; margin-right: 0px; margin-left: 10px;}
   .filter-bar .dropdown.Choose button{font-size: 16px;}
   .filter-bar .dropdown.Choose button:hover{background: transparent; border-color: transparent; color: #fff;}
   .filter-bar .dropdown.Choose button:focus{outline: 0; box-shadow: none !important; background: transparent !important; border-color: transparent !important; color: #fff;}
   .filter-bar .dropdown.Choose button:active{outline: 0; box-shadow: none !important; background: transparent !important; border-color: transparent !important; color: #fff;}
   .filter-bar .dropdown.Choose .btn-default.active, 
   .filter-bar .dropdown.Choose .btn-default:active, 
   .filter-bar .dropdown.Choose.open>.dropdown-toggle.btn-default{background-color: transparent; border-color: transparent;}
   .filter-bar .dropdown.Choose button.dropdown-toggle::after{vertical-align: middle;}
   .filter-bar .dropdown.Choose ul.dropdown-menu{background: #fff;}
   .filter-bar .dropdown.Choose ul.dropdown-menu a{font-family: 'Roboto', sans-serif !important; font-size: 14px;}
   .filter-bar .dropdown.Choose.sort button.dropdown-toggle::after{border: none; content: "\e156"; font-family: "Glyphicons Halflings";}
   .filter-bar .dropdown.Choose.sort.Filter button.dropdown-toggle::after{border: none; content: "\e138"; font-family: "Glyphicons Halflings";}
   .car-list-pg .list-details{max-width: 900px; border-radius: 10px; margin: 50px auto 30px; background: #fff; align-items: center;}
   .car-list-pg .list-details p{margin: auto;}
   .car-list-pg .list-details .head{color: #ffc72c;}
   .car-list-pg .list-details .mrgn{margin: 20px 0; padding: 0 10px;}
   .car-list-pg .list-details .num-days{text-align: center;}
   .car-list-pg .list-details .num-days .txt{color: #0047bb; font-weight: 700; text-transform: uppercase;}
   .car-list-pg .list-details .num-days .txt span{display: block; font-size: 36px; margin: 5px 0;}
   .car-list-pg .car-list{}
   .car-list-pg .car-list .col-12{margin-bottom: 30px;}
   .car-list-pg .car-list .car-box1{background: #fff; border: 2px solid #ddd; border-left: 0; border-top: 0; height: 100%; padding: 10px 20px; }
   .car-list-pg .car-list .car-box1 img{display: block; margin: auto; width: 90%; height: 175px; object-fit: contain;}
   .car-list-pg .car-list .car-box1 .titl{}
   .car-list-pg .car-list .car-box1 .titl h2{text-transform: uppercase; font-size: 24px; font-weight: 700; color: #0047bb;}
   .car-list-pg .car-list .car-box1 .titl small{text-transform: none; color: gray; font-size: 16px;}
   .car-list-pg .car-list .car-box1 .titl p{text-transform: uppercase; font-size: 18px; border-bottom: 1px solid #ddd; padding: 10px 0;}
   .car-list-pg .car-list .car-box1 #carSpecs.all-spec p{display: block !important;}
   .car-list-pg .car-list .car-box1 #specMorBtn{color: #0047bb; background: transparent; border: none; padding: 0; font-family: 'Oswald', sans-serif; font-size: 13px; line-height: 20px;}
   .car-list-pg .car-list .car-box1 .car-price{text-align: center; align-items: flex-end;}
   .car-list-pg .car-list .car-box1 .car-price .day-price p{font-size: 24px;}
   .car-list-pg .car-list .car-box1 .car-price .day-price p small{display: block; font-size: 14px;}
   .car-list-pg .car-list .car-box1 .car-price .totl-price{}
   .car-list-pg .car-list .car-box1 .car-price .totl-price p{line-height: 1; background: #ffc72c; font-size: 36px; color: #0047bb; font-weight: 700;}
   .car-list-pg .car-list .car-box1 .car-price .totl-price p small{display: block; font-size: 14px; color: #fff;}
   .car-list-pg .car-list .car-box1 .car-price .totl-price p.ofr-price{background: transparent; color: red; font-size: 24px;}
   .car-list-pg .car-list .car-box1 .car-price .totl-price p.ofr-price small{color: red; display: inline;}
</style>
<div class="rental-wrapper car-list-pg car-single-pg car-summary-pg">
   <div class="filter-bar">
      <div class="container">
       <h2 style="margin: auto; margin-top: 10px; text-align: center; color: #000;">Booking Summary</h2>
      </div>
   </div>
   <div class="car-single-sec">
      <div class="container">
         <div class="row">
            <div class="col-12 col-sm-6 car-single-img">
               <img src="{{url('/assets/uploads/models/'.$ModelImage->model_image)}}">
            </div>
            <div class="col-12 col-sm-6 car-single-txt">
               <div class="titl">
                  <h2>{{$fetchModel->maker['maker_name']}} - {{$fetchModel->modal_name}}</h2>
                  <p>Car Specifications</p>
               </div>
               <div id="carSpecs" class="Specs carSpecs">
                  @foreach($modelSpec as $specss)
                  <p><img src="{{url('/assets/uploads/specifications/icons/'.$specss->specs['spec_icon'])}}" width="25"> {{$specss->specs['spec_name']}}</p>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
<form action="{{route('user.booking.save')}}" method="POST">
   @csrf
   @php
            $parseFrmDt = Helper::parseCarbon(Session::get('fromdate')); 
            $parseToDate = Helper::parseCarbon(Session::get('todate'));
            $parsePickTime = Helper::parseCarbon(Session::get('pickupTime'));
            $pickup = $parsePickTime->toTimeString();
            $parseRetnTime = Helper::parseCarbon(Session::get('returnTime'));
            $return = $parseRetnTime->toTimeString();
            @endphp 
            
            @php
   $ftCountryname = Country::where('country_id','=',$custNationality)->first();
   $cntName= $ftCountryname->country_name;
    $ftlcationName= City_location::where('city_loc_id','=',$custLocation)->first();
    $lcationName = $ftlcationName->location_name;
    $ftcityName = City::where('city_id','=',$custmrCity)->first();
    $cityName = $ftcityName->city_name;
   @endphp
   <input type="hidden" value="{{$fetchModel->modal_id}}"  name="book_car_model">
   <input type="hidden" name="book_cust_id" value="{{Auth::guard('main_customer')->user()->customer_id}}">
   <input type="hidden" value="{{$parseFrmDt}}" name="book_from_date">
   <input type="hidden" value="{{$parseToDate}}" name="book_to_date">
   <input type="hidden" value="{{Session::get('days')}}" name="book_total_days">
   <input type="hidden" value="{{Session::get('rate_type')}}" name="book_car_rate_type">
   <input type="hidden" value="{{$rate_per_day}}" name="book_daily_rate">
   <input type="hidden" value="{{$total_rate}}" name="book_total_rate">
   <input type="hidden" value="{{$pickup}}" name="book_pickup_time">
   <input type="hidden" value="{{$return}}" name="book_return_time">
   <input type="hidden" value="{{$fName}}" name="book_bill_cust_fname">
   <input type="hidden" value="{{$lName}}" name="book_bill_cust_lname">
   <input type="hidden" value="{{$MobileNumber}}" name="book_bill_cust_mobile">
   <input type="hidden" value="{{$custQatarId}}" name="book_bill_cust_qatar_id">
   <input type="hidden" value="{{$custNationality}}" name="book_bill_cust_nationality">
   <input type="hidden" value="{{$address1}}" name="book_bill_cust_address_1">
   <input type="hidden" value="{{$address2}}" name="book_bill_cust_address_2">
   <input type="hidden" value="{{$custmrCity}}" name="book_bill_cust_city">
   <input type="hidden" value="{{$custZipcode}}" name="book_bill_cust_zipcode">
   <input type="hidden" value="{{$custLocation}}" name="book_bill_cust_location">
   <input type="hidden" value="{{$custDob}}" name="book_bill_cust_dob">
   
   <div class="list-details row shadow" style="text-align: center;">
        <div class="col-12 Rental-Dtls">
          <h3>Booking Confirmation</h3>
        </div>
        <div class="col-12 col-md-12">
          <div class="mrgn">
          <p class="head">Hello, {{$fName}}&nbsp; {{$lName}}</p>
          <!-- <p class="txt">Doha</p> -->
          </div>
          <div class="mrgn">
          <!-- <p class="head">Location</p> -->
          <p class="txt">Billing Address:{{$address1}}<br>{{$address2}}</p>
            <p class="txt">Location: {{$cityName}},&nbsp; {{$lcationName}},&nbsp; {{$custZipcode}},&nbsp; {{$cntName}}</p>
          <p class="txt">Mobile Number: {{$MobileNumber}}<br>Passport Number:{{$custPassNumber}}<br>Qatar Id : {{$custQatarId}}</p>
        
          </div>
         
        </div>

      </div>

 <div class="row summary-date">
  <div class="col-12">
    <div class="col-12">
      <a href="#" class="btn btn-lg btn-block">Avaliable Coupons</a>
    </div>
  <div class="accordion mt-5" id="accordionExample">
  @foreach($coupons as $coupon)
				<div class="card">
					<div class="card-header" id="heading{{$coupon->id}}">
						<h2 class="clearfix mb-0">
							<a class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$coupon->id}}" aria-expanded="true" aria-controls="collapseOne"><i class="material-icons"></i> <h2>{{$coupon->coupon_code}}</h2></a>
              @if($coupon->discount_type==1)<span class="badge badge-primary">- {{$coupon->discount_value	}} QAR	@endif	
              @if($coupon->discount_type==2)<span class="badge badge-primary">- {{$coupon->discount_value	}} %	@endif		
              From :{{$coupon->minimum_order_amount}}	QAR	
						</h2>
					</div>
					<div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<div class="media">
								<img src="/examples/images/media/home.png" class="mr-3" alt="Home">
								<div class="media-body">
									<h5 class="mt-0"></h5>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor, varius quam at, luctus dui. Mauris magna metus, dapibus nec turpis vel, semper malesuada ante. Vestibulum id metus ac nisl bibendum scelerisque non non purus. Suspendisse varius nibh non aliquet sagittis. In tincidunt orci sit amet elementum vestibulum.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
  @endforeach
				
			
			</div>
  </div>
        
        <div class="col-6 border-right">
          <div class="date">
            
            <div class="dd">{{$parseFrmDt->format('d')}}</div>
            <div class="mmyy">
              <div class="mm">{{$parseFrmDt->format('M')}}</div>
              <div class="yy">{{$parseFrmDt->format('Y')}}</div>
            </div>
          </div>
          <div class="time">{{$pickup}}</div>
          <div class="city">{{Session::get('city_name')}}</div>
        </div>

        <div class="col-6 ">
          <div class="date">
            <div class="dd">{{$parseToDate->format('d')}}</div>
            <div class="mmyy">
              <div class="mm">{{$parseToDate->format('M')}}</div>
              <div class="yy">{{$parseToDate->format('Y')}}</div>
            </div>
          </div>
          <div class="time">{{$return}}</div>
          <div class="city">{{Session::get('location_name')}}</div>
        </div>

        <div class="border-bottom"> </div>
        <div class="row bill-list">
          <div class="col-6 titl"><p>Daily Rate:</p></div>
          <div class="col-6"><p>{{$rate_per_day}} {{Session::get('cur_code')}}</p></div>
        </div>
        <div class="row bill-list">
          <div class="col-6 titl"><p>No. of Days</p></div>
          <div class="col-6"><p>{{Session::get('days')}} Days</p></div>
        </div>
        <div class="row bill-list">
          <div class="col-6 titl"><p>Drop Fee</p></div>
          <div class="col-6"><p>0.00 QAR</p></div>
        </div>
        <div class="row bill-list">
          <div class="col-6 titl"><p>Additional Package</p></div>
          <div class="col-6"><p>0.00 QAR</p></div>
        </div>
        <div class="row bill-list">
          <div class="col-6 titl"><p>Apply Coupon Code</p></div>
          <div class="col-3"><p><input type="text" id="coupon_code"  class="form-control"></p></div>

          <div class="col-3"><input type="hidden" id="tot_amt" value="{{$total_rate}}"><p><input id="submitCoupon" type="button" class="btn btn-sm btn-danger"  class="form-control" value="APPLY"></p></div>
        </div>
        <div class="row bill-list">
        <div class="col-6"></div>
          <div class="col-6" id="ch"></div>
        </div>

        <div class="row bill-list summary-total">
          <div class="col-6 titl"><p>Total:</p></div>
          <div class="col-6"><p id="rateTag">{{$total_rate}}</p> {{Session::get('cur_code')}}</p></div>

          <button type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">Confirm</button>
        </div>

      </div>
   </form>
</div>

<div style="clear: both;"></div>
</div>
<hr />

  <script type="text/javascript">
          $(document).ready(function(){
$(function () {
  var checkboxes = $("input[type='checkbox']"),
    submitButt = $("#sub1");

    checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
});
        //check atleat 1 checkbox is checked
        // $('#sub1').on('click',function(){
        // if (!$('#terms').is(':checked')) {
        //   $("#erterm").css("color", "red");
        
         
        //     e.preventDefault();
        // }
        // });
          });

      });
            $("#submitCoupon").click(function() {
              var coupon_code=$('#coupon_code').val();
              var tot_amt=$('#tot_amt').val();
        $.ajax({
          type: "GET",
          url:"{{url('/apply-coupon')}}?coupon_code="+coupon_code+"&&total_amount="+tot_amt,
          success: function(data) {
            //alert(data.status);
            $('#rateTag').text(data.total_rate); 
           if(data.status==0)
           {
            $('#ch').html("Invalid coupon code"); 
           
           }
           if(data.status==2)
           {
  
            $('#ch').html("Coupon code applied successfully"); 
            $('#submitCoupon').hide();
           

           }
           if(data.status==5)
           {
  
            $('#ch').html("Coupon Expired"); 
           

           }
           if(data.status==6)
           {
  
            $('#ch').html("Not Applicable to current amount"); 
           

           }
           if(data.status==1)
           {
            $('#ch').html("You can not apply this coupon code.This coupon already applied before"); 
        
           }
         
            
          },
          error: function(data){
            alert("You tried to send data to ajax.php but it didn´t give a OK response");
          }

        });
     
    });
      </script>
@endsection