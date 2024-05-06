@extends('admin.layouts.app')
@section('content')
@php 
header('Content-Type: text/html; charset=utf-8'); 
@endphp
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
         </div>
         @if (count($errors) > 0)
         <div class="alert alert-danger" id="err_msg">
            <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></li>
               @endforeach
            </ul>
         </div>
         @endif
          @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
         <form name="coupForm" action="{{route('admin.customer.assign.save')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
               <div class="row">
                  
                
                 <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Coupon code')}}</label>
                        <input type="hidden" name="customer_id" value="{{$customer->customer_id}}">
                         <select   id="coupon" name="coupon" class="form-control" required>
                            
                              <option value="">Choose Coupon Code</option>
                             @foreach($coupons as $coupon)
                             <option value="{{$coupon->id}}" @if(old('coupon')==$coupon->id) selected @endif>{{$coupon->coupon_code}}</option>
                             @endforeach
                         </select>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="button" onclick="submitForm()" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Assign Coupon</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.coupon') }}">Cancel</a>
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </form>
   </div>
</div>
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12">
   <div class="card">
         <div class="card-header">
            <h3 class="mb-0 card-title">Assigned Coupons</h3>
         </div>
         <div class="card-body">
               <div class="row">
                 
                <table class="table table-sm">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Coupon</th>
                        <th scope="col">Status</th>
                        <th scope="col">Valid Till</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                    $i=1;
                    use App\Helpers\Helper;

                    @endphp
                    @foreach($customer_coupons as $coupon)
                    @php
                      $status=Helper::CouponCurrentStatus(@$coupon->coupon_id);
                    @endphp
                    @if(@$coupon->coupon!=NULL)
                        <tr>
                        <td scope="row">{{$i++}}</td>
                        <td>{{@$coupon->coupon->coupon_code}}</td>
                        <td>{{$status}}</td>
                        <td>{{date('d-M,Y',strtotime($coupon->coupon->end_date))}}</td>
                        <td><a href="{{url('customer/delete-coupon/'.Crypt::encryptString($coupon->id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this coupon?');">Delete</a></td>
                        </tr>
                    @endif
                    @endforeach
                        
                    </tbody>
                </table>
              @if(count($customer_coupons)==0)
                <div class="col-lg-12 mb-4">
            
                     <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        
                        <strong>Alert!</strong> No coupons Assigned Yet!.
                        </div>
                     </div>
          
               </div>
              @endif
         </div>
   </div>
   </div>
</div>
</div>
<script>
function submitForm()
{
   
document.coupForm.submit();
}

</script>
@endsection