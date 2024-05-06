@extends('admin.layouts.app')
@section('content')
@php
use App\Models\Mode_rate;
@endphp
<div class="row" style="min-height: 70vh;">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
      </div>
      <form method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Model Name') }}</label>
                <input type="text" class="form-control" readonly="" value="@if($viewRes->modal_name!=""){{$viewRes->modal_name}}@else Not Specified @endif">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Model Category') }}</label>
                <input type="text" class="form-control" readonly="" value="@if(@$viewRes->category->model_cat_name!="")
                {{@$viewRes->category->model_cat_name}}@else Not Specified @endif">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label class="form-label">{{ __('Maker') }}</label>
                <input type="text" class="form-control" readonly="" value="@if(@$viewRes->maker->maker_name!=""){{@$viewRes->maker->maker_name}}@else Not Specified @endif">
              </div>
            </div>
       
            <div class="col-md-12">
              <div class="form-group">
                <label class="form-label">{{ __('Status') }}</label>
                <input type="text" class="form-control" readonly="" value="@if($viewRes->active_flag==1)
                Active
                @else
                Inactive
                @endif">
              </div>
            </div>
           
            <div class="col-md-12">
              <div class="form-group">
                <div class="card-box table-responsive">
                  <h2>Rates</h2>
                  <table class="table table-striped table-bordered text-nowrap w-100"  style="width:100%">
                    <thead>
                      <tr>
                        <th>{{ __('Sl No.') }}</th>
                        <th>{{ __('Rate Type') }}</th>
                        <th>{{ __('Rate') }}</th>
                        <th>{{ __('Min Rate') }}</th>
                        <!--<th>{{ __('Chauff Rate') }}</th>-->
                        <!--<th>{{ __('CF Min Rate') }}</th>-->
                      </tr>
                    </thead>
                    <tbody>
                      @php
                      $viewRate   = Mode_rate::where('model_id','=',$viewRes->modal_id)->where('maker_id','=',$viewRes->makers)->orderBy('rate_type_id','ASC')->get();
                      $i=0;
                      @endphp
                      @foreach($viewRate as $viewRates)
                      @php $i++; @endphp
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$viewRates->rates['rate_type_name']}}</td>
                        <td>{{$viewRates->rate}}</td>
                        <td>{{$viewRates->model_min_rate}}</td>
                        <!--<td>{{$viewRates->modal_chauff_rate}}</td>-->
                        <!-- <td>{{$viewRates->modal_cfmin_rate}}</td>-->
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            
            <div class="col-md-12">
              <div class="form-group">
                <center>
                
                <a class="btn btn-danger" href="{{route('admin.customers')}}">Back</a>
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