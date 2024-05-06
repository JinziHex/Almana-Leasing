@extends('admin.layouts.app')
@section('content')

      <div class="row">
         <div class="col-md-12 col-lg-12 ">
           
               <div class="x_title">
                  <h2>{{$pageTitle}}</h2>
                  <div class="clearfix"></div>
               </div>
            
                  <form id="demo-form2" data-parsley-validate class=" form-label-left" method="POST" action="{{route('save.terms')}}">
                     @csrf
                     @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 1')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <textarea class="form-control" required="" name="st_description" rows="5" cols="30"> {{$fetchTerms->st_description}} </textarea> 
                        </div>
                        <div class="item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 1(Arabic)')}}<span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 ">
                               <textarea class="form-control" dir="rtl" lang="ar" required="" name="ar_st_description" rows="5" cols="30"> {{$fetchTerms->ar_st_description}} </textarea> 
                            </div>
                        
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 2')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <textarea class="form-control" name="st_description_line_2" required="" rows="5" cols="30"> {{$fetchTerms->st_description_line_2}} </textarea>
                        </div>
                     </div>


                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 22 (Arabic)')}}<span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 ">
                           <textarea class="form-control" name="ar_st_description_line_2" required="" dir="rtl" lang="ar"  rows="5" cols="30"> {{$fetchTerms->ar_st_description_line_2}} </textarea>
                        </div>
                     </div>



                   
                     <div class="ln_solid"></div>
                     <div class="item form-group">
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                        </div>
                     </div>
                  </form>
             
               <div class="clearfix"></div>
           
        
   </div>
</div>
</div>
</div>
<script src="http://localhost:8000/assets/admin/vendors/jquery/dist/jquery.min.js"></script>
@endsection

