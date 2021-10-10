<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 07 Sep 2016 01:59:00 GMT
 */
if (! defined('NV_IS_FILE_SITEINFO'))
    die('Stop!!!');

$lang_siteinfo = nv_get_lang_module($mod);

$number = $db->query('SELECT COUNT(*) FROM ' . $db_config['prefix'] . '_' . $mod_data . '_booking WHERE status=0')->fetchColumn();
if ($number > 0) {
    $pendinginfo[] = array(
        'key' => $lang_siteinfo['queue'],
        'value' => $number,
        'link' => NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $mod . '&amp;' . NV_OP_VARIABLE . '=booking&amp;status=0'
    );
}