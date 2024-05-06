@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.sliders.create')}}" class="btn btn-dark btn-block">{{ __('Add') }}</a><br>
            @if(session('status'))
            <div class="alert alert-success" id="err_msg">
               <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="table-responsive">
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ ('Sl No.') }}</th>
                        <th class="wd-15p">{{ ('Slider') }}</th>
                        <th class="wd-15p">{{ ('Action') }}</th>
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                    @foreach($sliders as $specDetails)
                  @php $i++; @endphp
                  <tr>
                     <td>{{$i}}</td>
                     <td><img src="{{url('/assets/uploads/sliders/'.$specDetails->slider_name)}}" width="200" height="100"></td>
                    
                     <td><a href="{{url('admin/sliders/delete/'.Crypt::encryptString($specDetails->id))}}" class="btn btn-sm btn-danger"  onclick="return confirm('Do you want to delete this slider?');"><i class="fa fa-trash-o"></i>&nbsp;{{ __('Delete') }}</a></td>
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