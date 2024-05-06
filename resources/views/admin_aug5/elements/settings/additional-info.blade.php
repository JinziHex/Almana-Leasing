@extends('admin.layouts.app')
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
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('save.additional.info')}}">
                     @csrf
                     @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content')}}<span class="required">*</span></label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control" required="" name="st_description" rows="5" cols="30"> {{$fetchInfo->st_description}} </textarea> 
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content (Arabic)')}}<span class="required">*</span></label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control" style="text-align: right; direction: rtl;"  required="" name="ar_st_description" rows="5" cols="30"> {{$fetchInfo->ar_st_description}} </textarea> 
                        </div>
                     </div>
                   
                     <div class="ln_solid"></div>
                     <div class="item form-group">
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
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

<script src="http://localhost:8000/assets/admin/vendors/jquery/dist/jquery.min.js"></script>
@endsection