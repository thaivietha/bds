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

/**
 * nv_theme_bds_main()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bds_main($array_data, $viewtype, $page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_bds_cat, $array_config;
    
    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $data) {
            $data['title_clean'] = nv_clean60($data['title'], $array_config['title_lenght']);
            $data['catid'] = $array_bds_cat[$data['catid']]['title'];
            $data['price'] = nv_bds_number_format($data['price']);
            
            $xtpl->assign('ROW', $data);
            if ($data['show_price'] == '1') {
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }

    if (! empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_main_cat()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bds_main_cat($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
    
    $xtpl = new XTemplate('main_cat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $catid => $catinfo) {
            if ($catinfo['countcar'] > 0) {
                $xtpl->assign('CAT', $catinfo);
                if (nv_function_exists('nv_theme_bds_' . $catinfo['viewtype'])) {
                    $xtpl->assign('BDS', call_user_func('nv_theme_bds_' . $catinfo['viewtype'], $catinfo['bds']));
                }
                
                if ($catinfo['countcar'] > $catinfo['numlinks']) {
                    $xtpl->parse('main.cat.viewall');
                }
                
                $xtpl->parse('main.cat');
            }
        }
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_viewcat()
 *
 * @param mixed $array_data            
 * @param mixed $viewtype            
 * @return
 *
 */
