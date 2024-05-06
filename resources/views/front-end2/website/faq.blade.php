@extends('front-end.layouts.web-layout')
@section('content')
@php
if ($fetchBanner->page_banner_image) {
$getPath =  "assets/uploads/banner/".$fetchBanner->page_banner_image;
}
@endphp
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ @__($fetchBanner->page_banner_title) }}</h1>
			<h5>{!! wordwrap(@__($fetchBanner->page_banner_description), 50, "<br />\n") !!}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="container">
	<div id="faq-content" class="widecolumn">

		@foreach($fetchfaqs as $fetchfaqses)

		<button class="accordion">{{ @__($fetchfaqses->faq_question) }}</button>
		<div class="panel">
			<p>{!! @__($fetchfaqses->faq_answer)  !!}</p>
		</div>

		@endforeach
		
	</div>
</div>


<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var panel = this.nextElementSibling;
    if (panel.style.display === "block") {
      panel.style.display = "none";
    } else {
      panel.style.display = "block";
    }
  });
}
</script>
@endsection