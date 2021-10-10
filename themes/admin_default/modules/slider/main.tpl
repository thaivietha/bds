<!-- BEGIN: main -->
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="w100 text-center">&nbsp;</th>
				<th class="w150 text-center">&nbsp;</th>
				<th>{LANG.title}</th>
				<th class="w150 text-center">{LANG.status}</th>
				<th class="w150 text-center">{LANG.function}</th>
			</tr>
		</thead>
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center">
					<select id="change_weight_{ROW.id}" onchange="nv_change_row_weight('{ROW.id}');" class="form-control">
						<!-- BEGIN: weight -->
						<option value="{WEIGHT.w}"{WEIGHT.selected}>{WEIGHT.w}</option>
						<!-- END: weight -->
					</select>
				</td>
				<td><img class="img-thumbnail img-responsive" src="{ROW.image_thumb}"></td>
				<td>
					<strong>{LANG.content_title}:</strong> {ROW.title}
					<div class="clearfix"><strong>{LANG.content_description}:</strong> {ROW.description}</div>
					<div class="clearfix">
						<strong>{LANG.content_link_href1}:</strong> <em class="fa fa-{ROW.link_icon}"></em> {ROW.link_href}
					</div>
				</td>
				<td class="text-center">
					<input name="status" id="change_status{ROW.id}" value="1" type="checkbox"{ROW.status_render} onclick="nv_change_status('{ROW.id}');" />
				</td>
				<td class="text-center">
					<em class="fa fa-edit fa-lg">&nbsp;</em> <a href="{ROW.url_edit}">{GLANG.edit}</a> &nbsp;
					<em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="javascript:void(0);" onclick="nv_del_row('{ROW.id}');">{GLANG.delete}</a>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: main -->