/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 07 Sep 2016 01:59:00 GMT
 */

function nv_bds_delete(id) {
	if (confirm(nv_is_del_confirm[0])) {
		$.post(nv_base_siteurl + 'index.php?' + nv_lang_variable + '='
				+ nv_lang_data + '&' + nv_name_variable + '=' + nv_module_name
				+ '&' + nv_fc_variable + '=detail&nocache='
				+ new Date().getTime(), 'delete=1&id=' + id, function(res) {
			if (res == 'OK') {
				window.location.href = nv_base_siteurl + "index.php?"
						+ nv_lang_variable + "=" + nv_lang_data + "&"
						+ nv_name_variable + "=" + nv_module_name;
			} else {
				alert(nv_is_del_confirm[2]);
			}
		});
	}
}

function nv_formReset(a)
{
    $(a)[0].reset();
    if($.isFunction($.fn.select2)){
    	$(a).find("select").val(0).trigger("change");
    }
}