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

$array_data = array();
$cat_info = $array_bds_cat[$catid];
$base_url = $array_bds_cat[$catid]['link'];
$date_start_note = $cat_info['viewtype'] == 'viewlist' ? 1 : 0;

require_once NV_ROOTDIR . '/modules/location/location.class.php';
$location = new Location();

$db->sqlreset()
    ->select('COUNT(*)')
    ->from($db_config['prefix'] . '_' . $module_data . '_rows')
    ->where('catid=' . $catid);

$sth = $db->prepare($db->sql());

$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('id, catid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, homeimgfile, homeimgthumb, ' . NV_LANG_DATA . '_description description, province, district, price, money_unit, show_price, area, bed_room, bath_room, groups_view, hitstotal')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);

$sth = $db->prepare($db->sql());
$sth->execute();

while ($row = $sth->fetch()) {
    if (nv_user_in_groups($row['groups_view'])) {
        $row['title_clean'] = nv_clean60($row['title'], $array_config['title_lenght']);
        $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
        $row['link_cat'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$row['catid']]['alias'];
        $row['thumb'] = nv_bds_get_thumb($row['homeimgfile'], $row['homeimgthumb'], $module_upload);
        $row['address'] = $location->locationString($row['province'], $row['district']);
        $array_data[$row['id']] = $row;
    }
}

$page_title = ! empty($cat_info['custom_title']) ? $cat_info['custom_title'] : $cat_info['title'];
$key_words = $cat_info['keywords'];
$description = $cat_info['description'];

if ($page > 1) {
    $page_title = $page_title . ' - ' . $lang_global['page'] . ' ' . $page;
}
$page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);

$contents = nv_theme_bds_viewcat($array_data, $cat_info['viewtype'], $page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';