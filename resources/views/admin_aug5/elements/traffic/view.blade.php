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
        
         <form  method="POST" enctype="multipart/form-data">
            @csrf
           
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Customer')}}</label>
                       <input type="text" class="form-control" readonly="" value="
                           @if($traffDetail->customer_id!=""){{$traffDetail->customer->cust_fname}} {{$traffDetail->customer->cust_lname}}@else Not Specified @endif">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Model')}}</label>
                        <input type="text" class="form-control" readonly="" value="@if($traffDetail->model_id!=""){{$traffDetail->model->modal_name}}@else Not Specified @endif">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Model Registration Number')}}</label>
                        <input type="text" class="form-control" readonly="" value="@if($traffDetail->model_id!=""){{$traffDetail->model_reg_no}}@else Not Specified @endif">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Content')}}</label>
                        <textarea class="form-control" readonly="">@if($traffDetail->violation_content!=""){{$traffDetail->violation_content}}@else Not Specified @endif</textarea>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Date')}}</label>
                       <input type="text" class="form-control" readonly="" value="@if($traffDetail->violation_date!=""){{$traffDetail->violation_date}}@else Not Specified @endif">
                     </div>
                  </div>
                 
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="submit" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.traffic.violation') }}">Cancel</a>
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