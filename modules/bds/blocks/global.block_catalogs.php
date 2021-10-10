<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2017 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 04/18/2017 09:47
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (!function_exists('nv_pro_catalogs')) {

    /**
     * nv_block_config_catalogs_blocks()
     *
     * @param mixed $module
     * @param mixed $data_block
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_catalogs_blocks($module, $data_block, $lang_block)
    {
        global $db, $language_array, $db_config;

        $html = "";
        $html .= "<div class=\"form-group\">";
        $html .= "	<label class=\"control-label col-sm-6\">" . $lang_block['cut_num'] . "</label>";
        $html .= "	<div class=\"col-sm-18\"><input class=\"form-control w150\" type=\"text\" name=\"config_cut_num\" size=\"5\" value=\"" . $data_block['cut_num'] . "\"/></div>";
        $html .= "</div>";

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

    /**
     * nv_block_config_catalogs_blocks_submit()
     *
     * @param mixed $module
     * @param mixed $lang_block
     * @return
     */
    function nv_block_config_catalogs_blocks_submit($module, $lang_block)
    {
        global $nv_Request;
        $return = array();
        $return['error'] = array();
        $return['config'] = array();
        $return['config']['cut_num'] = $nv_Request->get_int('config_cut_num', 'post', 0);
        $return['config']['show_type'] = $nv_Request->get_int('config_show_type', 'post', 0);
        return $return;
    }

    /**
     * nv_pro_catalogs()
     *
     * @param mixed $block_config
     * @return
     */
    function nv_pro_catalogs($block_config)
    {
        global $nv_Cache, $site_mods, $global_config, $module_config, $module_name, $module_info, $module_array_cat, $db, $db_config;

        $module = $block_config['module'];
        $mod_data = $site_mods[$module]['module_data'];
        $mod_file = $site_mods[$module]['module_file'];
        $pro_config = $module_config[$module];

        $block_tpl_name = "block_catalogs.tpl";
        if (file_exists(NV_ROOTDIR . "/themes/" . $global_config['module_theme'] . "/modules/" . $mod_file . "/" . $block_tpl_name)) {
            $block_theme = $global_config['module_theme'];
        } else {
            $block_theme = "default";
        }

        $xtpl = new XTemplate($block_tpl_name, NV_ROOTDIR . "/themes/" . $block_theme . "/modules/" . $mod_file);
        $xtpl->assign('TEMPLATE', $block_theme);
        $cut_num = $block_config['cut_num'];

        foreach ($module_array_cat as $cat) {
            if ($cat['parentid'] == 0) {
                $xtpl->assign('ROW', $cat);
                $xtpl->parse('main.type' . $block_config['show_type'] . '.loop');
            }
        }
        $xtpl->parse('main.type' . $block_config['show_type']);
        $xtpl->parse('main');
        return $xtpl->text('main');
    }
}

if (defined('NV_SYSTEM')) {
    global $db_config, $site_mods, $module_name, $array_bds_cat, $module_array_cat, $nv_Cache, $db;
    $module = $block_config['module'];

    if (isset($site_mods[$module])) {
        if ($module == $module_name) {
            $module_array_cat = $array_bds_cat;
            unset($module_array_cat[0]);
        } else {
            $module_array_cat = array();
            $sql = 'SELECT id, parentid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, numlinks, groups_view, status FROM ' . $db_config['prefix'] . '_' . $site_mods[$module]['module_data'] . '_cat ORDER BY sort ASC';
            $list = $nv_Cache->db($sql, 'id', $module);
            if(!empty($list))
            {
                foreach ($list as $l) {
                    $module_array_cat[$l['id']] = $l;
                    $module_array_cat[$l['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module . '&amp;' . NV_OP_VARIABLE . '=' . $l['alias'];
                }
            }
        }
        $content = nv_pro_catalogs($block_config);
    }
}
