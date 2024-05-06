@extends('front-end.layouts.front-layout')
@section('content')
<style type="text/css">
   #header.car-list-pg{background: #fff; position: static; float: none;}
   div#logo.car-list-pg{background: #ffc72c;}
   .rental-wrapper.car-list-pg{padding: 0 0 50px;}
   .filter-bar{background: #ffc72c; padding: 0 0 10px;}
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
   .selctnation .select2-container{width:100% !important;}
</style>
<div class="rental-wrapper car-list-pg car-single-pg">
   <div class="filter-bar">
      <div class="container">
         <h2 style="margin: auto; margin-top: 10px; text-align: center; color: #000;">Personal Info</h2>
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
                  <h2>{{$fetchModel->maker->maker_name}} - {{$fetchModel->modal_name}}</h2>
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
   <div class="list-details row shadow">
      <div class="col-12 Rental-Dtls">
         <h3>Rental Details</h3>
      </div>
      <div class="col-6 col-md-3">
         <div class="mrgn">
            <p class="head">City</p>
            <p class="txt">{{Session::get('city_name')}}</p>
         </div>
         <div class="mrgn">
            <p class="head">Location</p>
            <p class="txt">{{Session::get('location_name')}}</p>
         </div>
      </div>
      <div class="col-6 col-md-3">
         <div class="mrgn">
            <p class="head">Pickup Date & Time </p>
            <p class="txt">{{Session::get('fromdate')}}-{{Session::get('pickupTime')}}</p>
         </div>
         <div class="mrgn">
            <p class="head">Return Date & Time</p>
            <p class="txt">{{Session::get('todate')}}-{{Session::get('returnTime')}}</p>
         </div>
      </div>
      <div class="col-6 col-md-3">
         <div class="mrgn">
            <p class="head">Daily Rate</p>
            <p class="txt">{{number_format($Rate_per_day, 3, '.', '')}} {{Session::get('cur_code')}}</p>
         </div>
         <div class="mrgn">
            <p class="head">No. Of Days</p>
            <p class="txt">{{Session::get('days')}} Days</p>
         </div>
      </div>
      <div class="col-6 col-md-3">
         <div class="totl-price ">
            <!-- <p class="ofr-price"><small>Offer Price</small> 200 QR</p> -->
            <p class=""><small>Total</small>{{$Total_Rate}} {{Session::get('cur_code')}}</p>
         </div>
      </div>
   </div>
   <div class="car-single-form">
      <div class="container">
         <form action="{{route('user.personal.info.save')}}" method="POST" class="row">
            @csrf
            <input type="hidden" name="model_id" value="{{$fetchModel->modal_id}}">
            <input type="hidden" value="{{$Rate_per_day}}" name="rate_per_day">
            <input type="hidden" value="{{$Total_Rate}}" name="total_rate">
            <div class="form-group col-md-6">
               <label for="">First Name <sup>*</sup></label>
               <input id="" class="form-control" required="" name="first_name" type="text" placeholder="Enter First Name" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_fname }}@endif">
            </div>
            <div class="form-group col-md-6">
               <label for="">Last Name <sup>*</sup></label>
               <input id="" class="form-control" required=""  type="text" name="last_name" placeholder="Enter Last Name" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_lname}}@endif">
            </div>
            <div class="form-group col-md-6">
               <label for="">Mobile Number <sup>*</sup></label>
               <input id="" class="form-control" required=""  type="text" name="mobile_number" placeholder="Enter your Mobile Number" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_mobile_number}}@endif">
            </div>
            <div class="form-group col-md-6 date time-picker">
               <label for="dob">Date Of Birth</label>
               <input id="input_1_26" class="form-control" required="" name="customer_dob"  type="text" placeholder="Choose date of birth" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_dob}}@endif">
            </div>
            <div class="form-group col-md-6">
               <label for="">Qatar ID</label>
               <input id="" class="form-control" required=""  type="text" name="customer_qatar_id" 
                placeholder="Enter your Qatar Id" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_qatar_id}}@endif">
            </div>
            <div class="form-group col-md-6">
               <label for="">Passport Number</label>
               <input id="" class="form-control" required=""  type="text" name="customer_passport_number" placeholder="Enter your passport number" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_passport_number}}@endif">
            </div>
            <div class="form-group col-md-6 selctnation">
               <label for="">Nationality</label>
               @if(Auth::guard('main_customer')->check())
               @php
               $getContry = Auth::guard('main_customer')->user()->customer->cust_nationality;
               @endphp
               @endif
               <select class="form-control select2" id="" required="" name="cust_nationality">
                  <option value="">--Choose a country--</option>

                  @foreach($getCont as $getConts)
                    <option {{$getContry  == $getConts->country_id ? 'selected':''}} value="{{$getConts->country_id}}">{{$getConts->country_name}} </option>
                    @endforeach
               </select>
            </div>
            <div class="form-group col-md-6">
               <label for="">Additional Information</label>
               <p><small>{{$getInfo->st_description}}</small></p>
            </div>
            <div class="form-group col-md-12">
               <label for="">Terms And Conditions</label>
               <div class="tnc">
                  <p><small>{{$getTerms->st_description}}</small></p>
                  <p><small>@if($getTerms->st_description_line_2) {{$getTerms->st_description_line_2}} @endif</small></p>
               </div>
            </div>
            <div class="form-check terms-agree col-md-12">
               <input type="checkbox" class="form-check-input" id="terms-agree">
               <label class="form-check-label" for="terms-agree" style="margin-top: -23px;margin-left: 20px;">I agree with all the terms of service and privacy policy</label>
            </div>
            <button type="button" data-toggle="modal" data-target="#billing-addrs" form="" id="sub1" class="btn btn-warning btn-lg btn-block mx-auto text-white" disabled="">Next</button>
        
      </div>
   </div>
