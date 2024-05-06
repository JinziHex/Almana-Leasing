@extends('front-end.layouts.web-layout')
@section('content')
@php
$getPath = "/assets/uploads/banner/".$fetchBanner->page_banner_image;
@endphp
<style type="text/css">
			.careers-list.careerdetail h3 {font-size: 50px;text-transform: uppercase;font-weight: 900;margin-bottom: 3%;}.careers-list.careerdetail .jobs-listing {display: block;width: 100%;float: left;padding: 0 0 2% 0;border: 0;}.careers-list.careerdetail .listing-logo {display: inline-block;}.careers-list.careerdetail .listing-logo img {width: 100px;height: auto;}.careers-list.careerdetail .jobs-listing .listing-title {flex-wrap: wrap;display: inline-block;top: 15px;padding-left: 25px;position: relative;padding-right: 5%;}.careers-list.careerdetail .jobs-listing h4 {font-family: Montserrat bold, Helvetica, Arial, sans-serif !important;letter-spacing: 0;font-size: 20px;line-height: 27px;color: #000;padding-top: 0%;margin-top: 2px;font-weight: bold;text-align: left;}.careers-list.careerdetail .listing-icons {padding: 2% 0px;}.careers-list.careerdetail ul.listing-icons li {color: #4a4a4a;}.careers-list.careerdetail h5.job-type {	right: 0;    top: 55px;}.careers-list.careerdetail div.wpcf7 {width: 62%;display: inline-block;padding: 30px 40px;border-radius: 9px;background: #fff;box-shadow: 0px 10px 26px -7px #000000, 5px 5px 15px 5px rgb(0 0 0 / 0%);}.careers-list.careerdetail div.wpcf7 .screen-reader-response {position: absolute;overflow: hidden;clip: rect(1px, 1px, 1px, 1px);height: 1px;width: 1px;margin: 0;padding: 0;border: 0;}.careers-list.careerdetail .col-lg-6, .careers-list.careerdetail .col-lg-12 { margin-bottom: 15px;}.careers-list.careerdetail label {width: 100%;font-family: Montserrat bold, Helvetica, Arial, sans-serif !important;font-size: 15px;font-weight: 500;text-align: left;color: #000;}.careers-list.careerdetail input[type=text], .careers-list.careerdetail input[type=tel], .careers-list.careerdetail input[type=email], .careers-list.careerdetail textarea {padding: 14px 18px;outline: none;font-size: 15px;color: #909090;margin: 0;max-width: 100%;border-radius: 5px;width: 100%;box-sizing: border-box;display: block;background-color: #fcfcfc;font-weight: 500;border: 1px solid #e0e0e0;opacity: 1;font-family: Montserrat bold, Helvetica, Arial, sans-serif !important;}.careers-list.careerdetail input[type=file] {font-family: Montserrat bold, Helvetica, Arial, sans-serif !important;font-weight: 500;font-size: 15px;}.careers-list.careerdetail input[type=submit] {display: inline-block;padding: 10px 30px;text-align: center;background-color: #ffc72c;color: #fff;font-weight: 600;font-size: 14px;font-family: Montserrat bold, Helvetica, Arial, sans-serif !important;border: none;border-radius: 4px;cursor: pointer;}
</style>
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ @$fetchCareer->career_title }}</h1>
		</div>
	</div>
</div>
<div class="careers-list careerdetail">
	<div class="container">
		@if(session('status'))
		<div class="alert alert-success" id="err_msg">
			<p>{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
		</div>
		@endif
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></li>
				@endforeach
			</ul>
		</div>
		@endif
		<div class=""> {{-- toggle-form --}}
			<h3>Apply Now</h3>
			<div class="jobs-listing @if($fetchCareer->job_type_id == 1) full-time @elseif($fetchCareer->job_type_id == 2) part-time @elseif($fetchCareer->job_type_id == 3) temporary @else freelance @endif" data-aos-duration="2000">
				<div class="listing-logo">
					@if($fetchCareer->job_icon)
					<img width="60" height="60" src="{{url('/assets/uploads/career/'.@$fetchCareer->job_icon)}}" class="attachment-featuredImageCroppedJobs size-featuredImageCroppedJobs wp-post-image" alt="">
					@endif
				</div>
				<div class="listing-title">
					<h4>{{ ucfirst(trans(@$fetchCareer->career_title)) }}</h4>
					<ul class="listing-icons">
						<li><img src="{{url('assets/front/website/images/1.jpg')}}">  {{ ucfirst(@$fetchCareer->job_company_name)  }}</li>
						<li><img src="{{url('assets/front/website/images/2.jpg')}}">  {{ ucfirst(@$fetchCareer->jobLocation['city_name'])  }}</li>
						<li><img src="{{url('assets/front/website/images/3.jpg')}}">  {{ @$fetchCareer->job_salary_range }}</li>
					</ul>
					<h5 class="job-type @if($fetchCareer->job_type_id == 1) full-time @elseif($fetchCareer->job_type_id == 2) part-time @elseif($fetchCareer->job_type_id == 3) temporary @else freelance @endif">{{ @$fetchCareer->jobTypes['job_type_title'] }}</h5>
				</div>
			</div>
			<div role="form" class="wpcf7" id="wpcf7-f187-p191-o1" lang="en-US" dir="ltr">
				<div class="screen-reader-response"></div>
				<form action="{{route('career.quick-enquiry.save')}}" method="post" class="wpcf7-form" enctype="multipart/form-data">
					@csrf()
					<input type="hidden" value="{{ $fetchCareer->career_id }}" name="career_id">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> Name*<br />
								<span class="wpcf7-form-control-wrap your-name"><input type="text" name="enquiry_name" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required="" /></span> </label>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> Email*<br />
								<span class="wpcf7-form-control-wrap your-email"><input type="email" name="enquiry_email" value="" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" required="" /></span> </label>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> Phone*<br />
								<span class="wpcf7-form-control-wrap your-mobile"><input type="tel" name="enquiry_phone" value="" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel" aria-required="true" aria-invalid="false" required="" /></span> </label>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> Location<br />
								<span class="wpcf7-form-control-wrap your-subject"><input type="text" name="enquiry_location" value="" size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false" required="" /></span> </label>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> Upload Your CV<br />
								<span class="wpcf7-form-control-wrap file-819"><input type="file" name="enquiry_cv" size="40" class="wpcf7-form-control wpcf7-file" accept=".pdf,.doc,.docx" required="" /></span> </label>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<label> Message<br />
								<span class="wpcf7-form-control-wrap your-message"><textarea name="enquiry_message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" required=""></textarea></span> </label>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
						<input type="submit" value="Send" class="wpcf7-form-control wpcf7-submit" />
						</div>
					</div>
				<div class="wpcf7-response-output wpcf7-display-none"></div></form>
			</div>	 {{-- form end	 --}}
		</div>
	</div>
</div>
@endsection