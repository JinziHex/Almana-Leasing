@extends('admin.layouts.app')
@section('content')
<style>
    /*#bukingtable{
        width: 100%;
        border-collapse: collapse !important;
        background: #eee;
        border-radius: 5px;
        overflow: hidden;
    }
     #bukingtable th{
             border-top: none;
            border-bottom-color: #fff;
            background: rgba(0,0,0,.1);
            border-right: 1px solid #fff;
     }
     #bukingtable th:last-child{
         border-right:none;
         
     }
     .bookpaginate ul.pagination{
         justify-content: flex-end;
     }
     .bookpaginate .page-item:first-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-link{
         border: none;
        color: #5A738E!important;
     }
     .bookpaginate .page-item:last-child .page-link{
         text-decoration:underline;
         font-size: 0;
     }
     .bookpaginate .page-item.active .page-link{
         background-color:transparent;
         border-color:transparent;
     }
     .bookpaginate .page-link:hover{color:#0056b3!important; background:transparent;}
     .bookpaginate .page-link:focus{box-shadow:none;}
     .bookpaginate .page-item:first-child .page-link::after{content:'Previous'; font-size: 13px;}
     .bookpaginate .page-item:last-child .page-link::after{content:'Next'; font-size: 13px;}
     li.page-item.active span {color: #007bff !important;}*/
</style>
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body bookpaginate">
         @if(session('status'))
            <div class="alert alert-success" id="err_msg">
               <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger" id="err_msg">
               <p>{{session('error')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
              <!-- Filter -->
             <form method="GET" action="{{route('booking.filter')}}">
               @csrf
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                         <label>{{ __('Reference Id')}}</label>
                        <input type="number" id="reference_id"  name="reference_id"  class="form-control" >
                     </div>
                  </div>

                  <div class="col-md-4">
                     <label>{{ __('From date')}}</label>
                        <input type="date" id="from_date" name="from_date" value="{{Helper::dateFormat()->toDateString()}}" class="form-control" >
                  </div>

                  <div class="col-md-4">
                     <label>{{ __('To Date')}}</label>
                        <input type="date" id="to_date" name="to_date" value="{{Helper::dateFormat()->toDateString()}}" class="form-control" >
                  </div>


                  <div class="col-md-4">
                     <div class="form-group">
                        <label>{{ __('Customer') }}</label>
                       <select class="form-control" name="customers">
                             <option value="" default>--All Customers --</option>
                              @foreach($custmList as$custmLists)
                              <option value="{{$custmLists->customer_id}}">{{$custmLists->cust_fname}} {{$custmLists->cust_lname}}</option>
                              @endforeach
                           </select>
                       
                     </div>
                  </div>

                  <div class="col-md-4">
                           <label>{{ __('Booking Status')}}</label>
                           <select class="form-control" name="book_status">
                              <option value="" default>--All status --</option>
                              @foreach($bookStatus as$bookStatuses)
                              <option value="{{$bookStatuses->status_id}}">{{$bookStatuses->status}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-md-4">
                           <label>{{ __('Models')}}</label>
                           <select class="form-control" name="book_models">
                              <option value="" default>--All model --</option>
                              @foreach($bookModel as$bookModels)
                              <option value="{{$bookModels->modal_id}}">{{$bookModels->modal_name}}</option>
                              @endforeach
                           </select>
                        </div>

                  
               </div>
                 <div class="row">
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
                           <a href="{{route('admin.bookings')}}" class="btn btn-block btn-primary">{{__('Reset')}}</a>

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
                        <th class="wd-15p">{{ __('Sl No.')}}</th>
                        <th class="wd-15p">{{ __('Reference Id')}}</th>
                        <th class="wd-15p">{{ __('Customer')}}</th>
                        <th class="wd-15p">{{ __('From Date')}}</th>
                        <th class="wd-15p">{{ __('To Date')}}</th>
                        <th class="wd-15p">{{ __('Car Model')}}</th>
                        <th class="wd-15p">{{ __('Rate')}}</th>
                        <th class="wd-15p">{{ __('Status')}}</th>
                        <th class="wd-25p">{{ __('Action')}}</th>
                     </tr>
                  </thead>
                  <tbody>
                  @php
                  $i=0;
                  @endphp
                  @foreach($bkDetail as $bkDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td>{{$bkDetails->book_ref_id}}</td>
                     <td>{{ucfirst($bkDetails->customer->cust_fname)}} {{$bkDetails->customer->cust_lname}}</td>
                     <td>{{$bkDetails->book_from_date}}</td>
                     <td>{{$bkDetails->book_to_date}}</td>
                     <td>{{$bkDetails->model->modal_name}}</td>
                     <td>{{$bkDetails->book_total_rate}}<br>@if(!is_null($bkDetails->coupon_code))<span class="badge badge-sm badge-success">Coupon Applied-{{$bkDetails->coupon_code}}</span>@endif</td>
                     <td>
                         @if($bkDetails->book_status==6)
                         <button class="btn btn-success btn-sm">{{$bkDetails->status->status}}</button>
                         @else
                         <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg{{$bkDetails->book_id}}">
                           {{$bkDetails->status->status}}</button>
                         @endif
                        
                     </td>
                     <td><a href="{{url('booking/view/'.Crypt::encryptString($bkDetails->book_id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i>&nbsp;{{ __('View')}}</a></td>
                  </tr>
                  <!--status -->
                  <div class="modal fade bs-example-modal-lg{{$bkDetails->book_id}}" tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h4 class="modal-title" id="myModalLabel">Change status of Reference Number {{$bkDetails->book_ref_id}}</h4>
                              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" enctype="multipart/form-data" method="POST" action="{{route('admin.book.status')}}">
                                 @csrf
                                 <input type="hidden" value="{{$bkDetails->book_id}}" name="book_id">
                                 <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="car_image">{{ __('Status')}} <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                       <select name="status" class="form-control" required="">
                                          <option value="" disabled="">--choose a status--</option>
                                          @foreach($bkStatus as $bkStatuss)
                                           <option value="{{$bkStatuss->status_id}}" {{ $bkStatuss->status_id == $bkDetails->book_status ? 'selected' : '' }}>{{$bkStatuss->status}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
                           </div>
                           <div class="modal-footer">
                           <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                           
                           <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                           </div>
                           </form>
                        </div>
                     </div>
                  </div>
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