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
            <form method="GET" action="{{route('feedback.filter')}}">
               @csrf
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>{{ __('From Date')}}</label>
                       <input type="date" id="from_date"  name="from_date"  class="form-control"  value="{{Helper::dateFormat()->toDateString()}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>{{ __('To Date')}}</label>
                           <input type="date" id="to_date"  name="to_date"  class="form-control"  value="{{Helper::dateFormat()->toDateString()}}">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                       <label>{{ __('Customers')}}</label>
                           <select class="form-control" name="book_customers">
                              <option value="" default>--All Customers --</option>
                              @foreach($custDetail as$custDetails)
                              <option value="{{$custDetails->customer_id}}">{{$custDetails->cust_fname}} {{$custDetails->cust_lname}}</option>
                              @endforeach
                           </select>
                     </div>
                  </div>

                   <div class="col-md-6">
                     <div class="form-group">
                       <label>{{ __('Complaint Type')}}</label>
                             <select class="form-control" name="complaint_type">
                              <option value="" default>--All types --</option>
                            <option value="1">{{__('Complaint') }}</option>
                            <option value="2">{{ __('Suggestion') }}</option>
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
                           <a href="{{route('admin.feedbacks')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>

   
            {{-- filter ends --}}
          
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
                     <th class="wd-15p">{{ __('Type') }}</th>
                     <th class="wd-15p">{{ __('Customer') }}</th>
                     <th class="wd-15p">{{ __('Message') }}</th>
                     <th class="wd-15p">{{ __('Date') }}</th>
                     <th class="wd-15p">{{ __('Action') }}</th>

                      
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($feedDetail as $feedDetails)
                     @php $i++; @endphp
                     <tr>
                      <td>{{ $i }}</td>
                     <td>@if($feedDetails->feedback_type==1) {{ __('Complaint') }} @elseif($feedDetails->feedback_type==2) {{ __('Suggestion') }}@endif</td>
                     <td>{{ $feedDetails->feedback_fname }} {{ $feedDetails->feedback_lname }}</td>
                     <td>{{ $feedDetails->feedback_message }}</td>
                    
                     <td>{{ $feedDetails->post_date->toDateString()  }}</td>
                        
                        <td>
                           <a href="{{url('feedback/view/'.Crypt::encryptString($feedDetails->feedback_id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('View') }}</a>&nbsp;
                           
                        </td>
                           
                           
                        </td>
                     </tr>
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