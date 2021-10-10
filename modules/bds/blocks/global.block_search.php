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
	
	if (! nv_function_exists('nv_bds_numoney_to_strmoney')) {

        function nv_bds_numoney_to_strmoney($money)
        {
            global $lang_module;
            
            if ($money >= 1000000 and $money < 1000000000) {
                $money = $money / 1000000;
                return $money . ' ' . $lang_module['million'];
            } elseif ($money >= 1000000000) {
                $money = $money / 1000000000;
                return $money . ' ' . $lang_module['billion'];
            }
            return $money;
        }
    }
	
    function nv_block_config_bds_search_blocks($module, $data_block, $lang_block)
    {
        global $site_mods;
        $html = '';
        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['search_template'] . '</label>';
        $html .= '<div class="col-sm-18">';
        $html .= "<select name=\"config_search_template\" class=\"form-control w200\">\n";
		$sl = (isset($data_block['search_template']) and $data_block['search_template'] == 'vertical') ? 'selected="selected"' : '';
		$html .= "<option value=\"vertical\" " . $sl . " >" . $lang_block['search_template_vertical'] . "</option>\n";
        $sl = (isset($data_block['search_template']) and $data_block['search_template'] == 'horizontal') ? 'selected="selected"' : '';
        $html .= "<option value=\"horizontal\" " . $sl . " >" . $lang_block['search_template_horizontal'] . "</option>\n";

        $html .= "</select>";
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
	
	function nv_block_config_bds_search_blocks_submit($module, $lang_block)
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
        global $module_array_cat, $site_mods, $module_info, $db, $module_config, $global_config, $module_name, $db_config, $nv_Request, $my_head, $op, $lang_module, $module_array_direction, $module_array_legal;
		
		$module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
		
		$tplfile = 'block_search_vertical.tpl';
        if ($block_config['search_template'] == 'horizontal') {
            $tplfile = 'block_search_horizontal.tpl';
        }
		
        if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $mod_file . '/' . $tplfile)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = 'default';
        }
        
        if ($module != $module_name) {
            require_once NV_ROOTDIR . '/modules/location/data.functions.php';
            
            $my_head .= '<link rel="StyleSheet" href="' . NV_BASE_SITEURL . 'themes/' . $block_theme . '/css/' . $site_mods[$module]['module_file'] . '.css">';
            
            include NV_ROOTDIR . '/modules/' . $site_mods[$module]['module_file'] . '/language/' . NV_LANG_INTERFACE . '.php';
        }
        
        $array_search = array(
            'q' => $nv_Request->get_title('q', 'post,get', ''),
            'catid' => $nv_Request->get_int('catid', 'post,get', 0),
            'direction' => $nv_Request->get_int('direction', 'post,get', 0),
			'legal' => $nv_Request->get_int('legal', 'post,get', 0),
			'bed_room' => $nv_Request->get_int('bed_room', 'post,get', 0),
			'bath_room' => $nv_Request->get_int('bath_room', 'post,get', 0),
			'price_spread' => $nv_Request->get_title('price_spread', 'post,get', ''),
			'area' => $nv_Request->get_title('price_spread', 'post,get', ''),
			'province' => $nv_Request->get_int('province', 'post,get', 0),
            'district' => $nv_Request->get_int('district', 'post,get', 0),
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
                $value['space'] = '';
                if ($value['lev'] > 0) {
                    for ($i = 1; $i <= $value['lev']; $i ++) {
                        $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                    }
                }
                $value['selected'] = $catid == $array_search['catid'] ? ' selected="selected"' : '';
                
                $xtpl->assign('CAT', $value);
                $xtpl->parse('main.cat');
            }
        }	

        if (! empty($module_array_direction)) {
            foreach ($module_array_direction as $direction) {
                $direction['selected'] = $array_search['direction'] == $direction['id'] ? 'selected="selected"' : '';
                $xtpl->assign('DIRECTION', $direction);
                $xtpl->parse('main.direction');
            }
        }
		
		if (! empty($module_array_legal)) {
            foreach ($module_array_legal as $legal) {
                $legal['selected'] = $array_search['legal'] == $legal['id'] ? 'selected="selected"' : '';
                $xtpl->assign('LEGAL', $legal);
                $xtpl->parse('main.legal');
            }
        }
		
		// Chon khoang gia
		$array_price_spread = array();
		$price_begin = 0;
		$price_end = 5000000000;
		$price_step = 1000000000;
		$val = $price_begin;
		while (true) {
			$price1 = $val;
			$price2 = $val + $price_step;
			if ($val < $price_end) {
				$array_price_spread[] = array(
				'index' => ($price1 + 1) . '-' . $price2,
				'title' => nv_bds_numoney_to_strmoney($price1, $mod_file) . ' - ' . nv_bds_numoney_to_strmoney($price2, $mod_file)
			);
			} elseif ($val >= $price_end) {
				$array_price_spread[] = array(
				'index' => $price1 . '-0',
				'title' => $lang_module['from'] . ' ' . nv_bds_numoney_to_strmoney($val, $mod_file)
				);
			}
			if ($val >= $price_end) {
				break;
			}
			$val += $price_step;
		}
            
		if (! empty($array_price_spread)) {
			foreach ($array_price_spread as $price_spread) {
				$price_spread['selected'] = $array_search['price_spread'] == $price_spread['index'] ? 'selected="selected"' : '';
				$xtpl->assign('PRICE_SPREAD', $price_spread);
				$xtpl->parse('main.price_spread');
			}
		}
		
		// Chon dien tich
		$array_area = array();
		$area_begin = 0;
		$area_end = 1000;
		$area_step = 100;
		$val = $area_begin;
		while (true) {
			$area1 = $val;
			$area2 = $val + $area_step;
			if ($val < $area_end) {
				$array_area[] = array(
				'index' => ($area1 + 1) . '-' . $area2,
				'title' => $area1 . ' - ' . $area2
				);
			} elseif ($val >= $area_end) {
				$array_area[] = array(
				'index' => $area1 . '-0',
				'title' => $lang_module['from'] . ' ' . $val
				);
			}
			if ($val >= $area_end) {
				break;
			}
			$val += $area_step;
		}
            
		if (! empty($array_area)) {
			foreach ($array_area as $area) {
				$area['selected'] = $array_search['area'] == $area['index'] ? 'selected="selected"' : '';
				$xtpl->assign('AREA', $area);
				$xtpl->parse('main.area');
			}
		}
		
		require_once NV_ROOTDIR . '/modules/location/location.class.php';
		$location = new Location();
        
		$location->set('SelectProvinceid', $array_search['province']);
		$location->set('SelectDistrictid', $array_search['district']);
		$location->set('IsDistrict', 1);
		$location->set('NameProvince', 'province');
		$location->set('NameDistrict', 'district');
		$location->set('BlankTitleProvince', 1);
		$location->set('BlankTitleDistrict', 1);
		if ($block_config['search_template'] == 'horizontal') {
			$location->set('ColClass', 'col-xs-24 col-sm-12 col-md-12');
		}else {
			$location->set('ColClass', 'col-xs-24 col-sm-24 col-md-24');
		}
		$xtpl->assign('PLACE', $location->buildInput());
        
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $db_config, $site_mods, $module_name, $array_bds_cat, $module_array_cat, $nv_Cache, $array_direction, $module_array_direction, $array_legal, $module_array_legal;
    
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        $mod_data = $site_mods[$module]['module_data'];
        if ($module == $module_name) {
            $module_array_cat = $array_bds_cat;
            $module_array_direction = $array_direction;
			$module_array_legal = $array_legal;
        } else {
            $module_array_cat = array();
            $_sql = 'SELECT id, parentid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, ' . NV_LANG_DATA . '_custom_title custom_title, ' . NV_LANG_DATA . '_keywords keywords, ' . NV_LANG_DATA . '_description description, ' . NV_LANG_DATA . '_description_html description_html, inhome, numlinks, viewtype, lev, numsub, subid, sort, weight, status, image, groups_view FROM ' . $db_config['prefix'] . '_' . $mod_data . '_cat WHERE status=1 ORDER BY sort ASC';
            $list = $nv_Cache->db($_sql, 'id', $module_name);
            foreach ($list as $l) {
                $module_array_cat[$l['id']] = $l;
                $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
            }
            
            $_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_note note FROM ' . $db_config['prefix'] . '_' . $mod_data . '_direction WHERE status=1 ORDER BY id DESC';
            $module_array_direction = $nv_Cache->db($_sql, 'id', $module);
			
			$_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_note note FROM ' . $db_config['prefix'] . '_' . $mod_data . '_legal WHERE status=1 ORDER BY id DESC';
            $module_array_legal = $nv_Cache->db($_sql, 'id', $module);
        }
        $content = nv_bds_block_search($block_config, $mod_data);
    }
}