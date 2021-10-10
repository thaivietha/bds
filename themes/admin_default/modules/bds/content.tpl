<!-- BEGIN: main -->
<div class="bds-content">
	<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

	<!-- BEGIN: error -->
	<div class="alert alert-warning">{ERROR}</div>
	<!-- END: error -->

	<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
		<input type="hidden" name="id" value="{ROW.id}" />
		<div class="row">
			<div class="col-md-18">
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.bds_info}</div>
					<div class="panel-body">
						<div class="form-group">
							<input class="form-control" type="text" name="title" value="{ROW.title}" placeholder="{LANG.title}" required="required" />
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-19 col-md-22">
									<input class="form-control" type="text" name="alias" value="{ROW.alias}" placeholder="{LANG.alias}" id="id_alias" />
								</div>
								<div class="col-sm-4 col-md-2">
									<i class="fa fa-refresh fa-lg icon-pointer" onclick="nv_get_alias('id_alias');">&nbsp;</i>
								</div>
							</div>
						</div>
						<div class="form-group">
							<input class="form-control" type="text" name="title_custom" value="{ROW.title_custom}" placeholder="{LANG.custom_title}"/>
						</div>
						<div class="form-group">
							<select name="catid" class="form-control">
								<option value=0>---{LANG.cat_c}---</option>
								<!-- BEGIN: cat -->
								<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
								<!-- END: cat -->
							</select>
						</div>
						<div class="form-group">
							<input class="form-control" type="text" name="code" value="{ROW.code}" placeholder="{LANG.code}"/>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<input type="number" name="area" class="form-control" value="{ROW.area}" pattern="^[0-9]*$" oninvalid="setCustomValidity( nv_digits )" oninput="setCustomValidity('')" required="required" placeholder="{LANG.area}"/>
								</div>
								<div class="col-sm-12 col-md-6">
									<input type="number" name="room" class="form-control" value="{ROW.room}" pattern="^[0-9]*$" placeholder="{LANG.room}"/>
								</div>
								<div class="col-sm-12 col-md-6">
									<input type="number" name="bed_room" class="form-control" value="{ROW.bed_room}" pattern="^[0-9]*$" placeholder="{LANG.bed_room}"/>
								</div>
								<div class="col-sm-12 col-md-6">
									<input type="number" name="bath_room" class="form-control" value="{ROW.bath_room}" pattern="^[0-9]*$" placeholder="{LANG.bath_room}"/>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-12">
									<input type="text" name="price" class="form-control money" value="{ROW.price}" placeholder="{LANG.price}"/>
								</div>
								<div class="col-sm-6">
									<select class="form-control" name="money_unit">
										<!-- BEGIN: money_unit -->
										<option value="{MONEY.code}"{MONEY.selected}>{MONEY.currency} ({MONEY.code})</option>
										<!-- END: money_unit -->
									</select>
								</div>
								<div class="col-sm-6">
									<select class="form-control" name="unitid">
										<!-- BEGIN: unit -->
										<option value="{UNIT.id}"{UNIT.selected}>{UNIT.title}</option>
										<!-- END: unit -->
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.bds_description}</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" type="text" name="homeimgfile" value="{ROW.homeimgfile}" id="id_homeimgfile" placeholder="{LANG.homeimgfile}"/> <span class="input-group-btn">
									<button class="btn btn-default selectfile" type="button">
										<em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<input class="form-control" type="text" name="homeimgalt" value="{ROW.homeimgalt}" placeholder="{LANG.homeimgalt}"/>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="description" rows="4" placeholder="{LANG.description}">{ROW.description}</textarea>
						</div>
						<div class="form-group">
							<div class="row">
								<label class="col-sm-5 col-md-24"><strong>{LANG.description_html}</strong></label>
								<div class="col-sm-19 col-md-24">{ROW.description_html}</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.amenities}</div>
					<div class="panel-body">
						<!-- BEGIN: amenities -->
						<div class="row">
							<!-- BEGIN: loop -->
							<div class="col-xs-24 col-sm-12 col-md-8">
								<label><input type="checkbox" name="amenities[]" value="{AMENITIES.id}" {AMENITIES.checked} />{AMENITIES.title}</label>
							</div>
							<!-- END: loop -->
						</div>
						<!-- END: amenities -->
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.bds_location}</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="row">
								<div class="col-sm-24 col-md-12">
									<input class="form-control" type="text" name="address" value="{ROW.address}" placeholder="{LANG.address}"/>
								</div>
								<div class="col-sm-24 col-md-12">
									{PLACE_START}
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="coast" value="{ROW.coast}" placeholder="{LANG.coast}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="supermarket" placeholder="{LANG.supermarket}" value="{ROW.supermarket}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="airport" placeholder="{LANG.airport}" value="{ROW.airport}">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="hospital" placeholder="{LANG.hospital}" value="{ROW.hospital}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="park" placeholder="{LANG.park}" value="{ROW.park}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="bank" placeholder="{LANG.bank}" value="{ROW.bank}">
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="railway" placeholder="{LANG.railway}" value="{ROW.railway}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="schools" placeholder="{LANG.schools}" value="{ROW.schools}">
								</div>
								<div class="col-sm-24 col-md-8">
									<input class="form-control" type="text" name="bus" placeholder="{LANG.bus}" value="{ROW.bus}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.investor}</div>
					<div class="panel-body">
						<select class="form-control" name="investor">
							<option value="0">{LANG.investor_c}</option>
							<!-- BEGIN: investor -->
							<option value="{INVESTOR.id}"{INVESTOR.selected}>{INVESTOR.title}</option>
							<!-- END: investor -->
						</select>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.direction}</div>
					<div class="panel-body">
						<select class="form-control" name="direction">
							<option value="0">{LANG.direction_c}</option>
							<!-- BEGIN: direction -->
							<option value="{DIRECTION.id}"{DIRECTION.selected}>{DIRECTION.title}</option>
							<!-- END: direction -->
						</select>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.legal}</div>
					<div class="panel-body">
						<select class="form-control" name="legal">
							<option value="0"{LEGAL.selected}>{LANG.legal_c}</option>
							<!-- BEGIN: legal -->
							<option value="{LEGAL.id}"{LEGAL.selected}>{LEGAL.title}</option>
							<!-- END: legal -->
						</select>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.keywords}</div>
					<div class="panel-body">
						<input class="form-control" type="text" name="keywords" value="{ROW.keywords}" /> <span class="help-block">{LANG.keywords_note}</span>
					</div>
				</div>
				<!-- BEGIN: block_cat -->
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.groups}</div>
					<div class="panel-body">
						<!-- BEGIN: loop -->
						<label><input type="checkbox" value="{BLOCKS.bid}" name="bids[]"{BLOCKS.checked}>{BLOCKS.title}</label>
						<!-- END: loop -->
					</div>
				</div>
				<!-- END: block_cat -->
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.groups_view}</div>
					<div class="panel-body" style="height: 200px; overflow: scroll;">
						<!-- BEGIN: groups_view -->
						<label class="show"><input type="checkbox" name="groups_view[]" value="{GROUPS_VIEW.value}" {GROUPS_VIEW.checked} />{GROUPS_VIEW.title}</label>
						<!-- END: groups_view -->
					</div>
				</div>				
				<div class="panel panel-default">
					<div class="panel-heading">{LANG.extend}</div>
					<div class="panel-body">
						<label class="show"><input type="checkbox" name="allowed_rating" value="1" {ROW.allowed_rating_ck} />{LANG.allowed_rating}</label> <label class="show"><input type="checkbox" name="show_price" value="1" {ROW.show_price_ck} />{LANG.show_price}</label>
					</div>
				</div>
			</div>
		</div>
		<div class="text-center">
			<input class="btn btn-primary loading" name="submit" type="submit" id="submit" value="{LANG.save}" />
		</div>
	</form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery/jquery.validate.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.validator-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/autoNumeric-1.9.41.js"></script>
