@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Mode_rate;
use App\Models\Modal;
@endphp
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <!-- Filter -->
            <form method="GET" action="{{route('admin.rates')}}">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>{{ __('Models')}}</label>
                        <select class="form-control" name="book_models">
                           <option value="" default>--All model --</option>
                           @foreach($bookModel as$bookModels)
                           <option  {{request()->input('book_models') == $bookModels->modal_id ? 'selected':''}} 
                           value="{{$bookModels->modal_id}}">{{$bookModels->modal_name}}</option>
                           @endforeach
                        </select>
                     </div>
                     
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>{{ __('Rate Type')}}</label>
                        <select class="form-control" name="rate_type">
                           <option value="" default>--All rate type --</option>
                           @foreach($rate as $rates)
                           <option  {{request()->input('rate_type') == $rates->rate_type_id ? 'selected':''}}  
                           value="{{$rates->rate_type_id }}">{{$rates->rate_type_name}}</option>
                           @endforeach
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
                           <a href="{{route('admin.rates')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
            <!--filter ends-->
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                        <th class="wd-15p">{{ __('Model') }}</th>
                        <th class="wd-15p">{{ __('Rate type') }}</th>
                        <th class="wd-15p">{{ __('Rate') }}</th>
                        <th class="wd-15p">{{ __('Min Rate') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($modalRate as $modalRates)


                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $modalRates->models->modal_name }}</td>
                        <td>{{ $modalRates->rates->rate_type_name }}</td>
                        <td>{{ $modalRates->rate }}</td>
                        <td>{{ $modalRates->model_min_rate }}</td>
                        {{-- <!--<td>{{ $modalRates->modal_chauff_rate }}</td>-->
                        <!--<td>{{ $modalRates->modal_cfmin_rate }}</td>--> --}}





                     {{-- @php
                     $getModelId = $bookModels->modal_id;
                     $getMakerId = $bookModels->makers;
                     $rateDetail = Mode_rate::where('model_id','=',$getModelId)->where('maker_id','=',$getMakerId)->orderBy('model_rate_id','DESC')->get();
                     @endphp
                     
                     @foreach($rateDetail as $rateDetails)
                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $rateDetails->models->modal_name }}</td>
                        <td>{{ $rateDetails->rates->rate_type_name }}</td>
                        <td>{{ $rateDetails->rate }}</td>
                        <td>{{ $rateDetails->model_min_rate }}</td>
                        <!--<td>{{ $rateDetails->modal_chauff_rate }}</td>-->
                        <!--<td>{{ $rateDetails->modal_cfmin_rate }}</td>-->
                        
                     </tr>
                     @endforeach --}}
                     @endforeach
                  </tbody>
               </table>
               
            </div>
            
            
         </div>
      </div>
   </div>
</div>
</div>
@endsection