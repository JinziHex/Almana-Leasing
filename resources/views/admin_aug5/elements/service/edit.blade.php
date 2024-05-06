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
       <form  action="{{route('admin.services.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
        <input type="hidden" name="service_id" value="{{$fetchDetail->service_id}}"> 
        <div class="card-body">
          <div class="row">
             <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Service Title</label>
                     <input type="text" name="service_title" required="required" value="{{$fetchDetail->service_title}}" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Service Title (Arabic)</label>
                     <input type="text" name="ar_service_title" required="required"  value="{{$fetchDetail->ar_service_title}}" dir="rtl" lang="ar" class="form-control">
                  </div>
                </div>
    
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Description</label>
                      <textarea rows="3" cols="3" class="form-control" name="service_description" required="">{{$fetchDetail->service_description}}</textarea> 
                     
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Description (Arabic)</label>
                      <textarea rows="3" cols="3" class="form-control" name="ar_service_description" dir="rtl" lang="ar" required="">{{$fetchDetail->ar_service_description}}</textarea> 
                     
                    </div>
                  </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Service Image 1 (Supported Formats: .png,.jpg,.jpeg)</label>
                    <input type="file" name="service_image_1" value="{{$fetchDetail->service_image_1}}" class="form-control" accept=".png,.jpg,.jpeg">
                           <br>
                           <img src="{{url('assets/uploads/service/'.$fetchDetail->service_image_1)}}" width="60">
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Image 2 (Supported Formats: .png,.jpg,.jpeg)</label>
                      <input type="file" name="service_image_2" value="{{$fetchDetail->service_image_2}}" class="form-control" accept=".png,.jpg,.jpeg">
                             <br>
                             <img src="{{url('assets/uploads/service/'.$fetchDetail->service_image_2)}}" width="60">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Icon (Supported Formats: .png,.jpg,.jpeg)</label>
                      <input type="file" name="service_icon" value="{{$fetchDetail->service_icon}}" class="form-control" accept=".png,.jpg,.jpeg">
                             <br>
                             <img src="{{url('assets/uploads/service/icons/'.$fetchDetail->service_icon)}}" width="60">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Content Title</label>
                       <input type="text" name="service_content_title" required="required" value="{{$fetchDetail->service_content_title}}" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Service Content Title (Arabic)</label>
                       <input type="text" name="ar_service_content_title" required="required" dir="rtl" lang="ar" value="{{$fetchDetail->ar_service_content_title}}" class="form-control">
                    </div>
                  </div>
      
                  <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Service Content Description</label>
                        <textarea rows="3" cols="3" class="form-control" name="service_content_description" required="">{{$fetchDetail->service_content_description}}</textarea> 
                       
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label class="form-label">Service Content Description (Arabic)</label>
                        <textarea rows="3" cols="3" class="form-control" name="ar_service_content_description" dir="rtl" lang="ar" required="">{{$fetchDetail->ar_service_content_description}}</textarea> 
                       
                      </div>
                    </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                 
                  <a class="btn btn-danger" href="{{route('admin.services')}}">Cancel</a>
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