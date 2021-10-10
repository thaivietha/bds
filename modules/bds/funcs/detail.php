<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sun, 08 May 2016 07:42:57 GMT
 */
if (! defined('NV_IS_MOD_BDS'))
    die('Stop!!!');

if ($nv_Request->isset_request('delete', 'post')) {
    $id = $nv_Request->get_int('id', 'post', 0);
    if (empty($id)) {
        die('NO');
    }
    nv_bds_delete($id);
    die('OK');
}

require_once NV_ROOTDIR . '/modules/location/location.class.php';
$location = new Location();

$bds_info = $db->query('SELECT * FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE status=1 AND ' . NV_LANG_DATA . '_alias=' . $db->quote($alias_url))
    ->fetch();

if (empty($bds_info) or ! nv_user_in_groups($array_bds_cat[$catid]['groups_view']) or ! nv_user_in_groups($bds_info['groups_view'])) {
    $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
    nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
}

$bds_info['title'] = $bds_info[NV_LANG_DATA . '_title'];
$bds_info['alias'] = $bds_info[NV_LANG_DATA . '_alias'];

$base_url_rewrite = nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$bds_info['catid']]['alias'] . '/' . $bds_info['alias'] . $global_config['rewrite_exturl'], true);
if ($_SERVER['REQUEST_URI'] == $base_url_rewrite) {
    $canonicalUrl = NV_MAIN_DOMAIN . $base_url_rewrite;
} elseif (NV_MAIN_DOMAIN . $_SERVER['REQUEST_URI'] != $base_url_rewrite) {
    // chuyen huong neu doi alias
    header('HTTP/1.1 301 Moved Permanently');
    Header('Location: ' . $base_url_rewrite);
    die();
} else {
    $canonicalUrl = $base_url_rewrite;
}

$contact_info = array(
    'fullname' => '',
    'email' => '',
    'phone' => '',
    'note' => ''
);

$bds_info['title_custom'] = $bds_info[NV_LANG_DATA . '_title_custom'];
$bds_info['description'] = $bds_info[NV_LANG_DATA . '_description'];
$bds_info['keywords'] = $bds_info[NV_LANG_DATA . '_keywords'];
$bds_info['description_html'] = $bds_info[NV_LANG_DATA . '_description_html'];
$bds_info['unit'] = ! empty($bds_info['unitid']) ? $array_unit[$bds_info['unitid']]['title'] : '';
$bds_info['direction'] = ! empty($bds_info['direction']) ? $array_direction[$bds_info['direction']]['title'] : '';
$bds_info['legal'] = ! empty($bds_info['legal']) ? $array_legal[$bds_info['legal']]['title'] : '';
$bds_info['address2'] = $location->locationString($bds_info['province'], $bds_info['district']);

$bds_info['image'] = array();
if (! empty($bds_info['homeimgfile'])) {
    $src = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $bds_info['homeimgfile'];
    $meta_property['og:image'] = (preg_match('/^(http|https|ftp|gopher)\:\/\//', $src)) ? $src : NV_MY_DOMAIN . $src;
}
$result = $db->query('SELECT ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_description description, homeimgfile FROM ' . $db_config['prefix'] . '_' . $module_data . '_images WHERE rows_id=' . $bds_info['id']);
while ($_row = $result->fetch()) {
    $_row['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $_row['homeimgfile'];
    $_row['description'] = strip_tags($_row['description']);
    $bds_info['image'][] = $_row;
}

if (empty($bds_info['image'])) {
    $bds_info['noimage'] = nv_bds_get_thumb('', 0, $module_upload);
}

// Tien ich
$bds_info['amenities'] = unserialize($bds_info['amenities']);
if(!empty($bds_info['amenities'])){
    $_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title FROM ' . $db_config['prefix'] . '_' . $module_data . '_amenities WHERE status=1 ORDER BY weight';
    $array_amenities = $nv_Cache->db($_sql, 'id', $module_name);
    foreach($bds_info['amenities'] as $index => $value){
        $bds_info['amenities'][$index] = $array_amenities[$value]['title'];
    }
}

// bds cung chu de
$array_bds_other = array();
$db->select('id, catid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, homeimgfile, homeimgthumb, ' . NV_LANG_DATA . '_description description, money_unit, show_price, area, groups_view, province, district, unitid')
    ->from($db_config['prefix'] . '_' . $module_data . '_rows')
    ->where('status=1 AND catid=' . $bds_info['catid'] . ' AND id!=' . $bds_info['id'])
    ->order('id DESC')
    ->limit($array_bds_cat[$bds_info['catid']]['numlinks']);

$sth = $db->prepare($db->sql());
$sth->execute();

while ($_row = $sth->fetch()) {
    if (nv_user_in_groups($_row['groups_view'])) {
        $_row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$_row['catid']]['alias'] . '/' . $_row['alias'] . $global_config['rewrite_exturl'];
        $_row['thumb'] = nv_bds_get_thumb($_row['homeimgfile'], $_row['homeimgthumb'], $module_upload);
        $_row['unit'] = ! empty($_row['unitid']) ? $array_unit[$_row['unitid']]['title'] : '';
		
        $array_bds_other[$_row['id']] = $_row;
    }
}

