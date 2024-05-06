@extends('front-end.layouts.web-layout')
@section('content')
@php
if ($fetchBanner->page_banner_image) {
$getPath =  "assets/uploads/banner/".$fetchBanner->page_banner_image;
}
@endphp
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<!-- img src="" alt=""> -->
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ @$fetchBanner->page_banner_title }}</h1>
			<h5>{!! wordwrap(@$fetchBanner->page_banner_description, 50, "<br />\n") !!}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="container">
	<div id="po-content" class="widecolumn">
		<div class="po-post" id="post-347">
			
			<div class="fea-img">
				<img src="{{url('assets/uploads/page-data/'.@$fetchBanner->page_content_image)}}" alt="">
			</div>
			<div class="po-entry">
				<h1 class="po-title">{{ ucFirst(@$fetchBanner->page_title) }}</h1>
				<p>{!! @$fetchBanner->page_content !!}</p>
				<table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-page rw-urid-3480" data-img="{{url('assets/uploads/page-data/'.@$fetchBanner->page_content_image)}}"></div></div></td></tr></table>
			</div>
		</div>
		
	</div>
</div>
@endsection