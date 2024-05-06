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
         <form action="{{route('admin.about-us.clients.save')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Name(English)') }}</label>
                        <input type="text" class="form-control" name="client_name" value="{{old('client_name')}}" placeholder="Enter client_name">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Name(Arabic)') }}</label>
                        <input type="text" class="form-control"  name="arabic_client_name" value="{{old('arabic_client_name')}}" dir="rtl" placeholder="Enter client_name">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Logo') }} (Supported Formats: .png,.jpg,.jpeg)</label>
                        <input type="file" class="form-control" name="client_logo" value="{{old('client_logo')}}" accept=".png,.jpg,.jpeg">
                     </div>
                  </div>
                  
                  
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="submit" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.about-us.clients') }}">Cancel</a>
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