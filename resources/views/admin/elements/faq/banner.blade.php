@extends('admin.layouts.app')
@section('content')
    <div class="row" style="min-height: 70vh;">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body">
                  
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
                                <th class="wd-15p">{{ __('Page Name') }}</th>
                                <th class="wd-15p">{{ __('Page Name (Arabic)') }}</th>
                                <th class="wd-15p">{{ __('Page Banner Title ') }}</th>
                                <th class="wd-15p">{{ __('Page Banner Title  (Arabic) ') }}</th>
                                <th class="wd-15p">{{ __('Page Banner Description') }}</th>
                                <th class="wd-15p">{{ __('Page Banner Description (Arabic)') }}</th>
                                <th class="wd-15p">{{ __('Page Banner Image ') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                               
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                      
                                        <td>{{ $fetchDetail->page_name}}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $fetchDetail->ar_page_name}}</td>

                                        <td>{{ $fetchDetail->page_banner_title }}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $fetchDetail->ar_page_banner_title }}</td>

                                        <td>{{ $fetchDetail->page_banner_description }}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $fetchDetail->ar_page_banner_description }}</td>

                                        <td><img src="{{url('/assets/uploads/banner/'.$fetchDetail->page_banner_image)}}" width="50"></td>
                                        <td>{{ $fetchDetail->page_title }}</td>
                                        <td style="text-align: right; direction: rtl;">{{ $fetchDetail->ar_page_title }}</td>
                                       
                                       
                                       
                                     
                                        </td>
                                    </tr>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
