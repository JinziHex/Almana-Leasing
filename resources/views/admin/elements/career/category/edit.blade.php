@extends('admin.layouts.app')
@section('content')
<div class="row" style="min-height: 70vh;">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h3 class="mb-0 card-title">{{ $pageTitle }}</h3>
      </div>
      @if (count($errors) > 0)
      <div class="alert alert-danger" id="err_msg">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></li>
          @endforeach
        </ul>
      </div>
      @endif
      @if(session('status'))
      <div class="alert alert-danger" id="err_msg">
        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
      </div>
      @endif
       <form action="{{route('admin.job-category.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
      <input type="hidden" name="job_category_id" value="{{$fetchDetail->job_category_id}}"> 
        <div class="card-body">
          <div class="row">


             <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Title')}}</label>
                           <input type="text" name="category_title" value="{{$fetchDetail->category_title}}" required="required" class="form-control">
                  </div>
                </div>

                
              


            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                  <a class="btn btn-danger" href="{{ route('admin.job-category.list') }}">Cancel</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- ROW-1 CLOSED -->
@endsection