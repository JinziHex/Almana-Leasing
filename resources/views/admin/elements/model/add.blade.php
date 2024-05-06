@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Mode_rate;
use App\Models\Model_specification;
use App\Models\Specification;
@endphp
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
            <form action="{{ route('admin.model.save') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Model Name') }}</label>
                                <input type="text" id="modal_name" name="modal_name" required="required"
                                class="form-control" value="{{ old('modal_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">{{ __('Model Name (Arabic)') }}</label>
                                <input type="text" id="ar_modal_name" name="ar_modal_name" required="required"  dir="rtl" lang="ar" 
                                class="form-control" value="{{ old('ar_modal_name') }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('Model Category') }}</label>
                            <select required="required" class="form-control" name="modal_category"> 
                                <option value="">--Select a model category--</option>
                                @foreach ($listCategory as $listCategorys)
                                <option {{ old('model_cat_id') == $listCategorys->model_cat_id ? 'selected' : '' }}
                                value="{{ $listCategorys->model_cat_id }}">{{ $listCategorys->model_cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                             <label class="form-label">{{ __('Maker') }}</label>
                            <select required="required" class="form-control" name="makers">
                                <option value="">--Select maker--</option>
                                @foreach ($listMaker as $listMakers)
                                <option {{ old('maker_id') == $listMakers->maker_id ? 'selected' : '' }}
                                value="{{ $listMakers->maker_id }}">{{ $listMakers->maker_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                             <label class="form-label">{{ __('Group') }}</label>
                            <select required="required" class="form-control" name="group_id">
                                <option value="">--Select a group--</option>
                                @foreach ($listGroup as $listGroups)
                                <option {{ old('group_id') == $listGroups->group_id ? 'selected' : '' }}
                                value="{{ $listGroups->group_id }}">{{ $listGroups->group_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">{{ __('Images (Press and hold cntr+ to add multiple images)') }}</label>
                            <input type="file" multiple="multiple" name="image[]" class="form-control" required="" accept="image/x-png, image/gif, image/jpeg" />
                        </div>
                        <div class="col-md-12 form-check ">
                            <label class="form-label ">{{ __('Specifications') }}</label>
                          
                            {{-- <select class="multi-select" name="specifications[]" required="" multiple="multiple">
                                
                                @foreach($showSPec as $showSpecs)
                                <option value="{{$showSpecs->spec_id}}">{{$showSpecs->spec_name}}</option>
                                @endforeach
                            </select> --}}
                             <div class="pl-5 form-check ">
                            @foreach($showSPec as $showSpecs)
                            <input  class="form-check-input " type="checkbox" name="specifications[]" value="{{$showSpecs->spec_id}}" multiple="multiple"  >
                            <label class="form-check-label "  >{{$showSpecs->spec_name}}</label><br><br>
                            @endforeach
                             </div>
                        </div>
                       

                        <div class="col-md-12">
                            <div class="form-group">
                                <center>
                                <button type="submit" class="btn btn-raised btn-primary">
                                <i class="fa fa-check-square-o"></i> Add</button>
                                <button type="reset" class="btn btn-raised btn-success">
                                Reset</button>
                                <a class="btn btn-danger" href="{{ route('admin.models') }}">Cancel</a>
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