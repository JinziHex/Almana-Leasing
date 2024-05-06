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
      
      
      <div class="card-body">
        <div class="table-responsive">
          <h3>Images</h3>
          <table class="table table-striped table-bordered text-nowrap w-100" style="width:100%">
            <thead>
              <tr>
                <th>{{ __('Sl No.') }}</th>
                <th>{{ __('Image') }}</th>
                <th>{{ __('Mode') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i=0;
              @endphp
              @foreach($viewImage as $viewImages)
              @php $i++; @endphp
              <tr>
                <td>{{$i}}</td>
                <td><img src="{{url('/assets/uploads/models/'.$viewImages->model_image)}}" width="100" height="60"></td>
                <td>
                  @if($viewImages->model_image_flag==0)
                  <button class="btn btn-sm btn-info" style="cursor: pointer;">{{ __('Default Image') }}</button>
                  @else
                  <a href="{{url('model/image/remove/thumb/'.Crypt::encryptString($viewImages->model_image_id))}}" class="btn btn-sm btn-success" onclick="return confirm('Do you want to make this image as default');">{{ __('Thumb') }}</a>
                  @endif
                </td>
                <td><a href="{{url('model/image/delete/'.Crypt::encryptString($viewImages->model_image_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this image?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <h3>Specifications</h3>
          <table class="table table-striped table-bordered text-nowrap w-100" style="width:100%">
            <thead>
              <tr>
                <th>{{ __('Sl No.') }}</th>
                <th>{{ __('Specifications') }}</th>
                <th>{{ __('Action') }}</th>
              </tr>
            </thead>
            <tbody>
              @php
              $i=0;
              @endphp
              @foreach($viewSpec as $viewSpecs)
              @php $i++; @endphp
              <tr>
                <td>{{$i}}</td>
                <td>{{ucFirst($viewSpecs->specs['spec_name'])}}</td>
                
                <td><a href="{{url('model/spec/delete/'.Crypt::encryptString($viewSpecs->model_spec_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this specification?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="ln_solid"></div>
          <div class="item form-group">
            <div class="col-md-6 col-sm-6">
              <a class="btn btn-secondary" href="{{route('admin.models')}}" >{{ __('Back') }}</a>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>
<!-- ROW-1 CLOSED -->
@endsection