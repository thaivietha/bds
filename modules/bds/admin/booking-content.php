<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sun, 08 May 2016 07:42:57 GMT
 */
if (!defined('NV_IS_FILE_ADMIN')) die('Stop!!!');

$id = $nv_Request->get_int('id', 'get', 0);
$booking_info = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_booking WHERE booking_id=' . $id)->fetch();

$error = array();
if ($nv_Request->isset_request('submit', 'post')) {
    $booking_info['booking_id'] = $nv_Request->get_int('booking_id', 'post', 0);
    $booking_info['fullname'] = $nv_Request->get_title('fullname', 'post', '');
    $booking_info['address'] = $nv_Request->get_title('address', 'post', '');
    $booking_info['phone'] = $nv_Request->get_title('phone', 'post', '');
    $booking_info['note'] = $nv_Request->get_textarea('note', '', NV_ALLOWED_HTML_TAGS);

    if (empty($booking_info['fullname'])) {
        $error[] = $lang_module['error_empty_fullname'];
    }

    if (empty($booking_info['address'])) {
        $error[] = $lang_module['error_empty_address'];
    }

    if (empty($booking_info['phone'])) {
        $error[] = $lang_module['error_empty_phone'];
    }

    if (empty($error)) {
        try {
            $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_booking SET contact_fullname = :contact_fullname, contact_address = :contact_address, contact_phone = :contact_phone, contact_note = :contact_note WHERE booking_id=' . $booking_info['booking_id']);
            $stmt->bindParam(':contact_fullname', $booking_info['fullname'], PDO::PARAM_STR);
            $stmt->bindParam(':contact_address', $booking_info['address'], PDO::PARAM_STR);
            $stmt->bindParam(':contact_phone', $booking_info['phone'], PDO::PARAM_STR);
            $stmt->bindParam(':contact_note', $booking_info['note'], PDO::PARAM_STR, strlen($booking_info['note']));

            if ($stmt->execute()) {
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=booking-detail&id=' . $booking_info['booking_id']);
            }
        } catch (Exception $e) {
            trigger_error($e->getMessage());
        }
    }
}

$bds_info = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE id=' . $booking_info['rows_id'])->fetch();

$bds_info['title'] = $bds_info[NV_LANG_DATA . '_title'];
$bds_info['alias'] = $bds_info[NV_LANG_DATA . '_alias'];
$bds_info['direction'] = !empty($bds_info['direction']) ? $array_direction[$bds_info['direction']]['title'] : '';
$bds_info['legal'] = !empty($bds_info['legal']) ? $array_legal[$bds_info['legal']]['title'] : '';
$bds_info['price'] = nv_bds_number_format($bds_info['price']);
$bds_info['unit'] = ! empty($bds_info['unitid']) ? $array_unit[$bds_info['unitid']]['title'] : '';

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('BDS', $bds_info);
$xtpl->assign('BOOKING', $booking_info);

if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$set_active_op = 'booking';
$page_title = $lang_module['booking_edit'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';