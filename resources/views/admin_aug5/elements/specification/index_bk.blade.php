@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.specification.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                        
                        <th class="wd-15p">{{ __('Status') }}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                    @foreach($specDetail as $specDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td><img src="{{url('/assets/uploads/specifications/icons/'.$specDetails->spec_icon)}}" width="30" height="30">&nbsp;{{ucfirst($specDetails->spec_name)}}</td>
                     
                     <td>
                        @if($specDetails->active_flag==1)
                        <a href="{{url('/admin/spec/deactivate/'.Crypt::encryptString($specDetails->spec_id))}}" class="btn btn-round btn-success btn-sm" onclick="return confirm('Do you want to deactivate this specification');">Active</a>
                        @else
                        <a href="{{url('/admin/spec/activate/'.Crypt::encryptString($specDetails->spec_id))}}" class="btn btn-round btn-danger btn-sm" onclick="return confirm('Do you want to activate this specification');">Inactive</a>
                        @endif
                     </td>
                     <td><a href="{{url('specification/edit/'.Crypt::encryptString($specDetails->spec_id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;<a href="{{url('specification/delete/'.Crypt::encryptString($specDetails->spec_id))}}" class="btn btn-sm btn-danger"  onclick="return confirm('Do you want to delete this specification?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
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