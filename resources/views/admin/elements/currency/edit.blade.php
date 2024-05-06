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
      <div class="alert alert-success" id="err_msg">
        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
      </div>
      @endif
      <form action="{{route('currency.update')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="currency_id" value="{{$curId}}">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Currency Code') }}</label>
                <input type="text" id="currency_code" value="{{$resUpdate->currency_code}}" name="currency_code" required="required" class="form-control ">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Currency Name') }}</label>
                <input type="text" id="currency_name" value="{{$resUpdate->currency_name}}" name="currency_name" required="required" class="form-control">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Conversion Rate') }}</label>
                <input type="number" id="currency_conversion_rate" value="{{$resUpdate->currency_conversion_rate}}" name="currency_conversion_rate" step="0.01" class="form-control">
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <center>
                <button type="submit" class="btn btn-raised btn-primary">
                <i class="fa fa-check-square-o"></i> Update</button>
                <button type="reset" class="btn btn-raised btn-success">
                Reset</button>
                <a class="btn btn-danger" href="{{route('admin.currency')}}">Cancel</a>
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
@endsection