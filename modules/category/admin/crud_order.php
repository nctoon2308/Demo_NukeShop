<?php

/**
 * @Project NUKEVIET 4.x
 * @Author VINADES.,JSC <contact@vinades.vn>
 * @Copyright (C) 2020 VINADES.,JSC. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Tue, 10 Nov 2020 06:56:08 GMT
 */

if (!defined('NV_IS_FILE_ADMIN')) {
    die('Stop!!!');
}

$page_title = $lang_module['main'];

$post['id'] = $nv_Request->get_int('id','post,get','0');



//change weight
//thay doi stt



//phan trang
$page_title = $lang_module['main'];


$db->sqlreset()
    ->select('product_id')
    ->from($db_config['prefix'].'_'.'orderdetail2')
    ->where('order_id='.$post['id']);
$sql = $db->sql();
$result = $db->query($sql);
//SELECT * FROM `nv4_product` WHERE ID IN (4,5)
while ($row = $result->fetch()){

}



//------------------------------
// Viết code xử lý chung vào đây

//xoá sản phẩmd

if ($nv_Request->isset_request('action','post,get')){
    $id = $nv_Request->get_int('id','post,get',0);
    $checksess = $nv_Request->get_title('checksess','post,get',0);
    if($id>0 && $checksess==md5($id.NV_CHECK_SESSION)){
        $db->query("DELETE FROM `nv4_product` WHERE id=".$id);
    }
}

//------------------------------

$xtpl = new XTemplate('crud_order.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);


//-------------------------------
// Viết code xuất ra site vào đây

if (!empty($array_row)){
    $i = 0;
    foreach ($array_row as $row){

        $row['stt'] = $i+1;
        if (!empty($row['product_image']))
            $row['product_image'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/'.$module_name.'/'. $row['product_image'];

        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name. '&amp;' . NV_OP_VARIABLE .'=list_product&amp;id='.$row['id'].'&action=delete&checksess='. md5($row['id'].NV_CHECK_SESSION) ;

        $xtpl->assign('ROW',$row);
        $xtpl->parse('main.loop');
        $i++;

    }
}



//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');



include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
