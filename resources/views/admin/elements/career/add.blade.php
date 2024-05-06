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
                     <div class="alert alert-success" id="err_msg">
                        <p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
                     </div>
                     @endif 
         <form action="{{route('admin.career.save')}}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Job Title(English)') }}</label>
                       <input type="text" name="career_title" required="required" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Job Title(Arabic)') }}</label>
                       <input type="text" dir="rtl" name="arabic_career_title" required="required" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Category') }}</label>
                       <select class="form-control" required="" name="job_category_id">
                              <option value="">--Choose a category--</option>
                              @foreach($fetchJobCat as $fetchJobCats)
                              <option value="{{$fetchJobCats->job_category_id}}">{{ $fetchJobCats->category_title }}</option>
                              @endforeach
                           </select>
                     </div>
                  </div>
                  
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Job Type') }}</label>
                       <select class="form-control" required="" name="job_type_id">
                              <option value="" class="form-control" required="">--Choose a job type--</option>
                              @foreach($fetchJobType as $fetchJobTypees)
                              <option value="{{$fetchJobTypees->job_type_id}}">{{ $fetchJobTypees->job_type_title }}</option>
                              @endforeach
                           </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Company Name(English)') }}</label>
                         <input type="text" name="job_company_name" required="required" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Company Name(Arabic)') }}</label>
                         <input type="text" dir="rtl" name="arabic_job_company_name" required="required" class="form-control">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Salary range') }}</label>
                         <input type="text" placeholder="Example: QAR 150 - QAR 200" name="job_salary_range" required="" class="form-control">
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Location') }}</label>
                         <select class="form-control" required="" name="job_location">
                              <option value="" class="form-control" required="">--Choose a job type--</option>
                              @foreach($fetchCity as $fetchCitys)
                              <option value="{{$fetchCitys->city_id}}">{{ $fetchCitys->city_name }}</option>
                              @endforeach
                           </select>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Job Description(English)') }}</label>
                       <textarea class="form-control" required="" name="job_description" ></textarea>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Job Description(Arabic)') }}</label>
                       <textarea class="form-control" dir="rtl" required="" name="arabic_job_description" ></textarea>
                     </div>
                  </div>

                  <div class="col-md-6">
                     <div class="form-group">
                        <label class="form-label">{{ __('Company Logo') }} (Supported Formats: .png,.jpg,.jpeg)</label>
                        <input type="file" name="job_icon" required="required" class="form-control" accept=".png,.jpg,.jpeg">
                     </div>
                  </div>
                  
                  
                  <div class="col-md-12">
                     <div class="form-group">
                        <center>
                        <button type="submit" class="btn btn-raised btn-primary">
                        <i class="fa fa-check-square-o"></i> Add</button>
                        <button type="reset" class="btn btn-raised btn-success">
                        Reset</button>
                        <a class="btn btn-danger" href="{{ route('admin.jobs.list') }}">Cancel</a>
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </form>
   </div>
</div>
</div>
@endsection