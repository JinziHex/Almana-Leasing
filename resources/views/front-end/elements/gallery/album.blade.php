@extends('front-end.layouts.front-layout') 
@section('content')
	<section class="container tabbedGallery">
	<!-- tab -->
		<div class="tab">
		  @foreach($albums as $key=>$album)
		  <button class="tablinks-tab" onclick="openTab(event, 'tab{{$album->id}}')" id="defaultOpen{{$key}}">{{$album->title}}</button>
		  @endforeach
		</div>

        @foreach($albums as $key=>$album)
		<div id="tab{{$album->id}}" class="tabcontent-tab">
			<!-- tab gallery -->
			    @if($album->photos)
			    <div class="row gallery">
			    @foreach($album->photos as $photo)
					<div class="col-lg-3 col-md-4 col-xs-6 thumb">
						<a href="{{url('assets/uploads/album/photo/'.$photo->photo_image)}}">
							<h3> {{$photo->photo_title}} </h3>
							<figure><img class="img-fluid img-thumbnail" src="{{url('assets/uploads/album/photo/'.$photo->photo_image)}}" alt="Random Image"></figure>
						</a>
					</div>
				@endforeach
				</div>
				@endif
				<!--  -->
		</div>
		 @endforeach
	</section>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.5/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>	

<script type="text/javascript">
	$(document).ready(function() {
		$(".gallery").magnificPopup({
			delegate: "a",
			type: "image",
			tLoading: "Loading image #%curr%...",
			mainClass: "mfp-img-mobile",
			gallery: {
				enabled: true,
				navigateByImgClick: true,
				preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
			},
			image: {
				tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
			}
		});
	});

</script>

<script>
    function openTab(evt, tabName) {
        
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent-tab");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks-tab");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active-tab", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active-tab";
    }
    
    // Get the element with id="defaultOpen" and click on it
    document.getElementById("defaultOpen0").click();
</script>
@endsection