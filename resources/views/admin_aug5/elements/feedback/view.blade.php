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
       
         <form method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="174" name="country_id">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Feedback Type') }}</label>
                         <input type="text" class="form-control" readonly="" value="
                           @if($feedDetail->feedback_type=="1") {{ __('Complaint') }}@elseif($feedDetail->feedback_type=="2") {{  __('Suggestion') }} @endif">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Subject') }}</label>
                        <input type="text" class="form-control" readonly="" value="@if($feedDetail->feedback_subject!=""){{$feedDetail->feedback_subject}}@else Not Specified @endif">
                     </div>
                  </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Customer') }}</label>
                       <input type="text" class="form-control" readonly="" value="@if($feedDetail->customer_id!=""){{$feedDetail->customer['cust_fname']}} {{$feedDetail->customer_lname}}@else Not Specified @endif">
                     </div>
                  </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Mobile Number') }}</label>
                        <input type="text" class="form-control" readonly="" value="@if($feedDetail->customer_id!=""){{$feedDetail->customer['cust_mobile_code']}}{{$feedDetail->customer['cust_mobile_number']}} @else Not Specified @endif">
                     </div>
                  </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Message') }}</label>
                        <textarea class="form-control" readonly="">@if($feedDetail->feedback_message!=""){{$feedDetail->feedback_message}}@else Not Specified @endif</textarea>
                     </div>
                  </div>

                 
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <a class="btn btn-danger" href="{{ route('admin.feedbacks') }}">Back</a>
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
@endsection