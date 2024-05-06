@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.about-us.teams.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                        <th class="wd-15p">{{ __('Name(En)') }}</th>
                        <th class="wd-15p">{{ __('Name(Ar)') }}</th>
                        <th class="wd-15p">{{ __('Designation(En)') }}</th>
                        <th class="wd-15p">{{ __('Designation(Ar)') }}</th>
                        <th class="wd-15p">{{ __('Image') }}</th>
                        <th class="wd-25p">{{ __('Action') }}</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($fetchDetail as $fetchDetails)
                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $fetchDetails->team_member_name }}</td>
                        <td>{{ __($fetchDetails->ar_team_member_name)}}</td>
                        <td>{{ $fetchDetails->team_member_designation }}</td>
                        <td>{{ __($fetchDetails->ar_team_member_designation) }}</td>
                        <td><img src="{{url('/assets/uploads/team/'.$fetchDetails->team_member_image)}}" width="50"></td>
                        <td>
                           <a href="{{url('admin/about-us/teams/edit/'.Crypt::encryptString($fetchDetails->team_id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;<a href="{{url('admin/about-us/teams/delete/'.Crypt::encryptString($fetchDetails->team_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this member?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
                           
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