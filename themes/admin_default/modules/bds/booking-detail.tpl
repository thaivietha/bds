<!-- BEGIN: main -->
<div class="booking-detail">
	<div class="control m-bottom text-right">
		<button class="btn btn-primary btn-xs loading" id="change_booking_status" data-status="{BOOKING.status}">
			<em class="fa fa-recycle">&nbsp;</em>{LANG.booking_status_success}
		</button>
		<a class="btn btn-default btn-xs" href="{BDS.link_edit}"><em class="fa fa-edit">&nbsp;</em>{LANG.edit}</a>
		<a class="btn btn-danger btn-xs" href="{URL_DELETE}" onclick="return confirm(nv_is_del_confirm[0]);"><em class="fa fa-trash-o">&nbsp;</em>{LANG.delete}</a>
	</div>
	<div class="row">
		<div class="col-md-14 col-sm-14 col-xs-24">
			<div class="panel panel-default">
				<div class="panel-heading">{LANG.contact_info}</div>
				<div class="panel-body">
					<ul>
						<li><a href="{BDS.link}" title="{BDS.title}" target="_blank">{BDS.title}</a></li>
						<li><strong>{LANG.fullname}:</strong> {BOOKING.contact_fullname}</li>
						<li><strong>{LANG.email}:</strong> {BOOKING.contact_email}</li>
						<li><strong>{LANG.phone}:</strong> {BOOKING.contact_phone}</li>
						<li><strong>{LANG.note}:</strong> {BOOKING.contact_note}</li>
						<li><strong>{LANG.booking_time}:</strong> {BOOKING.booking_time}</li>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-10 col-sm-10 col-xs-24">
			<div class="panel-body text-center">
				<div class="booking-status">
					<span class="show m-bottom text-danger">{LANG.status}</span> {LANG.booking_status}
				</div>
			</div>
		</div>
	</div>
</div>
<script>
var CFG = [];
CFG.booking_change_status_confirm = '{LANG.booking_change_status_confirm}';
CFG.selfurl = '{SELFURL}';
CFG.booking_id = '{BOOKING.booking_id};'
</script>
<!-- END: main -->