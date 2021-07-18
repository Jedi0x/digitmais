
	

	    // Task Pdf code her
    $('body').on('click', '#buy_offer', function() {
        var service_id = $(this).data('offer');

        var result = `<input type='hidden' name='offer_id' value='`+service_id+`' >`;
        $("#hidden_feilds").html(result);
        $("#subscriptionProduct").modal('show');
     
    });
$(document).ready(function () {



	$("#search-form").submit(function(e) {
		
		if($('#search-input').val() != ''){
			window.location = base_url+'service/results/'+$('#search-input').val();
		}
		return false;
	});
	
	$('.responsive').slick({
        infinite: true,
        speed: 100,
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
         dots: false,
         fade: false,
         autoplay: false
});
// 	 $('.view').slick({
//   dots: true,
//   infinite: true,
//   speed: 100,
//   slidesToShow: 1,
//   slidesToScroll: 1,
//   dots: false,
//   autoplay: false,
//   fade: false,
//   responsive: [
//     {
//       breakpoint: 1024,
//       settings: {
//         slidesToShow: 3,
//         slidesToScroll: 3,
//         infinite: true
//       }
//     },
//     {
//       breakpoint: 600,
//       settings: {
//         slidesToShow: 2,
//         slidesToScroll: 2
//       }
//     },
//     {
//       breakpoint: 480,
//       settings: {
//         slidesToShow: 1,
//         slidesToScroll: 1
//       }
//     }
//   ]
// });


    

	
	/* index */
	// $('.recent-slider').slick({
	// 	slidesToShow: 4,
	// 	slidesToScroll: 1,
	// 	arrows: true,
	// 	fade: false,
	// 	responsive: [{
	// 			breakpoint: 1099,
	// 			settings: {
	// 				slidesToShow: 4,
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 1024,
	// 			settings: {
	// 				slidesToShow: 3,
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 600,
	// 			settings: {
	// 				slidesToShow: 1,
	// 			}
	// 		}

	// 	]
	// });

	$('.freelance-slider').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: true,
		fade: false,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});
	$('.service-slider').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		fade: false,
		responsive: [{
				breakpoint: 1099,
				settings: {
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
				}
			}

		]
	});

	/* web design */
	$(function () {
		$('.aniimated-thumbnials').lightGallery({
			thumbnail: true,
		});

		$('.slider-for').slick({
			slidesToShow: 1,
			slidesToScroll: 1,
			arrows: true,
			fade: true,
			adaptiveHeight: true,
			asNavFor: '.slider-nav'
		});

		$('.recommend').slick({
			slidesToShow: 2,
			slidesToScroll: 1,
			arrows: true,
			fade: false,
		});



	});
	/* profile */

	/* wireframe */
	// $('#aniimated-thumbnials').lightGallery({
	// 	thumbnail: true,
	// });

	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		fade: true,
		adaptiveHeight: true

	});

	$('.recommend').slick({
		slidesToShow: 2,
		slidesToScroll: 1,
		arrows: true,
		fade: false,
		responsive: [{
				breakpoint: 767,
				settings: {
					slidesToShow: 1,
				}
			}

		]
	});

	// $(".view").not('.slick-initialized').slick({
	// 	slidesToShow: 4,
	// 	slidesToScroll: 1,
	// 	arrows: true,
	// 	fade: false,
	// 	responsive: [{
	// 			breakpoint: 1099,
	// 			settings: {
	// 				slidesToShow: 4,
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 1024,
	// 			settings: {
	// 				slidesToShow: 2,
	// 			}
	// 		},
	// 		{
	// 			breakpoint: 600,
	// 			settings: {
	// 				slidesToShow: 1,
	// 			}
	// 		}

	// 	]
	// });

	


});