@extends('front-end.layouts.front-layout')
@section('content')
@php
$getPath = "assets/uploads/banner/".$fetchMainContent->about_page_banner_image;
@endphp
<style type="text/css">
	.our-team {background: #ffffff !important;}.our-team h5, .our-team h3, .our-team p, .our-team .our-teams h4 {color: #171d29 !important;}.our-team h3 {font-family: 'Glegoo', serif !important;text-transform: uppercase;font-size: 40px;line-height: 1.4em;}
</style>
<div class="banner" style="background-image: linear-gradient(120deg,#000000 0%,rgba(0,0,0,0) 53%),url('{{@$getPath}}')!important;">
	<div class="slider_overLay"></div>
	<div class="container">
		<div class="banner-title" data-aos="zoom-in" data-aos-duration="1200">
			<h1>{{ @__($fetchMainContent->about_us_pagetitle) }}</h1>
			<h5>{!! wordwrap(@__($fetchMainContent->about_page_meta_description), 50, "<br />\n") !!}</h5>
		</div>
	</div>
</div>
<!-- **** -->
<div class="abt-cmpy" data-aos="fade-up" data-aos-duration="3000">
	<div class="container">
		<h2>{{ @__($fetchMainContent->about_content_main_title) }}</h2>
		<div class="spn-brdr"><span class="border-btm"></span></div>
		<p>{!! @__($fetchMainContent->about_content_description) !!}</p>
		<table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-page rw-urid-660"></div></div></td></tr></table>	</div>
	</div>
	<!-- *** -->
	<div class="our-team">
		<div class="container">
			<h5>{{__('EXPERTS')}}</h5>
			<h3>{{ @__($fetchMainContent->about_content_meet_team_title) }}</h3>
			
			<div class="row our-teams">
				
				@foreach($fetchTeam as $fetchTeams)
					<div class="col-sm-12 col-md-6 col-lg-4" data-aos-duration="1500">
						<img src="{{url('assets/uploads/team/'.$fetchTeams->team_member_image)}}" alt="h">
						<h4>{{ @__($fetchTeams->team_member_name)}}</h4>
						<h6>{{ @__($fetchTeams->team_member_designation)}}</h6>
					</div>
				@endforeach

			</div>
		</div>
	</div>
	<!-- **** -->
	<div class="our-clients" data-aos="fade-down" data-aos-duration="3000">
		<div class="container">
			<h2>{{__('Our Prestigious Clients')}}</h2>
			<div class="spn-brdr"><span class="border-btm"></span></div>
			<div class="clients-list">
				<div class="owl1 owl-carousel owl-theme" id="clientSlider"> {{-- class =  owl1 owl-carousel owl-theme  - not working--}}
					
					@foreach($fetchClient as $fetchClients)
					<div class="item">
						<h4><table class="rw-rating-table rw-ltr rw-left rw-no-labels"><tr><td><nobr>&nbsp;</nobr></td><td><div class="rw-left"><div class="rw-ui-container rw-class-blog-post rw-urid-920" data-img="{{url('assets/uploads/client/'.@$fetchClients->client_logo)}}"></div></div></td></tr></table></h4>
						<img src="{{url('assets/uploads/client/'.@$fetchClients->client_logo)}}" alt="img">
					</div>
					@endforeach
					
						
					</div>
				</div>
			</div>
		</div>
	</div>
		<!-- ********* -->
		<script type="text/javascript">		
			$("#clientSlider").owlCarousel({
    		navigation : true
  			});
  		</script>

		@endsection