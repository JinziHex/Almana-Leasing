@extends('admin.layouts.app')
@section('content')
<div class="right_col" role="main">
  <div class="">
    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
          <div class="x_title">
            <h2>{{$pageTitle}}</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{route('admin.page-data.update')}}" enctype="multipart/form-data">
              @csrf
              @if(session('status'))
              <div class="alert alert-success" id="err_msg">
                <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
              </div>
              @endif
              @if (count($errors) > 0)
              <div class="alert alert-danger" id="err_msg">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif
              @php
              $userId = Auth::user()->id;
              @endphp
              <input type="hidden" value="{{$fetchDetail->page_data_id}}" name="page_data_id">
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Banner Title')}}<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_banner_title" required="" value="{{$fetchDetail->page_banner_title}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Banner Description')}}<span class="required">*</span></label>
                  
                  <input  type="text" class="form-control" name="page_banner_description" value="{{$fetchDetail->page_banner_description}}" >
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Banner Image')}}<span class="required">*</span>(Supported formats: .png,.jpg,.jpeg)</label>
                  <input type="file" class="form-control" name="page_banner_image" value="{{$fetchDetail->page_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/banner/'.$fetchDetail->page_banner_image)}}" style="width: 100%;">
                </div>
              </div>
              <div class="x_title">
                <h2>{{ __('Content') }}</h2>
                <div class="clearfix"></div>
              </div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Title')}}<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title" required="" value="{{$fetchDetail->page_title}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Content')}}<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content" required="">{{$fetchDetail->page_content}}</textarea> 
                </div>
              </div>
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label class="col-form-label label-align" for="content-title">{{ __('Image')}}<span class="required">*</span>(Supported formats: .png,.jpg,.jpeg)</label>
                  <input type="file" class="form-control" name="page_content_image" value="{{$fetchDetail->page_content_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/page-data/'.$fetchDetail->page_content_image)}}" width="100">
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                  <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
                  
                </div>
              </div>
            </form>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<script src="http://localhost:8000/assets/admin/vendors/jquery/dist/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
//password match
$('#password-confirm').on('keyup', function () {
if ($('#password').val() == $('#password-confirm').val()) {
$('#message').html('Password Matching').css('color', 'green');
} else
$('#message').html('Password does not match').css('color', 'red');
});
//password match ends
//check minlength of password
var minLength = 8;
$("#password").on("keydown keyup change", function(){
var value = $(this).val();
if (value.length < minLength)
$("#rule").html("Password length must be atleast 8").css('color', 'red');
else
$("#rule").html("Password accepted").css('color', 'green');
});
//minlength check ends
});
</script>
@endsection