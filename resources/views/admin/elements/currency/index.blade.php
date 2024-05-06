@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            {{-- <a href="{{route('admin.currency.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br> --}}
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
                        <th class="wd-15p">{{ __('Code') }}</th>
                        <th class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Conversion Rate') }}</th>
                        <th class="wd-15p">{{ __('Currency Type') }}</th>   
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($curDetail as $curDetails)
                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $curDetails->currency_code }}</td>
                        <td>{{ ucfirst($curDetails->currency_name) }}</td>
                        <td>{{ $curDetails->currency_conversion_rate  }}</td>
                        <td> @if($curDetails->currency_id==1)
                           {{ __('Base Currency') }}
                           @else
                           <a href="{{url('currency/edit/'.Crypt::encryptString($curDetails->currency_id))}}" class="btn btn-sm btn-info">
                              <i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>
                           <a href="{{url('currency/delete/'.Crypt::encryptString($curDetails->currency_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this currency?');">
                              <i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>  
                        @endif</td>
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