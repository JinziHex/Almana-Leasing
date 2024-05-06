@extends('admin.layouts.app')
@section('content')
    <div class="row" style="min-height: 70vh;">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.service.add') }}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
                    @if (session('status'))
                        <div class="alert alert-success" id="err_msg">
                            <p>{{ session('status') }}<button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">×</button></p>
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                            <thead>
                                <tr>
                                    <th class="wd-15p">{{ __('Sl No.') }}</th>
                                    <th class="wd-15p">{{ __('Service Title') }}</th>
                                    <th class="wd-15p">{{ __('Service Title (Arabic)') }}</th>
                                    
                                    
                                    <th class="wd-15p">{{ __('Service Image 1') }}</th>
                                    <th class="wd-15p">{{ __('Service Image 2') }}</th>
                                    <th class="wd-15p">{{ __('Service Icons') }}</th>
                                    <th class="wd-15p">{{ __('Service Content Title') }}</th>
                                    
                                   
                                   
                                     <th class="wd-15p">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($fetchDetail as $fetchDetails)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $fetchDetails->service_title }}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $fetchDetails->ar_service_title }}</td>
                                       
                                       
                                        <td><img src="{{url('/assets/uploads/service/'.$fetchDetails->service_image_1)}}" width="50"></td>
                                        <td><img src="{{url('/assets/uploads/service/'.$fetchDetails->service_image_2)}}" width="50"></td>
                                        <td><img src="{{url('/assets/uploads/service/icons/'.$fetchDetails->service_icon)}}" width="50"></td> 
                                        <td>{{ $fetchDetails->service_content_title }}</td>
                                       
                                       
                                        <td>
                                            <a href="{{ url('admin/service/edit/' . Crypt::encryptString($fetchDetails->service_id )) }}"
                                                class="btn btn-sm btn-info"><i
                                                    class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;<a
                                                href="{{ url('admin/service/delete/' . Crypt::encryptString($fetchDetails->service_id )) }}"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Do you want to delete this location?');"><i
                                                    class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a>
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
