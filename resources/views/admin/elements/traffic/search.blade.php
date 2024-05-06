@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            {{-- filter --}}
            <form method="GET" action="{{route('violation.filter')}}">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                       <label>{{ __('From Date')}}</label>
                        <input type="date" id="from_date"  name="from_date"  class="form-control"   value="{{$frmDt}}">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                      <label>{{ __('To Date')}}</label>
                           <input type="date" id="to_date"  name="to_date"  class="form-control"  value="{{$toDt}}">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <label>{{ __('Models')}}</label>
                         <select class="form-control" name="book_models">
                              <option value="" default>--All models --</option>
                              @foreach($bookModel as$bookModels)
                               <option value="{{$bookModels->modal_id}}" {{ $bookModels->modal_id == $modelss ? 'selected' : '' }}>{{$bookModels->modal_name}}</option>
                              {{-- <option value="{{$bookModels->modal_id}}">{{$bookModels->modal_name}}</option> --}}
                              @endforeach
                           </select>
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
                           <a href="{{route('admin.traffic.violation')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>

   
            {{-- filter ends --}}
           
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                        <th class="wd-15p">{{ __('Customer') }}</th>
                        <th class="wd-15p">{{ __('Model') }}</th>
                        <th class="wd-15p">{{ __('Registration No:')}}</th>
                        <th class="wd-15p">{{ __('Date') }}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @isset($result)
                     @foreach($result as $trafDetails)
                     @php $i++; @endphp
                     <tr>
                     <td>{{ $i }}</td>
                     <td>{{ $trafDetails->customer['cust_fname'] }} {{ $trafDetails->customer['cust_lname'] }}</td>
                      <td>{{ $trafDetails->model['modal_name'] }}</td>
                     <td>{{$trafDetails->model_reg_no}}</td>
                     <td>{{ $trafDetails->violation_date  }}</td>
                        
                        <td>
                           <a href="{{url('violation/view/'.Crypt::encryptString($trafDetails->violation_id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('View') }}</a>&nbsp;                        
                        </td>
                           
                           
                        </td>
                     </tr>
                     @endforeach
                     @endif
                  </tbody>
               </table>
               
            </div>
            
            
         </div>
      </div>
   </div>
</div>
</div>
@endsection