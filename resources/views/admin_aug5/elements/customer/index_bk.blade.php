@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">

            <!-- Filter -->
             <form method="GET" action="{{route('customer.filter')}}">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>{{ __('Customer Number')}}</label>
                           <input type="text" id="reference_id"  name="cust_no"  class="form-control" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>{{ __('Mobile Number')}}</label>
                           <input type="text" id="reference_id"  name="cust_mobile_number"  class="form-control" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                       <label>{{ __('Customer Name')}}</label>
                           <input type="text" id="reference_id"  name="cust_name"  class="form-control" >
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
                           <a href="{{route('admin.customers')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>

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
                        <th class="wd-15p">{{ __('Action') }}</th>
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
                     <td>{{$custDetails->nationality['country_name']}}
                     </td>
                     <td>@if($custDetails->cust_profile_status==1)
                        <a href="{{url('customer/deactivate/'.Crypt::encryptString($custDetails->customer_id))}}" style="font-size: 12px;padding: 0px 5px;" class="btn btn-outline-success btn-sm" onclick="return confirm('Do you want to deactivate this profile?');">Active</a>
                        @else
                        <a href="{{url('customer/activate/'.Crypt::encryptString($custDetails->customer_id))}}" style="font-size: 12px;padding: 0px 5px;" class="btn btn-outline-danger btn-sm" onclick="return confirm('Do you want to activate this profile?');">Inactive</a>
                        @endif
                     </td>
                      <td>@if($custDetails->cust_otp_verify==1)
                        <a class="btn btn-outline-success btn-sm" style="font-size: 12px;padding: 0px 5px;">Verified</a>
                        @else
                       <a class="btn btn-outline-danger btn-sm" style="font-size: 12px;padding: 0px 5px;">Not Verified</a>
                        @endif
                     </td>
                     <td><a href="{{url('customer/view/'.Crypt::encryptString($custDetails->customer_id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i>&nbsp;{{ __('View') }}</a>{{-- <a href="{{url('customer/delete/'.Crypt::encryptString($custDetails->customer_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this customer?');">Delete</a> --}}</td>
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
@endsection