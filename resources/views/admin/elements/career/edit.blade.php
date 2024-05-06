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
       <form action="{{route('admin.career.update')}}" method="POST" enctype="multipart/form-data" >
        @csrf
       <input type="hidden" name="career_id" value="{{$fetchDetail->career_id}}"> 
        <div class="card-body">
          <div class="row">


             <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Title(English)')}}</label>
                     <input type="text" name="career_title" value="{{ $fetchDetail->career_title }}" required="required" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Title(Arabic)')}}</label>
                     <input type="text" dir="rtl" name="arabic_career_title" value="{{ $fetchDetail->ar_career_title }}" required="required" class="form-control">
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Category')}}</label>
                    <select class="form-control" required="" name="job_category_id">
                              
                              @foreach($fetchJobCat as $fetchJobCats)
                              <option {{ $fetchJobCats->job_category_id == $fetchDetail->job_category_id ? 'selected' : '' }} value="{{$fetchJobCats->job_category_id}}">{{ $fetchJobCats->category_title }}</option>
                              @endforeach
                           </select>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Type')}}</label>
                    <select class="form-control" required="" name="job_type_id">
                              @foreach($fetchJobType as $fetchJobTypees)
                              <option {{ $fetchJobTypees->job_type_id == $fetchJobTypees->job_type_id ? 'selected' : '' }} value="{{$fetchJobTypees->job_type_id}}">{{ $fetchJobTypees->job_type_title }}</option>
                              @endforeach
                           </select>
                  </div>
                </div>

                  <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Company Name(English)')}}</label>
                    <input type="text" name="job_company_name" value="{{ $fetchDetail->job_company_name }}" required="required" class="form-control">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Company Name(Arabic)')}}</label>
                    <input type="text" dir="rtl" name="arabic_job_company_name" value="{{ $fetchDetail->ar_job_company_name }}" required="required" class="form-control">
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Salary range')}}</label>
                    <input type="text" value="{{ $fetchDetail->job_salary_range }}" placeholder="Example: QAR 150 - QAR 200" name="job_salary_range" required="" class="form-control">
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Location')}}</label>
                     <select class="form-control" required="" name="job_location">
                             
                              @foreach($fetchCity as $fetchCitys)
                              <option {{ $fetchCitys->city_id == $fetchCitys->city_id ? 'selected' : '' }} value="{{$fetchCitys->city_id}}">{{ $fetchCitys->city_name }}</option>
                              @endforeach
                           </select>
                  </div>
                </div>

                 <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Description(English)')}}</label>
                     <textarea class="form-control" required="" name="job_description" >{{ $fetchDetail->job_description }}</textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label">{{ __('Job Description(Arabic)')}}</label>
                     <textarea class="form-control" dir="rtl" required="" name="arabic_job_description" >{{ $fetchDetail->ar_job_description }}</textarea>
                  </div>
                </div>




                <div class="col-md-6">
                  <div class="form-group">
                    <label class="form-label"> Company Logo (Supported Formats: .png,.jpg,.jpeg)</label>
                   <input type="file" name="job_icon" value="{{ $fetchDetail->job_icon }}}" class="form-control" accept=".png,.jpg,.jpeg">
                           <br>
                           <img src="{{url('/assets/uploads/career/'.$fetchDetail->job_icon)}}" width="50">
                  </div>
                </div>


            <div class="col-md-12">
              <div class="form-group">
                <div class="col-md-12 col-sm-12 text-center">
                  <input type="submit" class="btn btn-success" value="Update">
                  <a class="btn btn-danger" href="{{ route('admin.jobs.list') }}">Cancel</a>
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