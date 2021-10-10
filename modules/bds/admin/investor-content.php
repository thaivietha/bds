<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate Mon, 09 May 2016 04:03:03 GMT
 */
 if (! defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

$table_name = $db_config['prefix'] . '_' . $module_data . '_investor';

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['description'] = $nv_Request->get_editor('description', '', NV_ALLOWED_HTML_TAGS);
    $row['website'] = $nv_Request->get_title('website', 'post', '');
    $row['image'] = $nv_Request->get_title('image', 'post', '');
    if (is_file(NV_DOCUMENT_ROOT . $row['image'])) {
        $row['image'] = substr($row['image'], strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/investor/'));
    } else {
        $row['image'] = '';
    }
    
    if (empty($row['title'])) {
        $error[] = $lang_module['error_required_title'];
    }
    
    if (empty($error)) {
        $field_lang = nv_file_table($table_name);
        $listfield = $listvalue = '';
        foreach ($field_lang as $field_lang_i) {
            list ($flang, $fname) = $field_lang_i;
            $listfield .= ', ' . $flang . '_' . $fname;
            $listvalue .= ', :' . $fname;
        }
        try {
            if (empty($row['id'])) {
                $stmt = $db->prepare('INSERT INTO ' . $table_name . ' (website, image' . $listfield . ') VALUES (:website, :image' . $listvalue . ')');
            } else {
                $stmt = $db->prepare('UPDATE ' . $table_name . ' SET website = :website, image = :image, ' . NV_LANG_DATA . '_title = :title, ' . NV_LANG_DATA . '_description = :description WHERE id=' . $row['id']);
            }
            $stmt->bindParam(':website', $row['website'], PDO::PARAM_STR);
            $stmt->bindParam(':image', $row['image'], PDO::PARAM_STR);
            foreach ($field_lang as $field_lang_i) {
                list ($flang, $fname) = $field_lang_i;
                $stmt->bindParam(':' . $fname, $row[$fname], PDO::PARAM_STR);
            }
            $exc = $stmt->execute();
            if ($exc) {
                $nv_Cache->delMod($module_name);
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=investor');
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . $table_name . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
    
    $row['title'] = $row[NV_LANG_DATA . '_title'];
    $row['description'] = $row[NV_LANG_DATA . '_description'];
    
    $lang_module['investor-content'] = $lang_module['edit_investor'];
} else {
    $row['id'] = 0;
    $row['title'] = '';
    $row['description'] = '';
    $row['website'] = '';
    $row['image'] = '';
    
    $lang_module['investor-content'] = $lang_module['add_investor'];
}

if (! empty($row['image']) and is_file(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/investor/' . $row['image'])) {
    $row['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/investor/' . $row['image'];
}

if (defined('NV_EDITOR'))
    require_once NV_ROOTDIR . '/' . NV_EDITORSDIR . '/' . NV_EDITOR . '/nv.php';
$row['description'] = htmlspecialchars(nv_editor_br2nl($row['description']));
if (defined('NV_EDITOR') and nv_function_exists('nv_aleditor')) {
    $row['description'] = nv_aleditor('description', '100%', '300px', $row['description']);
} else {
    $row['description'] = '<textarea style="width:100%;height:300px" name="description">' . $row[NV_LANG_DATA . '_description'] . '</textarea>';
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);

if (! empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['investor-content'];
$set_active_op = 'investor';

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';