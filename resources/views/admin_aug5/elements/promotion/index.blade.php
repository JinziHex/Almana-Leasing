@extends('admin.layouts.app')
@section('content')
    <div class="row" style="min-height: 70vh;">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.promotion.add') }}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
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
                                    <th class="wd-15p">{{ __('Model') }}</th>
                                    <th class="wd-15p">{{ __('Discount') }}</th>
                                    <th class="wd-15p">{{ __('Start Date') }}</th>
                                    <th class="wd-15p">{{ __('End Date') }}</th>
                                    <th class="wd-15p">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($proDetail as $proDetails)
                                    @php $i++; @endphp
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $proDetails->modal['modal_name'] }}</td>
                                        <td>{{ $proDetails->price }}</td>
                                        <td>{{ date('d-m-Y',strtotime($proDetails->start_date)) }}</td>
                                        <td>{{ date('d-m-Y',strtotime($proDetails->end_date)) }}</td>
                                        <td>
                                            <a href="{{ url('promotion/edit/' . Crypt::encryptString($proDetails->promotion_id )) }}"
                                                class="btn btn-sm btn-info"><i
                                                    class="fa fa-pencil-square-o"></i>&nbsp;{{ __('Edit') }}</a>&nbsp;<a
                                                href="{{ url('promotion/delete/' . Crypt::encryptString($proDetails->promotion_id )) }}"
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
