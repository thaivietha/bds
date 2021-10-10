<!-- BEGIN: main -->
<form action="" method="post" class="form-horizontal">
	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_system}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_home_type}</strong></label>
				<div class="col-sm-20">
					<select class="form-control" name="home_type">
						<!-- BEGIN: home_type -->
						<option value="{HOME_TYPE.index}"{HOME_TYPE.selected}>{HOME_TYPE.value}</option>
						<!-- END: home_type -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_per_page}</strong></label>
				<div class="col-sm-20">
					<input type="text" name="per_page" value="{DATA.per_page}" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_money_unit}</strong></label>
				<div class="col-sm-20">
					<select name="money_unit" class="form-control">
						<!-- BEGIN: money_loop -->
						<option value="{DATAMONEY.value}"{DATAMONEY.selected}>{DATAMONEY.title}</option>
						<!-- END: money_loop -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_structupload}</strong></label>
				<div class="col-sm-20">
					<select class="form-control" name="structure_upload" id="structure_upload">
						<!-- BEGIN: structure_upload -->
						<option value="{STRUCTURE_UPLOAD.key}"{STRUCTURE_UPLOAD.selected}>{STRUCTURE_UPLOAD.title}</option>
						<!-- END: structure_upload -->
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-5 col-md-4 control-label"><strong>{LANG.config_no_image}</strong></label>
				<div class="col-sm-19 col-md-20">
					<div class="input-group">
						<input class="form-control" type="text" name="no_image" value="{DATA.no_image}" id="id_image" /> <span class="input-group-btn">
							<button class="btn btn-default selectfile" type="button">
								<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 text-right"><strong>{LANG.config_groups_booking_sendmail}</strong></label>
				<div class="col-sm-20" style="height: 200px; overflow: scroll; border: solid 1px #ddd; padding: 10px">
					<!-- BEGIN: booking_groups_sendmail -->
					<label class="show"><input type="checkbox" name="booking_groups_sendmail[]" value="{GROUPS_BOOKING_SENDMAIL.value}" {GROUPS_BOOKING_SENDMAIL.checked} />{GROUPS_BOOKING_SENDMAIL.title}</label>
					<!-- END: booking_groups_sendmail -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_format_code}</strong></label>
				<div class="col-sm-20">
					<input type="text" name="format_code" value="{DATA.format_code}" class="form-control" />
				</div>
			</div>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">{LANG.config_booking}</div>
		<div class="panel-body">
			<div class="form-group">
				<label class="col-sm-4 text-right"><strong>{LANG.config_booking_groups}</strong></label>
				<div class="col-sm-20" style="height: 200px; overflow: scroll; border: solid 1px #ddd; padding: 10px">
					<!-- BEGIN: booking_groups -->
					<label class="show"><input type="checkbox" name="booking_groups[]" value="{GROUPS_BOOKING.value}" {GROUPS_BOOKING.checked} />{GROUPS_BOOKING.title}</label>
					<!-- END: booking_groups -->
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-4 control-label"><strong>{LANG.config_format_booking_code}</strong></label>
				<div class="col-sm-20">
					<input type="text" name="format_booking_code" value="{DATA.format_booking_code}" class="form-control" />
				</div>
			</div>
		</div>
	</div>
	<div class="text-center">
		<input type="submit" class="btn btn-primary" value="{LANG.save}" name="savesetting" />
	</div>
</form>
<script type="text/javascript">
	$(".selectfile").click(function() {
		var area = "id_image";
		var path = "{NV_UPLOADS_DIR}/{MODULE_UPLOAD}";
		var currentpath = "{CURRENTPATH}";
		var type = "image";
		nv_open_browse(script_name + "?" + nv_name_variable
				+ "=upload&popup=1&area=" + area + "&path="
				+ path + "&type=" + type + "&currentpath="
				+ currentpath, "NVImg", 850, 420,
				"resizable=no,scrollbars=no,toolbar=no,location=no,status=no");
		return false;
	});
</script>
<!-- BEGIN: main -->