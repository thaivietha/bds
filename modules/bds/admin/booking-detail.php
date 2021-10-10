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

$booking_id = $nv_Request->get_int('id', 'post,get', 0);
$tablename = $db_config['prefix'] . '_' . $module_data . '_booking';

if ($nv_Request->isset_request('change_booking_status', 'post')) {
    $status = $nv_Request->get_int('status', 'post,get', 0);
    if ($status) {
        $booking_status = 0;
    } else {
        $booking_status = 1;
    }
    $result = $db->query('UPDATE ' . $tablename . ' SET status=' . $booking_status . ' WHERE booking_id=' . $booking_id);
    if ($result) {
        die('OK');
    }
    die('NO');
}

$booking_info = $db->query('SELECT * FROM ' . $tablename . ' WHERE booking_id=' . $booking_id)->fetch();

if (empty($booking_info)) {
    nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=booking');
    die();
}

$bds_info = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE id=' . $booking_info['rows_id'])->fetch();
$bds_info['title'] = $bds_info[NV_LANG_DATA . '_title'];
$bds_info['alias'] = $bds_info[NV_LANG_DATA . '_alias'];
$booking_info['booking_time'] = nv_date('H:i d/m/Y', $booking_info['booking_time']);
$bds_info['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$bds_info['catid']]['alias'] . '/' . $bds_info['alias'] . $global_config['rewrite_exturl'];
$bds_info['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=booking-content&amp;id=' . $booking_id;

$lang_module['booking_status_success'] = $booking_info['status'] == 0 ? $lang_module['booking_status_success'] : $lang_module['booking_status_queue'];
$lang_module['booking_status'] = $booking_info['status'] == 0 ? $lang_module['queue'] : $lang_module['queued'];

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('BDS', $bds_info);
$xtpl->assign('BOOKING', $booking_info);
$xtpl->assign('SELFURL', $client_info['selfurl']);

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = sprintf($lang_module['booking_title'], $booking_info['booking_code']);
$set_active_op = 'booking';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';