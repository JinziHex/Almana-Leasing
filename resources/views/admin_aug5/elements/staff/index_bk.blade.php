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
            <form method="GET" action="{{route('staff.filter')}}">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>{{ __('Employee Code')}}</label>
                         <input type="text" id="employee_code"  name="employee_code"  class="form-control" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>{{ __('Mobile Number')}}</label>
                         <input type="text" id="mobile_number"  name="mobile_number"  class="form-control" >
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>{{ __('Username')}}</label>
                        <input type="text" id="username"  name="user_name"  class="form-control" >
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
                           <a href="{{route('admin.staffs')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>
                        </div>
                     </div>
                  </div>
               </div>
            </form>

   
            {{-- filter ends --}}
            <a href="{{route('admin.staff.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                        <th class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Employee Code') }}</th>
                        <th class="wd-15p">{{ __('Username') }}</th>
                        <th class="wd-15p">{{ __('Email') }}</th>
                        <th class="wd-15p">{{ __('Mobile') }}</th>
                        <th class="wd-15p">{{ __('Status') }}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($usrDetail as $usrDetails)
                     @php $i++; @endphp
                     <tr>
                        <td>{{$i}}</td>
                     <td>{{ucfirst($usrDetails->staff_name)}}</td>
                     <td>{{$usrDetails->staff_code}}</td>
                     <td>{{ucfirst($usrDetails->name)}}</td>
                     <td>@if($usrDetails->email!=""){{$usrDetails->email}}@else Not Specified @endif</td>
                     <td>@if($usrDetails->mobile_number!=""){{$usrDetails->mobile_number}}@else Not Specified @endif</td>
                     <td>
                        @if($usrDetails->status==1)
                       <a href="{{url('staff/inactivate/'.Crypt::encryptString($usrDetails->id))}}" style="font-size: 12px;padding: 0px 5px;" class="btn btn-sm btn-outline-success" onclick="return confirm('Do you want to make this staff inactive?');">{{ __('Active') }}</a> 
                        @else
                        <a href="{{url('staff/activate/'.Crypt::encryptString($usrDetails->id))}}" style="font-size: 12px;padding: 0px 5px;" class="btn btn-sm btn-outline-danger" onclick="return confirm('Do you want to make this staff active?');">{{ __('Inactive')}}  </a>
                        @endif
                     </td> 
                        
                        <td>
                           <a href="{{url('staff/edit/'.Crypt::encryptString($usrDetails->id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;
                           {{-- <a href="{{url('staff/delete/'.Crypt::encryptString($usrDetails->id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this staff?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a> --}}
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