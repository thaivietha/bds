<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@mynukeviet.net)
 * @Copyright (C) 2016 mynukeviet. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 07 Sep 2016 01:59:00 GMT
 */
if (!defined('NV_ADMIN') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}
$module_version = array(
    'name' => 'BĐS',
    'modfuncs' => 'main,detail,search,viewcat,groups',
    'change_alias' => 'groups',
    'submenu' => 'main,search',
    'is_sysmod' => 0,
    'virtual' => 1,
    'version' => '1.0.00',
    'date' => 'Wed, 7 Sep 2016 01:59:00 GMT',
    'author' => 'BCB SOLUTIONS (contact@bcbsolution.vn)',
    'uploads_dir' => array(
        $module_upload,
        $module_upload . '/investor'
    ),
    'note' => 'Module BĐS'
);