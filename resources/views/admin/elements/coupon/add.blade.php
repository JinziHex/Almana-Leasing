@extends('admin.layouts.app')
@section('content')
@php 
header('Content-Type: text/html; charset=utf-8'); 
@endphp
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<div class="row" style="min-height: 70vh;">
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
         <form name="coupForm" action="{{route('admin.coupon.save')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Coupon Code')}}</label>
                         <input type="text" id="coupon_code" name="coupon_code"  class="form-control" value="{{old('coupon_code')}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                        <label class="form-label">{{ __('Coupon Description')}}</label>
                         <textarea  class="form-control" name="coupon_description">{{old('coupon_description')}}</textarea>
                     </div>
                  </div>
                 <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Discount Type')}}</label>
                       
                         <select   id="discount_type" name="discount_type" class="form-control">
                             <option value="">Choose Discount type</option>
                             <option value="1" @if(old('discount_type')==1) selected @endif>Price Discount</option>
                             <option value="2" @if(old('discount_type')==2) selected @endif>Percentage Discount</option>
                         </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                        <label class="form-label">{{ __('Min.Amount')}}</label>
                        <input type="number" id="minimum_amount" name="minimum_amount"  class="form-control" value="{{old('minimum_amount')}}">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="form-label">{{ __('Discount Value')}}<p style="display:inline;" id="perIn"></p></label>
                         <input type="number" class="form-control" id="discount_value" name="discount_value"  value="{{old('discount_value')}}">
                       
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="form-label">{{ __('Start Date-Activation')}}</label>
                         <input type="date" class="form-control" id="start_date" name="start_date"  value="{{old('start_date')}}">
                       
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label class="form-label">{{ __('End Date-Activation')}}</label>
                         <input type="date" class="form-control" id="end_date" name="end_date"  value="{{old('end_date')}}">
                       
                     </div>
                  </div>
                 
                 
                 
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button id="btnUp" type="button" onclick="submitForm()" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
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
</div>
<script>
function submitForm()
{
   
document.coupForm.submit();
}
        if($('#discount_type').val() == 1){
            $('#discount_value').attr('placeholder', 'In Price');
            $('#perIn').text('(QAR)');
            //$('#btnUp').show();
        }else if($('#discount_type').val() == 2){
            $('#discount_value').attr('placeholder', 'In Percentage(Only add number)');
            $('#perIn').text('(%)');
            //$('#btnUp').show();
        }
        else if($('#discount_type').val() == ""){
            $('#discount_value').attr('placeholder', '');
            $('#perIn').text('');
            //$('#btnUp').hide();
        }
$("#discount_type").on('change', function(event) {
        event.preventDefault();
        if($('#discount_type').val() == 1){
            $('#discount_value').attr('placeholder', 'In Price');
            $('#perIn').text('(QAR)');
           // $('#btnUp').show();
        }else if($('#discount_type').val() == 2){
            $('#discount_value').attr('placeholder', 'In Percentage(Only add number)');
            $('#perIn').text('(%)');
            //$('#btnUp').show();
        }
        else if($('#discount_type').val() == ""){
            $('#discount_value').attr('placeholder', '');
            $('#perIn').text('');
            //$('#btnUp').hide();
        }
    });
</script>
@endsection