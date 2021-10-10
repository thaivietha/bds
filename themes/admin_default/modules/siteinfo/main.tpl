<!-- BEGIN: main -->
<!-- BEGIN: updateinfo -->
<div class="alert alert-info text-center" id="infodetectedupg">
	<p>{LANG.update_package_detected}</p>
	<strong><a href="{URL_UPDATE}" title="{LANG.update_package_do}">{LANG.update_package_do}</a></strong>
	 - 
	<strong><a href="{URL_DELETE_PACKAGE}" title="{LANG.update_package_delete}" class="delete_update_backage">{LANG.update_package_delete}</a></strong>
</div>
<!-- END: updateinfo -->
<!-- BEGIN: pendinginfo -->
<h3><em class="fa fa-clock-o">&nbsp;</em><strong>{LANG.pendingInfo}</strong></h3>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>{LANG.moduleName}</th>
				<th>{LANG.moduleContent}</th>
				<th>{LANG.moduleValue}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td>{MODULE}</td>
				<td>
				<!-- BEGIN: link -->
				<a class="link" href="{LINK}" title="{KEY}">{KEY}</a>
				<!-- END: link -->
				<!-- BEGIN: text -->
				{KEY}
				<!-- END: text -->
				</td>
				<td class="aright">{VALUE}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: pendinginfo -->
<!-- BEGIN: info -->
<h3><em class="fa fa-info">&nbsp;</em><strong>{LANG.moduleInfo}</strong></h3>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th>{LANG.moduleName}</th>
				<th>{LANG.moduleContent}</th>
				<th class="aright">{LANG.moduleValue}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td>{MODULE}</td>
				<td>
				<!-- BEGIN: link -->
				<a class="link" href="{LINK}" title="{KEY}">{KEY}</a>
				<!-- END: link -->
				<!-- BEGIN: text -->
				{KEY}
				<!-- END: text -->
				</td>
				<td>{VALUE}</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: info -->
<!-- END: main -->