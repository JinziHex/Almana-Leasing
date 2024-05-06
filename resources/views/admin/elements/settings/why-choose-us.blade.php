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
                  <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('admin.page-data.update')}}">
                     @csrf
                     @if(session('status'))
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
                      <input type="hidden" value="{{$fetchDetail->page_data_id}}" name="page_data_id">
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Title(English)')}}<span class="required">*</span></label>
                        <div class="col-md-12 col-sm-12 ">
                           <input type="text" class="form-control" required="" value="{{ $fetchDetail->page_title }}" name="page_title">
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Title(Arabic)')}}<span class="required">*</span></label>
                        <div class="col-md-12 col-sm-12 ">
                           <input type="text" class="form-control" required="" value="{{ $fetchDetail->ar_page_title }}" name="arabic_page_title">
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content Line 1(English)')}}</label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control" name="page_content" rows="5" cols="30"> {{$fetchDetail->page_content}} </textarea>
                        </div>
                     </div>
                     <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content Line 1(Arabic)')}}</label>
                        <div class="col-md-12 col-sm-12 ">
                           <textarea class="form-control" dir="rtl" name="arabic_page_content" rows="5" cols="30"> {{$fetchDetail->ar_page_content}} </textarea>
                        </div>
                     </div>
                     <!--<div class="item form-group">-->
                     <!--   <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content Line 2(English)')}}<span class="required">*</span></label>-->
                     <!--   <div class="col-md-12 col-sm-12 ">-->
                     <!--      <textarea class="form-control" dir="rtl" required="" name="page_content_2" rows="5" cols="30"> {{$fetchDetail->page_content_2}} </textarea> -->
                     <!--   </div>-->
                     <!--</div>-->
                     <!--<div class="item form-group">-->
                     <!--   <label class="col-form-label col-md-3 col-sm-3 label-align">{{ __('Content Line 2(Arabic)')}}<span class="required">*</span></label>-->
                     <!--   <div class="col-md-12 col-sm-12">-->
                     <!--      <textarea class="form-control" required="" name="arabic_page_content_2" rows="5" cols="30"> {{$fetchDetail->ar_page_content_2}} </textarea> -->
                     <!--   </div>-->
                     <!--</div>-->
                     
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
</div>
<script src="http://localhost:8000/assets/admin/vendors/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
   CKEDITOR.replace( 'page_content_2' );
   CKEDITOR.replace( 'arabic_page_content_2',
   {
      contentsLangDirection: 'rtl',
   } );
   CKEDITOR.replace( 'page_content' );
   CKEDITOR.replace( 'arabic_page_content',{
      contentsLangDirection: 'rtl',
   } );
 </script>
@endsection