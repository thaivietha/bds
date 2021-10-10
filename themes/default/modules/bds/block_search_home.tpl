<!-- BEGIN: main -->
<div class="search-form-vertical">
	<form action="{NV_BASE_SITEURL}index.php" method="get" class="form-search">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
		<input type="hidden" name="{NV_OP_VARIABLE}" value="search" />
		<div class="search-form-inner clearfix">
			<div class="content-main-inner">
				<div class="row">
					<div class="col-xs-24 col-md-24">
						<div class="form-group form-group-title">
							<div class="form-group-inner inner">
								<input type="text" class="form-control" name="q" value="{SEARCH.q}" placeholder="{LANG.keywords_input}" />
							</div>
						</div>
                	</div>
                	<div class="col-xs-24 col-md-24">
                		<div class="form-group form-group-type tax-select-field">
			                <div class="form-group-inner inner select-wrapper">
			                	<select name="catid" id="catid" class="form-control select">
									<option value="0">{LANG.cat}</option>
									<!-- BEGIN: cat -->
									<option value="{CAT.id}"{CAT.selected}>{CAT.space}{CAT.title}</option>
									<!-- END: cat -->
								</select>
			        		</div>
			    		</div>
                	</div>
                	<div class="col-xs-24 col-md-24">
                		<div class="form-group form-group-location tax-select-field">
			        		{PLACE}
			   			</div>
                	</div>
                	<div class="col-xs-24 col-md-24">
                		<div class="form-group form-group-baths">
					        <div class="form-group-inner inner select-wrapper">
								<select class="form-control select" id="bed_room" name="bed_room">
									<option value="0">{LANG.bed_room}</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
					    	</div>
						</div>
                	</div>
                	<div class="col-xs-24 col-md-24">
                		<div class="form-group form-group-beds">
							<div class="form-group-inner inner select-wrapper">
								<select class="form-control select" id="bath_room" name="bath_room">
									<option value="0">{LANG.bath_room}</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
						</div>
                	</div>
				</div>
				<div class="row">
					<div class="col-xs-24 col-md-24 form-button-search">
						<input type="submit" class="btn-submit" value="{LANG.search}" />
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<!-- END: main -->