<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="side-header" style="background-color: #6b57ee;">
    <a class="header-brand1" href="{{route('home')}}">
     {{--  <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img desktop-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img toggle-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img light-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/logo-white.png')}}" class="header-brand-img light-logo1" alt="logo"> --}}
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
      <li><h3>General</h3></li>
      <li class="slide">
        <a class="side-menu__item" href="{{route('dashboard')}}"><i class="side-menu__icon ti-shield"></i><span class="side-menu__label"> Dashboard</span></a>
        
        
      </li>
      <li><h3>Website Data</h3></li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Masters') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.city')}}">{{ __('City') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.location')}}">{{ __('Location') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.currency')}}">{{ __('Currency') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.specification')}}">{{ __('Specification') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.models')}}">{{ __('Models') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.rates')}}">{{ __('Rates') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.customers')}}">{{ __('Customers') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.staffs')}}">{{ __('Manage Staff') }}</a></li>

          <li><a class="slide-item" href="{{route('admin.coupon')}}">{{ __('Coupons') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.promotions')}}">{{ __('Promotion') }}</a></li>
        </ul>
      </li>
      
      
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Transactions') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.bookings')}}">{{ __('Bookings') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.traffic.violation')}}">{{ __('Traffic Violations') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.feedbacks')}}">{{ __('Feedbacks') }}</a></li>
        </ul>
      </li>

     {{--  <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Careers') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.jobs.banner')}}">{{ __('Banner') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.job-category.list')}}">{{ __('Job Category') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.jobs.list')}}">{{ __('Jobs') }}</a></li>
        </ul>
      </li> --}}

      {{--   <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Footer Links') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.terms-and-conditions')}}">{{ __('Terms & Conditions') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.process-and-packages')}}">{{ __('Process and Packages') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.requirements')}}">{{ __('Requirements') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.car-for-sale')}}">{{ __('Car for Sale') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.long-term-rental')}}">{{ __('Long Term Rental') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.lease-to-own')}}">{{ __('Lease to Own') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.social-media')}}">{{ __('Social Media Links') }}</a></li>

        </ul>
      </li>
 --}}
        <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('About Us') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.about-us.main-content')}}">{{ __('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.about-us.team')}}">{{ __('Meet our Team') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.about-us.clients')}}">{{ __('Clients') }}</a></li>
        </ul>
      </li>
     {{--   <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('FAQ') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.faq')}}">{{ __('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.faq.banner')}}">{{ __('Banner') }}</a></li>
        </ul>
      </li> --}}

     {{--  <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Services') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.services')}}">{{ __('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.services.banner')}}">{{ __('Banner') }}</a></li>
        </ul>
      </li>
 --}}
    {{--   <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Offers') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.offers')}}">{{ __('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.offers.banner')}}">{{ __('Banner') }}</a></li>
        </ul>
      </li> --}}

      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Enquiries') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          {{-- <li><a class="slide-item" href="{{route('admin.career.enquiry')}}">{{ __('Career Enquiries') }}</a></li> --}}
          <li><a class="slide-item" href="{{route('admin.contact.enquiry')}}">{{ __('Contact Enquiries') }}</a></li>
        </ul>
      </li> 

      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Settings') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.profile')}}">{{ __('Profile') }}</a></li>
         {{--  <li><a class="slide-item" href="{{route('admin.terms')}}">{{ __('Book Terms & Conditions') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.additional-information')}}">{{ __('Book Additional Information') }}</a></li>
            <li><a class="slide-item" href="{{route('admin.why-choose-us')}}">{{ __('Why Choose Us') }}</a></li>
             <li><a class="slide-item" href="{{route('admin.contact-us')}}">{{ __('Contact Us') }}</a></li> --}}
        </ul>
      </li>







    </ul>
    
    @endif
  </aside>
  <!--/APP-SIDEBAR-->