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

$page_title = $lang_module['search'];

$page = $nv_Request->get_int('page', 'get', 1);
$array_data = array();
$where = '';
$viewtype = 'viewgridsearch';
$is_search = 0;

require_once NV_ROOTDIR . '/modules/location/location.class.php';
$location = new Location();

$array_data = array();
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$base_url_rewrite = $request_uri = urldecode($_SERVER['REQUEST_URI']);

$array_search = array(
    'q' => $nv_Request->get_title('q', 'post,get', ''),
    'catid' => $nv_Request->get_int('catid', 'post,get', 0),
    'direction' => $nv_Request->get_int('direction', 'post,get', 0),
	'legal' => $nv_Request->get_int('legal', 'post,get', 0),
	'bed_room' => $nv_Request->get_int('bed_room', 'post,get', 0),
	'bath_room' => $nv_Request->get_int('bath_room', 'post,get', 0),
	'price_spread' => $nv_Request->get_title('price_spread', 'post,get', ''),
	'area' => $nv_Request->get_title('area', 'post,get', ''),
    'province' => $nv_Request->get_int('province', 'post,get', 0),
    'district' => $nv_Request->get_int('district', 'post,get', 0)
);

if (! empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (' . NV_LANG_DATA . '_title LIKE ' . $db->quote("%" . $array_search['q'] . "%") . '
	OR ' . NV_LANG_DATA . '_alias LIKE ' . $db->quote("%" . $array_search['q'] . "%") . '
	OR ' . NV_LANG_DATA . '_title_custom LIKE ' . $db->quote("%" . $array_search['q'] . "%") . '
	OR ' . NV_LANG_DATA . '_description LIKE ' . $db->quote("%" . $array_search['q'] . "%") . ')';
}

if (! empty($array_search['catid'])) {
    $_array_cat = nv_bds_getCatidInParent($array_search['catid']);
    $base_url .= '&catid=' . $array_search['catid'];
    $where .= ' AND catid IN (' . implode(',', $_array_cat) . ')';
} else {
    $base_url_rewrite = str_replace('&catid=' . $array_search['catid'], '', $base_url_rewrite);
}

if (! empty($array_search['direction'])) {
    $base_url .= '&direction=' . $array_search['direction'];
    $where .= ' AND direction=' . $array_search['direction'];
}

if (! empty($array_search['legal'])) {
    $base_url .= '&legal=' . $array_search['legal'];
    $where .= ' AND legal=' . $array_search['legal'];
}

if (! empty($array_search['bed_room'])) {
    $base_url .= '&bed_room=' . $array_search['bed_room'];
    $where .= ' AND bed_room=' . $array_search['bed_room'];
}

if (! empty($array_search['bath_room'])) {
    $base_url .= '&bath_room=' . $array_search['bath_room'];
    $where .= ' AND bath_room=' . $array_search['bath_room'];
}

if (! empty($array_search['price_spread'])) {
    $base_url .= 'price_spread=' . $array_search['price_spread'];
    
    $price_spread = explode('-', $array_search['price_spread']);
    if (sizeof($price_spread) == 2) {
        if (! empty($price_spread[0]) and ! empty($price_spread[1])) {
            $where .= ' AND (price >= ' . $price_spread[0] . ' AND price <= ' . $price_spread[1] . ')';
        } elseif (! empty($price_spread[0]) and empty($price_spread[1])) {
            $where .= ' AND price >= ' . $price_spread[0];
        }
    }
} else {
    $base_url_rewrite = str_replace('&price_spread=' . $array_search['price_spread'], '', $base_url_rewrite);
}

if (! empty($array_search['area'])) {
    $base_url .= 'area=' . $array_search['area'];
    
    $area = explode('-', $array_search['area']);
    if (sizeof($area) == 2) {
        if (! empty($area[0]) and ! empty($area[1])) {
            $where .= ' AND (area >= ' . $area[0] . ' AND area <= ' . $area[1] . ')';
        } elseif (! empty($area[0]) and empty($area[1])) {
            $where .= ' AND area >= ' . $area[0];
        }
    }
} else {
    $base_url_rewrite = str_replace('&area=' . $array_search['area'], '', $base_url_rewrite);
}

if (! empty($array_search['province'])) {
    $base_url .= 'province=' . $array_search['province'];
    $where .= ' AND province=' . $array_search['province'];
} else {
    $base_url_rewrite = str_replace('&province=' . $array_search['province'], '', $base_url_rewrite);
}

if (! empty($array_search['district'])) {
    $base_url .= 'district=' . $array_search['district'];
    $where .= ' AND district=' . $array_search['district'];
} else {
    $base_url_rewrite = str_replace('&district=' . $array_search['district'], '', $base_url_rewrite);
}

$base_url_rewrite = nv_url_rewrite($base_url_rewrite, true);
if ($request_uri != $base_url_rewrite and NV_MAIN_DOMAIN . $request_uri != $base_url_rewrite) {
    header('Location: ' . $base_url_rewrite);
    die();
}

if (! empty($where)) {
    $is_search = 1;
}

$db->sqlreset()
    ->select('COUNT(*)')
    ->from($db_config['prefix'] . '_' . $module_data . '_rows')
    ->where('status=1' . $where);

$sth = $db->prepare($db->sql());

$sth->execute();
$num_items = $sth->fetchColumn();

$db->select('id, catid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, homeimgfile, homeimgthumb, ' . NV_LANG_DATA . '_description description, price, money_unit, direction, legal, district, province, groups_view, show_price, hitstotal,area')
    ->order('id DESC')
    ->limit($per_page)
    ->offset(($page - 1) * $per_page);
$sth = $db->prepare($db->sql());
$sth->execute();

while ($row = $sth->fetch()) {
    if (nv_user_in_groups($row['groups_view'])) {
        $row['title_clean'] = nv_clean60($row['title'], $array_config['title_lenght']);
        $row['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$row['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
        $row['thumb'] = nv_bds_get_thumb($row['homeimgfile'], $row['homeimgthumb'], $module_upload);
        $row['direction'] = ! empty($row['direction']) ? $array_direction[$row['direction']]['title'] : '';
        $row['address'] = $location->locationString($row['province'], $row['district']);
		$row['legal'] = ! empty($row['legal']) ? $array_legal[$row['legal']]['title'] : '';
        $array_data[$row['id']] = $row;
    }
}

$lang_module['search_result_number'] = sprintf($lang_module['search_result_number'], $num_items);

if ($page > 1) {
    $page_title = $page_title . ' - ' . $lang_global['page'] . ' ' . $page;
}
$generate_page = '';
if ($num_items > $per_page) {
    $url_link = $_SERVER['REQUEST_URI'];
    if (strpos($url_link, '&page=') > 0) {
        $url_link = substr($url_link, 0, strpos($url_link, '&page='));
    } elseif (strpos($url_link, '?page=') > 0) {
        $url_link = substr($url_link, 0, strpos($url_link, '?page='));
    }
    $_array_url = array(
        'link' => $url_link,
        'amp' => '&page='
    );
    $generate_page = nv_generate_page($_array_url, $num_items, $per_page, $page);
}

$contents = nv_theme_bds_search($array_data, $is_search, $viewtype, $generate_page);

$array_mod_title[] = array(
    'title' => $page_title,
    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op
);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';