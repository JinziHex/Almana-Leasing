 const buttonCustom = document.querySelector("button.btn-custom");
   buttonCustom.addEventListener("click", () => {
      buttonCustom.closest("div.container-menu").classList.toggle("active");
   });
/*******************************************************/
    $(document).ready(function() {
      $(".toggle-accordion").on("click", function() {
         var accordionId = $(this).attr("accordion-id"),
            numPanelOpen = $(accordionId + ' .collapse.in').length;
         $(this).toggleClass("active");
         if(numPanelOpen == 0) {
            openAllPanels(accordionId);
         } else {
            closeAllPanels(accordionId);
         }
      })
      openAllPanels = function(aId) {
         console.log("setAllPanelOpen");
         $(aId + ' .panel-collapse:not(".in")').collapse('show');
      }
      closeAllPanels = function(aId) {
         console.log("setAllPanelclose");
         $(aId + ' .panel-collapse.in').collapse('hide');
      }
   });

    /*******************************************************/


     $('input').on('blur', function() {
      $(this).next('input').removeClass('button-on');
   }).on('focus', function() {
      $(this).next('input').addClass('button-on');
   });

   /*******************************************/

    $('input').on('blur', function() {
      $(this).next('input').removeClass('button-on');
   }).on('focus', function() {
      $(this).next('input').addClass('button-on');
   });


 /*******************************************************/

   $('.owl-carousel').owlCarousel({
      loop: true,
      margin: 10,
      navText: ["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
      nav: true,
      responsive: {
         0: {
            items: 1
         },
         600: {
            items: 3
         },
      }
   })


 /*******************************************************/

    $(document).ready(function() {
      $("#news-slider").owlCarousel({
         items: 3,
         itemsDesktop: [1199, 3],
         itemsDesktopSmall: [980, 2],
         itemsMobile: [600, 1],
         navigation: true,
         navigationText: ["", ""],
         pagination: true,
         autoPlay: true
      });
   });