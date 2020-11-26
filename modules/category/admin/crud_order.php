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
    ->select('*')
    ->from($db_config['prefix'].'_'.'orderdetail2')
    ->where('order_id='.$post['id']);
$sql = $db->sql();
$result = $db->query($sql);

//SELECT product_name, category_id, product_image, nv4_orderdetail2.quantity, nv4_orderdetail2.product_price FROM nv4_product
// LEFT JOIN nv4_orderdetail2 ON nv4_product.id = nv4_orderdetail2.product_id WHERE nv4_product.id = 4

//SELECT * FROM `nv4_product` WHERE ID IN (4,5)

while ($row = $result->fetch()){
 /*  echo "<pre>";
    print_r($row);
    echo "</pre>";*/
    $array_row[$row['id']] = $row;

}
/*echo "<pre>";
    print_r($array_row);
    echo "</pre>";*/



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

        if (!empty($row['product_id'])){
            $db->sqlreset()
                ->select('*')
                ->from($db_config['prefix'].'_'.'product')
                ->where('id='.$row['product_id']);
            $sql = $db->sql();
            $result = $db->query($sql);
            while ($row2 = $result->fetch()){
                $row['product_name'] = $row2['product_name'];
                $row['category_id'] = $row2['category_id'];

                $row['product_image'] = $row2['product_image'];
                if (!empty($row['product_image']))
                    $row['product_image'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/'.$module_name.'/'. $row['product_image'];

                $row['product_desc'] = $row2['product_desc'];
            }
        }




        /*if (!empty($row['product_image']))
            $row['product_image'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/'.$module_name.'/'. $row['product_image'];*/

        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name. '&amp;' . NV_OP_VARIABLE .'=crud_order&amp;id='.$row['id'].'&prudct_id='.$row['product_id'].'&action=delete&checksess='. md5($row['product_id'].NV_CHECK_SESSION) ;

        $xtpl->assign('ROW',$row);
        $xtpl->parse('main.total.loop');
        $i++;

    }
}

if (!empty($row['order_id'])) {
    $i=0;
    $db->sqlreset()
        ->select('*')
        ->from($db_config['prefix'] . '_' . 'orders2')
        ->where('id=' . $row['order_id']);
    $sql = $db->sql();
    $result = $db->query($sql);
    /*$row3 = $result->fetch();
    $customer['total_price'] = number_format($row3['total_price'],0,'.',' ');*/
    while ($row3 = $result->fetch()){
        $customer['customer_name'] = $row3['customer_name'];
        $customer['customer_email'] = $row3['customer_email'];
        $customer['customer_phone'] = $row3['customer_phone'];
        $customer['customer_address'] = $row3['customer_address'];
        $customer['order_status'] = $row3['order_status'];
        $customer['order_note'] = $row3['order_note'];
        $customer['total_price'] = number_format($row3['total_price'],0,'.',' ');
    }
}



$xtpl->assign('TOTAL',$customer);
$xtpl->parse('main.total');



//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');



include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
