<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Ho Ngoc Trien (hongoctrien@2mit.org)
 * @Copyright (C) 2015 Ho Ngoc Trien. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sun, 16 Aug 2015 01:05:44 GMT
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

require_once NV_ROOTDIR . '/modules/location/location.class.php';

if (! isset($site_mods['location']) or ! file_exists(NV_ROOTDIR . '/modules/location/location.class.php')) {
    $contents = nv_theme_alert($lang_module['error_location_title'], $lang_module['error_location_content'], 'danger');
    nv_info_die($lang_module['error_location_title'], $lang_module['error_location_title'], $lang_module['error_location_content']);
}

require_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

function nv_bds_delete($rows_id)
{
    global $db, $db_config, $module_data;
    
    // xoa bds
    $_sql = 'DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE id = ' . $rows_id;
    if ($db->exec($_sql)) {
        // xoa dat bds
        
        // xoa hinh anh khac
        nv_bds_image_delete($rows_id);
    }
}

function nv_bds_investor_delete($id)
{
    global $db, $db_config, $module_data;
    
    // xoa nha dau tu
    $_sql = 'DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_investor WHERE id = ' . $id;
    if ($db->exec($_sql)) {
        // xoa nha dau tu
        $result = $db->query('SELECT id FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE id=' . $id);
        while (list ($id) = $result->fetch(3)) {
            nv_bds_delete($id);
        }
    }
}

function nv_bds_image_delete($rows_id)
{
    global $db, $db_config, $module_data, $module_upload;
    
    // xoa hinh anh khac
    $result = $db->query('SELECT id, homeimgfile FROM ' . $db_config['prefix'] . '_' . $module_data . '_images WHERE rows_id=' . $rows_id);
    while (list ($id, $homeimgfile) = $result->fetch(3)) {
        $_sql = 'DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_images WHERE id = ' . $id;
        if ($db->exec($_sql)) {
            @nv_deletefile(NV_ROOTDIR . '/' . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile);
        }
    }
}

function nv_bds_booking_delete($booking_id)
{
    global $db, $db_config, $module_data;
    
    $_sql = 'DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_booking WHERE booking_id=' . $booking_id;
    $db->query($_sql);
}