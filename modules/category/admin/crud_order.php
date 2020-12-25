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
$error = [];
$page_title = $lang_module['main'];

$post['id'] = $nv_Request->get_int('id','post,get','0');

$post['customer_name'] = $nv_Request->get_title('customer_name','post','');
$post['customer_email'] = $nv_Request->get_title('customer_email','post','');
$post['customer_phone'] = $nv_Request->get_title('customer_phone','post','');
$post['order_status'] = $nv_Request->get_int('order_status','post','');
$post['customer_address'] = $nv_Request->get_title('customer_address','post','');
$post['order_note'] = $nv_Request->get_title('order_note','post','');

$post['submit'] = $nv_Request->get_title('submit','post');

echo "<pre>";
print_r($post);
echo "</pre>";

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
    $order_id = $nv_Request->get_int('order_id','post,get',0);
    $checksess = $nv_Request->get_title('checksess','post,get',0);


    if($id>0 && $checksess==md5($id.NV_CHECK_SESSION)) {
        /* $result = $db->query("SELECT total FROM `nv4_orderdetail2` WHERE id =".$order_id);*/
        $result = $db->query("SELECT total, quantity FROM `nv4_orderdetail2` WHERE id =" . $id);
        $row = $result->fetch();
        $total['total'] = $row['total'];
        $total['quantity'] = $row['quantity'];


        $result2 = $db->query("SELECT total_product, total_price  FROM `nv4_orders2` WHERE id =" . $order_id);
        $row2 = $result2->fetch();
        $total2['total_product'] = $row2['total_product'];
        $total2['total_price'] = $row2['total_price'];

        if ($db->query("DELETE FROM `nv4_orderdetail2` WHERE id=" . $id)) {
            $db->query("UPDATE `nv4_orders2` SET `total_product`=" . ($total2['total_product'] - $total['quantity']) . ",`total_price`=" . ($total2['total_price'] - $total['total']) . " WHERE id = " . $order_id);
            header('Location: '.NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' .$module_name.'&' . NV_OP_VARIABLE . '=crud_order&id=' . $order_id);
        }
    }

}

if (!empty($post['submit'])){
    if (empty($post['customer_name'])){
        $error[] = "Chưa nhập tên";
    }

    if (empty($post['customer_email'])){
        $error[] = "Chưa nhập email";
    }

    if (empty($post['customer_phone'])){
        $error[] = "Chưa nhập số điện thoại";
    }
    if (empty($post['customer_address'])){
        $error[] = "Chưa nhập địa chỉ";
    }
    if (empty($error)){
        if ($post['id']>0){
            /*
             * UPDATE `nv4_orders2` SET `id`=[value-1],`customer_name`=[value-2],`customer_email`=[value-3],`customer_phone`=[value-4],`customer_address`=[value-5],
             * `order_status`=[value-8],`order_note`=[value-9],`created_at`=[value-10],`updated_at`=[value-11] WHERE 1
             */
            $sql = "UPDATE `nv4_orders2` SET `customer_name`=:customer_name,`customer_email`=:customer_email,`customer_phone`=:customer_phone,`customer_address`=:customer_address,
`order_status`=:order_status,`updated_at`=:updated_at,`order_note`=:order_note WHERE id =".$post['id'];
            $sth = $db->prepare($sql);
            $sth->bindValue('updated_at',NV_CURRENTTIME);
        }
        $sth->bindParam('customer_name', $post['customer_name']);
        $sth->bindParam('customer_email', $post['customer_email']);
        $sth->bindParam('customer_phone', $post['customer_phone']);
        $sth->bindParam('customer_address', $post['customer_address']);
        $sth->bindParam('order_status', $post['order_status']);
        $sth->bindParam('order_note', $post['order_note']);
        $exe = $sth->execute();

        if ($exe) {
            $error[] = "OK";
        } else {
            $error[] = "Khong insert dc";
        }
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
$xtpl->assign('POST', $post);
$xtpl->assign('ERROR',implode('<br>',$error));
if (!empty($error)){
    $xtpl->parse('main.error');
}

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

        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name. '&amp;' . NV_OP_VARIABLE .'=crud_order&amp;id='.$row['id'].'&order_id='.$row['order_id'].'&action=delete&checksess='. md5($row['id'].NV_CHECK_SESSION) ;

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
        $customer['id'] = $row3['id'];
        $customer['total_product'] = $row3['total_product'];
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
