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
                <form action="{{ route('admin.faq.save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                   
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Faq Question(English)') }}</label>
                                    <input type="text" id="faq_question" name="faq_question" required="required" placeholder="Faq Question"
                                        class="form-control" value="{{ old('faq_answer') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label class="form-label">{{ __('Faq Question  (Arabic) ')}}</label>
                                      
                                      <input type="text" id="ar_faq_question" name="arabic_faq_question" required="required" class="form-control" dir="rtl" lang="ar" value="{{old('arabic_faq_question')}}">
                                   </div>
                             </div>
                         
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Faq Answer(English)') }}</label>
                                    <input type="text" id="faq_answer" name="faq_answer" required="required" placeholder="Faq Answer"
                                        class="form-control" value="{{ old('faq_answer') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label class="form-label">{{ __('Faq Answer(Arabic)') }}</label>
                                    <input type="text" id="faq_question" name="arabic_faq_answer" required="required" placeholder="Faq Question"
                                        class="form-control" value="{{ old('arabic_faq_answer') }}" dir="rtl">
                                </div>
                            </div>
                         
                           
                           
                            

                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                        <button type="submit" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Add</button>
                                        <button type="reset" class="btn btn-raised btn-success">
                                            Reset</button>
                                        <a class="btn btn-danger" href="{{ route('admin.faq') }}">Cancel</a>
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
