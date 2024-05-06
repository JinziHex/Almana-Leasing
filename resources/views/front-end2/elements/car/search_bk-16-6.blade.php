@extends('front-end.layouts.front-layout')
@section('content')
@php
use App\Models\Model_image;
use App\Models\Model_specification;
use App\Models\Mode_rate;
use App\Models\Maker;
use App\Models\Model_category;
@endphp
<style>
.filterspn{float:left;margin-top:10px;margin-right:10px;}
.filterspn span{padding: 50px;margin: 0px !important;font-size: 16px;padding: .375rem .75rem;display: inline-block;vertical-align: middle;line-height: 1.5;}
.filterstyle select{font-size: 16px;display: inline-block;font-weight: 400;color: #212529;text-align: center;vertical-align: top;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-color: transparent !important;border: 1px solid transparent;padding: .375rem .75rem;line-height: 1.5;border-radius: .25rem;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;text-transform: none;}
.filterstyle select option{font-family: 'Roboto', sans-serif !important;font-size: 14px;display: block;padding: 3px 20px;clear: both;font-weight: 400;line-height: 1.42857143;color: #333;white-space: nowrap;}
.filterstyle .sortarrow{position: relative; float: left;margin-right: 10px;}
.filterstyle .sortarrow label{position: absolute; right: 0; top: 17px; border-top: 5px solid;border-right: 5px solid transparent;border-bottom: 0;border-left: 5px solid transparent;color: #212529;transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;}
.filterstyle button:hover{background-color: #0069d9 !important;}
.filterstyle .sortarrow:hover select{color:#fff;}
.filterstyle .sortarrow:hover label{color:#fff;}
</style>
<div class="rental-wrapper car-list-pg">
  <div class="filter-bar">
    <div class="container">
      <div class="dropdown Choose">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Choose Currency {{Session::get('cur_code')}}
        <!-- <span class="caret"></span> -->
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          @foreach($fetcCurrency as $fetcCurrencys)
          @php
          $encChangeCurrency = Crypt::encryptString($fetcCurrencys->currency_id);
          @endphp
          <li><a href="{{url('car/search/change-currency/'.$encChangeCurrency)}}">{{$fetcCurrencys->currency_name}}&nbsp;({{$fetcCurrencys->currency_code}})</a></li>
          @endforeach
        </ul>
      </div>
      <div class="dropdown Choose filterstyle">
        <form method="GET" action="{{route('car.search')}}">
          @csrf
          <div class="sortarrow">
            <label></label>
            <select name="id"> {{-- onchange='if(this.value != 0) { this.form.submit(); }' --}}
              <option value="" selected="selected" disabled="disabled" style="display: none;">Vehicle Type</option>
              @foreach($vehicleType as $vehicleTypes)
              <option value="{{$vehicleTypes->model_cat_id}}">{{$vehicleTypes->model_cat_name}}</option>
              @endforeach
            </select>
          </div>
          <div class="sortarrow">
            <label></label>
            <select name="bid">
              <option value="" selected="selected" disabled="disabled" style="display: none;">Brand</option>
              @foreach($vehicleMaker as $vehicleMakers)
              <option value="{{$vehicleMakers->maker_id}}">{{$vehicleMakers->maker_name}}</option>
              @endforeach
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Apply Filter</button>
        </form>
      </div>
      <div class="filterspn">
        
        @isset($id,$bid)  
        @if($id!=13 && $bid!=29)
        @php
        $vehcleDet = Model_category::where('model_cat_id','=',$id)->first();
        if($vehcleDet)
        {
        $vehcleTyp = $vehcleDet->model_cat_name;
        }
        $brandDet = Maker::where('maker_id','=',$bid)->first();
        if($brandDet)
        {
        $brandType = $brandDet->maker_name;
        }
        
        @endphp
        <span><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search Results for {{$brandType}} - {{$vehcleTyp}}</span>
        @endif
        
        @elseif($id)
        @if($id!=13)
        @php
        $vehcleDet = Model_category::where('model_cat_id','=',$id)->first();
        if($vehcleDet)
        {
        $vehcleTyp = $vehcleDet->model_cat_name;
        }
        @endphp
        
        <span><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search Results for {{$vehcleTyp}}.</span>
        @endif
        @elseif($bid)
        @if($bid!=29)
        @php
        $brandDet = Maker::where('maker_id','=',$bid)->first();
        if($brandDet)
        {
        $brandType = $brandDet->maker_name;
        }
        @endphp
        <span><i class="fa fa-search" aria-hidden="true"></i>&nbsp; Search Results for {{$brandType}}.</span>
        @endif
        @else
        <span style="display: none;">None</span>
        @endif
      </div>
      
      <div class="dropdown Choose sort">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Sort by
        <!-- <span class="caret"></span> -->
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
          @php
          $lottohigh = "1";
          $hightolow = "2";
          @endphp
          <li><a href="{{url('car/search/sort/'.$lottohigh)}}">Price: Low to High</a></li>
          <li><a href="{{url('car/search/sort/'.$hightolow)}}">Price:  High to Low</a></li>
        </ul>
      </div>
      
      
    </div>
  </div>
  <form action="{{route('car.search')}}" method="GET" style="padding: 0 15px;">
    @csrf
    <div class="list-details row shadow">
      <div class="col-6 col-md-3">
        <div class="mrgn inp-spinner">
          <p class="head">City</p>
          <select class="form-control txt inp-select" id="SelectCity" name="city_id" required="">
            @foreach($fetchCity as $fetchCitys)
            <option value="{{$fetchCitys->city_id}}" {{ $fetchCitys->city_id == $city_id ? 'selected' : '' }}>{{$fetchCitys->city_name}}</option>
            @endforeach
          </select>
          <div class="htl" style="display:none;width:20px;height:20px;position:absolute;right:50px; bottom: 7px; "><img src="{{url('assets/uploads/spin.gif')}}" style="max-width: 100%;" /></div>
        </div>
        <div class="mrgn">
          <p class="head">Location</p>
          <select class="form-control txt inp-select" id="SelectLocation" name="city_loc_id" required="" readonly="">
            <option value="{{$location_id}}" selected>{{$Location}}</option>
          </select>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="mrgn">
          <p class="head">From Date</p>
          <div id="sandbox-container">
            <input id="input_1_24" class="form-control txt inp-select" autocomplete="off" type="text" placeholder="Select from date" name="from_date" required="" value="{{$From_Date}}">
          </div>
        </div>
        <div class="mrgn">
          <p class="head">To Date</p>
          <div id="sandbox-container">
            <input id="input_1_25" class="form-control txt inp-select" autocomplete="off" type="text" placeholder="Select from date" name="to_date" required="" value="{{$To_date}}">
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="mrgn">
          <p class="head">Pickup Time</p>
          <div>
            <input id="picktime2" class="form-control txt inp-select" type="text" placeholder="Select pickup time" name="pickup_time" required="" value="{{$pickup_Time}}">
          </div>
        </div>
        <div class="mrgn">
          <p class="head">Return Time</p>
          <div>
            <input id="rettime2" class="form-control txt inp-select" type="text" placeholder="Select return time" name="return_time" required="" value="{{$return_time}}">
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="num-days">
          <p class="head">No. of days</p>
          <p class="txt"><span>{{$Days}}</span>Days</p>
        </div>
      </div>
      <input type="hidden" name="cur_type" value="{{Session::get('cur_type')}}">
      <div class="col-12 col-md-6 col-md-offset-3">
        <input type="submit" value="Show Vehicles" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-bottom: 20px;">
      </div>
      <br>
    </div>
  </form>
  
  <div class="car-list">
    
    <div class="container">
      <div class="row">
        
        @foreach($data['Models'] as $Modelss)
        @php
        
        $rpDay = number_format($Modelss['Rate_per_day'], 3, '.', '');
        
        @endphp
        
        <div class="col-12 col-md-4">
          <div class="car-box1">
            <form action="{{ route('user.personal.info') }}" method="POST" style="height: 100%;position: relative;padding-bottom:199px;">
              @csrf
              <input type="hidden" value="{{$Modelss['Model_id']}}" name="model_id">
              <input type="hidden" value="{{$Modelss['Total_Rate']}}" name="total_rate">
              <input type="hidden" value="{{$rpDay}}" name="rate_per_day">
              
              <img src="{{url('/assets/uploads/models/'.$Modelss['Model_image'])}}">
              <div class="titl">
                <h2>{{$Modelss['Model_name']}}  <small><i>or similar</i></small></h2>
                <p>Car Specifications</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs row">
                {{--  {{dd($Modelss['specifications'])}} --}}
                @foreach($Modelss['specifications'] as $specs)
                {{--  <img src="{{url('/assets/uploads/specifications/icons/'.$specs['Spec_Image'])}}" style="width: 25px !important;"> --}}
                <p><i class="fa fa-male" aria-hidden="true"></i> {{$specs['Spec_name']}}</p>
                @endforeach
              </div>
              <button id="specMorBtn" class="specMorBtn" type="button"><i class="fa fa-plus" aria-hidden="true"></i> View more</button>
              <div class="totaldv" style="position: absolute;width: 100%;bottom: 0;">
                <div class="car-price row">
                  <div class="col-6 day-price">
                    @if($Modelss['Offer_Rate']<$Modelss['Main_Rate'])
                    <p class="ofr-price"><small>Offer Price</small> {{$Modelss['Offer_Rate']}} {{Session::get('cur_code')}}</p>
                    @endif
                    <p class=""><small>Per Day</small>{{number_format($Modelss['Rate_per_day'], 3, '.', '')}} &nbsp; {{Session::get('cur_code')}}</p>
                  </div>
                  <div class="col-6 totl-price ">
                    @if($Modelss['Offer_Rate']<$Modelss['Main_Rate'])
                    {{--  <p class="ofr-price"><small>Offer Price</small> {{$Modelss['Offer_Rate']}} </p> --}}
                    <p class="ofr-price"><small>Rate </small><strike>{{$Modelss['Main_Rate']}} {{Session::get('cur_code')}}</strike></p>
                    @else
                    <p class="ofr-price"><small>Rate </small>{{$Modelss['Main_Rate']}} {{Session::get('cur_code')}}</p>
                    @endif
                    <p class="totprice"><small>Total</small><span style="display: block;">{{$Modelss['Total_Rate']}}</span> {{Session::get('cur_code')}}</p>
                  </div>
                </div>
                {{-- <a href="{{url('car/detail/'.Crypt::encryptString($Modelss['Model_id']))}}" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-bottom: 10px;">Book Now</a> --}}
                @if(Auth::guard('main_customer')->check())
                <input type="submit" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-bottom: 10px;" value="Book Now">
                @else
                <a href="{{route('user.login')}}" class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-bottom: 10px;">Book Now</a>
                @endif
              </div>
              
              
            </form>
          </div>
        </div>
        
        @endforeach
      </div>
    </div>
  </div>
</div>
<div style="clear: both;"></div>
</div>
<hr />
<div class="htl" style="display:none;width:64px;height:64px;border:1px solid black;position:absolute;top:50%;left:50%;padding:2px;"><img src="{{url('assets/uploads/spinner.gif')}}" width="64" height="64" /><br>Loading..</div>
<script type="text/javascript">
$(document).ready(function(){
//   var priceid = $(".totprice").html();
//   var lastFive = priceid.substr(priceid.length - 3);
//   alert(lastFive);
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