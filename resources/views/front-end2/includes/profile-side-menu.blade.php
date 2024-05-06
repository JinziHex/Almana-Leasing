  @if(Auth::guard('main_customer')->check())
               @if(Request::is('user/rental/history') || Request::is('user/notifications') || Request::is('user/feedback') || Request::is('user/reservations') || Request::is('user/traffic/violation') || Request::is('user/profile') || Request::is('user/change-password'))
             <div class="sidepanel">
                    <div class="circle">
    <i class="fa fa-chevron-left" aria-hidden="true"></i>
    <i class="fa fa-chevron-right hide" aria-hidden="true"></i>    
  </div>
               <div class="header-sidemenu">
                  <div class="menu-header">
                     <div class="menu-header">
                        <ul id="menu-primary" class="menu">
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/profile') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.profile')}}">{{ __('Profile') }}</a></li>
                           <!--<li id="menu-item-20" class="menu-item menu-item-type-post_type menu-item-object-page  menu-item-20"><a href="http://rentsolutions.hexeam.in/">Home</a></li>-->
                           <li id="menu-item-108" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/rental/history') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-108"><a href="{{route('user.rental.history')}}">{{ __('Rental History') }}</a></li>
                           <li id="menu-item-160" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/notifications') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-160"><a href="{{route('user.notifications')}}">{{ __('Notifications') }}</a></li>
                           <li id="menu-item-168" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/feedback') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-168"><a href="{{route('user.feedback')}}">{{ __('Feedback') }}</a></li>
                           <li id="menu-item-192" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/reservations') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }}  menu-item-192"><a href="{{route('user.reservations')}}">{{ __('Reservations') }}</a></li>
                           <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/traffic/violation') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.traffic.violation')}}">{{ __('Traffic Violations') }}</a></li>
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page {{ (Request::is('user/change-password') ? 'menu-item-home actv current-menu-item page_item page-item-134 current_page_item' : '') }} menu-item-200"><a href="{{route('user.change.password')}}">{{ __('Change Password') }}</a></li>
                            
                            <li id="menu-item-200" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-200"><a href="{{route('user.logout')}}" onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">{{ __('Sign Out') }} </a></li>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                              @csrf
                           </form>

                        </ul>
                     </div>
                  </div>
               </div>
              </div>
               @endif
               @endif
               
            