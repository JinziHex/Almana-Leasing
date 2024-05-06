@extends('admin.layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"/>
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
              <input type="hidden" value="{{$fetchTerms->page_data_id}}" name="page_data_id">
            
              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label class="col-form-label label-align" for="content-title">Banner Image<span class="required">*</span>(Supported formats: .png,.jpg,.jpeg)</label>
                  <input type="file" class="form-control" name="page_banner_image" value="{{$fetchTerms->page_banner_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/banner/'.$fetchTerms->page_banner_image)}}" style="width: 50%;">
                </div>
              </div>
              <div class="x_title">
                <h2>{{ __('Content') }}</h2>
                <div class="clearfix"></div>
              </div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title" required="" value="{{$fetchTerms->page_title}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="arabic_page_title" dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " required="" value="{{$fetchTerms->ar_page_title}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control summernote" name="page_content" required="">{{$fetchTerms->page_content}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="arabic_page_content" required="">{{$fetchTerms->ar_page_content}}</textarea> 
                </div>
              </div>
              {{-- Title2 --}}
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)2<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title_2" required="" value="{{$fetchTerms->page_title_2}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)2<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="ar_page_title_2" dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " required="" value="{{$fetchTerms->ar_page_title_2}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)2<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content_2" required="">{{$fetchTerms->page_content_2}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)2<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="ar_page_content_2" required="">{{$fetchTerms->ar_page_content_2}}</textarea> 
                </div>
              </div>
                 {{--End  Title2 --}}

                  {{-- Title3 --}}
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)3<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title_3" required="" value="{{$fetchTerms->page_title_3}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)3<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="ar_page_title_3" required="" dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " value="{{$fetchTerms->ar_page_title_3}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)3<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content_3" required="">{{$fetchTerms->page_content_3}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)3<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="ar_page_content_3" required="">{{$fetchTerms->ar_page_content_3}}</textarea> 
                </div>
              </div>
                 {{--End  Title3 --}}
                      {{-- Title4 --}}
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)4<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title_4" required="" value="{{$fetchTerms->page_title_4}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)4<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="ar_page_title_4" required="" dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " value="{{$fetchTerms->ar_page_title_4}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)4<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content_4" required="">{{$fetchTerms->page_content_4}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)4<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="ar_page_content_4" required="">{{$fetchTerms->ar_page_content_4}}</textarea> 
                </div>
              </div>
                 {{--End  Title4 --}}
                {{-- Title5 --}}
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)5<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title_5" required="" value="{{$fetchTerms->page_title_5}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)5<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="ar_page_title_5" required="" dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; "value="{{$fetchTerms->ar_page_title_5}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)5<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content_5" required="">{{$fetchTerms->page_content_5}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)5<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="ar_page_content_5" required="">{{$fetchTerms->ar_page_content_5}}</textarea> 
                </div>
              </div>
                 {{--End  Title5 --}}
                      {{-- Title6 --}}
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(English)6<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="page_title_6" required="" value="{{$fetchTerms->page_title_6}}">
                </div>
                  
              
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Title(Arabic)6<span class="required">*</span></label>
                  
                  <input type="text" class="form-control" name="ar_page_title_6"dir="rtl" lang="ar" style=" unicode-bidi:bidi-override;direction: RTL; " required="" value="{{$fetchTerms->ar_page_title_6}}">
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(English)6<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="page_content_6" required="">{{$fetchTerms->page_content_6}}</textarea> 
                </div>
                <div class="col-md-6 col-sm-6 ">
                  <label class="col-form-label label-align" for="content-title">Content(Arabic)6<span class="required">*</span></label>
                  
                  <textarea rows="8" cols="4" class="form-control" name="ar_page_content_6" required="">{{$fetchTerms->ar_page_content_6}}</textarea> 
                </div>
              </div>
                 {{--End  Title6 --}}

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <label class="col-form-label label-align" for="content-title">Image<span class="required">*</span>(Supported formats: .png,.jpg,.jpeg)</label>
                  <input type="file" class="form-control" name="page_content_image" value="{{$fetchTerms->page_content_image}}" accept=".png,.jpg,.jpeg"><br>
                  <img src="{{url('/assets/uploads/page-data/'.$fetchTerms->page_content_image)}}" width="100">
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                  <button type="submit" class="btn btn-success">Update</button>
                  
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
  
  CKEDITOR.replace( 'page_content' );
  CKEDITOR.replace( 'arabic_page_content',
  {
     contentsLangDirection: 'rtl',
  } );
  
  CKEDITOR.replace( 'page_content_2' );
  CKEDITOR.replace( 'ar_page_content_2',
  {
     contentsLangDirection: 'rtl',
  } );
  
  CKEDITOR.replace( 'page_content_3' );
  CKEDITOR.replace( 'ar_page_content_3',
  {
     contentsLangDirection: 'rtl',
  } );
  
  CKEDITOR.replace( 'page_content_4' );
  CKEDITOR.replace( 'ar_page_content_4',
  {
     contentsLangDirection: 'rtl',
  } );
  
  CKEDITOR.replace( 'page_content_5' );
  CKEDITOR.replace( 'ar_page_content_5',
  {
     contentsLangDirection: 'rtl',
  } );
 
  CKEDITOR.replace( 'page_content_6' );
  CKEDITOR.replace( 'ar_page_content_6',
  {
     contentsLangDirection: 'rtl',
  } );
</script>
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