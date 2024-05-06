@extends('admin.layouts.app')
@section('content')

    @php
    header('Content-Type: text/html; charset=utf-8');
    @endphp
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote.min.css"/>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
                                <li>{{ $error }}<button type="button" class="close" data-dismiss="alert"
                                        aria-hidden="true">×</button></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('status'))
                    <div class="alert alert-success" id="err_msg">
                        <p>{{ session('status') }}<button type="button" class="close" data-dismiss="alert"
                                aria-hidden="true">×</button></p>
                    </div>
                @endif
                <form action="{{ route('admin.services.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                  
                    <div class="card-body">
                        <div class="row">
                          <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Title</label>
                                    <input type="text" name="service_title" required="required"
                                        class="form-control" value="{{ old('service_title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Title (Arabic)</label>
                                    <input type="text" name="ar_service_title" required="required" dir="rtl" lang="ar"
                                        class="form-control" value="{{ old('ar_service_title') }}">
                                </div>
                            </div>
                           
                             
                            <div class="col-md-6  ">
                                <label class="form-label" for="content-title">Service Description <span class="required"></span></label>
                                
                                <textarea rows="8" cols="4" class="form-control" required="required"  name="service_description" required="" value="{{ old('service_description') }}"></textarea> 
                              </div>

                            <div class="col-md-6 ">
                                <label class="form-label" for="content-title">Service Description (Arabic)<span class="required"></span></label>
                                
                                <textarea rows="8" cols="4" class="form-control" required="required" dir="rtl" lang="ar" name="ar_service_description" required="" value="{{ old('ar_service_description') }}"></textarea> 
                              </div>
                            

                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Image 1 (Supported Formats: .png,.jpg,.jpeg)</label>
                                    <input type="file" name="service_image_1"value="{{ old('service_image_1') }}"class="form-control" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Image 2 (Supported Formats: .png,.jpg,.jpeg)</label>
                                    <input type="file" name="service_image_2"value="{{ old('service_image_2') }}"class="form-control" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Service Icon(Supported Formats: .png,.jpg,.jpeg)</label>
                                    <input type="file" name="service_icon"value="{{ old('service_icon') }}"class="form-control" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Title  </label>
                                    <input type="text" name="service_content_title" 
                                        class="form-control" value="{{ old('service_content_title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Title (Arabic) </label>
                                    <input type="text" name="ar_service_content_title"  dir="rtl" lang="ar"
                                        class="form-control" value="{{ old('ar_service_content_title') }}">
                                </div>
                            </div>
                         
                             <div class="col-md-6  ">
                                <label class="form-label" for="content-title">Service Content Description <span class="required"></span></label>
                                
                                <textarea rows="8" cols="4" class="form-control"   name="service_content_description" required="" value="{{ old('service_content_description') }}"></textarea> 
                              </div>

                            <div class="col-md-6 ">
                                <label class="form-label" for="content-title">Service Content Description (Arabic)<span class="required"></span></label>
                                
                                <textarea rows="8" cols="4" class="form-control"  dir="rtl" lang="ar" name="ar_service_content_description" required="" value="{{ old('ar_service_content_description') }}"></textarea> 
                              </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                        <button type="submit" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Add</button>
                                        <button type="reset" class="btn btn-raised btn-success">
                                            Reset</button>
                                        <a class="btn btn-danger" href="{{ route('admin.services') }}">Cancel</a>
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

<script src="http://localhost:8000/assets/admin/vendors/jquery/dist/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
  
    CKEDITOR.replace( 'service_description' );
    CKEDITOR.replace( 'ar_service_description',
    {
       contentsLangDirection: 'rtl',
    } );
    CKEDITOR.replace( 'service_content_description' );
    CKEDITOR.replace( 'ar_service_content_description',
    {
       contentsLangDirection: 'rtl',
    } );
    </script>
    @endsection