@extends('admin.layouts.app')
@section('content')
@php 
header('Content-Type: text/html; charset=utf-8'); 
@endphp
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
      <div class="row">
         <div class="col-md-12 ">
           
               <div class="x_title">
                  <h2>{{$pageTitle}}</h2>
                  <div class="clearfix"></div>
               </div>
            
                  <form name="formSet"  method="POST" action="{{route('save.terms')}}">
                     @csrf
                     @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
                     <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 1')}}<span class="required">*</span></label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control" id="d1"  name="st_description" rows="5" cols="30" required> {{$fetchTerms->st_description}} </textarea> 
                        </div>
                        <div class="form-group">
                            <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 1(Arabic)')}}<span class="required">*</span></label>
                            <div class="col-md-12 col-sm-12 ">
                               <textarea class="form-control" id="d2" dir="rtl"  name="ar_st_description" rows="5" cols="30" required> {{$fetchTerms->ar_st_description}} </textarea> 
                            </div>
                        
                     </div>
                     <div class="form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 2')}}</label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control"  name="st_description_line_2" rows="5" cols="30" required> {{$fetchTerms->st_description_line_2}} </textarea>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 ">{{ __('Content Line 2 (Arabic)')}}</label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control"  dir="rtl"  name="ar_st_description_line_2" rows="5" cols="30" required> {{$fetchTerms->ar_st_description_line_2}} </textarea>
                        </div>
                     </div>
                     <div class="ln_solid"></div>
                     <div class="item form-group">
                        <div class="col-md-12 col-sm-12 text-center">
                           <button type="submit" o class="btn btn-success">{{ __('Update') }}</button>
                        </div>
                     </div>
                  </form>
             
               <div class="clearfix"></div>
           
        
   </div>
</div>
</div>
</div>
<script>

   
function submitForm()
{
if($('#d1').val()=="")
{
    alert('please enter content');
}
else
{
  document.formSet.submit();  
}
   

}
    
</script>
@endsection

