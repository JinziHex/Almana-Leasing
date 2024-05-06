@extends('front-end.layouts.web-layout')
@section('content')
@php
$getPath = "assets/uploads/banner/".$fetchBanner->page_banner_image;
@endphp
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
<div class="offers-list">
	<div class="container">
		<h2>Current Offers</h2>
		<div class="spn-brdr"><span class="border-btm"></span></div>
		<div class="offer-list-items">
			<div class="row">

				@foreach($fetchContent as $fetchContents)

				<div class="col-sm-12 col-md-6 col-lg-4" data-aos-duration="1200">
					<a href="#!"><img src="{{url('/assets/uploads/offers/'.$fetchContents->offer_image)}}"></a>
				</div>

				@endforeach
				
				
			</div>
		</div>
	</div>
</div>
@endsection