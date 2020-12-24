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

$array_data = [];
$post=[];
$error=[];
$alert=[];
$product_quantities=[];
$product_ids=[];



function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$post['submit'] = $nv_Request->get_title('submit', 'post', '');
$post['customer_name'] = check_input($nv_Request->get_title('customer_name', 'post', ''));
$post['customer_email'] = $nv_Request->get_title('customer_email', 'post', '');
$post['customer_phone'] = check_input($nv_Request->get_title('customer_phone', 'post', ''));
$post['total_product'] = check_input($nv_Request->get_int('total_product', 'post', ''));
$post['total_bill'] = $nv_Request->get_int('total_bill', 'post', '');
$post['customer_address'] = check_input($nv_Request->get_title('customer_address', 'post', ''));
$post['order_note'] = check_input($nv_Request->get_title('order_note', 'post', ''));

$product_id = $nv_Request->get_typed_array('product_id','post', '');
$product_qty = $nv_Request->get_typed_array('qty_pro','post', '');





//------------------
if (isset($_POST['id']) && isset($_POST['qty'])){
    $id = $_POST['id'];
    $qty = $_POST['qty'];
    $action = $_POST['action'];

    $sql = "SELECT * FROM `nv4_product` WHERE id = " .$id;
    $row_detail = $db->query($sql)->fetch();
        if (!isset($_SESSION["cart"])) {
            $cart = array();
            $cart[$id] = array(
                'name' => $row_detail['product_name'],
                'qty' => $qty,
                'price' => $row_detail['product_price'],
                'image' => $row_detail['product_image']
            );
        } else {
            $cart = $_SESSION["cart"];
            if (array_key_exists($id, $cart) && $action != 'update') {
                if ($qty) {
                    $cart[$id] = array(
                        'name' => $row_detail['product_name'],
                        'qty' => (int)$cart[$id]['qty'] + $qty,
                        'price' => $row_detail['product_price'],
                        'image' => $row_detail['product_image']
                    );
                }else{
                    unset($cart[$id]);
                }
            } else {
                    $cart[$id] = array(
                        'name' => $row_detail['product_name'],
                        'qty' => $qty,
                        'price' => $row_detail['product_price'],
                        'image' => $row_detail['product_image']
                    );
            }
        }
    $_SESSION["cart"] =$cart;
}



/* create order */
if(!empty($post['submit']))
{
    if (empty($post['customer_name']))
    {
        $error[] = 'Bạn chưa nhập tên';
    }
    if (empty($post['customer_email']))
    {
        $error[] = 'Bạn chưa nhập email';
    } else if (!preg_match("/^[a-z][a-z0-9_\.]{5,32}@[a-z0-9]{2,}(\.[a-z0-9]{2,4}){1,2}$/i", $post['customer_email'])){
        $error[] = 'Email sai định dạng';
    }
    if (empty($post['customer_phone']))
    {
        $error[] = 'Bạn chưa nhập số điện thoại';
    } else if ((!preg_match('/[0-9][^#&<>\"~;$^%{}?a-zA-Z]{9,10}$/', $post['customer_phone'])) || !is_numeric($post['customer_phone'])) {
        $error[] = 'số điện thoại không đúng định dạng';
    }
    if (empty($post['customer_address']))
    {
        $error[] = 'Bạn chưa nhập địa chỉ';
    }
    if (!empty($product_id) && !empty($product_qty))
    {
        $post['total_price'] = 0;
        foreach($product_id as $product_ids_key => $productId) {
            //
            $quantity = $product_qty[$product_ids_key];
            $sql = "SELECT * FROM `nv4_product` WHERE id=" . $productId;
            $product = $db->query($sql)->fetch();
            $totalPriceProduct = $quantity*$product['product_price'];
            $post['total_price'] += $totalPriceProduct;
        }
    }else{
        $error[] = 'Bạn chọn sản phẩm';
    }



    if (empty($error)){

        $sql = "INSERT INTO `nv4_orders2`(`customer_name`, `customer_email`, `customer_phone`, `customer_address`,  `order_note`, `created_at`,`order_status`,`total_product`, `total_price`) 
            VALUES (:customer_name,:customer_email,:customer_phone,:customer_address,:order_note,:created_at,:order_status, :total_product, :total_price)";
        $s = $db->prepare($sql);

        $s->bindParam('customer_name', $post['customer_name']);
        $s->bindParam('customer_email', $post['customer_email']);
        $s->bindParam('customer_phone', $post['customer_phone']);
        $s->bindParam('customer_address', $post['customer_address']);
        $s->bindParam('total_product', $post['total_product']);
        $s->bindParam('total_price', $post['total_bill']);
        $s->bindParam('order_note', $post['order_note']);
        $s->bindValue('created_at',NV_CURRENTTIME);
        $s->bindValue('order_status',1);
        if ($s->execute()){
            $order_id = $db->lastInsertId();
            foreach($product_id as $product_ids_key => $productId) {
                $quantity = $product_qty[$product_ids_key];
                $sql = "SELECT product_price FROM `nv4_product` WHERE id=" . $productId;
                $product = $db->query($sql)->fetch();
                $sql = "INSERT INTO `nv4_orderdetail2` (`order_id`,`product_id`,`quantity`,`product_price`)  VALUES (:order_id, :product_id, :quantity,:product_price)";
                $s = $db->prepare($sql);
                $s->bindValue('order_id', $order_id);
                $s->bindValue('product_id', $productId);
                $s->bindValue('quantity', $quantity);
                $s->bindValue('product_price', $product['product_price']);
                $s->execute();

                $alert = 'Đặt hàng thành công';
            }
        }
    }
}



//------------------

$contents = nv_theme_category_cart($array_data,$error,$alert);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