// dem so luot xem
$time_set = $nv_Request->get_int($module_data . '_' . $op . '_' . $bds_info['id'], 'session');
if (empty($time_set)) {
    $nv_Request->set_Session($module_data . '_' . $op . '_' . $bds_info['id'], NV_CURRENTTIME);
    $query = 'UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_rows SET hitstotal=hitstotal+1 WHERE id=' . $bds_info['id'];
    $db->query($query);
}

//Lien he
$error = array();
if ($nv_Request->isset_request('submit', 'post')) {
    $contact_info['fullname'] = $nv_Request->get_title('fullname', 'post', '');
    $contact_info['email'] = $nv_Request->get_title('email', 'post', '');
    $contact_info['phone'] = $nv_Request->get_int('phone', 'post', '0');
    $contact_info['note'] = $nv_Request->get_textarea('note', '', NV_ALLOWED_HTML_TAGS);
    
    if (empty($error)) {
        $userid = ! empty($user_info) ? $user_info['userid'] : 0;
        nv_insert_notification($module_name, 'book_new', '', $bds_info['id'], 0, $userid, 1);
        $_sql = 'INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_booking(rows_id, lang, contact_fullname, contact_email, contact_phone, contact_note, booking_time, user_id) VALUES (:rows_id, :lang, :contact_fullname, :contact_email, :contact_phone, :contact_note, ' . NV_CURRENTTIME . ', ' . $userid . ')';
        $data_insert = array();
        $data_insert['rows_id'] = $bds_info['id'];
        $data_insert['lang'] = NV_LANG_DATA;
        $data_insert['contact_fullname'] = $contact_info['fullname'];
        $data_insert['contact_email'] = $contact_info['email'];
        $data_insert['contact_phone'] = $contact_info['phone'];
        $data_insert['contact_note'] = $contact_info['note'];
        $new_id = $db->insert_id($_sql, 'booking_id', $data_insert);
        
        if ($new_id > 0) {
            // Cap nhat lai ma booking
            $booking_code = vsprintf($array_config['format_booking_code'], $new_id);
            $stmt = $db->prepare('UPDATE ' . $db_config['prefix'] . '_' . $module_data . '_booking SET booking_code= :booking_code WHERE booking_id=' . $new_id);
            $stmt->bindParam(':booking_code', $booking_code, PDO::PARAM_STR);
            $stmt->execute();
            
            // Gui email thong bao quan tri ve booking moi
            $listmail_admin = nv_bds_listmail_admin();
            if (! empty($listmail_admin)) {
                $xtpl = new XTemplate('sendmail_booking_admin.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
                $xtpl->assign('LANG', $lang_module);
                $xtpl->assign('BDS', $bds_info);
                $xtpl->assign('CONTACT', $contact_info);
                $xtpl->assign('URL_BOOKING_QUEUE', NV_MY_DOMAIN . NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=booking-detail&amp;id=' . $new_id);
                
                $xtpl->parse('main');
                $email_content = $xtpl->text('main');
                
                nv_sendmail(array(
                    $global_config['site_name'],
                    $global_config['site_email']
                ), $listmail_admin, sprintf($lang_module['booking_sendmail_admin_title'], $booking_code, $global_config['site_name']), $email_content);
            }
            
            $contents = nv_theme_alert($lang_module['booking_success_title'], $lang_module['booking_success_content'], 'info');
            include NV_ROOTDIR . '/includes/header.php';
            echo nv_site_theme($contents);
            include NV_ROOTDIR . '/includes/footer.php';
        }
    }
}


$meta_property['og:type'] = 'article';
$meta_property['article:published_time'] = date('Y-m-dTH:i:s', $bds_info['addtime']);
$meta_property['article:modified_time'] = date('Y-m-dTH:i:s', $bds_info['edittime']);
$meta_property['article:section'] = $array_bds_cat[$bds_info['catid']]['title'];

$page_title = ! empty($bds_info['title_custom']) ? $bds_info['title_custom'] : $bds_info['title'];
$key_words = $bds_info['keywords'];
$description = $bds_info['description'];

$contents = nv_theme_bds_detail($bds_info, $contact_info);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';