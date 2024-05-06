<style type="text/css">
        
.left_col .nav_title{display: none; height: 46px; background: transparent;}
.left_col .nav_title .site_title{height: 46px; line-height: 46px; padding: 0 10px;}
.profile_img{border: none; padding: 0; background: transparent; margin: auto; display: block; width: 100%; margin-bottom: 10px;}
#colside{background: #2151a3 !important; width: 100% !important;}
.left_col .profile{background-color: #ffc52f; display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; align-items: center; padding: 20px 10px; flex-direction: column !important;}
.left_col .profile .profile_info{padding-top: 0; padding-bottom: 0; width: 100%; text-align: center !important;}
.left_col .profile .profile_info span{font-size: 24px; text-transform: uppercase; color: #2151a3; line-height: normal;}
.left_col .profile .profile_info h2{color: #fff; font-weight: 700; margin-top: 5px;}
.nav.side-menu>li.active>a{background: #174188; box-shadow: none;}
.nav.side-menu>li.current-page, .nav.side-menu>li.active{border-right: none; background: #3f64a2;}
.active a span.fa{text-align: center !important; margin-right: 0;}
     </style>

 <div class="col-md-3 left_col">
          <div class="left_col scroll-view" id="colside">
            <div class="navbar nav_title" style="border: 0;">
              <a href="" class="site_title"> <span>{{ __('Rent Solutions') }}</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{URL::to('assets/admin/images/logo.png')}}" alt="..." class="profile_img">
              </div>
              <div class="profile_info">
                <span>{{ Auth::guard('main_customer')->user()->customer->cust_fname }}&nbsp; {{ Auth::guard('main_customer')->user()->customer->cust_lname }}</span>
                <h2>{{ Auth::guard('main_customer')->user()->customer->email }}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                {{-- <h3>General</h3> --}}
                <ul class="nav side-menu">
                 {{--  <li><a href="{{route('user.account')}}"><i class="fa fa-tachometer"></i>{{ __('Home') }} </a></li> --}}
                 <li><a href=""><i class="fa fa-university"></i> {{ __('Rental History') }} </a>
                   
                  </li>
                   <li><a href=""><i class="fa fa-bell"></i> {{ __('Notifications') }} </a>
                   
                  </li>
                   <li><a href="{{route('user.feedback')}}"><i class="fa fa-comments"></i> {{ __('Feedback') }} </a>
                   
                  </li>
                   <li><a href=""><i class="fa fa-university"></i> {{ __('Reservations') }} </a>
                   
                  </li>
                   <li><a href=""><i class="fa fa-signal"></i> {{ __('Traffic Violations') }} </a>
                   
                  </li>
                    <li><a><i class="fa fa-cog"></i> {{ __('Settings') }} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                     <li><a href="{{route('user.profile')}}">{{ __('Profile') }}</a></li>
                     <li><a href="{{route('user.change.password')}}">{{ __('Change Password') }}</a></li>
                     
                    </ul>
                  </li>
                   <li><a href=""><i class="fa fa-phone"></i> {{ __('Contact Us') }} </a>
                   
                  </li>
                   <li><a href=""><i class="fa fa-sign-out"></i> {{ __('Sign Out') }} </a>
                   
                  </li>

                

                  

                 

                </ul>
              </div>

            </div>
           
          </div>
        </div>