<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 3/9/2010 23:25
 */
if (! defined('NV_MAINFILE'))
    die('Stop!!!');

if (! nv_function_exists('nv_bds_block_search')) {
	
    function nv_block_config_bds_search_home($module, $data_block, $lang_block)
    {
        global $site_mods;
        $html = '';
        
        return $html;
    }
	
	function nv_block_config_bds_search_home_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['search_template'] = $nv_Request->get_title('config_search_template', 'post', 'vertical');
        return $return;
    }


    function nv_bds_block_search($block_config, $mod_data)
    {
        global $module_array_cat, $site_mods, $module_info, $db, $module_config, $global_config, $module_name, $db_config, $nv_Request, $my_head, $op, $lang_module;
		
		$module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
		
		$tplfile = 'block_search_home.tpl';
		
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/' . $tplfile)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        $array_search = array(
            'q' => $nv_Request->get_title('q', 'post,get', ''),
            'catid' => $nv_Request->get_int('catid', 'post,get', 0),
            'province' => $nv_Request->get_int('province', 'post,get', 0),
			'bed_room' => $nv_Request->get_int('bed_room', 'post,get', 0),
			'bath_room' => $nv_Request->get_int('bath_room', 'post,get', 0)
        );

		$array_search['bed_room'] = !empty($array_search['bed_room']) ? $array_search['bed_room'] : '';
		$array_search['bath_room'] = !empty($array_search['bath_room']) ? $array_search['bath_room'] : '';
        
        $xtpl = new XTemplate($tplfile, NV_ROOTDIR . '/themes/' . $block_theme . '/modules/' . $mod_file);
        $xtpl->assign('LANG', $lang_module);
        $xtpl->assign('TEMPLATE', $block_theme);
        $xtpl->assign('MODULE_NAME', $module);
        $xtpl->assign('SEARCH', $array_search);
        
        if (! empty($module_array_cat)) {
            foreach ($module_array_cat as $catid => $value) {
                $value['selected'] = $catid == $array_search['catid'] ? ' selected="selected"' : '';
                
                $xtpl->assign('CAT', $value);
                $xtpl->parse('main.cat');
            }
        }

        require_once NV_ROOTDIR . '/modules/location/location.class.php';
        $location = new Location();

        $location->set('SelectProvinceid', $array_search['province']);
        $location->set('NameProvince', 'province');
        $location->set('BlankTitleProvince', 1);
        
        $location->set('ColClass', 'col-xs-24 col-sm-24 col-md-24');
        $xtpl->assign('PLACE', $location->buildInput());
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $db_config, $site_mods, $module_name, $array_bds_cat, $module_array_cat, $nv_Cache;
    
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $mod_data = $site_mods[$module]['module_data'];
        if ($module == $module_name) {
            $module_array_cat = $array_bds_cat;
        } else {
            $module_array_cat = array();
            $_sql = 'SELECT id, parentid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, ' . NV_LANG_DATA . '_custom_title custom_title, ' . NV_LANG_DATA . '_keywords keywords, ' . NV_LANG_DATA . '_description description, ' . NV_LANG_DATA . '_description_html description_html, inhome, numlinks, viewtype, lev, numsub, subid, sort, weight, status, image, groups_view FROM ' . $db_config['prefix'] . '_' . $mod_data . '_cat WHERE status=1 ORDER BY sort ASC';
            $list = $nv_Cache->db($_sql, 'id', $module_name);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
        }
        $content = nv_bds_block_search($block_config, $mod_data);
    }
}