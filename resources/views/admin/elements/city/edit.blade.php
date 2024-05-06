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
      <div class="alert alert-danger" id="err_msg">
        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
      </div>
      @endif
      <form action="{{route('city.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="city_id" value="{{$curId}}">
        <input type="hidden" name="country_id" value="174">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('City Name')}} </label>
                <input type="text" id="city_name" value="{{@$resUpdate->city_name}}" name="city_name" required="required" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('City Name (Arabic)')}}</label>
                         <input type="text" id="ar_city_name" name="ar_city_name" required="required" class="form-control" dir="rtl" lang="ar" value="{{@$resUpdate->ar_city_name}}">
                     </div>
                  </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                
                  <a class="btn btn-danger" href="{{ route('admin.city') }}">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
<!-- ROW-1 CLOSED -->
@endsection