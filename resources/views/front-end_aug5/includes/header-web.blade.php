
      <!-- HEADER STARTS -->
      
      <header class="sticky-top header-top">
      <div id="header" class="header-banner car-list-pg-main ">
         <div class="container">
         
            <div class="menu-left">
               <div id="logo" class="car-list-pg" style="text-align:center;text-align: center;position: relative;z-index: 9999;left:-60px;">
                  <a href="{{route('web.index')}}"><img src="{{URL::to('assets/front/themes/rental/images/logo-old.png')}}"></a>
                   <!--<a href="{{route('web.index')}}"><img src="{{URL::to('assets/front/themes/rental/images/logo.jpg')}}" style="width:183px;height:117px;"></a>-->
               </div>  
               <div class="hed">
               <div id="access">
                  <div class="menu-header">
                     <div class="menu-header">
                        <ul id="menu-primary" class="menu">
                           <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page  menu-item-20 activeitem"><a href="{{route('web.index')}}">{{__('Home')}} </a></li>
                           
                           <li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-108"><a href="{{route('about-us')}}">{{__('About Us')}}</a></li>
                           
                           <li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('/car-rental') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-108"><a href="http://webprojects.hexeam.in/almana-rentals/car/search?city_id=1&city_loc_id=2&from_date=<?php echo date('m/d/Y')?>&to_date=<?php echo date('m/d/Y', strtotime(' +1 day'))?>&pickup_time=10%3A00&return_time=10%3A00&cur_type=1">{{__('Car Rental')}}</a></li>
                           
                           <!--  <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-160"><a href="{{route('services')}}">{{__('Services')}}</a></li>
                         <li id="menu-item-168" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-168"><a href="{{route('offers')}}">{{__('Offers')}}</a></li>-->
                           <li id="menu-item-192" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-192"><a href="{{route('careers')}}">{{__('Careers')}}</a></li>
                           <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('contact-us') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('contact-us')}}">{{ __('Contact Us') }}</a></li>
                           

                        </ul>
                     </div>
                  </div>
               </div>
         <!--       @if(Auth::guard('main_customer')->check())
               @if(Request::is('user/rental/history') || Request::is('user/notifications') || Request::is('user/feedback') || Request::is('user/reservations') || Request::is('user/traffic/violation') || Request::is('user/profile') || Request::is('user/change-password'))
               <div class="header-sidemenu">
                  <div class="menu-header">
                     <div class="menu-header">
                        <ul id="menu-primary" class="menu">
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/profile') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.profile')}}">{{ __('Profile') }}</a></li>
                          <li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page  menu-item-20"><a href="http://rentsolutions.hexeam.in/">Home</a></li>
                           <li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/rental/history') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-108"><a href="{{route('user.rental.history')}}">{{ __('Rental History') }}</a></li>
                           <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/notifications') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-160"><a href="{{route('user.notifications')}}">{{ __('Notifications') }}</a></li>
                           <li id="menu-item-168" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/feedback') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-168"><a href="{{route('user.feedback')}}">{{ __('Feedback') }}</a></li>
                           <li id="menu-item-192" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/reservations') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }}  menu-item-192"><a href="{{route('user.reservations')}}">{{ __('Reservations') }}</a></li>
                           <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/traffic/violation') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.traffic.violation')}}">{{ __('Traffic Violations') }}</a></li>
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/change-password') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.change.password')}}">{{ __('Change Password') }}</a></li>
                            
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('user.logout')}}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{ __('Sign Out') }} </a></li>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                              @csrf
                           </form>

                        </ul>
                     </div>
                  </div>
               </div>
               @endif
               @endif
               
               --->
         
               
            <div class="menu-right">
               <div class="download-app">
                  <a href="#">{{__('Download App')}} <img class="plystr" src="{{URL::to('assets/front/themes/rental/images/playstore3.png')}}"> <img src="{{URL::to('assets/front/themes/rental/images/apple3.png')}}"></a>
               </div>
                @if(!Auth::guard('main_customer')->check())
               <div class="register">
              
                  <a href="{{route('user.login')}}">{{__('Login')}}/{{__('Register')}}</a>

                  
                 
               </div>
               <div>
              
              
              
              
             
           </div>
                @else
               {{--  <div class="clearfix"></div> --}}
                <div class="dropdown Choose headrlog">
          @if(Auth::guard('main_customer')->check())
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <img src="{{url('assets/uploads/avatar2.png')}}" width="20" />
            {{Auth::guard('main_customer')->user()->customer->cust_fname}}&nbsp;{{Auth::guard('main_customer')->user()->customer->cust_lname}}
            <!-- <span class="caret"></span> -->
          </button>
           <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
            <li><a href="{{route('user.profile')}}">{{ __('Profile')}}</a></li>
            <li><a href="{{route('user.change.password')}}">{{ __('Change Password')}}</a></li>
             <li><a href="{{route('user.logout')}}" onclick="event.preventDefault();
                           document.getElementById('logout-form1').submit();">{{ __('Sign Out')}}</a></li>
              <form id="logout-form1" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                              @csrf
              </form>
          </ul>
          @endif
          
        </div>
                @endif
            <div class="mrgleft">  @include('front-end.includes.language-switch')</div>
            </div>
             </div>
           
         </div>
        
      </div>
      </header>
       @if(Auth::guard('main_customer')->check())
               @if(Request::is('user/rental/history') || Request::is('user/notifications') || Request::is('user/feedback') || Request::is('user/reservations') || Request::is('user/traffic/violation') || Request::is('user/profile') || Request::is('user/change-password'))
               <div class="header-sidemenu">
                  <div class="menu-header">
                     <div class="menu-header">
                        <ul id="menu-primary" class="menu">
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/profile') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.profile')}}">{{ __('Profile') }}</a></li>
                           <!--<li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page  menu-item-20"><a href="http://rentsolutions.hexeam.in/">Home</a></li>-->
                           <li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/rental/history') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-108"><a href="{{route('user.rental.history')}}">{{ __('Rental History') }}</a></li>
                           <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/notifications') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-160"><a href="{{route('user.notifications')}}">{{ __('Notifications') }}</a></li>
                           <li id="menu-item-168" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/feedback') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-168"><a href="{{route('user.feedback')}}">{{ __('Feedback') }}</a></li>
                           <li id="menu-item-192" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/reservations') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }}  menu-item-192"><a href="{{route('user.reservations')}}">{{ __('Reservations') }}</a></li>
                           <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/traffic/violation') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.traffic.violation')}}">{{ __('Traffic Violations') }}</a></li>
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/change-password') ? 'menu-item-home current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.change.password')}}">{{ __('Change Password') }}</a></li>
                            
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('user.logout')}}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{ __('Sign Out') }} </a></li>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                              @csrf
                           </form>

                        </ul>
                     </div>
                  </div>
               </div>
               @endif
               @endif
      <!-- END HEADER -->