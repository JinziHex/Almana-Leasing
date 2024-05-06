$( "li" ).add( "<p id='new'>new paragraph</p>" );



     
 

        $( document ).ready(function() {
              
            $('body').addClass('home-bpage');
        });

        $( document ).ready(function() {
            $('body').addClass('inner-bpage');
        });

	$( document ).ready(function() {
	   //alert("test");
		$('#clientSlider').owlCarousel({
			items:3,
	        loop:true,
	        margin:10,
	        nav:true,
	        dots:true,
	        autoplay:true,
    	    responsive:{
    	        0:{
    	            items:1
    	        },
    	        600:{
    	            items:2
    	        },
    	        1000:{
    	            items:3
    	        }
    	    }
	    })
	    if($('body').hasClass('page-template-homepage')) {
	        //alert("Home");
	        $('body').addClass('home-bpage');
        } else {
            //alert("Inner");
    	    $('body').addClass('inner-bpage');
        }


 

	});
	

	$(".rw-rating-table.rw-ltr.rw-left.rw-no-labels").each(function() {
    $(this).parent().prepend(this);
});



$(function(){

    var url = window.location.pathname, 
        urlRegExp = new RegExp(url.replace(/\/$/,'/') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
        // now grab every link from the navigation
        $('#mobmenuright li a').each(function(){
            // and test its normalized href against the url pathname regexp
            if(urlRegExp.test(this.href.replace(/\/$/,'/'))){

                //  $("#mobmenuright li").removeClass('current-menu-item');
                
                $(this).parent("#mobmenuright li").addClass('current-menu-item').append("<span></span>");
            }
        });
        $('.home  #mobmenuright li').removeClass('current-menu-item');
        $('.home  #mobmenuright li.menu-item-home').addClass('current-menu-item');
});


    
        $(document).ready(function(){
            // alert("test");
            // $('.home  #mobmenuright li').removeClass('current-menu-item');
            // $('.home  #mobmenuright li.menu-item-home').addClass('current-menu-item');
        });
        



$( ".current-menu-item" ).append( "<span></span>" );




	$(document).ready(function() {
  
		
});




	$( document ).ready(function () {
		$(".jobs-listing").slice(0, 6).show();
		if ($(".jobs-listing:hidden").length != 0) {
			$("#loadMore").show();
		}		
		$("#loadMore").on('click', function (e) {
			e.preventDefault();
			$(".jobs-listing:hidden").slice(0, 4).slideDown();
			if ($(".jobs-listing:hidden").length == 0) {
				$("#loadMore").fadeOut('slow');	
			}
		});
	});





	$(document).ready(function(){
		$(".jobs-listing").click(function(){
		   	$(".toggle-form").toggle(500);
		   	$('html, body').animate({
		      scrollTop: $(".toggle-form").offset().top
		    }, 1500)
		});
	});


$(".list-cars .blocks:first").attr("data-aos","fade-right");
$(".list-cars .blocks:last").attr("data-aos","fade-left");
$(".list-cars .blocks:nth-child(2n)").attr("data-aos","zoom-in");
$(".list-cars .blocks:nth-child(3n)").attr("data-aos","zoom-out");
$(".list-cars .blocks:nth-child(4n)").attr("data-aos","fade-up");



$(".our-team .col-md-6:first").attr("data-aos","fade-right");
$(".our-team .col-md-6:last").attr("data-aos","fade-left");
$(".our-team .col-md-6:nth-child(2n)").attr("data-aos","zoom-in");
$(".our-team .col-md-6:nth-child(3n)").attr("data-aos","zoom-out");


$(".offers-list .col-md-6:first").attr("data-aos","fade-right");
$(".offers-list .col-md-6:last").attr("data-aos","fade-left");
$(".offers-list .col-md-6:nth-child(2n)").attr("data-aos","fade-left");
$(".offers-list .col-md-6:nth-child(3n)").attr("data-aos","zoom-out");



$(".jobs .jobs-listing:nth-child(2n)").attr("data-aos","zoom-in");
$(".jobs .jobs-listing:nth-child(3n)").attr("data-aos","zoom-out");


// $(".home .section2 .col-md-6:first").attr("data-aos","flip-down");
// $(".home .section2 .col-md-6:last").attr("data-aos","flip-in");
// $(".home .section2 .col-md-6:nth-child(2n)").attr("data-aos","zoom-out");
// $(".home .section2 .col-md-6:nth-child(3n)").attr("data-aos","flip-down");







  AOS.init();

	$( ".inqform .wpcf7-submit" ).hover(
  function() {
    $( this ).addClass( "shadow-drop-2-center" );
  }, function() {
    $( this ).removeClass( "shadow-drop-2-center" );
  }
);	


$( ".btn.buTTon" ).hover(
  function() {
    $( this ).addClass( "shadow-drop-2-center" );
  }, function() {
    $( this ).removeClass( "shadow-drop-2-center" );
  }
);	


$( "#contactForm .btn" ).hover(
  function() {
    $( this ).addClass( "rotate-diagonal-2" );
  }, function() {
    $( this ).removeClass( "rotate-diagonal-2" );
  }
);



$( ".home .section2 .thumbnail a.btn-primary" ).hover(
  function() {
    $( this ).addClass( "rotate-center" );
  }, function() {
    $( this ).removeClass( "rotate-center" );
  }
);



$( ".section3 .list-cars .blocks .caption .right-wrap" ).hover(
  function() {
    $( this ).addClass( "rotate-hor-center" );
  }, function() {
    $( this ).removeClass( "rotate-hor-center" );
  }
);



$( ".home .section2 .col-md-6 .serv-img" ).hover(
  function() {
    $( this ).addClass( "rotate-hor-center" );
  }, function() {
    $( this ).removeClass( "rotate-hor-center" );
  }
);


$( ".footer-meunus .footer-wrap .ft3 li" ).hover(
  function() {
    $( this ).addClass( "rotate-scale-down-ver" );
  }, function() {
    $( this ).removeClass( "rotate-scale-down-ver" );
  }
);


	var valueSelected

	$('#list-open').on('change', function (e) {
    var optionSelected = $("option:selected", this);
   valueSelected = this.value;
    // alert(valueSelected);

    var url = window.location.href; 

var lastthree = url.slice(-3); // => "Tabs1"



if (lastthree == "USD" || lastthree == "EUR" || lastthree == "QAR" ) {
var url = url.replace(lastthree,'');
// alert(url);
}
var lastten = url.slice(-10);

if (lastten == "?currency=" || lastten == "&currency="  ) {
var url = url.replace(lastten,'');
// alert(url);
}






if (url.indexOf('?') > -1){



   url += "&currency=" + valueSelected;
}
else {
   url += "?currency=" + valueSelected;
}



window.location.href = url;


  
});


// 	$( document ).ready(function() {
// 	   var date = new Date();

// // add a day

//     document.getElementById("datess").valueAsDate =date.setDate(date.getDate() + 1);;
// });


	// Declare variables
var today = new Date();
var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);


// Set values
$("#dates").val(getFormattedDate(today));
$("#datess").val(getFormattedDate(tomorrow));



// Get date formatted as YYYY-MM-DD
function getFormattedDate (date) {
    return date.getFullYear()
        + "-"
        + ("0" + (date.getMonth() + 1)).slice(-2)
        + "-"
        + ("0" + date.getDate()).slice(-2);
}




function handler(e){
 var v = e.target.value;
 //alert(v);
var anydate = new Date(v);
var t = new Date(anydate.getTime() + 24 * 60 * 60 * 1000);
//alert(t);
$("#theTomorrow").val(getFormattedDate(tomorrow));
$("#datess").val(getFormattedDate(t));
}


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

    $(document).ready(function(){
      
      $('#city_id').change(function(){
        var cityId = $(this).val();
        //alert(cityId);
        $.ajax({
          type: "POST",
          url: "<?php echo get_option('home'); ?>/getlocations.php",
          data: {cityId:cityId},
          success: function (data) {
            // alert(data);
            $('#hexLocationOuter').html(data);
          },
          error: function () {
            alert("Server Error! Please try again later.");
          }
        });
      });
      $('.slider').bxSlider();
      
      
    });
