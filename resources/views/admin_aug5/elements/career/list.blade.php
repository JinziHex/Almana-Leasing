@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.jobs.add')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                        <th class="wd-15p">{{ __('Title(En)') }}</th>
                        <th class="wd-15p">{{ __('Title(Ar)') }}</th>
                        <th class="wd-15p">{{ __('Category') }}</th>
                        <th class="wd-15p">{{ __('Location') }}</th>
                        <th class="wd-15p">{{ __('Company(En)')}}</th>
                        <th class="wd-15p">{{ __('Company(Ar)')}}</th>
                        <th class="wd-15p">{{ __('Company Logo')}}</th>
                        <th class="wd-15p">{{ __('Type')}}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                        
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
                        <td>{{ @$fetchDetails->career_title }}</td>
                        <td>{{ @$fetchDetails->ar_career_title }}</td>
                        <td>{{ @$fetchDetails->jobCats['category_title'] }}</td>
                        <td>{{ @$fetchDetails->jobLocation['city_name'] }}</td>
                        <td>{{ @$fetchDetails->job_company_name }}</td>
                        <td>{{ @$fetchDetails->ar_job_company_name }}</td>
                        <td>@if( @$fetchDetails->job_icon ) <img src="{{url('/assets/uploads/career/'.@$fetchDetails->job_icon)}}" width="50"> @endif </td>
                       
                        <td> {{ @$fetchDetails->jobTypes['job_type_title'] }} </td>
                        <td>
                           <a href="{{url('admin/career/edit/'.Crypt::encryptString(@$fetchDetails->career_id))}}" class="btn btn-sm btn-info"><i class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a><a style="margin-left:10px;" href="{{url('admin/career/delete/'.Crypt::encryptString(@$fetchDetails->career_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this job?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
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