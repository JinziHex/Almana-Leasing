@extends('front-end.layouts.front-layout')
@section('content')
@php
$getPath = "assets/uploads/banner/".$fetchContent->contact_banner_image;
@endphp

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ __(@$fetchContent->contact_page_heading) }}</h1>
			<h5>{!! wordwrap(__(@$fetchContent->contact_page_meta_description), 50, "<br />\n") !!}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="contact-us">
	<div class="row">
		<div class="col-sm-12 col-md-5 col-lg-5 cleft" style="background-color: #000;" data-aos="fade-left" data-aos-duration="1500">
			<div class="container">
				<h3>{{ __('Contact Details') }} </h3>
				<div class="cphone">
					<h5>{{ __('Phone Number') }} </h5>
					<p><a href="tel:{{ @$fetchContent->contact_phone_number_1 }}">{{ @$fetchContent->contact_phone_number_1 }}</a></p>
					{{--<p><a href="tel:{{ @$fetchContent->contact_phone_number_2 }}">{{ @$fetchContent->contact_phone_number_2 }}</a></p>--}}
				</div>
				<div class="cmail">
					<h5>{{ __('Email Address') }}</h5>
					<p><a href="mailto:{{ @$fetchContent->contact_mail_1 }}">{{ @$fetchContent->contact_mail_1 }} </a></p>
					<p><a href="mailto:{{ @$fetchContent->contact_mail_1 }}">{{ @$fetchContent->contact_mail_2 }}</a></p>
				</div>
					<div class="caddrs">
					<h5>{{ __('Address') }}</h5>
					@foreach(explode(',', $fetchContent->contact_address) as $info)
					    <p>{{ $info }}</p>
					@endforeach
				</div>
					<h3>{{ __('Sales enquiries') }} </h3>
					<div class="cphone">
					<h5>{{ __('Landline') }} </h5>
					<p><a href="tel:{{ @$fetchContent->sales_enquiry_landline }}">{{ @$fetchContent->sales_enquiry_landline }}</a></p>
					<h5>{{ __('Mobile Number') }} </h5>
					<p><a href="tel:{{ @$fetchContent->sales_enquiry_mobile }}">{{ @$fetchContent->sales_enquiry_mobile }}</a></p>
				</div>
				<div class="cmail">
					<h5>{{ __('Email Address') }}</h5>
					<p><a href="mailto:{{ @$fetchContent->sales_enquiry_email1 }}">{{ @$fetchContent->sales_enquiry_email1 }} </a></p>
					<p><a href="mailto:{{ @$fetchContent->sales_enquiry_email2 }}">{{ @$fetchContent->sales_enquiry_email2 }}</a></p>
				</div>
				
					<h3>{{ __('Chauffer service enquiries') }} </h3>
					<div class="cphone">
					<h5>{{ __('Landline') }} </h5>
					<p><a href="tel:{{ @$fetchContent->ch_service_enq_landline  }}">{{ @$fetchContent->ch_service_enq_landline  }}</a></p>
					<h5>{{ __('Mobile Number') }} </h5>
					<p><a href="tel:{{ @$fetchContent->ch_service_enq_mobile }}">{{ @$fetchContent->ch_service_enq_mobile }}</a></p>
				</div>
				<div class="cmail">
					<h5>{{ __('Email Address') }}</h5>
					<p><a href="mailto:{{ @$fetchContent->ch_service_enq_email }}">{{ @$fetchContent->ch_service_enq_email }} </a></p>
				</div>
					<h3>{{ __('Service/Maintenance related queries') }} </h3>
					<div class="cphone">
					<h5>{{ __('Landline') }} </h5>
					<p><a href="tel:{{ @$fetchContent->sm_landline  }}">{{ @$fetchContent->sm_landline  }}</a></p>
					<h5>{{ __('Mobile Number') }} </h5>
					<p><a href="tel:{{ @$fetchContent->sm_mobile }}">{{ @$fetchContent->sm_mobile }}</a></p>
				</div>
				<div class="cmail">
					<h5>{{ __('Email Address') }}</h5>
					<p><a href="mailto:{{ @$fetchContent->sm_email }}">{{ @$fetchContent->sm_email }} </a></p>
				</div>
					<h3>{{ __('Airport branch related queries') }} </h3>
					<div class="cphone">
					<h5>{{ __('Landline') }} </h5>
					<p><a href="tel:{{ @$fetchContent->ab_landline  }}">{{ @$fetchContent->ab_landline  }}</a></p>
					<h5>{{ __('Mobile Number') }} </h5>
					<p><a href="tel:{{ @$fetchContent->ab_mobile }}">{{ @$fetchContent->ab_mobile }}</a></p>
					</div>
			
			</div>
		</div>
		<div class="col-sm-12 col-md-7 col-lg-7 cright" style="padding: 0;" data-aos="fade-right" data-aos-duration="1800">
			<p><iframe src="{{ @$fetchContent->contact_address_map_embed_url }}" width="100%" height="100%" frameborder="0" allowfullscreen="allowfullscreen"></iframe></p>
		</div>
	</div>
