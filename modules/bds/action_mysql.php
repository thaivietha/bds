<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC (contact@vinades.vn)
 * @Copyright (C) 2016 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Sun, 08 May 2016 09:31:28 GMT
 */
if (! defined('NV_IS_FILE_MODULES'))
    die('Stop!!!');

global $op, $db;

$sql_drop_module = array();

$result = $db->query("SHOW TABLE STATUS LIKE '" . $db_config['prefix'] . "\_" . $module_data . "\_money\_%'");
$num_table = intval($result->rowCount());
$array_lang_module_setup = array();
$set_lang_data = '';

if ($num_table > 0) {
    while ($item = $result->fetch()) {
        $array_lang_module_setup[] = str_replace($db_config['prefix'] . "_" . $module_data . "_money_", "", $item['name']);
    }
    
    if ($lang != $global_config['site_lang'] and in_array($global_config['site_lang'], $array_lang_module_setup)) {
        $set_lang_data = $global_config['site_lang'];
    } else {
        foreach ($array_lang_module_setup as $lang_i) {
            if ($lang != $lang_i) {
                $set_lang_data = $lang_i;
                break;
            }
        }
    }
}

if (in_array($lang, $array_lang_module_setup) and $num_table > 1) {
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_cat
	 DROP ' . $lang . '_title,
	 DROP ' . $lang . '_alias,
	 DROP ' . $lang . '_custom_title,
	 DROP ' . $lang . '_keywords,
	 DROP ' . $lang . '_description,
	 DROP ' . $lang . '_description_html';
    
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_rows
	 DROP ' . $lang . '_title,
	 DROP ' . $lang . '_alias,
     DROP ' . $lang . '_title_custom,
     DROP ' . $lang . '_description,
     DROP ' . $lang . '_description_html';
    
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_images
	 DROP ' . $lang . '_title,
     DROP ' . $lang . '_description';
    
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_firm
	 DROP ' . $lang . '_title,
     DROP ' . $lang . '_description';
    
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_unit
	 DROP ' . $lang . '_title,
     DROP ' . $lang . '_note';
    
    $sql_drop_module[] = 'ALTER TABLE ' . $db_config['prefix'] . '_' . $module_data . '_block_cat
	 DROP ' . $lang . '_title,
     DROP ' . $lang . '_alias,
     DROP ' . $lang . '_description,
     DROP ' . $lang . '_keywords';
} elseif ($op != 'setup') {
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_cat";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_rows";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_booking";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_config";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_images";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_firm";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_request";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_unit";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_block";
    $sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $module_data . "_block_cat";
}

