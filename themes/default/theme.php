<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2014 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 31/05/2010, 00:36
 */

if (!defined('NV_SYSTEM') or !defined('NV_MAINFILE')) {
    die('Stop!!!');
}

/**
 * @param string $title
 * @param string $content
 * @param string $footer
 * @return string
 */
function nv_mailHTML($title, $content, $footer = '')
{
    global $global_config, $lang_global;
    $xtpl = new XTemplate('mail.tpl', NV_ROOTDIR . '/themes/default/system');
    $xtpl->assign('SITE_URL', NV_MY_DOMAIN);
    $xtpl->assign('GCONFIG', $global_config);
    $xtpl->assign('LANG', $lang_global);
    $xtpl->assign('MESSAGE_TITLE', $title);
    $xtpl->assign('MESSAGE_CONTENT', $content);
    $xtpl->assign('MESSAGE_FOOTER', $footer);
    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * @param string $contents
 * @param boolean $full
 * @return mixed|string
 */
function nv_site_theme($contents, $full = true)
{
    global $home, $array_mod_title, $lang_global, $global_config, $site_mods, $module_name, $module_info, $op_file, $mod_title, $my_head, $my_footer, $client_info, $module_config, $op, $nv_plugin_area;

    // Determine tpl file, check exists tpl file
    $layout_file = ($full) ? 'layout.' . $module_info['layout_funcs'][$op_file] . '.tpl' : 'simple.tpl';

    if (!file_exists(NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/layout/' . $layout_file)) {
        nv_info_die($lang_global['error_layout_title'], $lang_global['error_layout_title'], $lang_global['error_layout_content']);
    }

    if (isset($global_config['sitetimestamp'])) {
        $global_config['timestamp'] += $global_config['sitetimestamp'];
    }

    $site_favicon = NV_BASE_SITEURL . 'favicon.ico';
    if (!empty($global_config['site_favicon']) and file_exists(NV_ROOTDIR . '/' . $global_config['site_favicon'])) {
        $site_favicon = NV_BASE_SITEURL . $global_config['site_favicon'];
    }

    if (isset($nv_plugin_area[4])) {
        // Kết nối với các plugin sau khi xây dựng nội dung module
        foreach ($nv_plugin_area[4] as $_fplugin) {
            include NV_ROOTDIR . '/includes/plugin/' . $_fplugin;
        }
    }

    $xtpl = new XTemplate($layout_file, NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/layout');
    $xtpl->assign('LANG', $lang_global);
    $xtpl->assign('TEMPLATE', $global_config['module_theme']);
    $xtpl->assign('NV_BASE_SITEURL', NV_BASE_SITEURL);

    $xtpl->assign('NV_SITE_COPYRIGHT', $global_config['site_name'] . ' [' . $global_config['site_email'] . '] ');
    $xtpl->assign('NV_SITE_NAME', $global_config['site_name']);
    $xtpl->assign('NV_SITE_TITLE', $global_config['site_name'] . NV_TITLEBAR_DEFIS . $lang_global['admin_page'] . NV_TITLEBAR_DEFIS . $module_info['custom_title']);
    $xtpl->assign('SITE_DESCRIPTION', $global_config['site_description']);
    $xtpl->assign('NV_CHECK_PASS_MSTIME', (intval($global_config['user_check_pass_time']) - 62) * 1000);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
    $xtpl->assign('NV_LANG_INTERFACE', NV_LANG_INTERFACE);
    $xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
    $xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
    $xtpl->assign('NV_CURRENTTIME', nv_date($global_config['date_pattern'] . ', ' . $global_config['time_pattern'], NV_CURRENTTIME));
    $xtpl->assign('NV_COOKIE_PREFIX', $global_config['cookie_prefix']);
    $xtpl->assign('SITE_FAVICON', $site_favicon);
    $xtpl->assign('NV_MY_DOMAIN', NV_MY_DOMAIN);

    // System variables
    $xtpl->assign('THEME_PAGE_TITLE', nv_html_page_title(false));

    // Meta-tags
    $metatags = nv_html_meta_tags(false);
    if ($global_config['current_theme_type'] == 'r') {
        $metatags[] = [
            'name' => 'name',
            'value' => 'viewport',
            'content' => 'width=device-width, initial-scale=1'
        ];
    }

    foreach ($metatags as $meta) {
        $xtpl->assign('THEME_META_TAGS', $meta);
        $xtpl->parse('main.metatags');
    }

    //Links
    $html_links = [];
    $html_links[] = [
        'rel' => 'stylesheet',
        'href' => NV_BASE_SITEURL . NV_ASSETS_DIR . '/css/font-awesome.min.css'
    ];
    if ($global_config['current_theme_type'] == 'r') {
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/bootstrap.min.css'
        ];
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/style.css'
        ];
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/style.responsive.css'
        ];
    } else {
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/bootstrap.non-responsive.css'
        ];
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/style.css'
        ];
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/style.non-responsive.css'
        ];
    }
    if (defined('NV_IS_ADMIN') and $full) {
        $html_links[] = [
            'rel' => 'stylesheet',
            'href' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/css/admin.css'
        ];
    }
    $html_links = array_merge_recursive($html_links, nv_html_links(false));

    foreach ($html_links as $links) {
        foreach ($links as $key => $value) {
            $xtpl->assign('LINKS', [
                'key' => $key,
                'value' => $value
            ]);
            if (!empty($value)) {
                $xtpl->parse('main.links.attr.val');
            }
            $xtpl->parse('main.links.attr');
        }
        $xtpl->parse('main.links');
    }

    $html_js = nv_html_site_js(false);
    $html_js[] = [
        'ext' => 1,
        'content' => NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/js/main.js'
    ];

    foreach ($html_js as $js) {
        if ($js['ext']) {
            $xtpl->assign('JS_SRC', $js['content']);
            $xtpl->parse('main.js.ext');
        } else {
            $xtpl->assign('JS_CONTENT', PHP_EOL . $js['content'] . PHP_EOL);
            $xtpl->parse('main.js.int');
        }
        $xtpl->parse('main.js');
    }

    if ($client_info['browser']['key'] == 'explorer' and $client_info['browser']['version'] < 9) {
        $xtpl->parse('main.lt_ie9');
    }

    // Module contents
    $xtpl->assign('MODULE_CONTENT', $contents);

    // Header variables
    $xtpl->assign('SITE_NAME', $global_config['site_name']);
    $xtpl->assign('THEME_SITE_HREF', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA);
    $xtpl->assign('LOGO_SRC', NV_BASE_SITEURL . $global_config['site_logo']);

    if (empty($global_config['site_banner'])) {
        $xtpl->assign('BANNER_SRC', NV_BASE_SITEURL . 'themes/' . $global_config['module_theme'] . '/images/header.png');
    } else {
        $xtpl->assign('BANNER_SRC', NV_BASE_SITEURL . $global_config['site_banner']);
    }

    if (preg_match("/<h1[^\>]*\>/i", $contents)) {
        $xtpl->parse('main.site_name_span');
    } else {
        $xtpl->parse('main.site_name_h1');
    }

    // Only full theme
    if ($full) {
        // Search form variables
        $xtpl->assign('NV_MAX_SEARCH_LENGTH', NV_MAX_SEARCH_LENGTH);
        $xtpl->assign('NV_MIN_SEARCH_LENGTH', NV_MIN_SEARCH_LENGTH);

        if (!$global_config['rewrite_enable']) {
            $xtpl->assign('THEME_SEARCH_URL', NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek&amp;q=');
        } else {
            $xtpl->assign('THEME_SEARCH_URL', nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=seek', true) . '?q=');
        }

        // Breadcrumbs
        if (!$home) {
            $array_mod_title_copy = $array_mod_title;
            if ($global_config['rewrite_op_mod'] != $module_name) {
                $arr_cat_title_i = [
                    'catid' => 0,
                    'title' => $module_info['custom_title'],
                    'link' => NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name
                ];
                array_unshift($array_mod_title_copy, $arr_cat_title_i);
            }
            if (!empty($array_mod_title_copy)) {
                $border = 2;
                foreach ($array_mod_title_copy as $arr_cat_title_i) {
                    $arr_cat_title_i['position'] = $border++;
                    $xtpl->assign('BREADCRUMBS', $arr_cat_title_i);
                    $xtpl->parse('main.breadcrumbs.loop');
                }
            }
            $xtpl->parse('main.breadcrumbs');
            $xtpl->parse('main.header_no_home');
            $xtpl->parse('main.body_content');
        } elseif (empty($array_mod_title_copy)) {
            $xtpl->parse('main.home');
        }
    }

    $xtpl->parse('main');
    $sitecontent = $xtpl->text('main');

    // Only full theme
    if ($full) {
        $sitecontent = nv_blocks_content($sitecontent);
        $sitecontent = str_replace('[THEME_ERROR_INFO]', nv_error_info(), $sitecontent);
    }

    if (!empty($my_head)) {
        $sitecontent = preg_replace('/(<\/head>)/i', $my_head . '\\1', $sitecontent, 1);
    }
    if (!empty($my_footer)) {
        $sitecontent = preg_replace('/(<\/body>)/i', $my_footer . '\\1', $sitecontent, 1);
    }

    if (defined('NV_IS_ADMIN') and $full) {
        $sitecontent = preg_replace('/(<\/body>)/i', PHP_EOL . nv_admin_menu() . PHP_EOL . '\\1', $sitecontent, 1);
    }

    return $sitecontent;
}

/**
 * @param string $title
 * @param string $content
 * @param integer $code
 */
function nv_error_theme($title, $content, $code)
{
    nv_info_die($title, $title, $content, $code);
}
