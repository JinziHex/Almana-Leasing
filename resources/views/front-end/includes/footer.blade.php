@php
use App\Models\Mst_service;
use App\Models\Mst_social_media_icon;
@endphp

<div class="call__badge__new"> 
<!--<div class="call__badge"> -->
    <!--<a href="tel:+974 333 600 43">-->
    <a href="https://api.whatsapp.com/send?phone=97433360043">
        <!--<i class="fa fa-phone" aria-hidden="true"></i>-->
        <img src="{{URL::to('assets/front/themes/rental/images/wp.gif')}}"  style="width: 70px;height: 70px;position: fixed;right: 20px;bottom: 20px;z-index: 9999;display: flex;">
    </a>
</div>
<div class="mainfooter">
  <div class="footer-meunus">
    <div class="container">
      <div class="footer-wrap">
        <div class="ft1 blk-wrap">
          <h4>{{__('MASSIVE CHOICES')}}</h4>
          <!-- <p><p>Short term and long term rentals.<br>Commercial vehicles including pick-ups, trucks and buses.<br>Range of 4 x 4 Vehicles.<br>Sports cars<br>Bus lease (with or without driver).<br>Limousine services.</p></p> -->
          <ul>
            @php
            $fetchService = Mst_service::orderBy('service_id','DESC')->get();
            $limousine = Mst_service::where('service_slug','limousine-service')->count();
            $service = Mst_service::where('service_slug','service-and-maintenance')->count();
            @endphp
            {{-- @foreach($fetchService as $fetchServices)
            <!--<li><a href="{{url('almana/services/'.$fetchServices->service_slug)}}">{{ ucFirst(@$fetchServices->service_title) }}</a></li>-->
            <li><a href="{{url('services')}}">{{ __(ucFirst(@$fetchServices->service_title)) }}</a></li>
            @endforeach --}}
            <li><a href="{{route('short-term-car-rental')}}">	{{__('Short term car rentals')}}</a></li>
            <li> <a href="{{route('long-term-car-rental')}}">{{__('Long term car rental')}}</a></li>
           <li> <a href="{{route('lease-to-own')}}">{{__('Lease to Own')}}</a></li>
            <li> <a href="{{route('car-for-sale')}}">{{__('Car for Sale')}}</a></li>
            @if($limousine)
            <li> <a href="{{route('limousine-and-chaufeer-services')}}">{{__('Limousine and chauffer services')}}</a></li>
            @endif
            @if($service)
             <li> <a href="{{route('service-and-maintenance')}}">{{__('Service & Maintenance')}}</a>	</li>
            @endif
          </ul>
        </div>
        <div class="ft2 blk-wrap">
          <h4>{{__('General Information')}}</h4>
          <ul>
            <li> <a href="{{route('faqs')}}">{{__('FAQ')}}</a></li>
            <li> <a href="{{route('terms-and-conditions')}}">{{__('Terms and Conditions')}}</a></li>
            <li> <a href="{{route('our-process-and-packages')}}">{{__('Our Process and Packages')}}</a></li>
            <li> <a href="{{route('requirements')}}">{{__('Requirements')}}</a></li>
            <!--<li> <a href="#">{{__('FAQ')}}</a></li>-->
            <!--<li> <a href="#">{{__('Terms and Conditions')}}</a></li>-->
            <!--<li> <a href="#">{{__('Our Process and Packages')}}</a></li>-->
            <!--<li> <a href="#">{{__('Requirements')}}</a></li>-->
            <ul>
            </ul></ul></div>
            <div class="ft4 blk-wrap">
              @if(session('status'))
              <div class="alert alert-success" id="err_msg">
                <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
              </div>
              @endif
              <h4>{{__('Newsletter')}}</h4>
              <p>
                <form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-25" method="post" data-id="25" data-name="Newsletter" action="{{route('newsletter-send')}}">
                  @csrf()
                  <div class="mc4wp-form-fields"><p>
                    <input type="email" name="newsletter_email" placeholder="" required />
                  </p>
                  <p>
                    <input type="submit" value="{{__('Submit')}}" />
                  </p></div></form></p>
                  <div class="ft3 blk-wrap">
                    <h4>{{__('Social Media')}}</h4>
                    <p>
                    </p><ul>
                    @php
                    $fetchService = Mst_social_media_icon::orderBy('icon_id','ASC')->get();
                    @endphp
                    @if(!$fetchService->isEmpty())
                    @foreach($fetchService as $fetchServices)
                    <li><a href="{{ $fetchServices->icon_link }}" target="_blank"><i class="fab {{ $fetchServices->icon_fa }}"></i></a></li>
                    @endforeach
                    @endif
                    </ul><p></p>
                  </div>
                </div>
                <div class="ft5 blk-wrap">
                  <h4>{{__('Quick Links')}}</h4>
                  <p>
                    </p><div class="footer-menu"><ul id="menu-primary-1" class="menu"><li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-20"><a href="{{route('web.index')}}">Home</a></li>
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-108"><a href="{{route('about-us')}}">About Us</a></li>-->
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-370"><a href="{{route('app.index')}}">Car Rental</a></li>-->
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-366"><a href="{{route('services')}}">Services</a></li>-->
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-168"><a href="{{route('offers')}}">Offers</a></li>-->
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-365"><a href="{{route('careers')}}">Careers</a></li>-->
                    <!--<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('contact-us')}}">Contact</a></li>-->
                     <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-108"><a href="{{route('about-us')}}">{{__('About Us')}}</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-370"><a href="{{route('app.index')}}">{{__('Car Rental')}}</a></li>
                  <!--  <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-366"><a href="#">{{__('Services')}}</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-168"><a href="#">{{__('Offers')}}</a></li>-->
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-365"><a href="{{route('careers')}}">{{__('Careers')}}</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('contact-us')}}">{{__('Contact ')}}</a></li>
                  </ul></div>
                </div>
              </div>
            </div>
          </div>
          <div id="footer">
            <div class="footer_copy">{{__('Copyright ©')}} <?php echo date('Y'); ?> {{__('ALMANA LEASING. ALL RIGHTS RESERVED')}}</div>
          </div>
        </div>
        <script>
        $( document ).ready(function() {
        $('body').addClass('inner-bpage');
        });
        </script>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
        <script>
        $(document).ready(function(){
        $('.slider').bxSlider();
        });
        </script>
        <div class="mobmenu-overlay"></div>
        <div class="mob-menu-header-holder mobmenu"  data-menu-display="mob-menu-slideout-over"data-detach-el=".menu-right" data-open-icon="down-open" data-close-icon="up-open">
          <div  class="mobmenul-container"></div>
          <div class="mobmenur-container"><a href="#" class="mobmenu-right-bt  mobmenu-trigger-action" data-panel-target="mobmenu-right-panel" aria-label="Right Menu Button"><i class="fa fa-bars"></i><i class="mob-icon-cancel-1 mob-cancel-button"></i></a></div>
        </div>
        <div class="mobmenu-right-alignment mobmenu-panel mobmenu-right-panel  ">
          <a href="#" class="mobmenu-right-bt" aria-label="Right Menu Button"><i class="mob-cancel-button fa fa-times"></i></a>
          <div class="mobmenu-content">
            <div class="menu-primary-container">
              <ul id="mobmenuright">
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-20"><a href="{{route('web.index')}}" class="">{{__('Home')}}</a></li>
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-108"><a href="{{route('about-us')}}" class="">{{__('About Us')}}</a></li>
                
                 <li class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('/car-rental') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-108"><a href="/car/search?city_id=1&city_loc_id=2&from_date=<?php echo date('m/d/Y')?>&to_date=<?php echo date('m/d/Y', strtotime(' +1 day'))?>&pickup_time=10%3A00&return_time=10%3A00&cur_type=1">{{__('Car Rental')}}</a></li>
                 
                <!--<li  class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-134 current_page_item menu-item-142"><a href="{{route('app.index')}}" class="">{{__('Car Rental')}}</a></li>-->
                <!--<li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-160"><a href="{{route('services')}}" class="">{{__('Services')}}</a></li>-->
                <!--<li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-168"><a href="{{route('offers')}}" class="">{{__('Offers')}}</a></li>-->
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-192"><a href="{{route('careers')}}" class="">{{__('Careers')}}</a></li>
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('contact-us')}}" class="">{{__('Contact Us')}}</a></li>
                @if(Auth::guard('main_customer')->check())
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a  href="{{route('user.profile')}}" class="">{{__('Profile')}}</a></li>
                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a onclick="event.preventDefault();
                           document.getElementById('logout-form-home').submit();" class="">{{__('Sign Out')}}</a></li>
                 <form id="logout-form-home" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                 @csrf
                </form>
                @else
                  <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"> <a href="{{route('user.login')}}">{{__('Login')}}/{{__('Register')}}</a></li>
                
                @endif
                 <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"> @include('front-end.includes.language-switch')</li>
               
              </ul>
            </div>
          </div>
          <div class="mob-menu-right-bg-holder"></div>
        </div>
        <script type="text/javascript">
        $( "i.mob-icon-menu-3.mob-menu-icon" ).one( "click", function(){
        
        
        
        $('.menu-right').contents().appendTo('#mobmenuright');
        
        });
        </script>
        {{--   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" integrity="sha512-GDey37RZAxFkpFeJorEUwNoIbkTwsyC736KNSYucu1WJWFK9qTdzYub8ATxktr6Dwke7nbFaioypzbDOQykoRg==" crossorigin="anonymous"></script>
        <script type="text/javascript">
        $(function () {
        $('#datetimepicker').datetimepicker({
        format: 'DD-MM-YYYY LT'
        });
        
        });
        </script> --}}
        {{--  <script src="{{URL::to('assets/front/js/bootstrap-datepicker.min.js')}}"></script> --}}
        {{-- <script type="text/javascript">
        $('#sandbox-container input').datepicker({
        startDate: new Date()
        });
        </script> --}}
        
        <script src="{{URL::to('assets/front/js/main.js')}}"></script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
        $( function() {
        $( "#input_1_24" ).datepicker({
        dateFormat: "mm/dd/yy",
        setDate: new Date(),
        minDate: 0,
        onSelect: function (date) {
        var date2 = $('#input_1_24').datepicker('getDate');
        date2.setDate(date2.getDate() + 1);
        $('#input_1_25').datepicker('setDate', date2);
        //sets minDate to dt1 date + 1
        $('#input_1_25').datepicker('option', 'minDate', date2);
        }
        });
        //history
        $( ".input_1_24history" ).datepicker({
        dateFormat: "mm/dd/yy",
        setDate: new Date(),
        minDate: 0,
        onSelect: function (date) {
        var date2 = $('.input_1_24history').datepicker('getDate');
        date2.setDate(date2.getDate() + 1);
        $('.input_1_25history').datepicker('setDate', date2);
        //sets minDate to dt1 date + 1
        $('.input_1_25history').datepicker('option', 'minDate', date2);
        }
        } );
        $( "#input_1_25" ).datepicker({
        dateFormat: "mm/dd/yy",
        minDate: 0,
        onClose: function () {
        var dt1 = $('#input_1_24').datepicker('getDate');
        console.log(dt1);
        var dt2 = $('#input_1_25').datepicker('getDate');
        if (dt2 <= dt1) {
        var minDate = $('#input_1_25').datepicker('option', 'minDate');
        $('#input_1_25').datepicker('setDate', minDate);
        }
        }
        });
        //history
        $( ".input_1_25history" ).datepicker({
        dateFormat: "mm/dd/yy",
        minDate: 0,
        onClose: function () {
        var dt1 = $('.input_1_24history').datepicker('getDate');
        console.log(dt1);
        var dt2 = $('.input_1_25history').datepicker('getDate');
        if (dt2 <= dt1) {
        var minDate = $('.input_1_25history').datepicker('option', 'minDate');
        $('.input_1_25history').datepicker('setDate', minDate);
        }
        }
        }
        );
        $( "#input_1_26" ).datepicker({
        dateFormat: "dd-mm-yy",
        endDate: '-20y',
        changeMonth: true,
        changeYear: true,
        yearRange: '1950:-20',
        maxDate: '-20y'
        // showOn: 'button',
        // onClose: function () {
        //          var dt1 = $('#input_1_24').datepicker('getDate');
        //          console.log(dt1);
        //          var dt2 = $('#input_1_25').datepicker('getDate');
        //          if (dt2 <= dt1) {
        //              var minDate = $('#input_1_25').datepicker('option', 'minDate');
        //              $('#input_1_25').datepicker('setDate', minDate);
        //          }
        //      }
        }
        );
        } );
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script>
        $(document).ready(function(){
        $('#picktime').timepicker({
        timeFormat: 'HH:mm',
        defaultTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        });
        
        $('#rettime').timepicker({
        timeFormat: 'HH:mm',
        defaultTime: '10:00',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        });
        });
        </script>
        <script>
        $(document).ready(function(){
        $('.picktimehistory').timepicker({
        timeFormat: 'HH:mm',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        
        });
        
        $('.rettimehistory').timepicker({
        timeFormat: 'HH:mm',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        });
        });
        </script>
        <script>
        $(document).ready(function(){
        $('#picktime2').timepicker({
        timeFormat: 'HH:mm',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        
        });
        
        $('#rettime2').timepicker({
        timeFormat: 'HH:mm',
        dynamic: false,
        dropdown: true,
        scrollbar: true
        
        });
        });
        </script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script>
        $(document).ready(function() {
        $("#login-form").validate({
        rules: {
        cust_fname: "required",
        password: {
        required: true,
        minlength: 8
        },
        password_confirmation: {
        required: true,
        minlength: 8,
        equalTo: "#password"
        }
        
        },
        messages: {
        cust_fname: "This field is required",
        password_confirmation: {
        
        equalTo: "Password does not match.",
        },
        
        }
        });
        // $("#emptyalert").css("display", "block").fadeOut(10000);
        $('#submit1').click(function() {
        $("#login-form").valid();
        });
        });
        </script>
        <script type="text/javascript">
        AOS.init({
        duration: 1500,
        })
        </script>
        
              <script>
         $(function() {
         $(window).on("scroll", function() {
             if($(window).scrollTop() > 50) {
                 $(".header-top").addClass("activee");
             } else {
                 //remove the background property so it comes transparent again (defined in your css)
                $(".header-top").removeClass("activee");
             }
         });
         });
      </script>
      
      <script>
          
          $('.circle').click(function() {
  let spWidth = $('.sidepanel').width();
  let spMarginLeft = parseInt($('.sidepanel').css('margin-left'),10);
  let w = (spMarginLeft >= 0 ) ? spWidth * -1 : 0;
  let cw = (w < 0) ? -w : spWidth-22;
  $('.sidepanel ').animate({
    marginLeft:w
  });
  $('.sidepanel span').animate({
    marginLeft:w
  });
  $('.circle').animate({
    left:cw
  },function() {
    $('.fa-chevron-left').toggleClass('hide');
    $('.fa-chevron-right').toggleClass('hide');
  });
});
      </script>
      
  <!---    <script>
function openNav() {
  document.getElementById("mySidepanel").style.width = "250px";
   
}

function closeNav() {
  document.getElementById("mySidepanel").style.width = "0";
  
  
}
</script>-->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.5/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>	

