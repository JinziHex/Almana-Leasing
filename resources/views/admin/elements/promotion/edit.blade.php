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
                <form action="{{ route('promotion.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="promotion_id" value="{{$curId}}">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">{{ __('Model Name') }}</label>
                                <select required="required" class="form-control" name="modal_id">
                                    @foreach($modal as $modals)
                                <option value="{{$modals->modal_id}}"  {{ $modals->modal_id == $promotion->modal_id ? 'selected' : '' }}>{{$modals->modal_name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __(' Discount(%)') }}</label>
                                    <input type="text" id="price" name="price" required="required"
                                        class="form-control" value="{{ $promotion->price }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Start Date') }}</label>
                                   
                                    <input type="date" id="start_date" name="start_date" required="required"
                                        class="form-control"  lang="ar" value="{{ $promotion->start_date }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('End Date') }}</label>
                                    <input type="date" id="end_date" name="end_date" required="required"
                                        class="form-control"  lang="ar" value="{{ $promotion->end_date }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <center>
                                        <button type="submit" class="btn btn-raised btn-primary">
                                            <i class="fa fa-check-square-o"></i> Update</button>
                                       
                                        <a class="btn btn-danger" href="{{ route('admin.promotions') }}">Cancel</a>
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
