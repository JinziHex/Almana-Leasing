<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="side-header" style="background-color: #6b57ee;">
    <a class="header-brand1" href="{{route('home')}}">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img desktop-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img toggle-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img light-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img light-logo1" alt="logo">
      </a><!-- LOGO -->
      <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
    </div>
    <div class="app-sidebar__user">
      <div class="dropdown user-pro-body text-center">
        <div class="user-pic">
          <img src="{{URL::to('/assets/uploads/admin.png')}}" alt="user-img" class="avatar-xl rounded-circle">
        </div>
        <div class="user-info">
          <h6 class=" mb-0 text-dark">{{Auth::user()->name}}</h6>
          <span class="text-muted app-sidebar__user-name text-sm">{{Auth::user()->email}}</span>
        </div>
      </div>
    </div>
    <div class="sidebar-navs">
      <ul class="nav  nav-pills-circle" style="justify-content: center;">
        {{-- <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Followers">
          <a class="nav-link text-center m-2">
            <i class="fe fe-user"></i>
          </a>
        </li> --}}
        <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
          <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fe fe-power"></i>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div>
    @if(Auth::check())
    <ul class="side-menu">
      <li><h3>Main</h3></li>
      <li class="slide">
        <a class="side-menu__item" href="{{route('home')}}"><i class="side-menu__icon ti-shield"></i><span class="side-menu__label"> Dashboard</span></a>
       
        
      </li> 
      <!-- <li class="slide">-->
      <!--  <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('DashBoard') }}</span><i class="angle fa fa-angle-right"></i></a>-->
      <!--  <ul class="slide-menu">-->
         
      <!--    <li><a class="slide-item" href="{{route('admin.password')}}">{{ __('Settings') }}</a></li>-->
         
      <!--  </ul>-->
      <!--</li>-->
      
      <li><h3>Elements</h3></li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Masters') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">

            
         {{--  <li class="slide-new">
            <a class="side-menu__item-new" data-toggle="slide-new" href="#" ><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Masters') }}</span><i class="angle-new fa fa-angle-right"></i></a>
            <ul class="slide-menu-new">
              
              <li><a class="slide-item-new" href="{{route('admin.list_category')}}">{{ __('Category') }}</a></li>
              <li><a class="slide-item-new" href="{{route('admin.list_brand')}}">{{ __('Product Brand') }} </a></li>
              <li><a class="slide-item-new" href="{{route('admin.list_qualification')}}">{{ __('Job Qualifications') }}</a></li>
              <li><a class="slide-item-new" href="{{route('admin.list_industry')}}">{{ __('Job Industry') }}</a></li>
              <li><a class="slide-item-new" href="{{route('admin.list_skill')}}">{{ __('Job Skill') }}</a></li>
              
            </ul>
          </li> --}}

          <li><a class="slide-item" href="{{route('admin.list_category')}}">{{ __('Category') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_brand')}}">{{ __('Product Brand') }} </a></li>
           <li><a class="slide-item" href="{{route('admin.list_qualification')}}">{{ __('Job Qualifications') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_industry')}}">{{ __('Job Industry') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_skill')}}">{{ __('Job Skill') }}</a></li>
          
        </ul>
      </li>
      
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-home"></i><span class="side-menu__label">{{ __('Home Secure') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.list_insurance')}}">{{ __('Insurance') }}</a></li>
          
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-receipt"></i><span class="side-menu__label">{{ __('WFH Jobs') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
         
          <li><a class="slide-item" href="{{route('admin.list_job_seeker')}}">{{ __('Job Seekers') }}</a></li>
          
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-mouse-alt"></i><span class="side-menu__label">{{ __('Workcations') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          
         {{--  <li><a class="slide-item" href="{{route('workcation.data')}}">{{ __('Data') }}</a></li> --}}
          
          <li><a class="slide-item" href="{{route('admin.list_workcation')}}">{{ __('Enquiry') }}</a></li>
          
          
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-video-camera"></i><span class="side-menu__label">{{ __('Theatre At Home') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
         {{--  
          <li><a class="slide-item" href="{{route('theatre.data')}}">{{ __('Data') }}</a></li> --}}
          
          <li><a class="slide-item" href="{{route('admin.list_theatre')}}">{{ __('Enquiry') }}</a></li>
          
          
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-thought"></i><span class="side-menu__label">{{ __('Mind Wellbeing') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          
          <li><a class="slide-item" href="{{route('admin.mind_wellbeing')}}">{{ __('Data') }}</a></li>   
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-comments-smiley"></i><span class="side-menu__label">{{ __('Virtual Mentor') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.mentor.folders')}}">{{ __('Folders') }}</a></li>  
          <li><a class="slide-item" href="{{route('admin.mentor.documents')}}">{{ __('Documents') }}</a></li>   
        </ul>
      </li>
       <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-wheelchair"></i><span class="side-menu__label">{{ __('Physiotherapy') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          
          <li><a class="slide-item" href="{{route('admin.list_befit')}}">{{ __('Enquiries') }}</a></li>   
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-files"></i><span class="side-menu__label">{{ __('Site Content') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          
          <li><a class="slide-item" href="{{route('admin.workcation_data')}}">{{ __('Workcation Page') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.theatre_data')}}">{{ __('Theatre at Home Page') }}</a></li>
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-home"></i><span class="side-menu__label">{{ __('Home Page') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.list_slider')}}">{{ __('Slider') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_newsevent')}}">{{ __('News & Events') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_testimonial')}}">{{ __('Testimonial') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_video_corner')}}">{{ __('Video Corner') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.list_faq')}}">{{ __('FAQ') }}</a></li>
         


          
        </ul>
      </li>
       <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-settings"></i><span class="side-menu__label">{{ __('Settings') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          
          <li><a class="slide-item" href="{{route('admin.password')}}">{{ __('Change Password') }}</a></li>  
           <li><a class="slide-item" href="{{route('admin.about_data')}}">{{ __('About') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.contact_data')}}">{{ __('Contact') }}</a></li> 
        </ul>
      </li>
      
      
    </ul>
    
    @endif
  </aside>
  <!--/APP-SIDEBAR-->