<script type="text/javascript">
	//<![CDATA[
	var file_items = '{FILE_ITEMS}';
	var file_selectfile = '{LANG.file_selectfile}';
	var nv_base_adminurl = '{NV_BASE_ADMINURL}';
	var inputnumber = '{LANG.error_inputnumber}';
	var file_dir = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}';
	var currentpath = "{CURRENTPATH}";
	
	var Options = {
		aSep : '{aSep}',
		aDec : '{aDec}',
		vMin : '0',
		vMax : '99999999999999'
	};
	
	$(function() {
		$('form').validate();
		
		$('.money').autoNumeric('init', Options);
		$('.money').bind('blur focusout keypress keyup', function() {
			$(this).autoNumeric('get', Options);
		});
	});

	function nv_get_alias(id) {
		var title = strip_tags($("[name='title']").val());
		if (title != '') {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name
					+ '&' + nv_fc_variable + '=content&nocache='
					+ new Date().getTime(), 'get_alias_title='
					+ encodeURIComponent(title), function(res) {
				$("#" + id).val(strip_tags(res));
			});
		}
		return false;
	}

	$(".selectfile").click(function() {
		var area = "id_homeimgfile";
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

	//]]>
</script>

<!-- BEGIN: auto_get_alias -->
<script>
	//<![CDATA[
	$("[name='title']").change(function() {
		nv_get_alias('id_alias');
	});
	//]]>
</script>
<!-- END: auto_get_alias -->

<!-- END: main -->