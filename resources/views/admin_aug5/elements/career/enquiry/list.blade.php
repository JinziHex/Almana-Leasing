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
                        <th class="wd-15p">{{ __('Category') }}</th>
                        <th class="wd-15p">{{ __('Name') }}</th>
                        <th class="wd-15p">{{ __('Contact') }}</th>
                        <th class="wd-15p">{{ __('Location') }}</th>
                        <th class="wd-15p">{{ __('CV')}}</th>
                        <th class="wd-15p">{{ __('Message')}}</th>
                        <th class="wd-15p">{{ __('Action') }}</th>
                        
                        
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($fetchEnquiryList as $fetchEnquiryLists)
                     @php $i++; @endphp
                     <tr>
                        <td>{{ $i }}</td>
                        <td>
                           @if($fetchEnquiryLists->career_id == NULL)
                           Quick Enquiry
                           @else
                           
                           {!! wordwrap(@$fetchEnquiryLists->careers['career_title'], 50, "<br />\n") !!}
                           @endif
                        </td>
                        <td>{{ ucFirst($fetchEnquiryLists->enquiry_name) }}</td>
                        <td>Email: {{ $fetchEnquiryLists->enquiry_email }}<br>Phone:
                        {{ $fetchEnquiryLists->enquiry_phone }}</td>
                        <td>{{ $fetchEnquiryLists->enquiry_location }}</td>
                        <td>@if( $fetchEnquiryLists->enquiry_cv )
                           <a href="{{url('assets/uploads/career/cv/'.$fetchEnquiryLists->enquiry_cv)}}" target="_blank">{{ $fetchEnquiryLists->enquiry_cv }}</a>
                           @else No File @endif
                           
                           <td> {{ $fetchEnquiryLists->enquiry_message }} </td>
                           <td>
                              <a href="{{url('admin/career/enquiry/delete/'.Crypt::encryptString($fetchEnquiryLists->career_enquiry_id))}}" class="btn btn-sm btn-danger" onclick="return confirm('Do you want to delete this enquiry?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
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