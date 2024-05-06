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
         <form name="cityForm" action="{{route('admin.city.save')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="174" name="country_id">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('City Name')}}</label>
                         <input type="text" id="city_name" name="city_name" required="required" class="form-control" value="{{old('city_name')}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('City Name (Arabic)')}}</label>
                         <input type="text" id="ar_city_name" name="ar_city_name" required="required" class="form-control" dir="rtl" lang="ar" value="{{old('ar_city_name')}}">
                     </div>
                  </div>
                 
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="button" onclick="submitForm()" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.city') }}">Cancel</a>
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
function submitForm()
{
   
document.cityForm.submit();
}

</script>
@endsection