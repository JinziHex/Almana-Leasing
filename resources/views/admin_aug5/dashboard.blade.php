@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Modal;
use App\Models\Customer;
use App\Models\Booking;
use Carbon\Carbon;
@endphp
<!-- ROW-1 -->
<div class="row" style="min-height: 70vh;">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
      <div class="row">
         <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-primary mb-0 box-primary-shadow">
                     <i class="fe fe-trending-up text-white"></i>
                  </div>
                
                  <h2 class="mt-4 mb-2 number-font">{{Modal::count()}}</h2>
                  <p class="text-muted">{{ __('From Total vehicles') }}</p>
               </div>  
             <div class="cardft-head"><h6 class="mt-3 mb-2">{{ __('Vehicles') }}</h6></div>  
            </div>
         </div>
         <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                     <i class="fe fe-codepen text-white"></i>
                  </div>
                  
                  <h2 class="mt-4 mb-2 number-font">{{Customer::count()}}</h2>
                  <p class="text-muted">{{ __('Registered Customers') }}</p>
               </div>
                <div class="cardft-head"> <h6 class="mt-3 mb-2">{{ __('Customers') }}</h6></div>
            </div>
         </div>
         <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-success mb-0 box-success-shadow">
                     <i class="fe fe-aperture text-white"></i>
                  </div>
                 
                  <h2 class="mt-4 mb-2  number-font">{{Booking::whereDate('created_at', Carbon::today())->count()}}</h2>
                  <p class="text-muted">{{ __('From Total Bookings') }}</p>
               </div>
               
                <div class="cardft-head">  <h6 class="mt-3 mb-2">{{ __('Todays Bookings') }}</h6></div>
            </div>
         </div>
         <div class="col-lg-3 col-md-12 col-sm-12 col-xl-3">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-info mb-0 box-info-shadow">
                     <i class="fe fe-briefcase text-white"></i>
                  </div>
                
                  <h2 class="mt-4 mb-2  number-font">{{Booking::whereMonth('created_at',$dtToday->format('m'))->count()}}</h2>
                  <p class="text-muted">Bookings on {{$dtToday->format('F')}}</p>
               </div>
               
               <div class="cardft-head">  <h6 class="mt-3 mb-2">{{ __('Current Month Booking') }}</h6></div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ __('Recent Bookings List') }}</h3>
         </div>
         <div class="card-body">
         <div class="table-responsive">
               <table class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.')}}</th>
                        <th class="wd-15p">{{ __('Reference Id')}}</th>
                        <th class="wd-15p">{{ __('Customer')}}</th>
                        <th class="wd-15p">{{ __('From Date')}}</th>
                        <th class="wd-15p">{{ __('To Date')}}</th>
                        <th class="wd-15p">{{ __('Car Model')}}</th>
                        <th class="wd-15p">{{ __('Rate')}}</th>
                        <th class="wd-15p">{{ __('Status')}}</th>
                        <th class="wd-25p">{{ __('Action')}}</th>
                     </tr>
                  </thead>
                  <tbody>
                  @php
                  $i=0;
                  @endphp
                  @foreach($bkDetail as $bkDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td>{{$bkDetails->book_ref_id}}</td>
                     <td>{{ucfirst($bkDetails->customer->cust_fname)}} {{$bkDetails->customer->cust_lname}}</td>
                     <td>{{$bkDetails->book_from_date}}</td>
                     <td>{{$bkDetails->book_to_date}}</td>
                     <td>{{$bkDetails->model->modal_name}}</td>
                     <td>{{$bkDetails->book_total_rate}}</td>
                     <td>
                         @if($bkDetails->book_status==6)
                         <button class="btn btn-success btn-sm">{{$bkDetails->status->status}}</button>
                         @else
                         <button type="button" class="btn btn-dark btn-sm">{{$bkDetails->status->status}}</button>
                         @endif
                        
                     </td>
                     <td><a href="{{url('booking/view/'.Crypt::encryptString($bkDetails->book_id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i>&nbsp;{{ __('View')}}</a></td>
                  </tr>
                  <!--status -->
                 
                  @endforeach
               </tbody>
               </table>
              
               
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ __('Recent Bookings') }}</h3>
         </div>
         <div class="card-body">
            <div id="container2"></div>
         </div>
      </div>
   </div>
   <?php 
      $returnNum = array_map('intval', $return);
   ?>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
    var users =  <?php echo json_encode($returnNum) ?>;

    Highcharts.chart('container2', {
        title: {
            text: 'Booking Trends <?php echo date("Y"); ?> '
        },
        // subtitle: {
        //     text: 'Source: codechief.org'
        // },
         xAxis: {
            categories: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug',  'Sep', 'Oct', 'Nov', 'Dec'],
            title: {
                text: 'Months'
            } ,

        //     labels: {
        //   formatter: function() {
        //     return Highcharts.dateFormat('%M %Y',users);
        //   }
        // }   
        },

        
        yAxis: {
            title: {
                text: 'Number of New Bookings'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                allowPointSelect: true
            }
        },
        series: [{
            name: 'New Bookings',
            //data: [1,2,0,1,1,2,4,2,0,1,1,2]
            data: users
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
});
</script>
   
   <!-- COL END -->
</div>
<!-- ROW-1 END -->
</div>
</div>
<!-- CONTAINER END -->
</div>
@endsection