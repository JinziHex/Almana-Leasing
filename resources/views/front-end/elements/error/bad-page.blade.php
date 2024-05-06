<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    @include('front-end.includes.head')
    <style>
        div#footer {display: none;}
    </style>
</head>
<body style="background-color:#eee;">

    <div class="rental-wrapper car-list-pg car-single-pg car-summary-pg reservation-pg" style="padding-bottom:40px;">
       
  
  
       <div class="Reservation-txt">
           <img src="{{URL::to('assets/uploads/bad-page.png')}}" width="500" style="display: block;max-width: 100%;margin:auto;">
        <h2>OH NO! <br>Something went wrong. Please try again later.</h2>
       <a class="btn btn-warning btn-lg btn-block mx-auto text-white" style="margin-top: 40px;width: 200px;" href="{{url('/')}}">Back to Home </a>
       
        
      </div>
      



      


      
    </div>


   
    <div style="clear: both;"></div>
</div>

<hr />
@include('front-end.includes.footer')
</body>
</html>