</div>
<!-- billing address Modal -->
<!-- billing address Modal -->
<div class="modal " id="billing-addrs" role="dialog">
   <!-- fade -->
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h2 style="color: #0047bb;" class="modal-title">Billing Address</h2>
            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
         </div>
         <div class="modal-body">
            <div class="row" style="margin:0;">
               <div class="form-group col-md-12">
                  <label for="">Address Line 1 <sup>*</sup></label>
                  <textarea class="form-control" required="" placeholder="Enter Address" rows="4" cols="20" name="cust_address_line_1">@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_address_line_1}}@endif</textarea>
               </div>
               <div class="form-group col-md-6">
                  <label for="">Address Line 2 <sup>*</sup></label>
                  <textarea class="form-control" required="" placeholder="Enter region/landmark" rows="4" cols="20" name="cust_address_line_2">@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_address_line_2}}@endif</textarea>
               </div>
               <div class="form-group col-md-6">
                   <div style="margin-bottom:1rem;">
                  <label for="">City <sup>*</sup></label>
                  <select class="form-control" id="SelectCity" name="cust_city" required="">
                      <option value="">Please choose city</option>
                       @if(Auth::guard('main_customer')->check())
                        @if(Auth::guard('main_customer')->user()->customer->cust_city)
                        @php $cityId = Auth::guard('main_customer')->user()->customer->cust_city; @endphp
                           @foreach($fetchCity as $fetchCitys)
                           <option value="{{$fetchCitys->city_id}}" {{ $fetchCitys->city_id == $cityId ? 'selected' : '' }}>{{$fetchCitys->city_name}}</option>
                           @endforeach
                           @endif
                        @else
                        @foreach($fetchCity as $fetchCitys)
                           <option value="{{$fetchCitys->city_id}}">{{$fetchCitys->city_name}}</option>
                           @endforeach
                           @endif
                        
                  </select>
                  </div>
                  <div style="margin-bottom:1rem;">
                      <label for="">Location</label>
                   <select class="form-control" id="SelectLocation" name="cust_location" required="">
                  @if(Auth::guard('main_customer')->user()->customer->cust_state)
                  @php $locationId = Auth::guard('main_customer')->user()->customer->cust_state; @endphp
               <option value="{{$locationId}}" selected="">{{Auth::guard('main_customer')->user()->customer->location['location_name']}}</option>
               @else
               <option value="">--Choose a location--</option>
               @endif
                  </select>
                  </div>
               </div>
               <!-- <div class="form-group col-md-6" id="sandbox-container">
                  <label for="dob">Date Of Birth <i class="fa fa-calendar" aria-hidden="true"></i></label>
                  <input id="dob" class="form-control" type="text" placeholder="">
                  </div> -->
               <!--<div class="form-group col-md-6">-->
                  
                  <!--<input id="" class="form-control" type="text" required="" placeholder="" name="cust_location">-->
               <!--</div>-->
               <div class="form-group col-md-6">
                  <label for="">Zipcode</label>
                  <input id="" class="form-control" type="text" name="cust_zipcode" placeholder="" value="@if(Auth::guard('main_customer')->check()){{Auth::guard('main_customer')->user()->customer->cust_zipcode}}@endif">
               </div>
               <div class="form-group col-md-6">
                  <label for="">Country</label>
                  <select class="form-control" id="" name="cust_nationality" required="">
                     <option value="">--Choose a country--</option>
                     @if(Auth::guard('main_customer')->user()->customer->cust_bill_country)
                     @php $NationalityiD = Auth::guard('main_customer')->user()->customer->cust_bill_country; @endphp
                     @foreach($getCont as $getConts)
                    <option value="{{$getConts->country_id}}" {{ $getConts->country_id == $NationalityiD ? 'selected' : '' }}>{{$getConts->country_name}} </option>
                    @endforeach
                    @else
                     @foreach($getCont as $getConts)
                    <option value="{{$getConts->country_id}}" >{{$getConts->country_name}} </option>
                    @endforeach
                    @endif
                  </select>
               </div>
               <div class="form-group col-md-12">
                  <!-- <label for="">Additional Information</label> -->
                  <!-- <p><small></small></p> -->
                  <ul>
                     <li>The credit or debit card that was used for payment online (if the rental is prepaid) This card MUST be in the name of the name driver who MUST  be present at the time of pick-up.</li>
                     <li>Details can be found in the forms of payment informations.</li>
                  </ul>
               </div>
               </div>
               <!-- <button type="button" data-toggle="modal" data-target="#billing-addrs" form="" class="btn btn-warning btn-lg btn-block mx-auto text-white">Next</button> -->
            
         </div>
         <div class="modal-footer">
            <input type="submit" value="Submit" class="btn btn-warning btn-lg btn-block mx-auto text-white">
            <button type="button" class="btn-cancel btn btn-lg btn-block mx-auto" data-dismiss="modal">Cancel</button>
         </div>
      </div>
   </div>
</div>
</form>
<!-- end billing address Modal -->
<!-- end billing address Modal -->
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
      </script>
         <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
       <script>
    $('.select2').select2();
</script>
@endsection