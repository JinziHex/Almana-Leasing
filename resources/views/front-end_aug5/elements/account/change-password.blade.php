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
                 <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('user.change.password')}}">
   @csrf
    @if(session('status'))
   <div class="alert alert-success" id="err_msg">
      <p>{{session('status')}}</p>
   </div>
   @endif 
    @if(session('status-error'))
   <div class="alert alert-danger" id="err_msg">
      <p>{{session('status-error')}}</p>
   </div>
   @endif 
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
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="confirm-password">{{ __('Current Password')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <input id="current-password" type="password" class="form-control" name="current_password" required>
                        </div>
                     </div>
  <div class="item form-group">
      <label class="col-form-label col-md-3 col-sm-3 label-align" for="password">{{ __('New Password')}}<span class="required">*</span><br></label>
            <div class="col-md-6 col-sm-6 ">
               <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                <span id="rule"></span>
                           @error('password')
                           <span class="invalid-feedback" role="alert">
                           <strong>{{ $message }}</strong>
                           </span>
                           @enderror
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="confirm-password">{{ __('Confirm Password')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            <span id="message"></span>
                        </div>
                     </div>
   

   <div class="ln_solid"></div>
   <div class="item form-group">
      <div class="col-md-6 col-sm-6 offset-md-3">
         <button type="submit" class="btn btn-primary">{{ __('Update Password') }}</button>       
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