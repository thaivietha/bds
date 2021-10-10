<?php

/**
 * @Project NUKEVIET 4.x
 * @Author hongoctrien (contact@mynukeviet.net)
 * @Copyright (C) 2016 hongoctrien. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sun, 08 May 2016 07:42:57 GMT
 */
if (! defined('NV_SYSTEM'))
    die('Stop!!!');

define('NV_IS_MOD_BDS', true);
require_once NV_ROOTDIR . '/modules/' . $module_file . '/global.functions.php';
require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

$page = 1;
$per_page = $array_config['per_page'];

$catid = $parentid = 0;
$alias_cat_url = isset($array_op[0]) ? $array_op[0] : '';
$array_mod_title = array();

// Categories
foreach ($array_bds_cat as $row) {
    $array_bds_cat[$row['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];
    if ($alias_cat_url == $row['alias']) {
        $catid = $row['id'];
        $parentid = $row['parentid'];
    }
}

$count_op = sizeof($array_op);
if (! empty($array_op) and $op == 'main') {
    if ($catid == 0) {
        $contents = $lang_module['nocatpage'] . $array_op[0];
        if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
            $page = intval(substr($array_op[0], 5));
        } elseif (! empty($alias_cat_url)) {
            $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
            nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
        }
    } else {
        $op = 'main';
        if (sizeof($array_op) == 2 and preg_match('/^([a-z0-9\-]+)$/i', $array_op[1]) and ! preg_match('/^page\-([0-9]+)$/', $array_op[1], $m2)) {
            $op = 'detail';
            $alias_url = $array_op[1];
        } else {
            $op = 'viewcat';
            if (isset($array_op[1]) and substr($array_op[1], 0, 5) == 'page-') {
                $page = intval(substr($array_op[1], 5));
            }
        }
        
        $parentid = $catid;
        while ($parentid > 0) {
            $array_cat_i = $array_bds_cat[$parentid];
            $array_mod_title[] = array(
                'catid' => $parentid,
                'title' => $array_cat_i['title'],
                'link' => $array_cat_i['link']
            );
            $parentid = $array_cat_i['parentid'];
        }
        sort($array_mod_title, SORT_NUMERIC);
    }
}

/**
 * nv_bds_getCatidInParent()
 *
 * @param mixed $catid            
 * @return
 *
 */
function nv_bds_getCatidInParent($catid)
{
    global $array_bds_cat;
    
    $_array_cat = array();
    $_array_cat[] = $catid;
    $subcatid = explode(',', $array_bds_cat[$catid]['subid']);
    
    if (! empty($subcatid)) {
        foreach ($subcatid as $id) {
            if ($id > 0) {
                if ($array_bds_cat[$id]['numsub'] == 0) {
                    $_array_cat[] = $id;
                } else {
                    $array_cat_temp = nv_bds_getCatidInParent($id);
                    foreach ($array_cat_temp as $catid_i) {
                        $_array_cat[] = $catid_i;
                    }
                }
            }
        }
    }
    return array_unique($_array_cat);
}

function nv_bds_listmail_admin()
{
    global $db, $global_config, $array_config;
    
    $array_mail = array();
    if (! empty($array_config['booking_groups_sendmail'])) {
        $result = $db->query('SELECT email FROM ' . NV_USERS_GLOBALTABLE . ' WHERE userid IN ( SELECT userid FROM ' . NV_GROUPS_GLOBALTABLE . '_users WHERE group_id IN ( ' . $array_config['booking_groups_sendmail'] . ' ) )');
        while (list ($email) = $result->fetch(3)) {
            $array_mail[] = $email;
        }
    }
    $array_mail = array_unique($array_mail);
    return $array_mail;
}