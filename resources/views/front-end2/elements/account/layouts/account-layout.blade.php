<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="images/favicon.ico" type="image/ico" />
    <title>{{ config('app.name', 'Rent Solutions|User Account') }} </title>
     @include('front-end.elements.account.includes.header')
     
</head>
<style type="text/css">
     body{background: #fff;}
.container .container.body{position: relative;}
.nav-md .container.body .right_col{min-height: calc(100vh - 39px); }
</style>
    <body class="nav-md">
        <div class="container">
            <div class="container body">
                 @include('front-end.elements.account.includes.sidemenu')

       @include('front-end.elements.account.includes.top-navigation')
                <div class="main_container">
            @yield('content')
                </div>
            </div>
        </div>
        @include('admin.includes.footer')
    </body>
</html>