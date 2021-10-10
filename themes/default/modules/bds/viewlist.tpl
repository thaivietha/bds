<!-- BEGIN: main -->
<div class="viewlist">
	<!-- BEGIN: loop -->
	<div class="thumb-item">
		<div class="row">
			<div class="col-xs-24 col-sm-8 col-md-8">
				<div class="thumb-item-image">
					<a href="{ROW.link}" title="{ROW.title}"><img src="{ROW.thumb}" alt="{ROW.title}" ></a>
					<span class="thumb-item-label">
						<!-- BEGIN: price -->
						<span class="price">{PRICE.price}</span>
						<!-- END: price -->
						<!-- BEGIN: contact -->
						<span class="price">{LANG.contact}</span>
						<!-- END: contact -->
					</span>
				</div>
			</div>	
			<div class="col-xs-24 col-sm-16 col-md-16">
				<div class="thumb-item-content">
					<h3><a href="{ROW.link}" title="{ROW.title}">{ROW.title_clean}</a></h3>
					<p>{ROW.description}</p>
				</div>
				<div class="amenities clearfix">
					<div class="pull-left">
						{LANG.area} : {ROW.area} <sup>m<sup>2</sup></sup>
					</div>
					<div class="pull-right">
						<ul>
							<li><i class="icons icons-bedroom"></i>{ROW.bed_room}</li>
							<li><i class="icons icons-bathroom"></i>{ROW.bath_room}</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END: loop -->
</div>
<!-- END: main -->