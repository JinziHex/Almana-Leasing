@extends('front-end.elements.account.layouts.account-layout')
@section('content')
<div class="right_col" role="main">
   <div class="">
      <div class="row">
         <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
               <div class="x_title">
                  <h2>{{$pageTitle}}</h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('user.profile.update')}}">
   @csrf
   @if(session('status'))
   <div class="alert alert-success" id="err_msg">
      <p>{{session('status')}}</p>
   </div>
   @endif 
   @if (count($errors) > 0)
   <div class="alert alert-danger" id="err_msg">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
   <input type="hidden" name="customer_id" value="{{$fetchCust->customer_id}}">
   <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">{{ __('First Name') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="text" id="cust_fname" name="cust_fname" value="{{$fetchCust->customer->cust_fname}}" required="required" class="form-control ">
      </div>
   </div>
    <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Last Name') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="text" id="cust_lname"  name="cust_lname" required="required" class="form-control" value="{{$fetchCust->customer->cust_lname}}">
      </div>
   </div>
    <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Email') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="text" id="email" value="{{$fetchCust->customer->email}}" name="email" required="required" class="form-control ">
      </div>
   </div>
    <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Mobile Number') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="text" id="cust_mobile_number" value="{{$fetchCust->customer->cust_mobile_number}}" name="cust_mobile_number" required="required" readonly="" class="form-control ">
      </div>
   </div>
    <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Date of Birth') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="date" id="cust_dob" value="{{$fetchCust->customer->cust_dob}}" name="cust_dob" class="form-control ">
      </div>
   </div>
 <h2>Driving License Details</h2>
 <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Driving License Number') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="text" id="cust_driving_license_no" value="{{$fetchCust->customer->cust_driving_license_no}}" name="cust_driving_license_no" class="form-control">
      </div>
   </div>
   <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Driving License Country Issued') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <select class="form-control" name="cust_license_issued_country">
            @foreach($getCont as $getConts)
            <option value="{{$getConts->country_id}}" {{ $getConts->country_id == $fetchCust->cust_license_issued_country ? 'selected' : '' }}>{{$getConts->country_name}}</option>
            @endforeach
         </select>
        
      </div>
   </div>
     <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="currency-code">{{ __('Date Issued') }} <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 ">
         <input type="date" id="cust_license_issued_date" value="{{$fetchCust->customer->cust_license_issued_date}}" name="cust_license_issued_date" class="form-control">
      </div>
   </div>
   <div class="ln_solid"></div>
   <div class="item form-group">
      <div class="col-md-6 col-sm-6 offset-md-3">
         <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>       
      </div>
   </div>
</form>
               </div>
               <div class="clearfix"></div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
</div>
@endsection