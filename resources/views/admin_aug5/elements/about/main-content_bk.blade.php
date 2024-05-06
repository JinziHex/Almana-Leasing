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
       <form  action="{{route('admin.about-us.main-content.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
         <input type="hidden" value="{{$fetchDetail->about_content_id}}" name="about_content_id">
        <div class="card-body">
          <div class="row">
             <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Main Heading')}}</label>
                       <input type="text" class="form-control" name="about_us_pagetitle" required="" value="{{$fetchDetail->about_us_pagetitle}}">
                  </div>
                </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Meta Description</label>
                      <input  type="text" class="form-control" name="about_page_meta_description" required="" value="{{$fetchDetail->about_page_meta_description}}" >
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Title</label>
                      <input  type="text" class="form-control" name="about_content_main_title" required="" value="{{$fetchDetail->about_content_main_title}}">
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Description</label>
                      <textarea rows="3" cols="3" class="form-control" name="about_content_description" required="">{{$fetchDetail->about_content_description}}</textarea>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">Banner Image (Supported Formats: .png,.jpg,.jpeg)</label>
                    <input type="file" class="form-control" name="about_page_banner_image" value="{{$fetchDetail->about_page_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/banner/'.$fetchDetail->about_page_banner_image)}}" style="width: 100%;">
                  </div>
                </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                  <input type="submit" class="btn btn-success" value="Update">
                  <button class="btn btn-primary" type="reset">{{ __('Reset')}}</button>
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