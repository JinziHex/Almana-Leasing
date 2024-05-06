@extends('front-end.layouts.front-layout')
@section('content')
@php
$getPath = "assets/uploads/banner/".$fetchBanner->page_banner_image;
@endphp
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{__(@$fetchBanner->page_banner_title) }}</h1>
			<h5>{{__(@$fetchBanner->page_banner_description) }}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="careers-list">
	<div class="container">
		<h2> {{ __('HIRING CLASSIFIED') }} </h2>
		<div class="spn-brdr"><span class="border-btm"></span></div>
		<div class="jobs">
			
			@foreach($fetchContent as $fetchContents)
			
			<div class="jobs-listing @if($fetchContents->job_type_id == 1) full-time @elseif($fetchContents->job_type_id == 2) part-time @elseif($fetchContents->job_type_id == 3) temporary @else freelance @endif" data-aos-duration="2000">
				@php
				$titleSlug = $fetchContents->career_title_slug;
				@endphp
				<!--<a href="{{url('career/detail/'.$titleSlug)}}" id="listing-items">-->
				    <a href="#" id="listing-items">
					@if($fetchContents->job_icon)
					<div class="listing-logo"><img width="60" height="60" src="{{url('/assets/uploads/career/'.@$fetchContents->job_icon)}}" class="attachment-featuredImageCroppedJobs size-featuredImageCroppedJobs wp-post-image" alt="" /></div>
					@else
					<div class="listing-logo"><img width="60" height="60" src="{{url('assets/front/website/images/placeholder.png')}}" class="attachment-featuredImageCroppedJobs size-featuredImageCroppedJobs wp-post-image" alt="" /></div>
					@endif
					<div class="listing-title">
						<h4>{{ ucfirst(trans(@$fetchContents->career_title)) }}</h4>
						<ul class="listing-icons">
							<li><img src="{{url('assets/front/website/images/1.jpg')}}">  {{ ucfirst(@$fetchContents->job_company_name)  }}</li>
							<li><img src="{{url('assets/front/website/images/2.jpg')}}">  {{ ucfirst(@$fetchContents->jobLocation['city_name'])  }}</li>
							<li><img src="{{url('assets/front/website/images/3.jpg')}}">  {{ @$fetchContents->job_salary_range }}</li>
						</ul>
						<h5 class="job-type @if($fetchContents->job_type_id == 1) full-time @elseif($fetchContents->job_type_id == 2) part-time @elseif($fetchContents->job_type_id == 3) temporary @else freelance @endif">{{ @$fetchContents->jobTypes['job_type_title'] }}</h5>
					</div>
				</a>
			</div>

			@endforeach
			
			@if(count($fetchContent) > 6)
			<div class="page-load">
				<a href="#" id="loadMore"><i class="fas fa-plus-circle"></i> Show More Jobs</a>
			</div>
			@endif

		</div>
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
		<div class="toggle-form">
			<h3>{{__('Quick Enquiry')}}</h3>
			<div role="form" class="wpcf7" id="wpcf7-f187-o1" lang="en-US" dir="ltr">
				<div class="screen-reader-response"></div>
				<form action="{{route('career.quick-enquiry.save')}}" method="post" class="wpcf7-form" enctype="multipart/form-data">
					@csrf()
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<label> {{__('Name')}}<br />
								<span class="wpcf7-form-control-wrap your-name"><input type="text" name="enquiry_name" id="cname" value="{{old('enquiry_name')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required" required=""  /></span> </label>
							</div>
							<div class="col-sm-12 col-md-6 col-lg-6">
								<label> {{__('Email')}}<br />
									<span class="wpcf7-form-control-wrap your-email"><input type="email" name="enquiry_email" value="{{old('enquiry_email')}}" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" required="" /></span> </label>
								</div>
								<div class="col-sm-12 col-md-6 col-lg-6">
									<label> {{__('Phone')}}<br />
										<span class="wpcf7-form-control-wrap your-mobile"><input type="tel" onkeypress='validate(event)' name="enquiry_phone" value="{{old('enquiry_phone')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel" aria-required="true" aria-invalid="false" required="" /></span> </label>
									</div>
									<div class="col-sm-12 col-md-6 col-lg-6">
										<label>{{__('Location')}}<br />
											<span class="wpcf7-form-control-wrap your-subject"><input type="text" name="enquiry_location" value="{{old('enquiry_location')}}" size="40" class="wpcf7-form-control wpcf7-text" aria-invalid="false" required="" /></span> </label>
										</div>
										<div class="col-sm-12 col-md-6 col-lg-6">
											<label> {{__('Upload Your CV')}}<br />
												<span class="wpcf7-form-control-wrap file-819"><input type="file" name="enquiry_cv" size="40" class="wpcf7-form-control wpcf7-file" accept=".pdf,.doc,.docx" required="" /></span> </label>
											</div>
											<div class="col-sm-12 col-md-12 col-lg-12">
												<label> {{__('Message')}}<br />
													<span class="wpcf7-form-control-wrap your-message"><textarea name="enquiry_message" value="" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" required="">{{old('enquiry_message')}}</textarea></span> </label>
												</div>
												<div class="col-sm-12 col-md-12 col-lg-12 g-recaptcha" id="feedback-recaptcha"
                                                data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
                                                </div>
												<div class="col-sm-12 col-md-12 col-lg-12">
													<input type="submit" value="{{__('Send')}}" class="wpcf7-form-control wpcf7-submit" />
												</div>
											</div>
											<div class="wpcf7-response-output wpcf7-display-none"></div></form></div>		</div>
										</div>
									</div>
								</div>
								<script>
								 $( document ).ready(function() {
                                            $( "#cname" ).keypress(function(e) {
                                                var key = e.keyCode;
                                                if (key >= 48 && key <= 57) {
                                                    e.preventDefault();
                                                }
                                            });
                                          
                                        });
								     function validate(evt) {
                                        var theEvent = evt || window.event;
                                        var key = theEvent.keyCode || theEvent.which;
                                        key = String.fromCharCode( key );
                                        var regex = /[0-9]|\./;
                                        if( !regex.test(key) ) {
                                           theEvent.returnValue = false;
                                           if(theEvent.preventDefault) theEvent.preventDefault();
                                        }
                                        }
								</script>
								@endsection