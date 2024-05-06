@extends('front-end.layouts.front-layout') 
@section('content')
@php
use App\Models\Model_image;
use App\Models\Model_specification;
use App\Models\Mode_rate;
@endphp
<style type="text/css">
   #header.car-list-pg{background: #0047bb; position: static; float: none;}
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
</style>
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

    <div class="rental-wrapper car-list-pg">
      <div class="filter-bar">
      <div class="container">

        <div class="dropdown Choose">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Choose Currency
            <!-- <span class="caret"></span> -->
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            @foreach($fetcCurrency as $fetcCurrencys)
            <li><a href="{{$fetcCurrencys->currency_id}}">{{$fetcCurrencys->currency_name}}&nbsp;({{$fetcCurrencys->currency_code}})</a></li>
           @endforeach
          </ul>
        </div>

        <div class="dropdown Choose">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Vehicle Type
            <!-- <span class="caret"></span> -->
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            @foreach($vehicleType as $vehicleTypes)
            <li><a href="{{$vehicleTypes->model_cat_id}}">{{$vehicleTypes->model_cat_name}}</a></li>
            @endforeach
          </ul>
        </div>

        <div class="dropdown Choose sort">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Sort by
            <!-- <span class="caret"></span> -->
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="#">Sort 1</a></li>
            <li><a href="#">Sort 2</a></li>
            <li><a href="#">Sort 3</a></li>
            <!-- <li role="separator" class="divider"></li> -->
            <li><a href="#">Sort 4</a></li>
          </ul>
        </div>

        <div class="dropdown Choose sort Filter">
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Filter by
            <!-- <span class="caret"></span> -->
          </button>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="#">Filter 1</a></li>
            <li><a href="#">Filter 2</a></li>
            <li><a href="#">Filter 3</a></li>
            <!-- <li role="separator" class="divider"></li> -->
            <li><a href="#">Filter 4</a></li>
          </ul>
        </div>

      </div>
      </div>

      <div class="list-details row shadow">
        <div class="col-6 col-md-4">
          <div class="mrgn">
          <p class="head">City</p>
          <p class="txt">Doha</p>
          </div>
          <div class="mrgn">
          <p class="head">Location</p>
          <p class="txt">Airport</p>
          </div>
        </div>

        <div class="col-6 col-md-4">
          <div class="mrgn">
          <p class="head">From Date</p>
          <p class="txt">Nov. 20, 2020, 3:00 PM</p>
          </div>
          <div class="mrgn">
          <p class="head">To Date</p>
          <p class="txt">Nov. 23, 2020, 3:00 PM</p>
          </div>
        </div>

        <div class="col-12 col-md-4">
          <div class="num-days">
          <p class="head">No. of days</p>
          <p class="txt"><span>3</span>Days</p>
          </div>
        </div>

      </div>

      <div class="car-list">
        <div class="container">
          <div class="row">
            @foreach($fetchModels as $fetchModelss)
            <div class="col-12 col-md-4">
            <div class="car-box1">
               @php
               $fetchImage = Model_image::where('model_id','=',$fetchModelss->modal_id)->where('model_image_flag','=',0)->first();
               $fetchMainImg = $fetchImage->model_image;
               @endphp
              <img src="{{url('/assets/uploads/models/'.$fetchMainImg)}}">
              <div class="title">
                <h2>{{$fetchModelss->modal_name}} <small><i>or similar</i></small></h2>
                <p>Car Specifications</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                @php
                $getSpec = Model_specification::where('model_id','=',$fetchModelss->modal_id)->get();
                @endphp
              @foreach($getSpec as $specss)
                <p><img src="{{url('assets/uploads/specifications/icons/'.$specss->specs['spec_icon'])" width="30" height="30">  {{$specss->specs->spec_name}}</p>

                @endforeach
               
              </div>
              <button id="specMorBtn" class="specMorBtn" style="display:none;"><i class="fa fa-plus" aria-hidden="true" ></i> View more</button>
              <div class="car-price row">
                @php
                $getRate = Mode_rate::where('model_id','=',$fetchModelss->modal_id)->where('rate_type_id','=',1)->first();
                @endphp
                <div class="col-6 day-price">
                  <p class=""><small>Per Day</small>{{$getRate->rate}} &nbsp; QR</p>
                </div>
                <div class="col-6 totl-price ">
                  <p class="ofr-price"><small>Offer Price</small> {{$getRate->model_min_rate}}</p>
                  <p class=""><small>Total</small>{{$getRate->rate}}</p>
                </div>
              </div>
            </div>
            </div>
            @endforeach

            {{-- <div class="col-12 col-md-4">
            <div class="car-box1">
              <img src="images/kia-optima.png">
              <div class="titl">
                <h2>Kia Optima <small><i>or similar</i></small></h2>
                <p>Car Specifications</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                <p><i class="fa fa-male" aria-hidden="true"></i> 5 Passengers</p>
                <p><i class="fa fa-snowflake-o" aria-hidden="true"></i> Air Conditioning</p>
              </div>
              <button id="specMorBtn" class="specMorBtn"><i class="fa fa-plus" aria-hidden="true"></i> View more</button>
              <div class="car-price row">
                <div class="col-6 day-price">
                  <p class=""><small>Per Day</small>90 QR</p>
                </div>
                <div class="col-6 totl-price ">
                 
                  <p class=""><small>Total</small>270 QR</p>
                </div>
              </div>
            </div>
            </div> --}}

       {{--      <div class="col-12 col-md-4">
            <div class="car-box1">
              <img src="images/kia-optima.png">
              <div class="titl">
                <h2>Kia Optima <small><i>or similar</i></small></h2>
                <p>Car Specifications</p>
              </div>
              <div id="carSpecs" class="Specs carSpecs">
                <p><i class="fa fa-male" aria-hidden="true"></i> 5 Passengers</p>
                <p><i class="fa fa-snowflake-o" aria-hidden="true"></i> Air Conditioning</p>
                <p><i class="fa fa-suitcase" aria-hidden="true"></i> 1 Large Suitcase, 2 Small Suitcase</p>              
                <p><i class="fa fa-road" aria-hidden="true"></i> 11 km/l (approximate)</p>
                <p><i class="fa fa-cog" aria-hidden="true"></i> Automatic</p>
              </div>
              <button id="specMorBtn" class="specMorBtn"><i class="fa fa-plus" aria-hidden="true"></i> View more</button>
              <div class="car-price row">
                <div class="col-6 day-price">
                  <p class=""><small>Per Day</small>90 QR</p>
                </div>
                <div class="col-6 totl-price ">
                
                  <p class=""><small>Total</small>270 QR</p>
                </div>
              </div>
            </div>
            </div> --}}
              
          </div>
        </div>
      </div>
      
    </div>
    <div style="clear: both;"></div>
</div>

<hr />
@endsection