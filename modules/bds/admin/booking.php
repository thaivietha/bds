<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 09 May 2016 04:02:53 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$table_name = $db_config['prefix'] . '_' . $module_data . '_booking';

// change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $content = 'NO_' . $id;
    
    $query = 'SELECT status FROM ' . $table_name . ' WHERE booking_id=' . $id;
    $row = $db->query($query)->fetch();
    if (isset($row['status'])) {
        $status = ($row['status']) ? 0 : 1;
        $query = 'UPDATE ' . $table_name . ' SET status=' . intval($status) . ' WHERE booking_id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
    }
    $nv_Cache->delMod($module_name);
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if ($id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        nv_bds_booking_delete($id);
        $nv_Cache->delMod($module_name);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
        die();
    }
} elseif ($nv_Request->isset_request('delete_list', 'post')) {
    $listall = $nv_Request->get_title('listall', 'post', '');
    $array_id = explode(',', $listall);
    
    if (! empty($array_id)) {
        foreach ($array_id as $id) {
            nv_bds_booking_delete($id);
        }
        $nv_Cache->delMod($module_name);
        die('OK');
    }
    die('NO');
}

$row = array();
$error = array();
$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$array_search = array(
    'q' => $nv_Request->get_title('q', 'get', ''),
    'from' => $nv_Request->get_title('from', 'get', ''),
    'to' => $nv_Request->get_title('to', 'get', ''),
    'status' => $nv_Request->get_int('status', 'get', - 1),
    'id' => $nv_Request->get_int('id', 'get', 0)
);

$where = '';
if (! empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (booking_code LIKE "%' . $array_search['q'] . '%"
        OR contact_fullname LIKE "%' . $array_search['q'] . '%"
        OR contact_address LIKE "%' . $array_search['q'] . '%"
        OR contact_phone LIKE "%' . $array_search['q'] . '%"
        OR contact_note LIKE "%' . $array_search['q'] . '%"
    )';
}

if ($array_search['status'] >= 0) {
    $base_url .= '&status=' . $array_search['status'];
    $where .= ' AND status=' . $array_search['status'];
}

$per_page = 20;
$page = $nv_Request->get_int('page', 'post,get', 1);
$db->sqlreset()
    ->select('COUNT(*)')
    ->from('' . $table_name . '')
    ->where('1=1' . $where);

$sth = $db->prepare($db->sql());
$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('*')
    ->order('booking_id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('SEARCH', $array_search);
$xtpl->assign('BASE_URL', $base_url);

$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
if (! empty($generate_page)) {
    $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.generate_page');
}
while ($view = $sth->fetch()) {
    $view['booking_time'] = nv_date('H:i d/m/Y', $view['booking_time']);
    $view['link_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;delete_id=' . $view['booking_id'] . '&amp;delete_checkss=' . md5($view['booking_id'] . NV_CACHE_PREFIX . $client_info['session_id']);
    $view['link_view'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=booking-detail&amp;id=' . $view['booking_id'];
    $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
    $xtpl->assign('VIEW', $view);
    if (! $view['status']) {
        $xtpl->parse('main.loop.bold');
    }
    $xtpl->parse('main.loop');
}

if (! empty($array_payment_status)) {
    foreach ($array_payment_status as $index => $value) {
        $xtpl->assign('PAYMENT_STATUS', array(
            'index' => $index,
            'value' => $value,
            'selected' => $array_search['payment'] == $index ? 'selected="selected"' : ''
        ));
        $xtpl->parse('main.payment_status');
    }
}

$array_status = array(
    '0' => $lang_module['queue'],
    '1' => $lang_module['queued']
);
foreach ($array_status as $index => $value) {
    $sl = $array_search['status'] == $index ? 'selected="selected"' : '';
    $xtpl->assign('STATUS', array(
        'index' => $index,
        'value' => $value,
        'selected' => $sl
    ));
    $xtpl->parse('main.status');
}

$array_action = array(
    'delete_list_id' => $lang_global['delete']
);
foreach ($array_action as $key => $value) {
    $xtpl->assign('ACTION', array(
        'key' => $key,
        'value' => $value
    ));
    $xtpl->parse('main.action');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['booking'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';