<meta charset="UTF-8">
<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="{{URL::to('/assets/uploads/favicon.png')}}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- TITLE -->
<title>{{ __('Almana Leasing | Administration') }}</title>
<!-- BOOTSTRAP CSS -->
<link href="{{URL::to('/assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
<!-- STYLE CSS -->
<link href="{{URL::to('/assets/css/style.css')}}" rel="stylesheet"/>
<link href="{{URL::to('/assets/css/skin-modes.css')}}" rel="stylesheet"/>
<!-- SIDE-MENU CSS -->
<link href="{{URL::to('/assets/plugins/sidemenu/closed-sidemenu.css')}}" rel="stylesheet">
<!--C3 CHARTS CSS -->
<link href="{{URL::to('/assets/plugins/charts-c3/c3-chart.css')}}" rel="stylesheet"/>
<!-- CUSTOM SCROLL BAR CSS-->
<link href="{{URL::to('/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css')}}" rel="stylesheet"/>
<!--- FONT-ICONS CSS -->
<link href="{{URL::to('/assets/css/icons.css')}}" rel="stylesheet"/>
<!-- DATA TABLE CSS -->
<link href="{{URL::to('/assets/plugins/datatable/dataTables.bootstrap4.min.css')}}" rel="stylesheet"/>
<!-- SIDEBAR CSS -->
<link href="{{URL::to('/assets/plugins/sidebar/sidebar.css')}}" rel="stylesheet">
<!-- MULTI SELECT CSS -->
<link rel="stylesheet" href="{{URL::to('/assets/plugins/multipleselect/multiple-select.css')}}">

<!-- COLOR SKIN CSS -->
<link id="theme" rel="stylesheet" type="text/css" media="all" href="{{URL::to('/assets/colors/color1.css')}}" />
<script src="{{URL::to('/assets/js/jquery-3.4.1.min.js')}}"></script>
<script type="text/javascript" src="{{URL::to('/assets/js/lan.js')}}"></script>
<script src="{{URL::to('/assets/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::to('/assets/plugins/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{URL::to('/assets/plugins/datatable/datatable.js')}}"></script>
<script src="{{URL::to('/assets/plugins/datatable/datatable-2.js')}}"></script>
<script src="{{URL::to('/assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
@section('headSection')
@show