$sql_drop_module[] = 'DROP TABLE IF EXISTS ' . $db_config['prefix'] . '_' . $module_data . '_money_' . $lang;
$sql_create_module = $sql_drop_module;

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_cat(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  parentid smallint(4) unsigned NOT NULL DEFAULT '0',
  inhome tinyint(1) unsigned NOT NULL DEFAULT '1',
  numlinks smallint(3) unsigned NOT NULL DEFAULT '6',
  viewtype varchar(50) NOT NULL DEFAULT 'viewgrid',
  groups_view varchar(255) NOT NULL DEFAULT '6',
  image varchar(255) NOT NULL DEFAULT '',  
  lev smallint(4) unsigned NOT NULL DEFAULT '0',
  numsub smallint(4) unsigned NOT NULL DEFAULT '0',
  subid varchar(255) NOT NULL,
  sort smallint(4) unsigned NOT NULL DEFAULT '0',
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_title VARCHAR( 250 ) NOT NULL DEFAULT ''";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_alias VARCHAR( 250 ) NOT NULL DEFAULT ''";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_custom_title VARCHAR( 255 ) NOT NULL DEFAULT ''";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_keywords text NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_description tinytext NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD " . $lang . "_description_html TEXT NOT NULL";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_money_" . $lang . " (
 id mediumint(11) NOT NULL,
 code char(3) NOT NULL,
 currency varchar(250) NOT NULL,
 exchange float NOT NULL default '0',
 round varchar(10) NOT NULL,
 number_format varchar(5) NOT NULL DEFAULT ',||.',
 PRIMARY KEY (id),
 UNIQUE KEY code (code)
) ENGINE=MyISAM";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money_" . $lang . " (id, code, currency, exchange, round, number_format) VALUES (840, 'USD', 'US Dollar', 21000, '0.01', ',||.')";
$sql_create_module[] = "INSERT INTO " . $db_config['prefix'] . "_" . $module_data . "_money_" . $lang . " (id, code, currency, exchange, round, number_format) VALUES (704, 'VND', 'Vietnam Dong', 1, '100', ',||.')";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_rows(
  id int(11) unsigned NOT NULL AUTO_INCREMENT,
  catid smallint(4) NOT NULL,
  firmid smallint(4) unsigned NOT NULL,
  price float unsigned NOT NULL,
  money_unit varchar(3) NOT NULL,
  unitid smallint(4) unsigned NOT NULL,
  place_start_province mediumint(4) unsigned NOT NULL,
  place_start_district mediumint(4) unsigned NOT NULL,
  place_end_province mediumint(4) unsigned NOT NULL,
  place_end_district mediumint(4) unsigned NOT NULL,
  homeimgfile varchar(255) NOT NULL,
  homeimgalt varchar(255) NOT NULL,
  homeimgthumb tinyint(41) NOT NULL DEFAULT '0',
  allowed_rating tinyint(1) NOT NULL DEFAULT '0',
  show_price tinyint(1) NOT NULL DEFAULT '1',
  admin_id int(11) unsigned NOT NULL,
  hitstotal mediumint(8) NOT NULL DEFAULT '0',
  num_seat mediumint(8) unsigned NOT NULL COMMENT 'Số chổ',
  addtime int(11) unsigned NOT NULL,
  edittime int(11) NOT NULL DEFAULT '0',
  groups_view varchar(255) NOT NULL DEFAULT '6',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD " . $lang . "_title varchar(250) NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD " . $lang . "_alias varchar(250) NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD " . $lang . "_title_custom varchar(250) NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD " . $lang . "_description text NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD " . $lang . "_description_html text NOT NULL";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_images(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  rows_id int(11) unsigned NOT NULL,
  homeimgfile varchar(255) NOT NULL,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_images ADD " . $lang . "_title varchar(255) NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_images ADD " . $lang . "_description text NOT NULL";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_booking (
 booking_id int(11) unsigned NOT NULL auto_increment,
 booking_code varchar(30) NOT NULL default '',
 rows_id int(11) unsigned NOT NULL,
 lang char(2) NOT NULL default 'vi',
 contact_fullname varchar(250) NOT NULL,
 contact_address varchar(250) NOT NULL,
 contact_phone varchar(20) NOT NULL,
 contact_note text NOT NULL,
 time_start int(11) unsigned NOT NULL default '0',
 numday tinyint(2) unsigned NOT NULL default '1',
 numcar tinyint(2) unsigned NOT NULL default '1',
 booking_time int(11) unsigned NOT NULL default '0',
 user_id int(11) unsigned NOT NULL default '0',
 status tinyint(1) unsigned NOT NULL default '0',
 PRIMARY KEY (booking_id),
 UNIQUE KEY booking_code (booking_code),
 KEY user_id (user_id),
 KEY booking_time (booking_time)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_firm(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  website varchar(100) NOT NULL,
  image varchar(255) NOT NULL,
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_firm ADD " . $lang . "_title varchar(255) NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_firm ADD " . $lang . "_description text NOT NULL";

$sql_create_module[] = "CREATE TABLE " . $db_config['prefix'] . "_" . $module_data . "_request(
  id mediumint(8) NOT NULL AUTO_INCREMENT,
  catid smallint(4) unsigned NOT NULL DEFAULT '0',
  firmid smallint(4) unsigned NOT NULL DEFAULT '0',
  numseat tinyint(2) unsigned NOT NULL,
  place_start varchar(255) NOT NULL,
  place_end varchar(255) NOT NULL,
  time_start int(11) unsigned NOT NULL DEFAULT '0',
  numday tinyint(2) unsigned NOT NULL DEFAULT '1',
  numcar tinyint(2) unsigned NOT NULL DEFAULT '1',
  fullname varchar(255) NOT NULL,
  address varchar(255) NOT NULL,
  phone varchar(50) NOT NULL,
  note text NOT NULL,
  addtime int(11) unsigned NOT NULL,
  lang char(2) NOT NULL,
  userid int(11) unsigned NOT NULL,
  status tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_unit(
  id smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  weight smallint(4) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Trạng thái',
  PRIMARY KEY (id)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_unit ADD " . $lang . "_title varchar(255) NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_unit ADD " . $lang . "_note text NOT NULL";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_block(
  bid smallint(5) unsigned NOT NULL,
  id int(11) unsigned NOT NULL,
  weight int(11) unsigned NOT NULL,
  UNIQUE KEY bid (bid,id)
) ENGINE=MyISAM";

$sql_create_module[] = "CREATE TABLE IF NOT EXISTS " . $db_config['prefix'] . "_" . $module_data . "_block_cat(
  bid smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  adddefault tinyint(4) NOT NULL DEFAULT '0',
  numbers smallint(5) NOT NULL DEFAULT '10',
  image varchar(255) DEFAULT '',
  weight smallint(5) NOT NULL DEFAULT '0',
  add_time int(11) NOT NULL DEFAULT '0',
  edit_time int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (bid)
) ENGINE=MyISAM";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_block_cat ADD " . $lang . "_title varchar(250) NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_block_cat ADD " . $lang . "_alias varchar(250) NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_block_cat ADD " . $lang . "_description text NOT NULL";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_block_cat ADD " . $lang . "_keywords varchar(255) NOT NULL";

// Cau hinh mac dinh
$data = array();
$data['format_booking_code'] = '%09s';
$data['format_code'] = '%09s';
$data['money_unit'] = 'VND';
$data['structure_upload'] = '';
$data['home_type'] = '0';
$data['title_lenght'] = 50;
$data['booking_groups'] = 6;
$data['booking_groups_sendmail'] = 3;
$data['home_image_size'] = '250x150';
$data['no_image'] = '';
$data['per_page'] = 21;
$data['asep'] = '.';
$data['adec'] = ',';

foreach ($data as $config_name => $config_value) {
    $sql_create_module[] = "INSERT INTO " . NV_CONFIG_GLOBALTABLE . " (lang, module, config_name, config_value) VALUES ('" . $lang . "', " . $db->quote($module_name) . ", " . $db->quote($config_name) . ", " . $db->quote($config_value) . ")";
}

// Copy du lieu khi cai dat ngon ngu moi
if (! empty($set_lang_data)) {
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_cat")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_title = " . $global_config['site_lang'] . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_alias = " . $set_lang_data . "_alias";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_custom_title = " . $global_config['site_lang'] . "_custom_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_keywords = " . $set_lang_data . "_keywords";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_description = " . $set_lang_data . "_description";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_cat SET " . $lang . "_description_html = " . $set_lang_data . "_description_html";
    }
    
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_rows")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_rows SET " . $lang . "_title = " . $set_lang_data . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_rows SET " . $lang . "_alias = " . $set_lang_data . "_alias";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_rows SET " . $lang . "_title_custom = " . $set_lang_data . "_title_custom";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_rows SET " . $lang . "_description = " . $set_lang_data . "_description";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_rows SET " . $lang . "_description_html = " . $set_lang_data . "_description_html";
    }
    
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_images")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_images SET " . $lang . "_title = " . $set_lang_data . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_images SET " . $lang . "_description = " . $set_lang_data . "_description";
    }
    
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_firm")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_firm SET " . $lang . "_title = " . $set_lang_data . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_firm SET " . $lang . "_description = " . $set_lang_data . "_description";
    }
    
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_unit")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_unit SET " . $lang . "_title = " . $set_lang_data . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_unit SET " . $lang . "_note = " . $set_lang_data . "_note";
    }
    
    $numrow = $db->query("SELECT count(*) FROM " . $db_config['prefix'] . "_" . $module_data . "_block_cat")->fetchColumn();
    if ($numrow) {
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_block_cat SET " . $lang . "_title = " . $set_lang_data . "_title";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_block_cat SET " . $lang . "_alias = " . $set_lang_data . "_alias";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_block_cat SET " . $lang . "_description = " . $set_lang_data . "_description";
        $sql_create_module[] = "UPDATE " . $db_config['prefix'] . "_" . $module_data . "_block_cat SET " . $lang . "_keywords = " . $set_lang_data . "_keywords";
    }
}

// unique
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_cat ADD UNIQUE(" . $lang . "_alias)";
$sql_create_module[] = "ALTER TABLE " . $db_config['prefix'] . "_" . $module_data . "_rows ADD UNIQUE(" . $lang . "_alias)";