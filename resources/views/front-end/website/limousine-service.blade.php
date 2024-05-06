@extends('front-end.layouts.web-layout')
@section('content')
@php
if ($fetchBanner->service_image_1) {
$getPath =  "/assets/uploads/service/".$fetchBanner->service_image_1;
}
@endphp
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<!-- img src="" alt=""> -->
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ __(@$fetchBanner->service_title) }}</h1>
			<!--<h5>{!! wordwrap(@$fetchBanner->service_description, 50, "<br />\n") !!}</h5>-->
		</div>
	</div>
</div>
<!-- **** -->
<div class="container">
	<div id="po-content" class="widecolumn">
		<div class="po-post" id="post-347">
			
			<div class="fea-img">
				<img src="{{url('assets/uploads/page-data/1659693163.jpg')}}" alt="">
			</div>
			<div class="po-entry">
				<h1 class="po-title">{{ __(@$fetchBanner->service_title) }}</h1>
				<p>{{__(@$fetchBanner->service_description)}}</p>
				<table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-page rw-urid-3480" data-img="{{url('assets/uploads/page-data/'.@$fetchBanner->page_content_image)}}"></div></div></td></tr></table>
			</div>
		</div>
		
	</div>
</div>
@endsection