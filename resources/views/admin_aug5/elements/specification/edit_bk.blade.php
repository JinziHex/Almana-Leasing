@extends('admin.layouts.app')
@section('content')
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
      <form action="{{route('specification.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="specification_id" value="{{$specId}}">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Specification Name')}} </label>
                <input type="text" id="spec_name" value="{{$resUpdate->spec_name}}" name="spec_name" required="required" class="form-control ">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Specification Icon')}} </label>
                <input type="file" id="spec_icon" value="{{$resUpdate->spec_icon}}" name="spec_icon" class="form-control ">
                @if($resUpdate->spec_icon!="")
                <img src="{{url('/assets/uploads/specifications/icons/'.$resUpdate->spec_icon)}}" width="50" height="50">
              @endif              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                  <input type="submit" class="btn btn-success" value="Update">
                
                  <a class="btn btn-danger" href="{{ route('admin.specification') }}">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ROW-1 CLOSED -->
@endsection