<!-- BEGIN: main -->
<link rel="stylesheet" href="{NV_BASE_SITEURL}themes/{TEMPLATE}/css/jquery.fancybox.min.css" />
<script src="{NV_BASE_SITEURL}themes/{TEMPLATE}/js/jquery.fancybox.min.js"></script>
<div class="detail-property">
	<div class="wraper">
		<div class="container">
			<div class="content-property-detail">
				<div class="row">
					<div class="property-detail-main col-xs-24 col-md-16">
						<div class="property-single-details">
							<div class="property-information-detail">
								<div class="left-infor">
									<h1>{DATA.title}</h1>
									<div class="property-location"><i class="flaticon-maps-and-flags"></i> {DATA.address}, {DATA.address2}</div>
								</div>
								<div class="property-price"><!-- BEGIN: price -->$ {DATA.price} {DATA.money_unit}<!-- END: price --><!-- BEGIN: contact -->{LANG.contact}<!-- END: contact --></div>
							</div>
							<div class="detail-metas-top">
								<div class="property-meta"><a href="{DATA.link_cat}" title="{DATA.catid}">{DATA.catid}</a></div>
								<!-- BEGIN: bed_room -->
								<div class="property-meta">{LANG.bed_room}: {DATA.bed_room}</div>
								<!-- END: bed_room -->
								<!-- BEGIN: bath_room -->
								<div class="property-meta">{LANG.bath_room}: {DATA.bath_room}</div>
								<!-- END: bath_room -->
								<div class="property-meta">{LANG.area}: {DATA.area} m<sup>2</sup></div>
							</div>
							<div class="m-bottom">{DATA.description}</div>
							<!-- BEGIN: description_html -->
							<div class="m-bottom">{DATA.description_html}</div>
							<!-- END: description_html -->
							<div class="detail-list">
								<h3>{LANG.detail_list}</h3>
								<ul>
									<li>
										<div class="text">{LANG.code}</div>
										<div class="value">{DATA.code}</div>
									</li>
									<li>
										<div class="text">{LANG.area}</div>
										<div class="value">{DATA.area} m<sup>2</sup></div>
									</li>
									<!-- BEGIN: room_list -->
									<li>
										<div class="text">{LANG.room}</div>
										<div class="value">{DATA.room}</div>
									</li>
									<!-- END: room_list -->
									<!-- BEGIN: bed_room_list -->
									<li>
										<div class="text">{LANG.bed_room}</div>
										<div class="value">{DATA.bed_room}</div>
									</li>
									<!-- END: bed_room_list -->
									<!-- BEGIN: bath_room_list -->
									<li>
										<div class="text">{LANG.bath_room}</div>
										<div class="value">{DATA.bath_room}</div>
									</li>
									<!-- END: bath_room_list -->
									<!-- BEGIN: direction -->
									<li>
										<div class="text">{LANG.direction}</div>
										<div class="value">{DATA.direction}</div>
									</li>
									<!-- END: direction -->
									<!-- BEGIN: legal -->
									<li>
										<div class="text">{LANG.legal}</div>
										<div class="value">{DATA.legal}</div>
									</li>
									<!-- END: legal -->
									<!-- BEGIN: investor -->
									<li>
										<div class="text">{LANG.investor}</div>
										<div class="value">{DATA.investor}</div>
									</li>
									<!-- END: investor -->
								</ul>
							</div>
						</div>
						<!-- BEGIN: amenities -->
						<div class="property-amenities">
					        <h3>{LANG.amenities}</h3>
					        <ul class="list-check">
					        	<!-- BEGIN: loop -->
	                            <li>{AMENITIES.title}</li>
	                            <!-- END: loop -->
	                        </ul>
						</div>
						<!-- END: amenities -->
						<div class="property-amenities facilities">
					        <h3>{LANG.facilities}</h3>
					        <ul>
					        	<!-- BEGIN: coast -->
	                            <li>
									<div class="text">{LANG.coast}</div>
									<div class="value">{DATA.coast}</div>
								</li>
								<!-- END: coast -->
								<!-- BEGIN: supermarket -->
								<li>
									<div class="text">{LANG.supermarket}</div>
									<div class="value">{DATA.supermarket}</div>
								</li>
								<!-- END: supermarket -->
								<!-- BEGIN: airport -->
								<li>
									<div class="text">{LANG.airport}</div>
									<div class="value">{DATA.airport}</div>
								</li>
								<!-- END: airport -->
								<!-- BEGIN: hospital -->
								<li>
									<div class="text">{LANG.hospital}</div>
									<div class="value">{DATA.hospital}</div>
								</li>
								<!-- END: hospital -->
								<!-- BEGIN: park -->
								<li>
									<div class="text">{LANG.park}</div>
									<div class="value">{DATA.park}</div>
								</li>
								<!-- END: park -->
								<!-- BEGIN: bank -->
								<li>
									<div class="text">{LANG.bank}</div>
									<div class="value">{DATA.bank}</div>
								</li>
								<!-- END: bank -->
								<!-- BEGIN: railway -->
								<li>
									<div class="text">{LANG.railway}</div>
									<div class="value">{DATA.railway}</div>
								</li>
								<!-- END: railway -->
								<!-- BEGIN: schools -->
								<li>
									<div class="text">{LANG.schools}</div>
									<div class="value">{DATA.schools}</div>
								</li>
								<!-- END: schools -->
								<!-- BEGIN: bus -->
								<li>
									<div class="text">{LANG.bus}</div>
									<div class="value">{DATA.bus}</div>
								</li>
								<!-- END: bus -->
	                        </ul>
						</div>
						<div class="property-detail-gallery">
							<h3>Hình ảnh</h3>
							<div class="row">
								<!-- BEGIN: noimage -->
								<div class="col-xs-24">
									<img src="{DATA.noimage}" class="img-thumbnail" />
								</div>
								<!-- END: noimage -->
								<!-- BEGIN: image -->
								<!-- BEGIN: loop -->
								<div class="col-xs-12 col-sm-6 col-md-6 no-padding">
									<a data-fancybox="gallery" href="{IMAGE.homeimgfile}"><img src="{IMAGE.homeimgfile}" /></a>
								</div>
								<!-- END: loop -->
								<!-- END: image -->
							</div>
						</div>
					</div>
					<div class="sidebar-property col-xs-24 col-md-8">
						<div class="sidebar-property-form">
							<h3>Liên hệ tư vấn</h3>
							<div class="contact-form-agent">
								<div class="agent-content-wrapper flex-middle">
								    <form class="contact-form-wrapper" method="post" id="frm-booking">
								    	<div class="row">
									        <div class="col-sm-24">
										        <div class="form-group">
										            <input type="text" class="form-control" name="fullname" value="{CONTACT.fullname}" placeholder="{LANG.fullname}" required="required">
										        </div>
										    </div>
										    <div class="col-sm-24">
										        <div class="form-group">
										            <input type="email" class="form-control" name="email" placeholder="{LANG.email}" required="required" value="{CONTACT.email}">
										        </div>
										    </div>
										    <div class="col-sm-24">
										        <div class="form-group">
										            <input type="text" class="form-control" name="phone" placeholder="{LANG.phone}" required="required" value="{CONTACT.phone}">
										        </div>
										    </div>
								        </div>
								        <div class="form-group">
								            <textarea class="form-control" name="note" placeholder="{LANG.note}">{CONTACT.note}</textarea>
								        </div>
								        <button class="btn submit btn-block" type="submit" name="submit">Gửi thông tin</button>
								    </form>
			    			</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END: main -->