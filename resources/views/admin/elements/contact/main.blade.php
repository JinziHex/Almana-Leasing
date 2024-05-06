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
                <label class="form-label">General enquiries-Landline </label>
                  <input type="text" class="form-control" name="contact_phone_number_1" required="" value="{{$fetchDetail->contact_phone_number_1}}">
              </div>
            </div>
            

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">General enquiries-Email </label>
                  <input type="emailt" class="form-control" name="contact_mail_1" required="" value="{{$fetchDetail->contact_mail_1}}">
              </div>
            </div>

             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sales enquiries-Landline </label>
                  <input  type="text" class="form-control" name="se_land" required="" value="{{$fetchDetail->sales_enquiry_landline }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sales enquiries-Mobile </label>
                  <input  type="text" class="form-control" name="se_mob" required="" value="{{$fetchDetail->sales_enquiry_mobile }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sales enquiries-Email1 </label>
                  <input  type="text" class="form-control" name="se_email1" required="" value="{{$fetchDetail->sales_enquiry_email1}}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Sales enquiries-Email2 </label>
                  <input  type="text" class="form-control" name="se_email2" required="" value="{{$fetchDetail->sales_enquiry_email2}}">
              </div>
            </div>
              <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Chauffer service enquiries-Landline </label>
                  <input  type="text" class="form-control" name="ch_land" required="" value="{{$fetchDetail->ch_service_enq_landline  }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Chauffer service enquiries-Mobile </label>
                  <input  type="text" class="form-control" name="ch_mob" required="" value="{{$fetchDetail->ch_service_enq_mobile }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Chauffer service enquiries-Email </label>
                  <input  type="text" class="form-control" name="ch_email" required="" value="{{$fetchDetail->ch_service_enq_email}}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Service/Maintenance enquiries-Landline </label>
                  <input  type="text" class="form-control" name="sm_land" required="" value="{{$fetchDetail->sm_landline   }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Service/Maintenance enquiries-Mobile </label>
                  <input  type="text" class="form-control" name="sm_mob" required="" value="{{$fetchDetail->sm_mobile }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Service/Maintenance enquiries-Email </label>
                  <input  type="text" class="form-control" name="sm_email" required="" value="{{$fetchDetail->sm_email}}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Airport branch enquiries-Landline </label>
                  <input  type="text" class="form-control" name="ab_land" required="" value="{{$fetchDetail->ab_landline }}">
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Airport branch enquiries-Mobile </label>
                  <input  type="text" class="form-control" name="ab_mob" required="" value="{{$fetchDetail->ab_mobile}}">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label class="form-label">Facebook link </label>
                  <input  type="text" class="form-control" name="fb_link" required="" value="{{$fetchDetail->fb_link}}">
              </div>
            </div>
            <!-- <div class="col-md-6">-->
            <!--  <div class="form-group">-->
            <!--    <label class="form-label">Instagram link </label>-->
            <!--      <input  type="text" class="form-control" name="ig_link" value="{{$fetchDetail->ig_link}}">-->
            <!--  </div>-->
            <!--</div>-->
            <!-- <div class="col-md-6">-->
            <!--  <div class="form-group">-->
            <!--    <label class="form-label">Twitter link </label>-->
            <!--      <input  type="text" class="form-control" name="tw_link" value="{{$fetchDetail->tw_link}}">-->
            <!--  </div>-->
            <!--</div>-->
            <!--<div class="col-md-6">-->
            <!--  <div class="form-group">-->
            <!--    <label class="form-label">Linkedin link </label>-->
            <!--      <input  type="text" class="form-control" name="link_link" value="{{$fetchDetail->link_link}}">-->
            <!--  </div>-->
            <!--</div>-->
            <!-- <div class="col-md-6">-->
            <!--  <div class="form-group">-->
            <!--    <label class="form-label">Youtube link </label>-->
            <!--      <input  type="text" class="form-control" name="you_link" value="{{$fetchDetail->you_link}}">-->
            <!--  </div>-->
            <!--</div>-->

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
                <div class="col-md-6 col-sm-6 offset-md-3">
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