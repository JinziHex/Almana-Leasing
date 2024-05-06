@extends('admin.layouts.app')
@section('content')
@php
use App\Models\admin\category\Category;
use App\Models\admin\insurance\Insurance;
use App\Models\admin\template\Template;
use App\Models\admin\job_seeker\TrnJobSeeker;
use App\Models\admin\product\Mst_product;
@endphp
<!-- ROW-1 -->
<div class="row" style="min-height: 70vh;">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xl-6">
      <div class="row">
         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-primary mb-0 box-primary-shadow">
                     <i class="fe fe-trending-up text-white"></i>
                  </div>
                  <h6 class="mt-4 mb-1">{{ __('Products') }}</h6>
                  <h2 class="mb-2 number-font">{{Mst_product::count()}}</h2>
                  <p class="text-muted">{{ __('Registered Products ') }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-secondary mb-0 box-secondary-shadow">
                     <i class="fe fe-codepen text-white"></i>
                  </div>
                  <h6 class="mt-4 mb-1">{{ __('Category') }}</h6>
                  <h2 class="mb-2 number-font">{{Category::count()}}</h2>
                  <p class="text-muted">{{ __('Total Category') }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-success mb-0 box-success-shadow">
                     <i class="fe fe-aperture text-white"></i>
                  </div>
                  <h6 class="mt-4 mb-1">{{ __('Insurance') }}</h6>
                  <h2 class="mb-2  number-font">{{Insurance::count()}}</h2>
                  <p class="text-muted">{{ __('Total Insurance') }}</p>
               </div>
            </div>
         </div>
         <div class="col-lg-6 col-md-12 col-sm-12 col-xl-6">
            <div class="card">
               <div class="card-body text-center statistics-info">
                  <div class="counter-icon bg-info mb-0 box-info-shadow">
                     <i class="fe fe-briefcase text-white"></i>
                  </div>
                  <h6 class="mt-4 mb-1">{{ __('Job Enquiries') }}</h6>
                  <h2 class="mb-2  number-font">{{TrnJobSeeker::count()}}</h2>
                  <p class="text-muted">{{ __('Total WFH Job enquiries') }}</p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ __('Orders') }}</h3>
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
      var orderss =  <?php echo json_encode($returnNum) ?>;
     
      
      Highcharts.chart('container2', {
          title: {
              text: 'Customer Orders <?php echo date("Y"); ?> '
          },
         
           xAxis: {
              categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug',  'Sept', 'Oct', 'Nov', 'Dec'],
              title: {
                  text: 'Months'
              } ,
              gridLineWidth: 1
      
            
          },
      
          
          yAxis: {
              title: {
                  text: 'Count'
              },


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
              name: 'New Orders',
              data: orderss
          }
          
          ],
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