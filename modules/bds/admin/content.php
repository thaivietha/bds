<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 09 May 2016 09:39:30 GMT
 */
if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

if (empty($array_bds_cat)) {
    $urlcat = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat';
    $contents = nv_theme_alert($lang_module['error_data_title'], $lang_module['error_data_cat_empty'], 'danger', $urlcat, $lang_module['cat_manage']);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}
$location = new Location();
$array_country = $location->getArrayCountry();

if (empty($array_country)) {
    $urllocation = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=location';
    $contents = nv_theme_alert($lang_module['error_data_title'], $lang_module['error_data_location_empty'], 'danger', $urllocation, $lang_module['location_manage']);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

$table_name = $db_config['prefix'] . '_' . $module_data . '_rows';

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
	$alias = strtolower($alias);
    die($alias);
}

$groups_list = nv_groups_list();
$row = array();
$error = array();
$id_block_content = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);

$username_alias = change_alias($admin_info['username']);
$array_structure_image = array();
$array_structure_image[''] = $module_upload;
$array_structure_image['Y'] = $module_upload . '/' . date('Y');
$array_structure_image['Ym'] = $module_upload . '/' . date('Y_m');
$array_structure_image['Y_m'] = $module_upload . '/' . date('Y/m');
$array_structure_image['Ym_d'] = $module_upload . '/' . date('Y_m/d');
$array_structure_image['Y_m_d'] = $module_upload . '/' . date('Y/m/d');
$array_structure_image['username'] = $module_upload . '/' . $username_alias;

$array_structure_image['username_Y'] = $module_upload . '/' . $username_alias . '/' . date('Y');
$array_structure_image['username_Ym'] = $module_upload . '/' . $username_alias . '/' . date('Y_m');
$array_structure_image['username_Y_m'] = $module_upload . '/' . $username_alias . '/' . date('Y/m');
$array_structure_image['username_Ym_d'] = $module_upload . '/' . $username_alias . '/' . date('Y_m/d');
$array_structure_image['username_Y_m_d'] = $module_upload . '/' . $username_alias . '/' . date('Y/m/d');

$structure_upload = isset($module_config[$module_name]['structure_upload']) ? $module_config[$module_name]['structure_upload'] : 'Ym';
$currentpath = isset($array_structure_image[$structure_upload]) ? $array_structure_image[$structure_upload] : '';

if (file_exists(NV_UPLOADS_REAL_DIR . '/' . $currentpath)) {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $currentpath;
} else {
    $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $module_upload;
    $e = explode('/', $currentpath);
    if (! empty($e)) {
        $cp = '';
        foreach ($e as $p) {
            if (! empty($p) and ! is_dir(NV_UPLOADS_REAL_DIR . '/' . $cp . $p)) {
                $mk = nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $cp, $p);
                if ($mk[0] > 0) {
                    $upload_real_dir_page = $mk[2];
                    try {
                        $db->query("INSERT INTO " . NV_UPLOAD_GLOBALTABLE . "_dir (dirname, time) VALUES ('" . NV_UPLOADS_DIR . "/" . $cp . $p . "', 0)");
                    } catch (PDOException $e) {
                        trigger_error($e->getMessage());
                    }
                }
            } elseif (! empty($p)) {
                $upload_real_dir_page = NV_UPLOADS_REAL_DIR . '/' . $cp . $p;
            }
            $cp .= $p . '/';
        }
    }
    $upload_real_dir_page = str_replace('\\', '/', $upload_real_dir_page);
}

$currentpath = str_replace(NV_ROOTDIR . '/', '', $upload_real_dir_page);
$uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload;
if (! defined('NV_IS_SPADMIN') and strpos($structure_upload, 'username') !== false) {
    $array_currentpath = explode('/', $currentpath);
    if ($array_currentpath[2] == $username_alias) {
        $uploads_dir_user = NV_UPLOADS_DIR . '/' . $module_upload . '/' . $username_alias;
    }
}

