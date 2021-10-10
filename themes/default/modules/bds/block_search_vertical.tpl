<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.css">
<link rel="stylesheet" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2-bootstrap.min.css">
<form action="{NV_BASE_SITEURL}index.php" method="get" class="form-search search-vertical">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" /> <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" /> <input type="hidden" name="{NV_OP_VARIABLE}" value="search" />

		<div class="form-group">
			<input type="text" class="form-control" name="q" value="{SEARCH.q}" placeholder="{LANG.keywords_input}" />
		</div>
		<div class="form-group">
			<select name="catid" id="catid" class="form-control">
				<option value="0">{LANG.cat}</option>
				<!-- BEGIN: cat -->
				<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
				<!-- END: cat -->
			</select>
		</div>
		<div class="form-group">
			<select name="direction" id="direction" class="form-control">
				<option value="0">{LANG.direction}</option>
				<!-- BEGIN: direction -->
				<option value="{DIRECTION.id}"{DIRECTION.selected}>{DIRECTION.title}</option>
				<!-- END: direction -->
			</select>
		</div>
		<div class="form-group">
			<select name="legal" id="legal" class="form-control">
				<option value="0">{LANG.legal}</option>
				<!-- BEGIN: legal -->
				<option value="{LEGAL.id}"{LEGAL.selected}>{LEGAL.title}</option>
				<!-- END: legal -->
			</select>
		</div>
		<div class="form-group">
			{PLACE}
		</div>
		<div class="form-group">
			<select name="area" class="form-control">
				<option value="0">{LANG.area}</option>
				<!-- BEGIN: area -->
				<option value="{AREA.index}" {AREA.selected}>{AREA.title} m2</option>
				<!-- END: area -->
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" id="bed_room" name="bed_room">
				<option value="0">{LANG.bed_room}</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="form-group">
			<select class="form-control" id="bath_room" name="bath_room">
				<option value="0">{LANG.bath_room}</option>
				<option value="1">1</option>
				<option value="2">2</option>
				<option value="3">3</option>
				<option value="4">4</option>
				<option value="5">5</option>
			</select>
		</div>
		<div class="form-group">
			<select name="price_spread" class="form-control">
				<option value="0">{LANG.price_spread}</option>
				<!-- BEGIN: price_spread -->
				<option value="{PRICE_SPREAD.index}" {PRICE_SPREAD.selected}>{PRICE_SPREAD.title}</option>
				<!-- END: price_spread -->
			</select>
		</div>		
		<div class="text-center form-button-search">
			<input type="submit" class="btn-submit" value="{LANG.search}" />
		</div>
	</form>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/select2.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/select2/i18n/{NV_LANG_INTERFACE}.js"></script>
<!-- END: main -->