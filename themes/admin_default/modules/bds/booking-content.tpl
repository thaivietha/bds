<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />

<div class="booking-detail">
    <div class="panel panel-default">
        <div class="panel-heading">{LANG.bds_info}</div>
        <div class="panel-body">
            <h1 class="m-bottom">{BDS.title}</h1>
            <ul>
				<li>{LANG.direction}: <strong>{BDS.direction}</strong></li>
				<li>{LANG.legal}: <strong>{BDS.legal}</strong></li>
				<li>{LANG.area}: <strong>{BDS.area}</strong></li>
				<li>{LANG.living_room}: <strong>{BDS.living_room}</strong></li>
				<li>{LANG.bed_room}: <strong>{BDS.bed_room}</strong></li>
				<li>{LANG.bath_room}: <strong>{BDS.bath_room}</strong></li>
				<li>{LANG.price}: <strong>{BDS.price} VNĐ / {BDS.unit}</strong></li>
				<li>{LANG.address}: <strong>{BDS.address}</strong></li>
            </ul>
        </div>
    </div>

    <!-- BEGIN: error -->
    <div class="alert alert-danger">{ERROR}</div>
    <!-- END: error -->

    <form class="form-horizontal" method="post" id="frm-booking">
        <input type="hidden" value="{BOOKING.booking_id}" name="booking_id">
		<div class="panel panel-default">
            <div class="panel-heading">{LANG.contact_info}</div>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.fullname}</strong></label>
                    <div class="col-sm-19 col-md-21">
                        <input class="form-control required" type="text" name="fullname" value="{BOOKING.contact_fullname}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.address}</strong></label>
                    <div class="col-sm-19 col-md-21">
                        <input class="form-control required" required="required" type="text" name="address" value="{BOOKING.contact_address}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.phone}</strong></label>
                    <div class="col-sm-19 col-md-21">
                        <input class="form-control required" required="required" type="text" name="phone" value="{BOOKING.contact_phone}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-5 col-md-3 control-label"><strong>{LANG.note}</strong></label>
                    <div class="col-sm-19 col-md-21">
                        <textarea class="form-control" name="note">{BOOKING.note}</textarea>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="submit" class="btn btn-primary">
                        <em class="fa fa-save">&nbsp;</em>{LANG.save}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script>
$(".datepicker").datepicker({
	dateFormat: "dd/mm/yy",
	changeMonth: !0,
	changeYear: !0,
	showOtherMonths: !0,
	showOn: "focus",
	yearRange: "-90:+0"
});
</script>
<!-- END: main -->