if ($row['id'] > 0) {
    $lang_module['content'] = $lang_module['content_edit'];
    
    $row = $db->query('SELECT * FROM ' . $table_name . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
    
    $row['title'] = $row[NV_LANG_DATA . '_title'];
    $row['title_custom'] = $row[NV_LANG_DATA . '_title_custom'];
    $row['alias'] = $row[NV_LANG_DATA . '_alias'];
    $row['description'] = $row[NV_LANG_DATA . '_description'];
    $row['description_html'] = $row[NV_LANG_DATA . '_description_html'];
	$row['keywords'] = $row[NV_LANG_DATA . '_keywords'];
    
    if (! empty($row['homeimgfile']) and file_exists(NV_UPLOADS_REAL_DIR)) {
        $currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . dirname($row['homeimgfile']);
    }
    
    $id_block_content = array();
    $sql = 'SELECT bid FROM ' . $db_config['prefix'] . '_' . $module_data . '_block where id=' . $row['id'];
    $result = $db->query($sql);
    while (list ($bid_i) = $result->fetch(3)) {
        $id_block_content[] = $bid_i;
    }
} else {
    $lang_module['content'] = $lang_module['content_add'];
    
    $row['id'] = 0;
    $row['catid'] = 0;
    $row['code'] = '';
	$row['address'] = '';
    $row['province'] = 0;
    $row['district'] = 0;
    $row['homeimgfile'] = '';
    $row['homeimgalt'] = '';
    $row['homeimgthumb'] = 0;
    $row['allowed_rating'] = 1;
    $row['groups_view'] = 6;
    $row['title'] = '';
    $row['alias'] = '';
    $row['title_custom'] = '';
    $row['description'] = '';
    $row['description_html'] = '';
	$row['keywords'] = '';
    $row['show_price'] = 1;
    $row['area'] = '';
    $row['price'] = 0;
    $row['money_unit'] = $array_config['money_unit'];
    $row['unitid'] = 0;
	$row['room'] = 0;
	$row['bed_room'] = 0;
	$row['bath_room'] = 0;
	$row['direction'] = 0;
	$row['legal'] = 0;
    $row['investor'] = 0;
    $row['amenities'] = '';
    $row['coast'] = '';
    $row['supermarket'] = '';
    $row['airport'] = '';
    $row['hospital'] = '';
    $row['park'] = '';
    $row['bank'] = '';
    $row['railway'] = '';
    $row['schools'] = '';
    $row['bus'] = '';
}

if ($nv_Request->isset_request('submit', 'post')) {
    $row['catid'] = $nv_Request->get_int('catid', 'post', 0);
    $row['code'] = $nv_Request->get_title('code', 'post', '');
    $row['price'] = $nv_Request->get_title('price', 'post', 0);
    $row['price'] = floatval(preg_replace('/[^0-9]/', '', $row['price']));
    $row['money_unit'] = $nv_Request->get_title('money_unit', 'post', '');
    $row['unitid'] = $nv_Request->get_int('unitid', 'post', 0);
	$row['address'] = $nv_Request->get_title('address', 'post', '');
    $row['province'] = $nv_Request->get_int('province', 'post', 0);
    $row['district'] = $nv_Request->get_int('district', 'post', 0);
    $row['area'] = $nv_Request->get_int('area', 'post', 0);
	$row['room'] = $nv_Request->get_int('room', 'post', 0);
	$row['bed_room'] = $nv_Request->get_int('bed_room', 'post', 0);
	$row['bath_room'] = $nv_Request->get_int('bath_room', 'post', 0);
    $row['homeimgfile'] = $nv_Request->get_title('homeimgfile', 'post', '');
    $row['homeimgalt'] = $nv_Request->get_title('homeimgalt', 'post', '');
	$row['direction'] = $nv_Request->get_int('direction', 'post', 0);
	$row['legal'] = $nv_Request->get_int('legal', 'post', 0);
    $row['investor'] = $nv_Request->get_int('investor', 'post', 0);

    $row['coast'] = $nv_Request->get_title('coast', 'post', '');
    $row['supermarket'] = $nv_Request->get_title('supermarket', 'post', '');
    $row['airport'] = $nv_Request->get_title('airport', 'post', '');
    $row['hospital'] = $nv_Request->get_title('hospital', 'post', '');
    $row['park'] = $nv_Request->get_title('park', 'post', '');
    $row['bank'] = $nv_Request->get_title('bank', 'post', '');
    $row['railway'] = $nv_Request->get_title('railway', 'post', '');
    $row['schools'] = $nv_Request->get_title('schools', 'post', '');
    $row['bus'] = $nv_Request->get_title('bus', 'post', '');

    $row['amenities'] = $nv_Request->get_typed_array('amenities', 'post', 'int', array());
    $row['amenities'] = ! empty($row['amenities']) ? serialize($row['amenities']) : '';
    
    $_groups_post = $nv_Request->get_array('groups_view', 'post', array());
    $row['groups_view'] = ! empty($_groups_post) ? implode(',', nv_groups_post(array_intersect($_groups_post, array_keys($groups_list)))) : '';
    
    $row['allowed_rating'] = $nv_Request->get_int('allowed_rating', 'post');
    $row['show_price'] = $nv_Request->get_int('show_price', 'post');
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['title_custom'] = $nv_Request->get_title('title_custom', 'post', '');
    $row['description'] = $nv_Request->get_textarea('description', '', NV_ALLOWED_HTML_TAGS);
    $row['description_html'] = $nv_Request->get_editor('description_html', '', NV_ALLOWED_HTML_TAGS);
	$row['keywords'] = $nv_Request->get_title('keywords', 'post', '');
    $row['id_block_content_post'] = array_unique($nv_Request->get_typed_array('bids', 'post', 'int', array()));
    
    // xu ly alias
    $row['alias'] = $nv_Request->get_title('alias', 'post', '', 1);
    $row['alias'] = empty($row['alias']) ? change_alias($row['title']) : $row['alias'];
    $stmt = $db->prepare('SELECT COUNT(*) FROM ' . $table_name . ' WHERE id !=' . $row['id'] . ' AND ' . NV_LANG_DATA . '_alias = :alias');
    $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
    $stmt->execute();
    if ($stmt->fetchColumn()) {
        $weight = $db->query('SELECT MAX(id) FROM ' . $table_name . '')->fetchColumn();
        $weight = intval($weight) + 1;
        $row['alias'] = $row['alias'] . '-' . $weight;
    }
    
    if (empty($row['title'])) {
        $error[] = $lang_module['error_required_title'];
    } elseif (empty($row['catid'])) {
        $error[] = $lang_module['error_required_catid'];
    } elseif (empty($row['description'])) {
        $error[] = $lang_module['error_required_description'];
    } elseif (empty($row['area'])) {
        $error[] = $lang_module['error_required_area'];
    } elseif (empty($row['address'])) {
        $error[] = $lang_module['error_required_address'];
    }
	
    
    if (empty($error)) {
        // Xu ly anh minh hoa
        $row['homeimgthumb'] = 0;
        if (! nv_is_url($row['homeimgfile']) and nv_is_file($row['homeimgfile'], NV_UPLOADS_DIR . '/' . $module_upload) === true) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
            $row['homeimgfile'] = substr($row['homeimgfile'], $lu);
            if (file_exists(NV_ROOTDIR . '/' . NV_FILES_DIR . '/' . $module_upload . '/' . $row['homeimgfile'])) {
                $row['homeimgthumb'] = 1;
            } else {
                $row['homeimgthumb'] = 2;
            }
        } elseif (nv_is_url($row['homeimgfile'])) {
            $row['homeimgthumb'] = 3;
        } else {
            $row['homeimgfile'] = '';
        }
        
        $field_lang = nv_file_table($table_name);
        $listfield = $listvalue = '';
        foreach ($field_lang as $field_lang_i) {
            list ($flang, $fname) = $field_lang_i;
            $listfield .= ', ' . $flang . '_' . $fname;
            $listvalue .= ', :' . $flang . '_' . $fname;
        }
        
        try {
            $new_id = 0;
            if (empty($row['id'])) {
                $data_insert = array();
                $_sql = 'INSERT INTO ' . $table_name . ' (catid, code, price, money_unit, unitid, address, province, district, homeimgfile, homeimgalt, homeimgthumb, allowed_rating, show_price, admin_id, area, room, bed_room, bath_room, direction, legal, investor, amenities, coast, supermarket, airport, hospital, park, bank, railway, schools, bus, addtime, groups_view' . $listfield . ') VALUES (:catid, :code :price, :money_unit, :unitid, :address, :province, :district, :homeimgfile, :homeimgalt, :homeimgthumb, :allowed_rating, :show_price, :admin_id, :area, :room, :bed_room, :bath_room, :direction, :legal, :investor, :amenities, :coast, :supermarket, :airport, :hospital, :park, :bank, :railway, :schools, :bus, ' . NV_CURRENTTIME . ', :groups_view' . $listvalue . ')';
                $data_insert['catid'] = $row['catid'];
                $data_insert['code'] = $row['code'];
                $data_insert['price'] = $row['price'];
                $data_insert['money_unit'] = $row['money_unit'];
                $data_insert['unitid'] = $row['unitid'];
				$data_insert['address'] = $row['address'];
                $data_insert['province'] = $row['province'];
                $data_insert['district'] = $row['district'];
                $data_insert['homeimgfile'] = $row['homeimgfile'];
                $data_insert['homeimgalt'] = $row['homeimgalt'];
                $data_insert['homeimgthumb'] = $row['homeimgthumb'];
                $data_insert['allowed_rating'] = $row['allowed_rating'];
                $data_insert['show_price'] = $row['show_price'];
                $data_insert['admin_id'] = $admin_info['userid'];
                $data_insert['area'] = $row['area'];
				$data_insert['room'] = $row['room'];
				$data_insert['bed_room'] = $row['bed_room'];
				$data_insert['bath_room'] = $row['bath_room'];
				$data_insert['direction'] = $row['direction'];
				$data_insert['legal'] = $row['legal'];
                $data_insert['investor'] = $row['investor'];
                $data_insert['amenities'] = $row['amenities'];
                $data_insert['coast'] = $row['coast'];
                $data_insert['supermarket'] = $row['supermarket'];
                $data_insert['airport'] = $row['airport'];
                $data_insert['hospital'] = $row['hospital'];
                $data_insert['park'] = $row['park'];
                $data_insert['bank'] = $row['bank'];
                $data_insert['railway'] = $row['railway'];
                $data_insert['schools'] = $row['schools'];
                $data_insert['bus'] = $row['bus'];
                $data_insert['groups_view'] = $row['groups_view'];
				
                foreach ($field_lang as $field_lang_i) {
                    list ($flang, $fname) = $field_lang_i;
                    $data_insert[$flang . '_' . $fname] = $row[$fname];
                }
                $new_id = $db->insert_id($_sql, 'id', $data_insert);
            } else {
                $stmt = $db->prepare('UPDATE ' . $table_name . ' SET catid = :catid, code = :code, price = :price, money_unit = :money_unit, unitid = :unitid, address = :address, province = :province, district = :district, homeimgfile = :homeimgfile, homeimgalt = :homeimgalt, homeimgthumb = :homeimgthumb, allowed_rating = :allowed_rating, show_price = :show_price, area = :area, room = :room, bed_room = :bed_room, bath_room = :bath_room, direction = :direction, legal = :legal, investor = :investor, amenities = :amenities, coast = :coast, supermarket = :supermarket, airport = :airport, hospital = :hospital, park = :park, bank = :bank, railway = :railway, schools = :schools, bus = :bus, edittime = ' . NV_CURRENTTIME . ', groups_view = :groups_view, ' . NV_LANG_DATA . '_title = :title, ' . NV_LANG_DATA . '_alias = :alias, ' . NV_LANG_DATA . '_title_custom = :title_custom, ' . NV_LANG_DATA . '_description = :description, ' . NV_LANG_DATA . '_description_html = :description_html, ' . NV_LANG_DATA . '_keywords = :keywords WHERE id=' . $row['id']);
                $stmt->bindParam(':catid', $row['catid'], PDO::PARAM_INT);
                $stmt->bindParam(':code', $row['code'], PDO::PARAM_STR);
                $stmt->bindParam(':price', $row['price'], PDO::PARAM_INT);
                $stmt->bindParam(':money_unit', $row['money_unit'], PDO::PARAM_STR);
                $stmt->bindParam(':unitid', $row['unitid'], PDO::PARAM_INT);
				$stmt->bindParam(':address', $row['address'], PDO::PARAM_STR);
                $stmt->bindParam(':province', $row['province'], PDO::PARAM_INT);
                $stmt->bindParam(':district', $row['district'], PDO::PARAM_INT);
                $stmt->bindParam(':homeimgfile', $row['homeimgfile'], PDO::PARAM_STR);
                $stmt->bindParam(':homeimgalt', $row['homeimgalt'], PDO::PARAM_STR);
                $stmt->bindParam(':homeimgthumb', $row['homeimgthumb'], PDO::PARAM_INT);
                $stmt->bindParam(':allowed_rating', $row['allowed_rating'], PDO::PARAM_INT);
                $stmt->bindParam(':show_price', $row['show_price'], PDO::PARAM_INT);
                $stmt->bindParam(':area', $row['area'], PDO::PARAM_INT);
				$stmt->bindParam(':room', $row['room'], PDO::PARAM_INT);
				$stmt->bindParam(':bed_room', $row['bed_room'], PDO::PARAM_INT);
				$stmt->bindParam(':bath_room', $row['bath_room'], PDO::PARAM_INT);
				$stmt->bindParam(':direction', $row['direction'], PDO::PARAM_INT);
				$stmt->bindParam(':legal', $row['legal'], PDO::PARAM_INT);
                $stmt->bindParam(':investor', $row['investor'], PDO::PARAM_INT);
                $stmt->bindParam(':amenities', $row['amenities'], PDO::PARAM_STR);
                $stmt->bindParam(':coast', $row['coast'], PDO::PARAM_STR);
                $stmt->bindParam(':supermarket', $row['supermarket'], PDO::PARAM_STR);
                $stmt->bindParam(':airport', $row['airport'], PDO::PARAM_STR);
                $stmt->bindParam(':hospital', $row['hospital'], PDO::PARAM_STR);
                $stmt->bindParam(':park', $row['park'], PDO::PARAM_STR);
                $stmt->bindParam(':bank', $row['bank'], PDO::PARAM_STR);
                $stmt->bindParam(':railway', $row['railway'], PDO::PARAM_STR);
                $stmt->bindParam(':schools', $row['schools'], PDO::PARAM_STR);
                $stmt->bindParam(':bus', $row['bus'], PDO::PARAM_STR);
                $stmt->bindParam(':groups_view', $row['groups_view'], PDO::PARAM_STR);
                $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
                $stmt->bindParam(':alias', $row['alias'], PDO::PARAM_STR);
                $stmt->bindParam(':title_custom', $row['title_custom'], PDO::PARAM_STR);
                $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR, strlen($row['description']));
                $stmt->bindParam(':description_html', $row['description_html'], PDO::PARAM_STR, strlen($row['description_html']));
				$stmt->bindParam(':keywords', $row['keywords'], PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $new_id = $row['id'];
                }
            }
            
            if ($new_id > 0) {
                $auto_code = '';
                if (empty($row['code'])) {
                    $i = 1;
                    $format_code = ! empty($array_config['format_code']) ? $array_config['format_code'] : 'PT%04s';
                    $auto_code = vsprintf($format_code, $new_id);
                    
                    $stmt = $db->prepare('SELECT id FROM ' . $table_name . ' WHERE code= :code');
                    $stmt->bindParam(':code', $auto_code, PDO::PARAM_STR);
                    $stmt->execute();
                    while ($stmt->rowCount()) {
                        $auto_code = vsprintf($format_code, ($new_id + $i ++));
                    }
                    
                    $stmt = $db->prepare('UPDATE ' . $table_name . ' SET code= :code WHERE id=' . $new_id);
                    $stmt->bindParam(':code', $auto_code, PDO::PARAM_STR);
                    $stmt->execute();
                }

                $id_block_content_new = array_diff($row['id_block_content_post'], $id_block_content);
                $id_block_content_del = array_diff($id_block_content, $row['id_block_content_post']);
                
                $array_block_fix = array();
                foreach ($id_block_content_new as $bid_i) {
                    $db->query('INSERT INTO ' . $db_config['prefix'] . '_' . $module_data . '_block (bid, id, weight) VALUES (' . $bid_i . ', ' . $new_id . ', 0)');
                    $array_block_fix[] = $bid_i;
                }
                foreach ($id_block_content_del as $bid_i) {
                    $db->query('DELETE FROM ' . $db_config['prefix'] . '_' . $module_data . '_block WHERE id = ' . $new_id . ' AND bid = ' . $bid_i);
                    $array_block_fix[] = $bid_i;
                }
                
                $array_block_fix = array_unique($array_block_fix);
                foreach ($array_block_fix as $bid_i) {
                    nv_fix_block($bid_i, false);
                }
                
                $nv_Cache->delMod($module_name);
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage()); // Remove this line after checks finished
        }
    }
    $id_block_content = $row['id_block_content_post'];
}

