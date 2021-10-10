<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/owl.carousel.min.css">
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/owl.carousel.min.js"></script>

<script>
	$(document).ready(function() { 
	  $(".branditems").owlCarousel({ 
		autoplay:true,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
		loop: true,
		margin: 10,
		responsiveClass:true,
		responsive:{
	        0:{
	            items:2
	        },
	        600:{
	            items:3
	        },
	        1000:{
	            items:6
	        }
	    }
	  });
	});
</script>
<div class="owl-carousel owl-theme branditems">
	<!-- BEGIN: loop -->
	<div class="item">
		<div class="box-img">
			<img src="{ROW.image}" alt="{ROW.image_alt}"/>
		</div>
	</div>
	<!-- END: loop -->
</div>
<!-- END: main -->