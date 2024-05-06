@extends('front-end.layouts.web-layout')
@section('content')
@php
if ($fetchBanner->page_banner_image) {
$getPath =  "assets/uploads/banner/".$fetchBanner->page_banner_image;
}
@endphp
<style type="text/css">
	body,h1,h2,h3,h4,h5,h6{
		font-family: 'Quicksand Light', sans-serif !important;
	}p{font-family: 'Quicksand Light', sans-serif !important;color: #666;font-size: 17px;line-height: 1.8em;}.carmaintainence ul {columns: 2;-webkit-columns: 2;-moz-columns: 2;}.carmaintainence ul li {position: relative;font-family: 'Quicksand Light', sans-serif !important;color: #666;margin: 3% 0;font-size: 15px;line-height: 1.8em;font-weight: 400;padding-left: 27px;margin-bottom: 10px;list-style: none;margin: 0;padding: 10px 10px 10px 27px;}.carmaintainence ul li::before {position: absolute;content: '';display: block;font: normal normal normal 14px/1 FontAwesome;font-size: inherit;text-rendering: auto;-webkit-font-smoothing: antialiased;-moz-osx-font-smoothing: grayscale;transform: translate(0,0);left: 0;top: 18px;content: "\f00c";font-size: 11px;color: #ffc43f;}
</style>
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ @$fetchBanner->page_banner_title }}</h1>
			<h5>{!! wordwrap(@$fetchBanner->page_banner_description, 50, "<br />\n") !!}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="services-list">
	<div class="container">
		
		@foreach($fetchContent as $fetchContents)
		@php
		$fetchTitle = $fetchContents->service_title;
		$splitTitle = explode(" ",$fetchTitle);
		@endphp
		
		<div class="row service-elements">
			<div class="col-sm-12 col-md-8 col-lg-8" data-aos="fade-right" data-aos-duration="1500">
				<h2><span>{{ @$splitTitle[0] }}</span> {{ @$splitTitle[1] }}</h2>
				<div class="content-element">
					<p>{!! ucFirst(@$fetchContents->service_description) !!}</p>
					<h4>{{ strtoupper(@$fetchContents->service_content_title) }}</h4>
					<div class="col-sm-12 col-md-12 col-lg-12 carmaintainence">
						{!! @$fetchContents->service_content_description !!}
					</div>
					
					<table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-blog-post rw-urid-360" data-img="images/icon1.png"></div></div></td></tr></table>
				</div>
			</div>
			<div class="col-sm-12 col-md-4 col-lg-4" data-aos="zoom-in" data-aos-duration="1500">
				<div class="image-block">
					<img src="{{url('/assets/uploads/service/'.@$fetchContents->service_image_1)}}" alt="">
				</div>
				<div class="image-block">
					<img src="{{url('/assets/uploads/service/'.@$fetchContents->service_image_2)}}" alt="">
				</div>
			</div>
		</div>
		@endforeach
		
	</div>
</div>
@endsection