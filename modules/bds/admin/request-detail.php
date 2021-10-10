<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sun, 08 May 2016 07:42:57 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$request_id = $nv_Request->get_int('id', 'post,get', 0);
$tablename = $db_config['prefix'] . '_' . $module_data . '_request';

if ($nv_Request->isset_request('change_request_status', 'post')) {
    $status = $nv_Request->get_int('status', 'post,get', 0);
    if ($status) {
        $request_status = 0;
    } else {
        $request_status = 1;
    }
    $result = $db->query('UPDATE ' . $tablename . ' SET status=' . $request_status . ' WHERE id=' . $request_id);
    if ($result) {
        die('OK');
    }
    die('NO');
}

$request_info = $db->query('SELECT * FROM ' . $tablename . ' WHERE id=' . $request_id)->fetch();
if (empty($request_info)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=request');
}

$request_info['cat'] = ! empty($request_info['catid']) ? $array_bds_cat[$request_info['catid']]['title'] : '';
$request_info['direction'] = ! empty($request_info['directionid']) ? $array_direction[$request_info['directionid']]['title'] : '';
$request_info['legal'] = ! empty($request_info['legalid']) ? $array_legal[$request_info['legalid']]['title'] : '';

$lang_module['booking_status_success'] = $request_info['status'] == 0 ? $lang_module['booking_status_success'] : $lang_module['booking_status_queue'];
$lang_module['booking_status'] = $request_info['status'] == 0 ? $lang_module['queue'] : $lang_module['queued'];

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('REQUEST', $request_info);
$xtpl->assign('SELFURL', $client_info['selfurl']);
$xtpl->assign('URL_DELETE', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $request_info['id'] . '&amp;delete_checkss=' . md5($request_info['id'] . NV_CACHE_PREFIX . $client_info['session_id']));

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = sprintf($lang_module['request_title'], $request_info['fullname']);
$set_active_op = 'request';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';