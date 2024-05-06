<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <div class="side-header" >
    <a class="header-brand1" href="{{route('home')}}">
      <img src="{{URL::to('/assets/front-end/image/almana_leasing.png')}}" class="header-brand-img desktop-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/almana_leasing.png')}}" class="header-brand-img toggle-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/almana_leasing.png')}}" class="header-brand-img light-logo" alt="logo">
      <img src="{{URL::to('/assets/front-end/image/almana_leasing.png')}}" class="header-brand-img light-logo1" alt="logo">
      </a><!-- LOGO -->
      <a aria-label="Hide Sidebar" class="app-sidebar__toggle ml-auto" data-toggle="sidebar" href="#"></a><!-- sidebar-toggle-->
    </div>
    {{-- <div class="app-sidebar__user">
      <div class="dropdown user-pro-body text-center">
        <div class="user-pic">
          <img src="{{URL::to('/assets/uploads/admin.png')}}" alt="user-img" class="avatar-xl rounded-circle">
        </div>
        <div class="user-info">
          <h6 class=" mb-0 text-dark">{{Auth::user()->name}}</h6>
          <span class="text-muted app-sidebar__user-name text-sm">{{Auth::user()->email}}</span>
        </div>
      </div>
    </div> --}}
    {{-- <div class="sidebar-navs">
      <ul class="nav  nav-pills-circle" style="justify-content: center;">
        {{-- <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Followers">
          <a class="nav-link text-center m-2">
            <i class="fe fe-user"></i>
          </a>
        </li> --}}
        {{-- <li class="nav-item" data-toggle="tooltip" data-placement="top" title="Logout">
          <a class="nav-link text-center m-2" href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fe fe-power"></i>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </li>
      </ul>
    </div> --}} 
    @if(Auth::check())
    <ul class="side-menu">
      <li><h3>General</h3></li>
      <li class="slide">
        <a class="side-menu__item" href="{{route('dashboard')}}"><i class="side-menu__icon ti-shield"></i><span class="side-menu__label"> Dashboard</span></a>
        
        
      </li>
      <li><h3>Website Data</h3></li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-th-large"></i><span class="side-menu__label">{{ ('Masters') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li> <a class="slide-item" href="{{route('admin.city')}}">{{ ('City') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.location')}}">{{ ('Location') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.currency')}}">{{ ('Currency') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.specification')}}">{{ ('Specification') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.models')}}">{{ ('Models') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.rates')}}">{{ ('Rates') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.customers')}}">{{ ('Customers') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.staffs')}}">{{ ('Manage Staff') }}</a></li>

          <li><a class="slide-item" href="{{route('admin.coupon')}}">{{ ('Coupons') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.promotions')}}">{{ ('Promotion') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.customize.language.index')}}">{{ _('Language Customization') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.ads.index')}}">{{ _('Manage Ads') }}</a></li>
        </ul>
      </li>
      
      
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Transactions') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.bookings')}}">{{ ('Bookings') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.traffic.violation')}}">{{ ('Traffic Violations') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.feedbacks')}}">{{ ('Feedbacks') }}</a></li>
        </ul>
      </li>
      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-pencil-square-o"></i><span class="side-menu__label">{{ ('Reports') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.customer.report')}}">{{ ('Customer Report') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.booking.report')}}">{{ ('Booking Reports ') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.modelrate.report')}}">{{ ('Model Rates Reports ') }}</a></li>
         
        </ul>
      </li> 

      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-graduation-cap"></i><span class="side-menu__label">{{ ('Careers') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.jobs.banner')}}">{{ ('Banner') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.job-category.list')}}">{{ ('Job Category') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.jobs.list')}}">{{ ('Jobs') }}</a></li>
        </ul>
      </li> 
      
            <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-picture-o"></i><span class="side-menu__label">{{ ('Gallery') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.albums.index')}}">{{ _('Albums') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.photos.index')}}">{{ _('Photos') }}</a></li>
        </ul>
      </li> 

         <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-link"></i><span class="side-menu__label">{{ __('Footer Links') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.terms-and-conditions')}}">{{ ('Terms & Conditions') }}</a></li>
          {{-- <li><a class="slide-item" href="{{route('admin.process-and-packages')}}">{{ __('Process and Packages') }}</a></li> --}}
          {{-- <li><a class="slide-item" href="{{route('admin.requirements')}}">{{ __('Requirements') }}</a></li> --}}
          <li><a class="slide-item" href="{{route('admin.car-for-sale')}}">{{ ('Car for Sale') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.long-term-rental')}}">{{ ('Long Term Rental') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.short-term-rental')}}">{{ ('Short Term Rental') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.lease-to-own')}}">{{ ('Lease to Own') }}</a></li>
          {{-- <li><a class="slide-item" href="{{route('admin.social-media')}}">{{ __('Social Media Links') }}</a></li> --}}

        </ul>
      </li>

        <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-user-o"></i><span class="side-menu__label">{{ ('About Us') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.about-us.main-content')}}">{{ ('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.about-us.team')}}">{{ ('Meet our Team') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.about-us.clients')}}">{{ ('Clients') }}</a></li>
        </ul>
      </li>
        <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-tasks"></i><span class="side-menu__label">{{ ('FAQ') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.faq')}}">{{ ('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.faq.banner')}}">{{ ('Banner') }}</a></li>
        </ul>
      </li> 

     <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-cogs"></i><span class="side-menu__label">{{ ('Services') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.services')}}">{{ ('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.services.banner')}}">{{ ('Banner') }}</a></li>
        </ul>
      </li>

    {{-- <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon ti-panel"></i><span class="side-menu__label">{{ __('Offers') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.offers')}}">{{ __('Content') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.offers.banner')}}">{{ __('Banner') }}</a></li>
        </ul>
      </li>  --}}

      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-commenting-o"></i><span class="side-menu__label">{{ ('Enquiries') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
      <li><a class="slide-item" href="{{route('admin.career.enquiry')}}">{{ ('Career Enquiries') }}</a></li> 
          <li><a class="slide-item" href="{{route('admin.contact.enquiry')}}">{{ ('Contact Enquiries') }}</a></li>
        </ul>
      </li> 

      <li class="slide">
        <a class="side-menu__item"  data-toggle="slide" href="#"><i class="side-menu__icon fa fa-cog"></i><span class="side-menu__label">{{ ('Settings') }}</span><i class="angle fa fa-angle-right"></i></a>
        <ul class="slide-menu">
          <li><a class="slide-item" href="{{route('admin.profile')}}">{{ ('Profile') }}</a></li>
          <li><a class="slide-item" href="{{route('admin.terms')}}">{{ ('Book Terms & Conditions') }}</a></li>
           <li><a class="slide-item" href="{{route('admin.additional-information')}}">{{ ('Book Additional Information') }}</a></li>
            <!--<li><a class="slide-item" href="{{route('admin.why-choose-us')}}">{{ ('Why Choose Us') }}</a></li>-->
             <li><a class="slide-item" href="{{route('admin.contact-us')}}">{{ ('Contact Us') }}</a></li>
               <li><a class="slide-item" href="{{route('admin.sliders')}}">{{ ('Sliders') }}</a></li>
        </ul>
      </li>







    </ul>
    
    @endif
  </aside>
  <!--/APP-SIDEBAR-->