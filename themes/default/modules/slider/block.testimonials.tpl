<!-- BEGIN: main -->
<script>
	$(document).ready(function() { 
	  $(".testimonials").owlCarousel({ 
		autoplay:false,
		autoplayTimeout:4000,
		autoplayHoverPause:true,
		items: 1,
		loop: true,
		nav: false,
		dots: true
	  });
	});
</script>
<div class="owl-carousel owl-theme testimonials">
	<!-- BEGIN: loop -->
	<div class="testimonials-item">
		<div class="avarta">
			<img src="{ROW.image}" alt="{ROW.image_alt}"/>
		</div>
		<h3>{ROW.title}</h3>
		<div class="description">{ROW.description}</div>
	</div>
	<!-- END: loop -->
</div>
<!-- END: main -->