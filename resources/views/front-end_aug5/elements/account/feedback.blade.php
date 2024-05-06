@extends('front-end.elements.account.layouts.account-layout')
@section('content')
<div class="right_col" role="main">
   <div class="">
      <div class="row">
         <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
               <div class="x_title">
                  <h2>{{$pageTitle}}<small>{{$subTitle}}</small></h2>
                  <div class="clearfix"></div>
               </div>
               <div class="x_content">
                 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('user.feedback')}}">
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
   <input type="hidden" name="customer_id" value="{{$custId}}">
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="feedback_fname">{{ __('First Name ')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <input id="feedback_fname" type="text" value="{{Auth::guard('main_customer')->user()->customer->cust_fname}}" class="form-control" name="feedback_fname" required>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="feedback_fname">{{ __('Last Name ')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <input id="feedback_fname" type="text" value="{{Auth::guard('main_customer')->user()->customer->cust_lname}}" class="form-control" name="feedback_lname" required>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="feedback_fname">{{ __('Email ')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <input id="feedback_fname" type="email" value="{{Auth::guard('main_customer')->user()->email}}" class="form-control" name="feedback_email" required>
                        </div>
                     </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="feedback_fname">{{ __(' Feedback Type ')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                          <select name="feedback_type" required="" class="form-control">
                           <option value="">--Select a type--</option>
                             <option value="1">Complaint</option>
                             <option value="2">Suggestion</option>      
                          </select>
                        </div>
                     </div>
                      <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="feedback_fname">{{ __('Message ')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <textarea class="form-control" name="feedback_message" required="" rows="5" cols="20" placeholder="Type Message"></textarea>
                          
                        </div>
                     </div>
 
   

   <div class="ln_solid"></div>
   <div class="item form-group">
      <div class="col-md-6 col-sm-6 offset-md-3">
         <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>       
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