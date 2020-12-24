<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Tue, 10 Nov 2020 06:56:08 GMT
 */

if (!defined('NV_IS_MOD_CATEGORY')) {
    die('Stop!!!');
}

$page_title = $module_info['site_title'];
$key_words = $module_info['keywords'];


 

$row_detail = [];

$id = $nv_Request->get_title('id', 'post, get', '');

$sql = "SELECT * FROM `nv4_product` WHERE id = " .$id;
$row_detail = $db->query($sql)->fetch();

$sql = "SELECT category_name FROM `nv4_categories` WHERE id = " .$row_detail['category_id'];
$row_cate = $db->query($sql)->fetch();






$contents = nv_theme_category_detail($row_detail,$row_cate);



include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
