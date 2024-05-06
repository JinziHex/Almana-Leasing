@extends('admin.layouts.app')
@section('content')

   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">

            <!-- Filter -->
             <form method="GET" action="{{route('admin.customer.report')}}">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>{{ __('Customer Code')}}</label>
                           <input type="text" id="reference_id"  name="cust_no"  class="form-control" value="@isset($_GET['cust_no']){{$_GET['cust_no']}}@endisset" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>{{ __('Mobile Number')}}</label>
                           <input type="text" id="reference_id"  name="cust_mobile_number"  class="form-control" value="@isset($_GET['cust_mobile_number']){{$_GET['cust_mobile_number']}}@endisset" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                       <label>{{ __('Customer Name')}}</label>
                           <input type="text" id="reference_id"  name="cust_name"  class="form-control" value="@isset($_GET['cust_name']){{$_GET['cust_name']}}@endisset" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                       <label>{{ __('Profile Status ')}}</label>
                       <select class="form-control" name="cust_profile_status">
                        <option value="" default>--Select Profile Status --</option>
                   
                       
                        <option  {{request()->input('cust_profile_status') == "1" ? 'selected':''}}  value="1">Active</option>
                        <option  {{request()->input('cust_profile_status') == "0" ? 'selected':''}}  value="0">Inactive</option>
                       
                      
                     </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                       <label>{{ __('OTP Status')}}</label>
                       <select class="form-control" name="cust_otp_verify">
                        <option value="" default >--Select OTP Status --</option>
                      
                         <option  {{request()->input('cust_otp_verify') == "1" ? 'selected':''}}  value="1">Verified</option>
                        <option  {{request()->input('cust_otp_verify') ==  "0" ? 'selected':''}}  value="0">Not Verified </option>
                       

                       

                     </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <div class="col-md-12 col-sm-12">
                           <input type="submit" class="btn btn-block btn-primary" value="Filter">

                        </div>
                     </div>
                  </div>
                  
                   <div class="col-md-6">
                     <div class="form-group">
                        <div class="col-md-12 col-sm-12">
                           <a href="{{route('admin.customer.report')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>

                        </div>
                     </div>
                  </div>
                 
                  
                  
               </div>
                
            </form>
            <!--filter ends-->
            @if(session('status'))
            <div class="alert alert-success" id="err_msg">
               <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                        <th class="wd-15p">{{ __('Code/No.') }}</th>
                        <th class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Mobile') }}</th>
                        <th class="wd-15p">{{ __('Nationality') }}</th>
                        <th class="wd-15p">{{ __('Status') }}</th>
                        <th class="wd-15p">{{ __('OTP') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($custDetail as $custDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td>
                         @if($custDetails->cust_code)
                         {{$custDetails->cust_code}}
                         @else
                         ---
                         @endif
                         </td>
                     <td>{{ucfirst($custDetails->cust_fname)}}&nbsp;{{ucfirst($custDetails->cust_lname)}}</td>
                     <td>{{$custDetails->cust_mobile_number}}</td>
                     <td>{{$custDetails->nationality['country_name'] ?? ''}}
                     </td>
                     <td>@if($custDetails->cust_profile_status==1)
                            Active
                        @else
                            Inactive
                        @endif
                     </td>
                      <td>@if($custDetails->cust_otp_verify==1)
                        Verified
                      
                        @else
                         Not Verified
                      
                        @endif
                     </td>
                     
                  </tr>
                  @endforeach
                  </tbody>
               </table>
               
            </div>
            
            
         </div>
      </div>
   </div>
</div>
</div>
<script>

  $('#example').DataTable({
   
   dom: 'Bflrtip',
   buttons: [
      { extend: 'copy',title:"customers", className: 'btn btn-info glyphicon glyphicon-duplicate' },
    { extend: 'csv',title:"customers", className: 'btn btn-success glyphicon glyphicon-save-file' },
    { extend: 'excel',title:"customers", className: 'btn btn-success glyphicon glyphicon-list-alt' },
    { extend: 'pdf',title:"customers",title:"customers",className: 'btn btn-danger glyphicon glyphicon-file' },
    { extend: 'print',title:"customers", className: 'btn btn-warning glyphicon glyphicon-print' }
   ]
  });

</script>
@endsection