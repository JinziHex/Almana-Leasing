@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Mode_rate;
use App\Models\Model_specification;
use App\Models\Specification;
@endphp
<style>
    /*#bukingtable{
        width: 100%;
        border-collapse: collapse !important;
        background: #eee;
        border-radius: 5px;
        overflow: hidden;
    }
     #bukingtable th{
             border-top: none;
            border-bottom-color: #fff;
            background: rgba(0,0,0,.1);
            border-right: 1px solid #fff;
     }
     #bukingtable th:last-child{
         border-right:none;
         
     }
     .bookpaginate ul.pagination{
         justify-content: flex-end;
     }
     .bookpaginate .page-item:first-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-link{
         border: none;
        color: #5A738E!important;
     }
     .bookpaginate .page-item:last-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-item.active .page-link{
         background-color:transparent;
         border-color:transparent;
     }
     .bookpaginate .page-link:hover{color:#0056b3!important; background:transparent;}
     .bookpaginate .page-link:focus{box-shadow:none;}
     .bookpaginate .page-item:first-child .page-link::after{content:'Previous'; font-size: 13px;}
     .bookpaginate .page-item:last-child .page-link::after{content:'Next'; font-size: 13px;}
     li.page-item.active span {color: #007bff !important;}*/
</style>
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         
         <div class="card-body bookpaginate">
                        <!-- Filter -->
                        <form method="GET" action="{{route('admin.models')}}">
                           @csrf
                           <div class="row">
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('Models')}}</label>
                                    <select class="form-control" name="modal">
                                       <option value="">--Select model --</option>
                                      
                                       @foreach($modal as $modals)
                                       <option {{request()->input('modal') == $modals->modal_id ? 'selected':''}}  
                                          value="{{$modals->modal_id}}">{{$modals->modal_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('Category')}}</label>
                                    <select class="form-control" name="category">
                                       <option value="" >--Select category --</option>
                                       @foreach($modalCategory as $modalCategories)
                                       <option  {{request()->input('category') == $modalCategories->model_cat_id ? 'selected':''}}  
                                          value="{{$modalCategories->model_cat_id}}">{{$modalCategories->model_cat_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('Makers')}}</label>
                                    <select class="form-control" name="makers">
                                       <option value="" >--Select maker --</option>
                                       @foreach($maker as $makers)
                                       <option  {{request()->input('makers') == $makers->maker_id ? 'selected':''}} 
                                       value="{{$makers->maker_id }}">{{$makers->maker_name}}</option>
                                       @endforeach
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <label>{{ __('Status')}}</label>
                                    <select class="form-control" name="status">
                                       <option value="" >--Select status --</option>
                                     
                                       <option {{request()->input('status') == "1" ? 'selected':''}}  value="1">Active</option>
                                       <option {{request()->input('status') == "0" ? 'selected':''}} value="0"> Hidden </option>
                                      
                                    </select>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                       <input type="submit" class="btn btn-block btn-primary" value="Filter">
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-6">
                                 <div class="form-group">
                                    <div class="col-md-12 col-sm-12">
                                       <a href="{{route('admin.models')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                        <!--filter ends-->
            <a href="{{route('admin.model.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
            @if(session('status'))
            <div class="alert alert-success" id="err_msg">
               <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                        <th style="width:95px;" class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Category') }}</th>
                        <th  style="width:60px;" class="wd-15p">{{ __('Makers') }}</th>
                        <th class="wd-15p">{{ __('Rates') }}</th>
                        <th class="wd-15p">{{ __('Status') }}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($modDetail as $modDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td>{{ucfirst($modDetails->modal_name)}}</td>
                     <td>{{ucfirst($modDetails->category['model_cat_name'])}}</td>
                     <td>{{ucfirst($modDetails->maker['maker_name'])}}</td>
                     <td>
                        @php
                        $mRates = Mode_rate::where('model_id','=',$modDetails->modal_id)->where('maker_id','=',$modDetails->makers)->orderBy('rate_type_id','ASC')->get();
                        @endphp
                        @if(!$mRates->isEmpty())
                        @foreach($mRates as $mRatess)
                        {{$mRatess->rates->rate_type_code}}-{{$mRatess->model_year}}({{$mRatess->makers['maker_name']}}):{{$mRatess->model_min_rate}}<br>
                        @endforeach
                        @else
                        No Rates 
                        @endif
                     </td>
                     <td>
                        @if($modDetails->active_flag==1)
                        <a href="{{url('modal/hide/'.Crypt::encryptString($modDetails->modal_id))}}" class="btn btn-sm btn-info" onclick="return confirm('Do you want to hide this model?');">{{ __('Active') }}</a>
                        @else
                        <a href="{{url('modal/unhide/'.Crypt::encryptString($modDetails->modal_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to unhide this model?');">{{ __('Hidden') }}</a>
                        @endif
                     </td>
                     <td>
                        <button type="button" class="btn btn-warning btn-block btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg{{$modDetails->modal_id}}"><i class="fa fa-file-image-o"></i>{{ __('+ Image') }}</button><button type="button"  class="btn btn-dark btn-block btn-sm" data-toggle="modal" data-target=".bs-example-modal-lgsec{{$modDetails->modal_id}}"><i class="fa fa-pencil"></i>{{ __('+ Spec') }}</button><a href="{{url('modal/view/'.Crypt::encryptString($modDetails->modal_id))}}"  class="btn btn-sm btn-block btn-danger"><i class="fa fa-eye"></i>{{ __('View') }}</a><a href="{{url('modal/edit/'.Crypt::encryptString($modDetails->modal_id))}}"  class="btn btn-sm btn-block btn-info"><i class="fa fa-pencil-square-o"></i>{{ __('Edit') }}</a>
                     </td>
                  </tr>
                  
                  @endforeach
                  </tbody>
               </table>
                @foreach($modDetail as $modDetails)
            <div class="modal fade bs-example-modal-lg{{$modDetails->modal_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">{{ucfirst($modDetails->modal_name)}}</h4>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="{{route('image.save')}}">
                                 @csrf
                                 <input type="hidden" value="{{$modDetails->modal_id}}" name="modal_id">
                                 <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_image" style="font-size: 12px;">{{ __('Image (Press and hold Cntrl key to select multiple images)')}} <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                       <input type="file" multiple="multiple" name="image[]" class="form-control" required="" accept="image/x-png, image/gif, image/jpeg" />
                                    </div>
                                 </div>
                           </div>
                           <div class="modal-footer">
                           <button type="submit" class="btn btn-primary">{{ __('Upload') }}</button>
                           <button class="btn btn-secondary" type="reset">{{ __('Reset')}}</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  @endforeach
                  <!-- specifications -->
                  @foreach($modDetail as $modDetails)
                  <div class="modal fade bs-example-modal-lgsec{{$modDetails->modal_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">{{ __('Add Specifiactions For') }} {{$modDetails->modal_name}}</h4>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="{{route('admin.model.spec.save')}}">
                                 @csrf
                                 <input type="hidden" value="{{$modDetails->modal_id}}" name="modal_id">
                                 <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="specification">{{ __('Choose Specification (Press and hold Cntrl key to select multiple spec)')}} <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                       @php

                                        $oldSpecs = Model_specification::where('model_id','=',$modDetails->modal_id)->pluck('spec_id');
                                        $showSpec = Specification::whereNotIn('spec_id',$oldSpecs)->where('active_flag','=',1)->get();
                                       @endphp
                                       <select class="form-control" name="specifications[]" required="" multiple="multiple">
                                          <option value="">--Choose an Option --</option>
                                          @foreach($showSpec as $showSpecs)
                                          <option value="{{$showSpecs->spec_id}}">{{$showSpecs->spec_name}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                           </div>
                           <div class="modal-footer">
                           <button type="submit" class="btn btn-primary">{{ __('Add') }}</button>
                           <button class="btn btn-secondary" type="reset">{{ __('Reset')}}</button>
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close')}}</button>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  @endforeach
            
  
            </div>
            
            
         </div>
      </div>
   </div>
</div>
</div>
@endsection