function nv_theme_bds_viewcat($array_data, $viewtype, $page = '')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $catid, $array_bds_cat, $module_upload;
    
    $is_image = 0;
    if (! empty($array_bds_cat[$catid]['image'])) {
        $array_bds_cat[$catid]['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_cat[$catid]['image'];
        $is_image = 1;
    }
    
    $xtpl = new XTemplate('viewcat.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('CAT_INFO', $array_bds_cat[$catid]);
    
    if (nv_function_exists('nv_theme_bds_' . $viewtype)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_bds_' . $viewtype, $array_data));
    } else {
        return '';
    }
    
    if ($is_image) {
        $xtpl->parse('main.image');
    }
    
    if (! empty($array_bds_cat[$catid]['description_html'])) {
        $xtpl->parse('main.description');
    }
    
    if (! empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_viewgrid()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bds_viewgrid($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_bds_cat, $array_config;
    
    $xtpl = new XTemplate('viewgrid.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $data) {
            $data['title_clean'] = nv_clean60($data['title'], $array_config['title_lenght']);
            $data['catid'] = $array_bds_cat[$data['catid']]['title'];
            $data['price'] = nv_bds_number_format($data['price']);
            
            $xtpl->assign('ROW', $data);
            if ($data['show_price'] == '1') {
                // $price = nv_bds_get_price($data['id'], $array_config['money_unit']);
                // $xtpl->assign('PRICE', $price);
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_viewlist()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bds_viewlist($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config;
    
    $xtpl = new XTemplate('viewlist.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $data) {
            $data['title_clean'] = $data['title'];
            $xtpl->assign('ROW', $data);
            
            if ($data['show_price'] == '1') {
                $price = nv_bds_get_price($data['id'], $array_config['money_unit']);
                $xtpl->assign('PRICE', $price);
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            if (! empty($data['firm'])) {
                $xtpl->parse('main.loop.firm');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_detail()
 *
 * @param mixed $array_data            
 * @param mixed $array_bds_other            
 * @return
 *
 */
function nv_theme_bds_detail($bds_info, $contact_info)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $money_config, $client_info, $array_keyword, $array_legal, $array_direction, $array_bds_cat, $array_investor;

    $bds_info['price'] = nv_bds_number_format($bds_info['price']);
    $bds_info['link_cat'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_bds_cat[$bds_info['catid']]['alias'];
    $bds_info['catid'] = $array_bds_cat[$bds_info['catid']]['title'];
    $bds_info['investor'] = !empty($bds_info['investor']) ? $array_investor[$bds_info['investor']]['title'] : '';

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('DATA', $bds_info);
    $xtpl->assign('CONTACT', $contact_info);
    $xtpl->assign('TEMPLATE', $module_info['template']);
    $xtpl->assign('SELFURL', $client_info['selfurl']);
    
    if (! empty($bds_info['image'])) {
        foreach ($bds_info['image'] as $image) {
            $xtpl->assign('IMAGE', $image);
            if (! empty($image['description'])) {
                $xtpl->parse('main.image.loop.description');
            }
            $xtpl->parse('main.image.loop');
        }
        $xtpl->parse('main.image');
    } else {
        $xtpl->parse('main.noimage');
    }
    
    if ($bds_info['show_price'] == '1') {
        $xtpl->parse('main.price');
    } else {
        $xtpl->parse('main.contact');
    }
    
    if (!empty($bds_info['description_html'])) {
        $xtpl->parse('main.description_html');
    }

    if (!empty($bds_info['amenities'])) {
        foreach ($bds_info['amenities'] as $amenities) {
            $xtpl->assign('AMENITIES', $amenities);
            $xtpl->parse('main.amenities.loop');
        }
        $xtpl->parse('main.amenities');
    }
    
    if(!empty($bds_info['investor'])){
        $xtpl->parse('main.investor');
    }
    
    if (!empty($array_bds_other)) {
        $xtpl->assign('BDS_OTHER', nv_theme_bds_viewlist($array_bds_other));
        $xtpl->parse('main.bds_other');
    }
	
	if (!empty($bds_info['legal'])) {
		$xtpl->parse('main.legal');
	}
	
	if (!empty($bds_info['direction'])) {
		$xtpl->parse('main.direction');
	}

    if (!empty($bds_info['room'])) {
        $xtpl->parse('main.room');
        $xtpl->parse('main.room_list');
    }
    
	if (!empty($bds_info['bed_room'])) {
		$xtpl->parse('main.bed_room');
        $xtpl->parse('main.bed_room_list');
	}
	
	if (!empty($bds_info['bath_room'])) {
		$xtpl->parse('main.bath_room');
        $xtpl->parse('main.bath_room_list');
	}

    if (!empty($bds_info['coast'])) {
        $xtpl->parse('main.coast');
    }

    if (!empty($bds_info['supermarket'])) {
        $xtpl->parse('main.supermarket');
    }

    if (!empty($bds_info['airport'])) {
        $xtpl->parse('main.airport');
    }

    if (!empty($bds_info['hospital'])) {
        $xtpl->parse('main.hospital');
    }

    if (!empty($bds_info['park'])) {
        $xtpl->parse('main.park');
    }

    if (!empty($bds_info['bank'])) {
        $xtpl->parse('main.bank');
    }

    if (!empty($bds_info['railway'])) {
        $xtpl->parse('main.railway');
    }

    if (!empty($bds_info['schools'])) {
        $xtpl->parse('main.schools');
    }

    if (!empty($bds_info['bus'])) {
        $xtpl->parse('main.bus');
    }

    if (defined('NV_IS_MODADMIN')) {
        $xtpl->assign('URL_EDIT', NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&id=' . $bds_info['id']);
        $xtpl->parse('main.admin_control');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_search()
 *
 * @param mixed $array_data            
 * @param mixed $viewtype            
 * @param mixed $page            
 * @return
 *
 */
function nv_theme_bds_search($array_data, $is_search, $viewtype, $page)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op;
    
    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if ($is_search) {
        if (! empty($array_data)) {
            if (nv_function_exists('nv_theme_bds_' . $viewtype)) {
                $xtpl->assign('DATA', call_user_func('nv_theme_bds_' . $viewtype, $array_data));
            } else {
                return '';
            }
            
            if (! empty($page)) {
                $xtpl->assign('PAGE', $page);
                $xtpl->parse('main.result.page');
            }
            $xtpl->parse('main.result');
        } else {
            $xtpl->parse('main.result_empty');
        }
    } else {
        $xtpl->parse('main.empty');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_bds_viewgridsearch()
 *
 * @param mixed $array_data            
 * @return
 *
 */
function nv_theme_bds_viewgridsearch($array_data)
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_bds_cat, $array_config;
    
    $xtpl = new XTemplate('viewgridsearch.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    
    if (! empty($array_data)) {
        foreach ($array_data as $data) {
            $data['title_clean'] = nv_clean60($data['title'], $array_config['title_lenght']);
            $data['catid'] = $array_bds_cat[$data['catid']]['title'];
            
            $xtpl->assign('ROW', $data);
            if ($data['show_price'] == '1') {
                $price = nv_bds_get_price($data['id'], $array_config['money_unit']);
                $xtpl->assign('PRICE', $price);
                $xtpl->parse('main.loop.price');
            } else {
                $xtpl->parse('main.loop.contact');
            }
            
            $xtpl->parse('main.loop');
        }
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * function nv_theme_bds_viewgroups()
 *
 * @param mixed $array_data            
 * @param mixed $viewtype            
 * @param mixed $page            
 * @return
 *
 */
function nv_theme_bds_viewgroups($groups_data, $array_data, $viewtype, $page = '')
{
    global $global_config, $module_name, $module_file, $lang_module, $module_config, $module_info, $op, $array_config, $catid, $array_bds_cat, $module_upload;
    
    $xtpl = new XTemplate('viewgroup.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GROUP_INFO', $groups_data);
    
    if (nv_function_exists('nv_theme_bds_' . $viewtype)) {
        $xtpl->assign('DATA', call_user_func('nv_theme_bds_' . $viewtype, $array_data));
    } else {
        return '';
    }
    
    if (! empty($page)) {
        $xtpl->assign('PAGE', $page);
        $xtpl->parse('main.page');
    }
    
    $xtpl->parse('main');
    return $xtpl->text('main');
}