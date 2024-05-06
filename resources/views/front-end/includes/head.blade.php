      <!-- Google tag (gtag.js) --> 
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-B7BFPFLZGX"></script>
      <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-B7BFPFLZGX'); </script>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <meta name="description" content="{{ isset($pageDescription) ? $pageDescription : 'Welcome to Almana Leasing' }}">
      <title>{{ isset($pageTitle) ? $pageTitle : 'Almana Leasing' }}</title>
      @if(request()->is('/'))
      <link rel="canonical" href="https://www.almanaleasing.com/" />
      @endif
      <link rel="stylesheet" href="{{URL::to('assets/front/themes/rental/css/style.css')}}" type="text/css" media="screen" />
         <link rel="stylesheet" href="{{URL::to('assets/front/themes/rental/css/arabstyle.css')}}" type="text/css" media="screen" />
      <link href='https://fonts.googleapis.com/css?family=Oswald:400' rel='stylesheet' type='text/css'>
      <link href='https://fonts.googleapis.com/css?family=Oswald:300' rel='stylesheet' type='text/css'>
      <link href="https://fonts.googleapis.com/css?family=Oswald|Quicksand|Poppins|Glegoo|Montserrat&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Oswald:400,700&display=swap" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Montserrat:400,800&display=swap" rel="stylesheet">
      <link href="{{URL::to('assets/front/themes/rental/css/owl.carousel.min.css')}}" rel="stylesheet">
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
      <link href="{{URL::to('assets/front/themes/rental/css/owl.theme.default.min.css')}}" rel="stylesheet">
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <link href="{{URL::to('assets/front/themes/rental/css/font-awesome.min.css')}}" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
      <link href="{{URL::to('assets/front/themes/rental/css/responsive.css')}}" rel="stylesheet">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script type="text/javascript" src="{{URL::to('assets/front/themes/rental/js/jquery-1.12.4.min.js')}}"></script> 
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
      <script src="{{URL::to('assets/front/themes/rental/js/main_jQuery.js')}}" type="text/javascript"></script> <!--jQuery--> 
      <script src="{{URL::to('assets/front/themes/rental/js/owl.carousel.min.js')}}" type="text/javascript" charset="utf-8"></script> 

     {{--  <link rel='stylesheet' id='rw_toprated-css'  href='http://css.rating-widget.com/wordpress/toprated.css?ck=Y2020M09D16&#038;ver=3.0.6' type='text/css' media='all' /> --}}
      <link rel='stylesheet' id='rw_recommendations-css'  href='http://css.rating-widget.com/widget/recommendations.css?ck=Y2020M09D16&#038;ver=3.0.6' type='text/css' media='all' />
      <link rel='stylesheet' id='tf-compiled-options-mobmenu-css'  href='{{URL::to('assets/front/themes/rental/css/dynamic-mobmenu.css')}}' type='text/css' media='all' />
      <link rel='stylesheet' id='tf-google-webfont-roboto-css'  href='//fonts.googleapis.com/css?family=Roboto%3Ainherit%2C400&#038;subset=latin%2Clatin-ext&#038;ver=5.2.7' type='text/css' media='all' />
      <link rel='stylesheet' id='tf-google-webfont-dosis-css'  href='//fonts.googleapis.com/css?family=Dosis%3Ainherit%2C400&#038;subset=latin%2Clatin-ext&#038;ver=5.2.7' type='text/css' media='all' />
      <link rel='stylesheet' id='cssmobmenu-icons-css'  href='{{URL::to('assets/front/themes/rental/css/mobmenu-icons.css')}}' type='text/css' media='all' />
      <link rel='stylesheet' id='cssmobmenu-css'  href='{{URL::to('assets/front/themes/rental/css/mobmenu.css')}}' type='text/css' media='all' />
      <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
      <script type='text/javascript' src='{{URL::to('assets/front/themes/rental/js/mobmenu.js')}}'></script>
     
      
        @if(session()->get('locale')!=NULL)
            @if(session()->get('locale')=='en')
            <link rel="icon" href="{{URL::to('assets/front/themes/rental/images/favicon_en.png')}}" sizes="192x192" />
            <link rel="apple-touch-icon-precomposed" href="{{URL::to('assets/front/themes/rental/images/favicon_en.png')}}" />
             @else
             <link rel="icon" href="{{URL::to('assets/front/themes/rental/images/favicon_ar.png')}}" sizes="192x192" />
            <link rel="apple-touch-icon-precomposed" href="{{URL::to('assets/front/themes/rental/images/favicon_ar.png')}}" />
                      
            @endif
        @else
            <link rel="icon" href="{{URL::to('assets/front/themes/rental/images/favicon_en.png')}}" sizes="192x192" />
           <link rel="apple-touch-icon-precomposed" href="{{URL::to('assets/front/themes/rental/images/favicon_en.png')}}" />
        @endif
      <meta name="msapplication-TileImage" content="{{URL::to('assets/front/themes/rental/images/favicon.gif')}}" />
      <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
      <script src="https://use.fontawesome.com/00d9a7f975.js"></script>
     {{--  <link rel="stylesheet" href="{{URL::to('assets/front/css/bootstrap-datepicker.min.css')}}"> --}}
      <link rel="stylesheet" href="{{URL::to('assets/front/css/style.css')}}">
       <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
       <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
       <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css"> 
      <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>