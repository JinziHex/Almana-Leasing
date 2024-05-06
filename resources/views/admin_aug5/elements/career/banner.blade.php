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
         <form action="{{route('admin.page-data.update')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @php
            $userId = Auth::user()->id;
            @endphp
            <input type="hidden" value="{{$fetchDetail->page_data_id}}" name="page_data_id">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Banner Title') }}</label>
                        <input type="hidden" name="page_title" value="career">
                        <input type="text" class="form-control" name="page_banner_title" required="" value="{{$fetchDetail->page_banner_title}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Banner Description') }}</label>
                        <input  type="text" class="form-control" name="page_banner_description" value="{{$fetchDetail->page_banner_description}}" >
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Banner Image') }} (Supported formats: .png,.jpg,.jpeg)</label>
                        <input type="file" class="form-control" name="page_banner_image" value="{{$fetchDetail->page_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                        <img src="{{url('/assets/uploads/banner/'.$fetchDetail->page_banner_image)}}" style="width: 100%;">
                     </div>
                  </div>
                  
                  
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="submit" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Update</button>
                        
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