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
         <form name="coupForm" action="{{route('admin.customize.language.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('English')}}</label>
                         <input list="englishs"  id="english" name="english"  class="form-control"  required>
                         <datalist id="englishs">
                         @foreach($fars as $en=>$ar)
                              <option value="{{$en}}">
                         @endforeach
                         </datalist>

                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Arabic')}}</label>
                         <input dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " type="text"  id="arabic" name="arabic" onfocus=" let value = this.value; this.value = null; this.value=value"  class="form-control" required>
                     </div>
                  </div>
                 
                
                  <div class="col-md-6">
                </div>
                  
                 
    
                 
                 
                 
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button id="btnUp" type="button" onclick="submitForm()" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Save</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.customize.language.index') }}">Cancel</a>
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
 document.getElementById("yourId").focus()
function submitForm()
{
   
document.coupForm.submit();
}
      
</script>
@endsection