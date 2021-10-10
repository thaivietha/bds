<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<div class="panel panel-default">
	<div class="panel-body">
		<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
			<input type="hidden" name="id" value="{ROW.id}" />
			<div class="form-group">
				<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.title}</strong> <span class="red">(*)</span></label>
				<div class="col-sm-19 col-md-21">
					<input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.image}</strong></label>
				<div class="col-sm-19 col-md-21">
					<div class="input-group">
						<input class="form-control" type="text" name="image" value="{ROW.image}" id="id_image" /> <span class="input-group-btn">
							<button class="btn btn-default selectfile" type="button">
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-3 control-label"><strong>Website</strong></label>
				<div class="col-sm-19 col-md-21">
					<input class="form-control" type="url" name="website" value="{ROW.website}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-3 control-label"><strong>{LANG.description_html}</strong></label>
				<div class="col-sm-19 col-md-21">{ROW.description}</div>
			</div>
			<div class="form-group" style="text-align: center">
				<input class="btn btn-primary loading" name="submit" type="submit" value="{LANG.save}" />
			</div>
		</form>
	</div>
</div>

<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
</script>

<script type="text/javascript">
	//<![CDATA[
	$("#birthday").datepicker({
		dateFormat : "dd/mm/yy",
		changeMonth : true,
		changeYear : true,
		showOtherMonths : true,
	});

	$(".selectfile").click(function() {
		var area = "id_image";
		var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/investor";
		var currentpath = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}/investor";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable
				+ "=upload&popup=1&area=" + area + "&path="
				+ path + "&type=" + type + "&currentpath="
				+ currentpath, "NVImg", 850, 420,
				"resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});

	//]]>
</script>
<!-- END: main -->