if (! empty($row['homeimgfile']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $row['homeimgfile'])) {
    $row['homeimgfile'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $row['homeimgfile'];
}

if (defined('NV_EDITOR')) {
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
}
$row['description_html'] = htmlspecialchars(nv_editor_br2nl($row['description_html']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['description_html'] = nv_aleditor('description_html', '100%', '200px', $row['description_html'], 'Basic');
} else {
    $row['description_html'] = '<textarea style="width:100%;height:300px" name="description_html">' . $row['description_html'] . '</textarea>';
}

$row['allowed_rating_ck'] = $row['allowed_rating'] ? 'checked="checked"' : '';
$row['show_price_ck'] = $row['show_price'] ? 'checked="checked"' : '';
$row['area'] = ! empty($row['area']) ? $row['area'] : '';
$row['room'] = ! empty($row['room']) ? $row['room'] : '';
$row['bed_room'] = ! empty($row['bed_room']) ? $row['bed_room'] : '';
$row['bath_room'] = ! empty($row['bath_room']) ? $row['bath_room'] : '';
$row['price'] = ! empty($row['price']) ? $row['price'] : '';

$array_block_cat_module = array();
$sql = 'SELECT bid, adddefault, ' . NV_LANG_DATA . '_title title FROM ' . $db_config['prefix'] . '_' . $module_data . '_block_cat ORDER BY weight ASC';
$result = $db->query($sql);
while (list ($bid_i, $adddefault_i, $title_i) = $result->fetch(3)) {
    $array_block_cat_module[$bid_i] = $title_i;
    if ($adddefault_i) {
        $id_block_content[] = $bid_i;
    }
}
$id_block_content = array_unique($id_block_content);

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('TEMPLATE', $global_config['module_theme']);
$xtpl->assign('CURRENTPATH', $currentpath);
$xtpl->assign('aSep', $array_config['asep']);
$xtpl->assign('aDec', $array_config['adec']);

if (! empty($array_bds_cat)) {
    foreach ($array_bds_cat as $catid => $value) {
        $value['space'] = '';
        if ($value['lev'] > 0) {
            for ($i = 1; $i <= $value['lev']; $i ++) {
                $value['space'] .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            }
        }
        $value['selected'] = $catid == $row['catid'] ? ' selected="selected"' : '';
        
        $xtpl->assign('CAT', $value);
        $xtpl->parse('main.cat');
    }
}

$groups_view = explode(',', $row['groups_view']);
foreach ($groups_list as $group_id => $grtl) {
    $_groups_view = array(
        'value' => $group_id,
        'checked' => in_array($group_id, $groups_view) ? ' checked="checked"' : '',
        'title' => $grtl
    );
    $xtpl->assign('GROUPS_VIEW', $_groups_view);
    $xtpl->parse('main.groups_view');
}

$provinceid = ! empty($row['province']) ? $row['province'] : 0;
$districtid = ! empty($row['district']) ? $row['district'] : 0;

$location->set('SelectProvinceid', $provinceid);
$location->set('SelectDistrictid', $districtid);
$location->set('IsDistrict', 1);
$location->set('NameProvince', 'province');
$location->set('NameDistrict', 'district');
$location->set('BlankTitleProvince', 1);
$location->set('BlankTitleDistrict', 1);
$xtpl->assign('PLACE_START', $location->buildInput());

if (! empty($money_config)) {
    foreach ($money_config as $code => $info) {
        $info['selected'] = ($row['money_unit'] == $code) ? "selected=\"selected\"" : "";
        $xtpl->assign('MONEY', $info);
        $xtpl->parse('main.money_unit');
    }
}

if (! empty($array_investor)) {
    foreach ($array_investor as $investor) {
        $investor['selected'] = $investor['id'] == $row['investor'] ? 'selected="selected"' : '';
        $xtpl->assign('INVESTOR', $investor);
        $xtpl->parse('main.investor');
    }
}

if (! empty($array_amenities)) {
    $row['amenities'] = ! empty($row['amenities']) ? unserialize($row['amenities']) : array();
    foreach ($array_amenities as $amenities) {
        $amenities['checked'] = in_array($amenities['id'], $row['amenities']) ? 'checked="checked"' : '';
        $xtpl->assign('AMENITIES', $amenities);
        $xtpl->parse('main.amenities.loop');
    }
    $xtpl->parse('main.amenities');
}


if (! empty($array_direction)) {
    foreach ($array_direction as $direction) {
        $direction['selected'] = $direction['id'] == $row['direction'] ? 'selected="selected"' : '';
        $xtpl->assign('DIRECTION', $direction);
        $xtpl->parse('main.direction');
    }
}

if (! empty($array_legal)) {
    foreach ($array_legal as $legal) {
        $legal['selected'] = $legal['id'] == $row['legal'] ? 'selected="selected"' : '';
        $xtpl->assign('LEGAL', $legal);
        $xtpl->parse('main.legal');
    }
}

if (! empty($array_unit)) {
    foreach ($array_unit as $unit) {
        $unit['selected'] = $unit['id'] == $row['unitid'] ? 'selected="selected"' : '';
        $xtpl->assign('UNIT', $unit);
        $xtpl->parse('main.unit');
    }
}

if (sizeof($array_block_cat_module)) {
    foreach ($array_block_cat_module as $bid_i => $bid_title) {
        $xtpl->assign('BLOCKS', array(
            'title' => $bid_title,
            'bid' => $bid_i,
            'checked' => in_array($bid_i, $id_block_content) ? 'checked="checked"' : ''
        ));
        $xtpl->parse('main.block_cat.loop');
    }
    $xtpl->parse('main.block_cat');
}

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

if (empty($row['id'])) {
    $xtpl->parse('main.auto_get_alias');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['content'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';