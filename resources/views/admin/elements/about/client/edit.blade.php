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
       <form action="{{ route('admin.about-us.client.update') }}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="client_id" value="{{$fetchDetail->client_id}}">
        <div class="card-body">
          <div class="row">
             <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Name(English)') }}</label>
                    <input type="text" name="client_name" required="required" value="{{$fetchDetail->client_name}}" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Name(Arabic)') }}</label>
                        <input type="text" class="form-control" dir="rtl" name="arabic_client_name" value="{{$fetchDetail->ar_client_name}}" placeholder="Enter client_name">
                     </div>
                  </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Logo (Supported Formats: .png,.jpg,.jpeg)</label>
                    <input type="file" name="client_logo" value="{{$fetchDetail->client_logo}}" class="form-control" accept=".png,.jpg,.jpeg">
                    <br>
                    <img src="{{url('/assets/uploads/client/'.$fetchDetail->client_logo)}}" width="50">
                  </div>
                </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                  <a class="btn btn-danger" href="{{ route('admin.about-us.clients') }}">Cancel</a>
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