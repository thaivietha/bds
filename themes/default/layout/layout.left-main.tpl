<!-- BEGIN: main -->
{FILE "header_only.tpl"}
{FILE "header_extended.tpl"}
<section class="section-body">
	<div class="container">
		<div class="wraper">
			<div class="row">
			    <div class="col-sm-18 col-md-16 col-sm-push-6 col-md-push-8">
			        [TOP]
			        {MODULE_CONTENT}
			        [BOTTOM]
			    </div>
				<div class="col-sm-6 col-md-8 col-sm-pull-18 col-md-pull-16">
					[LEFT]
				</div>
			</div>
		</div>
	</div>
</section>
{FILE "footer_extended.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->