// car box spec more
$(document).ready(function(){

	var count = $(".carSpecs > p").length;
	
	if (count > 5) {
	    // $('.specMorBtn').show();
	    $('.specMorBtn').css("visibility", "visible");
	} else {
	    // $('.specMorBtn').hide();
	    $('.specMorBtn').css("visibility", "hidden");
	}

	$(".carSpecs").filter(function () {
        return $(this).find('p').length < 5
    }).addClass("short");
	$(".carSpecs.short").closest('.car-box1').children('.specMorBtn').css("visibility", "hidden");

	// $('.carSpecs p').hide();
	// $('.carSpecs p:lt(3)').show();
	$('.carSpecs').each(function() {
	  $(this).children().slice(5).hide(); 
	});

	$(".specMorBtn").click(function(){
	  $(this).closest('.car-box1').children('.carSpecs').addClass("all-spec");
	  $(this).hide();
	});

});

// end car box spec more


