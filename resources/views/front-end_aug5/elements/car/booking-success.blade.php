@extends('front-end.layouts.front-layout')
@section('content')
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
   .car-list-pg .list-details .head{color: #f25d25;}
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
       <h2 style="margin: auto; margin-top: 10px; text-align: center; color: #000;">{{__('Booking Success')}}</h2>
      </div>
   </div>

   

 <div class="list-details row shadow" style="text-align: center;margin-top: 0px;">
        <div class="col-12 Rental-Dtls">
          <h3>{{__('Booking Reference:')}} {{$referenceId}}</h3>
        </div>
        <div class="col-12 col-md-12">
          <div class="mrgn">
          <p class="head">{{__('Hello')}}, {{$Name}}</p>
          <!-- <p class="txt">Doha</p> -->
          </div>
          <div class="mrgn">
          <!-- <p class="head">Location</p> -->
          <p class="txt">{{__('Your payment has been successfully made and your booking is confirmed.')}}</p>
          <!--<p class="txt">We have sent you an email with your booking details.</p>-->
          <p class="txt">{{__('Thank you for choosing us!')}}</p><br>
           <a href="{{route('app.index')}}" class="btn btn-warning btn-lg btn-block mx-auto text-white">{{__('Back to Home')}}</a>
          </div>
        </div>

      </div>

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
      </script>
@endsection