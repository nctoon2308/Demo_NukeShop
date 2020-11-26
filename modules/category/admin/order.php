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

$page_title = $lang_module['config'];

//------------------------------
// Viết code xử lý chung vào đây
//phan trang
$page_title = $lang_module['main'];

$perpage = 15;
$page = $nv_Request->get_int('page','get',1);

$db->sqlreset()
    ->select('COUNT(*)')
    ->from($db_config['prefix'].'_'.'orders2');
$sql = $db->sql();
$total = $db->query($sql)->fetchColumn();

$db->select('*')
    ->limit($perpage)
    ->offset(($page-1)*$perpage);

$sql = $db->sql();
$result = $db->query($sql);
while ($row = $result->fetch()){
    $array_row[$row['id']] = $row;
}


if ($nv_Request->isset_request('action','post,get')){
    $id = $nv_Request->get_int('id','post,get',0);
    $checksess = $nv_Request->get_title('checksess','post,get',0);
    if($id>0 && $checksess==md5($id.NV_CHECK_SESSION)){
        $db->query("DELETE FROM `nv4_orders2` WHERE id=".$id);
        header("Refresh");
    }
}

//------------------------------

$xtpl = new XTemplate('order.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
    $i = ($page-1) * $perpage;
    foreach ($array_row as $row){
        $row['stt'] = $i+1;
        $i++;
        //hiển thị danh mục

        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name. '&amp;' . NV_OP_VARIABLE .'=order&amp;id='.$row['id'].'&action=delete&checksess='. md5($row['id'].NV_CHECK_SESSION) ;
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name.'&amp;' . NV_OP_VARIABLE . '=crud_order&amp;id=' . $row['id'];

        if (!empty($row['order_status'])){
            if ($row['order_status'] == 1)
                $row['order_status'] = 'Đang chờ xác nhận';
            elseif ($row['order_status'] == 2)
                $row['order_status'] = 'Đã xác nhận';
            elseif ($row['order_status'] == 3)
                $row['order_status'] = 'Đang vận chuyển';
            elseif ($row['order_status'] == 4)
                $row['order_status'] = 'Hoàn tất';
            elseif ($row['order_status'] == 5)
                $row['order_status'] = 'Đơn hủy';
            else
                $row['order_status'] = 'Đã hoàn tiền ( hủy đơn )';
        }

        $xtpl->assign('ROW',$row);
        $xtpl->parse('main.loop');


    }
}
//-------------------------------

$base_url =NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name.'&amp;' . NV_OP_VARIABLE . '=order';
$generate_page=nv_generate_page($base_url,$total,$perpage,$page);
$xtpl->assign('GENERATE_PAGE',$generate_page);
$xtpl->parse('main.GENERATE_PAGE');

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
