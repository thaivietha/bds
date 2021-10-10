/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 07 Sep 2016 01:59:00 GMT
 */

$(document).ready(function() {
	$('.loading').click(function() {
		if($.validator){
			var valid = $(this).closest('form').valid();
			if(valid){
				$('body').append('<div class="ajax-load-qa"></div>');
			}
		}else{
			var valid = $(this).closest('form').find('input:invalid').length;
			if(valid == 0){
				$('body').append('<div class="ajax-load-qa"></div>');
			}
		}
	});
	
	$('#change_booking_status').click(function(){
		if (confirm(CFG.booking_change_status_confirm)) {
			var status = $(this).data('status');
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&'
					+ nv_fc_variable + '=booking-detail&nocache=' + new Date().getTime(),
					'change_booking_status=1&id=' + CFG.booking_id + '&status=' + status, function(res) {
						var r_split = res.split('_');
						if (r_split[0] != 'OK') {
							$('.ajax-load-qa').remove();
							alert(nv_is_change_act_confirm[2]);
						}else{
							window.location.href = CFG.selfurl;
						}
						return;
					});
		}else{
			$('.ajax-load-qa').remove();
		}
	});
	
	$('#change_request_status').click(function(){
		if (confirm(CFG.request_change_status_confirm)) {
			var status = $(this).data('status');
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&'
					+ nv_fc_variable + '=request-detail&nocache=' + new Date().getTime(),
					'change_request_status=1&id=' + CFG.request_id + '&status=' + status, function(res) {
						var r_split = res.split('_');
						if (r_split[0] != 'OK') {
							$('.ajax-load-qa').remove();
							alert(nv_is_change_act_confirm[2]);
						}else{
							window.location.href = CFG.selfurl;
						}
						return;
					});
		}else{
			$('.ajax-load-qa').remove();
		}
	});
});

function nv_chang_cat(catid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + catid, 5000);
	var new_vid = $('#id_' + mod + '_' + catid).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&'
			+ nv_fc_variable + '=change_cat&nocache=' + new Date().getTime(),
			'catid=' + catid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
				var r_split = res.split('_');
				if (r_split[0] != 'OK') {
					alert(nv_is_change_act_confirm[2]);
				}
				clearTimeout(nv_timer);
				return;
			});
	return;
}

function nv_list_action( action, url_action, del_confirm_no_post )
{
	var listall = [];
	$('input.post:checked').each(function() {
		listall.push($(this).val());
	});

	if (listall.length < 1) {
		alert( del_confirm_no_post );
		return false;
	}

	if( action == 'delete_list_id' )
	{
		if (confirm(nv_is_del_confirm[0])) {
			$.ajax({
				type : 'POST',
				url : url_action,
				data : 'delete_list=1&listall=' + listall,
				success : function(data) {
					var r_split = data.split('_');
					if( r_split[0] == 'OK' ){
						window.location.href = window.location.href;
					}
					else{
						alert( nv_is_del_confirm[2] );
					}
				}
			});
		}
	}

	return false;
}

function nv_delete_other_images( i ){
	if (confirm(nv_is_del_confirm[0])) {
		$('#other-image-div-' + i).slideUp().promise().done(function() {
		    $(this).remove();
		});
	}
}

function nv_delete_other_images_tmp( path, thumb, i ){
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=images&nocache=' + new Date().getTime(), 'delete_other_images_tmp=1&path=' + path + '&thumb=' + thumb, function(res) {
			if (res != 'OK') {
				alert(nv_is_del_confirm[2]);
			}
			else{
				$('#other-image-div-' + i).slideUp();
			}
		});
	}
}

function nv_del_block_cat(bid) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=groups&nocache=' + new Date().getTime(), 'del_block_cat=1&bid=' + bid, function(res) {
			var r_split = res.split('_');
			if (r_split[0] == 'OK') {
				nv_show_list_block_cat();
			} else if (r_split[0] == 'ERR') {
				alert(r_split[1]);
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
	return false;
}

function nv_chang_block_cat(bid, mod) {
	var nv_timer = nv_settimeout_disable('id_' + mod + '_' + bid, 5000);
	var new_vid = $('#id_' + mod + '_' + bid).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=chang_block_cat&nocache=' + new Date().getTime(), 'bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		var r_split = res.split('_');
		if (r_split[0] != 'OK') {
			alert(nv_is_change_act_confirm[2]);
		}
		clearTimeout(nv_timer);
		nv_show_list_block_cat();
	});
	return;
}

function nv_show_list_block_cat() {
	if (document.getElementById('module_show_list')) {
		$('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block_cat&nocache=' + new Date().getTime());
	}
	return;
}

function nv_chang_block(bid, id, mod) {
	if (mod == 'delete' && !confirm(nv_is_del_confirm[0])) {
		return false;
	}
	var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
	var new_vid = $('#id_weight_' + id).val();
	$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'id=' + id + '&bid=' + bid + '&mod=' + mod + '&new_vid=' + new_vid, function(res) {
		nv_chang_block_result(res);
	});
	return;
}

function nv_chang_block_result(res) {
	var r_split = res.split('_');
	if (r_split[0] != 'OK') {
		alert(nv_is_change_act_confirm[2]);
	}
	var bid = parseInt(r_split[1]);
	nv_show_list_block(bid);
	return;
}

function nv_show_list_block(bid) {
	if (document.getElementById('module_show_list')) {
		$('#module_show_list').load(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=list_block&bid=' + bid + '&nocache=' + new Date().getTime());
	}
	return;
}

function nv_del_block_list(oForm, bid, del_confirm_no_post) {
	var del_list = '';
	var fa = oForm['idcheck[]'];
	if (fa.length) {
		for (var i = 0; i < fa.length; i++) {
			if (fa[i].checked) {
				del_list = del_list + ',' + fa[i].value;
			}
		}
	} else {
		if (fa.checked) {
			del_list = del_list + ',' + fa.value;
		}
	}

	if (del_list != '') {
		if (confirm(nv_is_del_confirm[0])) {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=change_block&nocache=' + new Date().getTime(), 'del_list=' + del_list + '&bid=' + bid, function(res) {
				nv_chang_block_result(res);
			});
		}
	}
	else{
		alert(del_confirm_no_post);
	}
}
function nv_add_otherimage() {
//	var newitem = "<div class=\"form-group\"><input class=\"form-control\" value=\"\" name=\"otherimage[]\" id=\"otherimage_" + file_items + "\" style=\"width : 80%\" maxlength=\"255\" />";
	//newitem += "&nbsp;<input type=\"button\" class=\"btn btn-info\" value=\"" + file_selectfile + "\" name=\"selectfile\" onclick=\"nv_open_browse( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=otherimage_" + file_items + "&path=" + file_dir + "&type=file&currentpath=" + currentpath + "', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" /></div>";

	var newitem = '';
	newitem += "<div class=\"form-group\">";
	newitem += "<div class=\"input-group\">";
	newitem += "	<input class=\"form-control\" type=\"text\" name=\"otherimage[]\" id=\"otherimage_" + file_items + "\" />";
	newitem += "	<span class=\"input-group-btn\">";
	newitem += "		<button class=\"btn btn-default\" type=\"button\" onclick=\"nv_open_browse( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=otherimage_" + file_items + "&path=" + file_dir + "&type=file&currentpath=" + currentpath + "', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" >";
	newitem += "			<em class=\"fa fa-folder-open-o fa-fix\">&nbsp;</em></button>";
	newitem += "	</span>";
	newitem += "</div>";
	newitem += "</div>";

	$("#otherimage").append(newitem);
	file_items++;
}