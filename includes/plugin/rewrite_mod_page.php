<?php

/**
 * @Project NUKEVIET 4.x
 * @Author mynukeviet (contact@tdfoss.vn)
 * @Copyright (C) 2017 TDFOSS.,LTD. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 21/07/2017 13:45
 */

if (!defined('NV_MAINFILE')) {
    die('Stop!!!');
}

if (defined('NV_SYSTEM')) {
    /**
     * Chỉnh lại nếu url có dạng http://domain.com/post-alias.html
     * thì trỏ module về page thay vì module lược bỏ đường dẫn theo cấu hình
     */
    $base_siteurl = NV_BASE_SITEURL;
    $base_siteurl_quote = nv_preg_quote($base_siteurl);

    $request_uri = preg_replace('/(' . $base_siteurl_quote . ')index\.php\//', '\\1', urldecode($_SERVER['REQUEST_URI']));
    $request_uri = parse_url($request_uri);
    if (!isset($request_uri['path'])) {
        nv_redirect_location($base_siteurl);
    }
    $request_uri_query = isset($request_uri['query']) ? $request_uri['query'] : '';
    $request_uri = $request_uri['path'];

    if ($global_config['rewrite_endurl'] != $global_config['rewrite_exturl'] and preg_match('/^' . $base_siteurl_quote . '([a-z0-9\-]+)' . nv_preg_quote($global_config['rewrite_exturl']) . '$/i', $request_uri, $matches)) {
        // Rewrite khi không có bất kỳ request lang hay nv
        $_GET[NV_NAME_VARIABLE] = 'page';
        $_GET[NV_OP_VARIABLE] = $matches[1];
    }
    unset($base_siteurl, $base_siteurl_quote, $request_uri, $request_uri_query, $matches);
}
