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
             <div class="col-md-12">
                  <div class="form-group">
                    <label class="form-label">{{ __('Main Heading')}}</label>
                       <input type="text" class="form-control" name="about_us_pagetitle" readonly required="" value="{{$fetchDetail->about_us_pagetitle}}">
                  </div>
                </div>
                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Meta Description-English</label>
                      <input  type="text" class="form-control" name="about_page_meta_description" required="" value="{{@$fetchDetail->about_page_meta_description}}" >
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Meta Description-Arabic</label>
                      <input  type="text" dir="rtl" class="form-control" name="arabic_about_page_meta_description" required="" value="{{@$fetchDetail->ar_about_page_meta_description}}" >
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Mission Title-English</label>
                      <input  type="text" class="form-control" name="about_content_main_title" required="" value="{{@$fetchDetail->about_content_main_title}}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Mission Title-Arabic</label>
                      <input  type="text" dir="rtl" class="form-control" name="arabic_about_content_main_title" required="" value="{{@$fetchDetail->ar_about_content_main_title}}">
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Mission Description-English</label>
                      <textarea rows="3" cols="3" class="form-control" name="about_content_description" required="">{{@$fetchDetail->about_content_description}}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">Mission Description-Arabic</label>
                      <textarea rows="3" cols="3" dir="rtl" class="form-control" name="arabic_about_content_description" required="">{{@$fetchDetail->ar_about_content_description}}</textarea>
                  </div>
                </div>
                  {{--Title 2--}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Mission Title 2-English </label>
                        <input  type="text" class="form-control" name="about_content_main_title2" required="" value="{{@$fetchDetail->about_content_main_title2}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Mission Title 2-Arabic </label>
                        <input  type="text" dir="rtl" class="form-control" name="arabic_about_content_main_title2" required="" value="{{@$fetchDetail->arabic_about_content_main_title2}}">
                    </div>
                  </div>
  
                   <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Mission Description 2-English 2</label>
                        <textarea rows="3" cols="3" class="form-control" name="about_content_description2" required="">{{@$fetchDetail->about_content_description2}}</textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Mission Description 2-Arabic 2</label>
                        <textarea rows="3" cols="3" dir="rtl" class="form-control" name="arabic_about_content_description2" required="">{{@$fetchDetail->arabic_about_content_description2}}</textarea>
                    </div>
                  </div>


                      {{--End Title 2--}}
                        {{--Title 3--}}
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Vision Title-English</label>
                        <input  type="text" class="form-control" name="about_content_main_title3" required="" value="{{@$fetchDetail->about_content_main_title3}}">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Vision Title-Arabic</label>
                        <input  type="text" dir="rtl" class="form-control" name="arabic_about_content_main_title3" required="" value="{{@$fetchDetail->arabic_about_content_main_title3}}">
                    </div>
                  </div>
  
                   <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Vision Description-English</label>
                        <textarea rows="3" cols="3" class="form-control" name="about_content_description3" required="">{{@$fetchDetail->about_content_description3}}</textarea>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label">Vision Description-Arabic</label>
                        <textarea rows="3" cols="3" dir="rtl" class="form-control" name="arabic_about_content_description3" required="">{{@$fetchDetail->arabic_about_content_description3}}</textarea>
                    </div>
                  </div>


                      {{--End Title 3--}}
                 <div class="col-md-12"> 
                  <div class="form-group">
                    <label class="form-label">Banner Image (Supported Formats: .png,.jpg,.jpeg)</label>
                    <input type="file" class="form-control" name="about_page_banner_image" value="{{$fetchDetail->about_page_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/banner/'.$fetchDetail->about_page_banner_image)}}" style="width: 100%;">
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