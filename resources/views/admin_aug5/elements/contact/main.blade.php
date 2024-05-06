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
      <form action="{{route('admin.contact-us.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
         @php
              $userId = Auth::user()->id;
              @endphp
         <input type="hidden" value="{{$fetchDetail->contact_id}}" name="contact_id">
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Main Heading')}} </label>
<input type="text" class="form-control" name="contact_page_heading" required="" value="{{$fetchDetail->contact_page_heading}}">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Meta Description')}} </label>
                  <input  type="text" class="form-control" name="contact_page_meta_description" required="" value="{{$fetchDetail->contact_page_meta_description}}" >
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Contact Number 1')}} </label>
                  <input type="text" class="form-control" name="contact_phone_number_1" required="" value="{{$fetchDetail->contact_phone_number_1}}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Contact Number 2')}} </label>
                  <input  type="text" class="form-control" name="contact_phone_number_2" required="" value="{{$fetchDetail->contact_phone_number_2}}">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Email 1')}} </label>
                  <input type="text" class="form-control" name="contact_mail_1" required="" value="{{$fetchDetail->contact_mail_1}}">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Email 2')}} </label>
                  <input  type="text" class="form-control" name="contact_mail_2" required="" value="{{$fetchDetail->contact_mail_2}}">
              </div>
            </div>

               <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">{{ __('Address')}} </label>
                  <textarea  rows="4" cols="4" class="form-control" name="contact_address" required="">{{ $fetchDetail->contact_address }}</textarea>
              </div>
            </div>

             <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Location Map')}} </label>
                  <input  type="url" class="form-control" name="contact_address_map_embed_url" required="" value="{{$fetchDetail->contact_address_map_embed_url}}"><br>

                  <iframe src="{{ $fetchDetail->contact_address_map_embed_url }}" width="100%" height="50%" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
              </div>
            </div>

              <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Banner Image')}} (Supported formats: .png,.jpg,.jpeg)</label>
                  <input type="file" class="form-control" name="contact_banner_image" value="{{$fetchDetail->contact_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/banner/'.$fetchDetail->contact_banner_image)}}" style="width: 100%;">    
              </div>
            </div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update"> 
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