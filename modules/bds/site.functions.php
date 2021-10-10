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

$array_config = $module_config[$module_name];

$_sql = 'SELECT id, parentid, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_alias alias, ' . NV_LANG_DATA . '_custom_title custom_title, ' . NV_LANG_DATA . '_keywords keywords, ' . NV_LANG_DATA . '_description description, ' . NV_LANG_DATA . '_description_html description_html, inhome, numlinks, viewtype, lev, numsub, subid, sort, css, weight, status, image, groups_view FROM ' . $db_config['prefix'] . '_' . $module_data . '_cat WHERE status=1 ORDER BY sort ASC';
$array_bds_cat = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT id, website, image, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_description description FROM ' . $db_config['prefix'] . '_' . $module_data . '_investor WHERE status=1';
$array_investor = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title FROM ' . $db_config['prefix'] . '_' . $module_data . '_amenities WHERE status=1 ORDER BY weight';
$array_amenities = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_note note FROM ' . $db_config['prefix'] . '_' . $module_data . '_unit WHERE status=1 ORDER BY weight';
$array_unit = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_note note FROM ' . $db_config['prefix'] . '_' . $module_data . '_direction WHERE status=1 ORDER BY weight';
$array_direction = $nv_Cache->db($_sql, 'id', $module_name);

$_sql = 'SELECT id, ' . NV_LANG_DATA . '_title title, ' . NV_LANG_DATA . '_note note FROM ' . $db_config['prefix'] . '_' . $module_data . '_legal WHERE status=1 ORDER BY weight';
$array_legal = $nv_Cache->db($_sql, 'id', $module_name);

// Ty gia ngoai te
$sql = 'SELECT code, currency, exchange, round, number_format FROM ' . $db_config['prefix'] . '_' . $module_data . '_money_' . NV_LANG_DATA . ' ORDER BY id';
$cache_file = NV_LANG_DATA . '_' . md5($sql) . '_' . NV_CACHE_PREFIX . '.cache';
if (($cache = $nv_Cache->getItem($module_name, $cache_file)) != false) {
    $money_config = unserialize($cache);
} else {
    $money_config = array();
    $result = $db->query($sql);
    while ($row = $result->fetch()) {
        $money_config[$row['code']] = array(
            'code' => $row['code'],
            'currency' => $row['currency'],
            'exchange' => $row['exchange'],
            'round' => $row['round'],
            'number_format' => $row['number_format'],
            'decimals' => $row['round'] > 1 ? $row['round'] : strlen($row['round']) - 2,
            'is_config' => ($row['code'] == $array_config['money_unit']) ? 1 : 0
        );
    }
    $result->closeCursor();
    $cache = serialize($money_config);
    $nv_Cache->setItem($module_name, $cache_file, $cache);
}

/**
 * nv_bds_number_format()
 *
 * @param mixed $number            
 * @param integer $decimals            
 * @return
 *
 */
function nv_bds_number_format($number, $decimals = 0)
{
    global $money_config, $array_config;
    
    $number_format = explode('||', $money_config[$array_config['money_unit']]['number_format']);
    $str = number_format($number, $decimals, $number_format[0], $number_format[1]);
    return $str;
}

/**
 * nv_bds_get_decimals()
 *
 * @param mixed $currency_convert            
 * @return
 *
 */
function nv_bds_get_decimals($currency_convert)
{
    global $money_config;
    
    $r = $money_config[$currency_convert]['round'];
    $decimals = 0;
    if ($r <= 1) {
        $decimals = $money_config[$currency_convert]['decimals'];
    }
    return $decimals;
}

/**
 * nv_bds_numoney_to_strmoney()
 *
 * @param mixed $pro_id            
 * @param mixed $currency_convert            
 * @param mixed $price            
 * @param mixed $module            
 * @return
 *
 */
function nv_bds_numoney_to_strmoney($price)
{
	global $lang_module;
	
	if ($price>= 100000 and $price< 1000000) {
		$price= $price/ 1000;
		return $price. ' ' . $lang_module['thousand'];
	}elseif ($price>= 1000000 and $price< 1000000000) {
		$price= $price/ 1000000;
		return $price. ' ' . $lang_module['million'];
	} elseif ($price>= 1000000000) {
		$price= $price/ 1000000000;
		return $price. ' ' . $lang_module['billion'];
	}
	return $price;
}
/**
 * nv_bds_get_price()
 *
 * @param mixed $pro_id            
 * @param mixed $currency_convert            
 * @param mixed $price            
 * @param mixed $module            
 * @return
 *
 */
function nv_bds_get_price($pro_id, $currency_convert, $price = 0, $module = '')
{
    global $db, $db_config, $site_mods, $module_data, $array_bds_cat, $array_config, $money_config, $discounts_config;
    
    $return = array();
    $module_data = ! empty($module) ? $site_mods[$module]['module_data'] : $module_data;
    $product = $db->query('SELECT price, money_unit FROM ' . $db_config['prefix'] . '_' . $module_data . '_rows WHERE id = ' . $pro_id)->fetch();
    $price = $price > 0 ? $price : $product['price'];
    
    $r = $money_config[$product['money_unit']]['round'];
    $decimals = nv_bds_get_decimals($currency_convert);
    if ($r > 1) {
        $price = round($price / $r) * $r;
    } else {
        $price = round($price, $decimals);
    }
    
    $price = nv_bds_currency_conversion($price, $product['money_unit'], $currency_convert);
    $return['price'] = nv_bds_numoney_to_strmoney($price); // Giá sản phẩm chưa format
    $return['price_format'] = nv_bds_number_format($price, $decimals); // Giá sản phẩm đã format
    $return['unit'] = $currency_convert;
    return $return;
}

/**
 * nv_bds_currency_conversion()
 *
 * @param mixed $price            
 * @param mixed $currency_curent            
 * @param mixed $currency_convert            
 * @return
 *
 */
function nv_bds_currency_conversion($price, $currency_curent, $currency_convert)
{
    global $array_config, $money_config, $discounts_config;
    
    if ($currency_curent == $array_config['money_unit']) {
        $price = $price / $money_config[$currency_convert]['exchange'];
    } elseif ($currency_convert == $array_config['money_unit']) {
        $price = $price * $money_config[$currency_curent]['exchange'];
    }
    
    return $price;
}

function nv_bds_get_thumb($homeimgfile, $homeimgthumb, $module_upload)
{
    global $array_config, $module_info;
    
    if ($homeimgthumb == 1) {
        $thumb = NV_BASE_SITEURL . NV_FILES_DIR . '/' . $module_upload . '/' . $homeimgfile;
    } elseif ($homeimgthumb == 2) {
        $thumb = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $homeimgfile;
    } elseif ($homeimgthumb == 3) {
        $thumb = $homeimgfile;
    } elseif (! empty($array_config['no_image'])) {
        $thumb = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $array_config['no_image'];
    } else {
        $thumb = NV_BASE_SITEURL . 'themes/' . $module_info['template'] . '/images/bds/nopicture.jpg';
    }
    return $thumb;
}