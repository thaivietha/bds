<!-- BEGIN: main -->
{FILE "header_only.tpl"}
{FILE "header_extended.tpl"}
<section class="section-body">
	<div class="container">
		<div class="wraper">
			<div class="row">
				<div class="col-sm-16 col-md-16">
					[TOP]
					{MODULE_CONTENT}
					[BOTTOM]
				</div>
				<div class="col-sm-8 col-md-8">
					[RIGHT]
				</div>
			</div>
		</div>
	</div>
</section>
{FILE "footer_extended.tpl"}
{FILE "footer_only.tpl"}
<!-- END: main -->