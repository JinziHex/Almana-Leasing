@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
   <div class="col-md-12 col-lg-12">
      <div class="card">
         <div class="card-header">
            <h3 class="card-title">{{ $pageTitle }}</h3>
         </div>
         <div class="card-body">
            <a href="{{route('admin.customize.language.add')}}" class="btn btn-dark btn-block">{{ __('Customize') }}</a><br>
            @if(session('status'))
            <div class="alert alert-success" id="err_msg">
               <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
            </div>
            @endif
            <div class="table-responsive">
            <small><p>NOTE:Please add through City Or Location in Masters if your intend to enter city/location name</p></small>
               <table id="example" class="table table-striped table-bordered text-nowrap w-100">
                  <thead>
                     <tr>
                        <th class="wd-15p">{{ __('Sl No.') }}</th>
                        <th class="wd-15p">{{ __('English') }}</th>
                        <th class="wd-15p">{{ __('Arabic') }}</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                     @php
                     $i=0;
                     @endphp
                     @foreach($fars as $en=>$ar)
                     @php $i++; @endphp
                     <tr>
                         <td>{{$i}}</td>
                         <td>{{$en}}</td>
                         <td>{{$ar}}</td>
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
<script>
    function deletePopup()
    {
        return confirm('Do you want to delete this city?');
    }
</script>
@endsection