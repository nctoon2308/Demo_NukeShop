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

//------------------
if (isset($_POST['id']) && isset($_POST['qty'])){
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    $sql = "SELECT * FROM `nv4_product` WHERE id = " .$id;
    $row_detail = $db->query($sql)->fetch();
    if(!isset($_SESSION["cart"])){
        $cart = array();
        $cart[$id] = array(
          'name' => $row_detail['product_name'],
            'qty' => $qty,
            'price' => $row_detail['product_price'],
            'image' =>  $row_detail['product_image']
        );
    }else{
        $cart = $_SESSION["cart"];
        if (array_key_exists($id, $cart)){
            $cart[$id] = array(
                'name' => $row_detail['product_name'],
                'qty' => (int)$cart[$id]['qty'] + $qty,
                'price' => $row_detail['product_price'],
                'image' =>  $row_detail['product_image']
            );
        }else{
            $cart[$id] = array(
                'name' => $row_detail['product_name'],
                'qty' => $qty,
                'price' => $row_detail['product_price'],
                'image' =>  $row_detail['product_image']
            );
        }
    }

    $_SESSION["cart"] =$cart;

    echo "<pre>";
    print_r($cart);
    echo "</pre>";
}

//------------------

$contents = nv_theme_category_cart($array_data, $_SESSION["cart"]);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
