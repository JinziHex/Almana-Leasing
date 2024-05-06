 <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('front-end.includes.head')
   </head>
   <body class="page-template page-template-carrental page-template-carrental-php page page-id-134 mob-menu-slideout-over" style="min-height: 100vh;position: relative;background: #eee0;padding-bottom:0px;">   
      @if(!Auth::guard('main_customer')->check())
               <div class="register">
              
                  <a href="{{route('user.login')}}">Login/Register</a>
                  
                 
               </div>
                @else
                <div class="clearfix"></div>
                <div class="dropdown Choose headrlog">
          @if(Auth::guard('main_customer')->check())
          <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <img src="{{url('assets/uploads/avatar2.png')}}" width="20" />
            {{Auth::guard('main_customer')->user()->customer->cust_fname}}&nbsp;{{Auth::guard('main_customer')->user()->customer->cust_lname}}, {{Auth::guard('main_customer')->user()->customer->email}}
            <!-- <span class="caret"></span> -->
          </button>
           <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
             <li><a href="{{route('user.logout2')}}" onclick="event.preventDefault();
                           document.getElementById('logout-form1').submit();">{{ __('Sign Out')}}</a></li>
              <form id="logout-form1" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                              @csrf
              </form>
          </ul>
          @endif
          
        </div>
                @endif
   </body>
</html>
 
 
 
 
 