@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.coupon.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                        <th class="wd-15p">{{ __('Code') }}</th>
                        <th class="wd-15p">{{ __('Description') }}</th>
                        <th class="wd-15p">{{ __('Discount Type') }}</th>
                        <th class="wd-15p">{{ __('Discount Value') }}</th>
                        <th class="wd-15p">{{ __('Minimum Amount') }}</th>
                        <th class="wd-15p">{{ __('Start Date') }}</th>
                        <th class="wd-15p">{{ __('End Date') }}</th>
                        <th class="wd-15p">{{ __('Actions') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($coupons as $coupon)
                     @php $i++; @endphp
                     <tr>
                         <td>{{$i}}</td>
                        <td>
                            {{$coupon->coupon_code}}<br>
                            @if($coupon->is_active==1)
                               @if(date('Y-m-d')<=$coupon->end_date)
                               <span class="badge badge-sm badge-success"><small>Active</small></span>
                               @else
                               <span class="badge badge-sm badge-danger"><small>Expired</small></span>
                               @endif
                            @else
                               <span class="badge badge-sm badge-danger"><small>Inctive</small></span>
                            @endif
                        </td>
                        <td><small>{{$coupon->coupon_description}}</small></td>
                        <td>@if($coupon->discount_type==1)Price @endif @if($coupon->discount_type==2)Percentage @endif</td>
                        <td>{{number_format(floatval($coupon->discount_value),2)}}</td>
                        <td>{{number_format(floatval($coupon->minimum_order_amount),2)}}</td>
                        <td>{{date('d-M,Y',strtotime($coupon->start_date))}}</td>
                        <td>{{date('d-M,Y',strtotime($coupon->end_date))}}</td>
                        <td>
                           <a href="{{url('coupon/edit/'.Crypt::encryptString(@$coupon->id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;<a onclick="deletePopup()" href="{{url('coupon/delete/'.Crypt::encryptString($coupon->id))}}" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
                           
                           
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
    function deletePopup()
    {
        return confirm('Do you want to delete this city?');
    }
</script>
@endsection