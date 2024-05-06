@extends('admin.layouts.app')
@section('content')
    @php
    header('Content-Type: text/html; charset=utf-8');
    @endphp
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Description</label>
                                    <input type="text" name="service_description" required="required"
                                        class="form-control" value="{{ old('service_description') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Description (Arabic)</label>
                                    <input type="text" name="ar_service_description" required="required" dir="rtl" lang="ar"
                                        class="form-control" value="{{ old('ar_service_description') }}">
                                </div>
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Icon(Supported Formats: .png,.jpg,.jpeg)</label>
                                    <input type="file" name="service_icon"value="{{ old('service_icon') }}"class="form-control" accept=".png,.jpg,.jpeg">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Title  </label>
                                    <input type="text" name="service_content_title" required="required" 
                                        class="form-control" value="{{ old('service_content_title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Title (Arabic) </label>
                                    <input type="text" name="ar_service_content_title" required="required" dir="rtl" lang="ar"
                                        class="form-control" value="{{ old('ar_service_content_title') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Description</label>
                                    <input type="text" name="service_content_description" required="required"
                                        class="form-control" value="{{ old('service_content_description') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Service Content Description (Arabic)</label>
                                    <input type="text" name="ar_service_content_description" required="required" dir="rtl" lang="ar"
                                        class="form-control" value="{{ old('ar_service_content_description') }}">
                                </div>
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
@endsection
