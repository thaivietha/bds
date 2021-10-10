<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-danger">{ERROR}</div>
<!-- END: error -->
<form method="post" action="{FORM_ACTION}">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<col class="w200"/>
			<tbody>
				<tr>
					<td class="text-right text-strong">{LANG.content_image}<span class="fa-required text-danger">(<em class="fa fa-asterisk"></em>)</span></td>
					<td>
						<div class="input-group w500">
							<input type="text" id="post-image" name="image" value="{DATA.image}" class="form-control">
							<span class="input-group-btn">
								<button data-path="{UPLOADS_DIR}" data-currentpath="{UPLOADS_DIR_CURRENT}" id="select-image" class="btn btn-default" type="button"><i class="fa fa-file-image-o"></i></button>
							</span>
						</div>
					</td>
				</tr>
				<tr>
					<td class="text-right text-strong">{LANG.content_title}</td>
					<td>
						<input type="text" id="idtitle" name="title" value="{DATA.title}" class="form-control w500">
					</td>
				</tr>
				<tr>
					<td class="text-right text-strong">{LANG.content_link_href}</td>
					<td>
						<input type="text" name="link_href" value="{DATA.link_href}" class="form-control w500">
					</td>
				</tr>
				<tr>
					<td class="text-right text-strong">{LANG.content_link_target}</td>
					<td>
						<select name="link_target" class="form-control w300">
							<!-- BEGIN: link_target --><option value="{LINK_TARGET.key}"{LINK_TARGET.selected}>{LINK_TARGET.title}</option><!-- END: link_target -->
						</select>
					</td>
				</tr>
				<tr>
					<td class="text-right text-strong">{LANG.content_description}</td>
					<td>
						<textarea name="description" class="form-control" rows="5">{DATA.description}</textarea>
					</td>
				</tr>
				<tr>
					<td class="text-right text-strong">{LANG.status}</td>
					<td>
						<input type="checkbox" name="status" value="1"{DATA.status}/>
					</td>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="{DATA.id}">
						<input type="submit" name="submit" value="{GLANG.submit}" class="btn btn-primary">
					</td>
				</tr>
			</tfoot>
		</table>
	</div>
</form>
<!-- END: main -->