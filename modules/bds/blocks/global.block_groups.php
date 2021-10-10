<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Sat, 10 Dec 2011 06:46:54 GMT
 */
if (! defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (! nv_function_exists('nv_block_bds_groups')) {

    function nv_block_config_bds_groups($module, $data_block, $lang_block)
    {
        global $db_config, $nv_Cache, $site_mods;
        
        $html_input = '';

        $html = '';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['blockid'] . ':</label>';
        $html .= '<div class="col-sm-9"><select name="config_blockid" class="form-control">';
        $sql = 'SELECT bid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias FROM ' . $db_config['prefix'] . '_' . $site_mods[$module]['module_data'] . '_block_cat ORDER BY weight ASC';
        $list = $nv_Cache->db($sql, '', $module);
        foreach ($list as $l) {
            $html_input .= '<input type="hidden" id="config_blockid_' . $l['bid'] . '" value="' . NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $site_mods[$module]['alias']['groups'] . '/' . $l['alias'] . '" />';
            $html .= '<option value="' . $l['bid'] . '" ' . (($data_block['blockid'] == $l['bid']) ? ' selected="selected"' : '') . '>' . $l['title'] . '</option>';
        }
        $html .= '</select>';
        $html .= $html_input;
        $html .= '<script type="text/javascript">';
        $html .= '  $("select[name=config_blockid]").change(function() {';
        $html .= '      $("input[name=title]").val($("select[name=config_blockid] option:selected").text());';
        $html .= '      $("input[name=link]").val($("#config_blockid_" + $("select[name=config_blockid]").val()).val());';
        $html .= '  });';
        $html .= '</script>';
        $html .= '</div></div>';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['numrow'] . ':</label>';
        $html .= '<div class="col-sm-9"><input type="text" class="form-control w200" name="config_numrow" size="5" value="' . $data_block['numrow'] . '"/></div>';
        $html .= '</div>';

        $html .= '<div class="form-group">';
        $html .= '<label class="control-label col-sm-6">' . $lang_block['show_type'] . ':</label>';
        $html .= '<div class="col-sm-9"><select name="config_show_type" class="form-control">';

        for ($i = 0; $i <= 1; $i ++) {
            $html .= '<option value="' . $i . '"' . ($i == $data_block['show_type'] ? ' selected="selected"' : '') . '>' . $lang_block['show_type' . $i] . '</option>';
        }

        $html .= '</select></div>';
        $html .= '</div>';

        return $html;
    }

    function nv_block_config_bds_groups_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['blockid'] = $nv_Request->get_int('config_blockid', 'post', 0);
        $return['config']['numrow'] = $nv_Request->get_int('config_numrow', 'post', 0);
        $return['config']['show_type'] = $nv_Request->get_int('config_show_type', 'post', 0);
        return $return;
    }

    function nv_block_bds_groups($block_config)
    {
        global $db_config, $module_array_cat, $module_info, $site_mods, $module_config, $global_config, $nv_Cache, $db, $array_config, $lang_module, $money_config, $module_name, $module_upload, $array_unit, $my_head, $array_bds_cat;
        
        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $mod_upload = $site_mods[$module]['module_upload'];
        
        $db->sqlreset()
            ->select('t1.id, catid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, homeimgfile, homeimgthumb, ' . NV_LANG_DATA . '_description description, province, district, price, money_unit, groups_view, show_price, area, bed_room, bath_room, unitid')
            ->from($db_config['prefix'] . '_' . $site_mods[$module]['module_data'] . '_rows t1')
            ->join('INNER JOIN ' . $db_config['prefix'] . '_' . $site_mods[$module]['module_data'] . '_block t2 ON t1.id = t2.id')
            ->where('t2.bid= ' . $block_config['blockid'] . ' AND t1.status= 1')
            ->order('t2.weight ASC')
            ->limit($block_config['numrow']);
        $list = $nv_Cache->db($db->sql(), '', $module);
        
        if (! empty($list)) {
            
            if (file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/bds/block_groups.tpl')) {
                $block_theme = $global_config['module_theme'];
            } else {
                $block_theme = 'default';
            }
            
            if ($module != $module_name) {
                $module_name = $module;
                $module_data = $mod_data;
                $module_file = $mod_file;
                $module_upload = $mod_upload;
                require_once NV_ROOTDIR . '/modules/' . $mod_file . '/site.functions.php';
            }
            
            $xtpl = new XTemplate('block_groups.tpl', NV_ROOTDIR . '/themes/' . $block_theme . '/modules/bds');
            $xtpl->assign('LANG', $lang_module);
            $xtpl->assign('TEMPLATE', $block_theme);
            require_once NV_ROOTDIR . '/modules/location/location.class.php';
            $location = new Location();
            
            foreach ($list as $l) {
                if (nv_user_in_groups($l['groups_view'])) {
                    $l['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'] . '/' . $l['alias'] . $global_config['rewrite_exturl'];
                    $l['link_cat'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $module_array_cat[$l['catid']]['alias'];
                    $l['thumb'] = nv_bds_get_thumb($l['homeimgfile'], $l['homeimgthumb'], $mod_upload);
                    $l['unit'] = ! empty($l['unitid']) ? $array_unit[$l['unitid']]['title'] : '';
                    $l['address'] = $location->locationString($l['province'], $l['district']);
                    $l['catid'] = $module_array_cat[$l['catid']]['title'];
                    $l['price'] = nv_bds_number_format($l['price']);
                    
                    $xtpl->assign('ROW', $l);
                    if ($l['show_price'] == '1') {
                        $xtpl->parse('main.type' . $block_config['show_type'] . '.loop.price');
                    } else {
                        $xtpl->parse('main.type' . $block_config['show_type'] . '.loop.contact');
                    }
                    $xtpl->parse('main.type' . $block_config['show_type'] . '.loop');
                }
            }
             $xtpl->parse('main.type' . $block_config['show_type']);
            $xtpl->parse('main');
            return $xtpl->text('main');
        }
    }
}
if (defined('NV_SYSTEM')) {
    
    global $site_mods, $module_name, $array_bds_cat, $module_array_cat, $nv_Cache, $db, $db_config, $array_unit, $module_data;
    
    $module = $block_config['module'];
    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_bds_cat;
        } else {
            $module_array_cat = array();
            $_sql = 'SELECT id, parentid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, ' . NV_LANG_DATA . '_custom_title custom_title, ' . NV_LANG_DATA . '_keywords keywords, ' . NV_LANG_DATA . '_description description, ' . NV_LANG_DATA . '_description_html description_html, inhome, numlinks, viewtype, lev, numsub, subid, sort, weight, status, image, groups_view FROM ' . $db_config['prefix'] . '_' . $site_mods[$module]['module_data'] . '_cat WHERE status=1 ORDER BY sort ASC';
            $list = $nv_Cache->db($_sql, 'id', $module);
            if (! empty($list)) {
                foreach ($list as $l) {
                    $module_array_cat[$l['id']] = $l;
                    $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_block_bds_groups($block_config);
    }
}