</div>

<div class="inqform" data-aos="zoom-in" data-aos-duration="1200">
	@if(session('status'))
		<div class="alert alert-success" id="err_msg">
			<p style="color: #000;">{{session('status')}}<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></p>
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
	<h2>{{ __('Send your Inquiry') }}</h2>
	<div class="spn-brdr"><span class="border-btm"></span></div>
	<p><p>{{ __('Get Help with our customer service that never failed your expectations') }}</p>
	<table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-page rw-urid-1940"></div></div></td></tr></table></p>
	<div class="contact-block">
		<div class="container">
			<div role="form" class="wpcf7" id="wpcf7-f199-o1" lang="en-US" dir="ltr">
				<div class="screen-reader-response"></div>
				<form action="{{route('contact-enquiry-save')}}" method="post" class="wpcf7-form">
					@csrf()
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<span class="wpcf7-form-control-wrap your-name"><input type="text" name="enquiry_fname" value="{{old('enquiry_fname')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required cname" aria-required="true" aria-invalid="false" placeholder="{{__('First Name')}}"  required /></span>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<span class="wpcf7-form-control-wrap your-name"><input type="text" name="enquiry_lname" value="{{old('enquiry_lname')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-validates-as-required cname" aria-required="true" aria-invalid="false" placeholder="{{__('Last Name')}}"  required /></span>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<span class="wpcf7-form-control-wrap your-email"><input type="email" name="enquiry_email" value="{{old('enquiry_email')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-email wpcf7-validates-as-required wpcf7-validates-as-email" aria-required="true" aria-invalid="false" placeholder="{{__('Email Address')}}"  required /></span>
						</div>
						<div class="col-sm-12 col-md-6 col-lg-6">
							<span class="wpcf7-form-control-wrap your-mobile"><input type="tel" name="enquiry_mobile" onkeypress='validate(event)' value="{{old('enquiry_mobile')}}" size="40" class="wpcf7-form-control wpcf7-text wpcf7-tel wpcf7-validates-as-required wpcf7-validates-as-tel" aria-required="true" aria-invalid="false" placeholder="{{__('Phone Number')}}"  required /></span>
						</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<span class="wpcf7-form-control-wrap your-message"><textarea name="enquiry_message" cols="40" rows="10" class="wpcf7-form-control wpcf7-textarea" aria-invalid="false" placeholder="{{__('Message')}}" required>{{old('enquiry_message')}}</textarea></span>
						</div>
					
<div class="col-sm-12 col-md-12 col-lg-12 g-recaptcha" id="feedback-recaptcha"
data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
</div>
						<div class="col-sm-12 col-md-12 col-lg-12">
							<input type="submit" value="{{__('Send Message')}}" class="wpcf7-form-control wpcf7-submit" />
						</div>
					</div>
					<div class="wpcf7-response-output wpcf7-display-none"></div></form></div> 		</div>
				</div>
			</div>
				<script>
								 $( document ).ready(function() {
                                            $( ".cname" ).keypress(function(e) {
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