<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      @include('front-end.includes.head')
   </head>
   <body class="page-template page-template-carrental page-template-carrental-php page page-id-134 mob-menu-slideout-over @if(session()->get('locale')=='ar') arabic-render @endif" style="min-height: 100vh;position: relative;background: #eee;padding-bottom:0px;position: static;">   
      @include('front-end.includes.header')
      @yield('content')
      @include('front-end.includes.footer')
   </body>
</html>