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

/**
 * nv_theme_category_main()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_category_main($array_data)
{
    global $module_info, $lang_module, $lang_global, $op, $page, $perpage, $row, $db, $module_name, $total, $row_cate;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    //------------------
    

    if (!empty($row_cate)) {
        foreach ($row_cate as $cate){
            $cate['url_product'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=search&amp;id='. $cate['id'];
            $xtpl->assign('CATE', $cate);
            $xtpl->parse('main.cate');
        }
    }


if (!empty($array_data)) {
    $i = ($page - 1) * $perpage;
    foreach ($array_data as $row) {

        $row['stt'] = $i + 1;
        if (!empty($row['product_image']))
            $row['product_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['product_image'];

            $row['url_detail'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=detail&amp;id='. $row['id'];
        //Trạng thái hàng hoá
        if ($row['product_status'] == 0) {
            $row['product_status'] = "Tạm ngưng bán";
        } else {
            $row['product_status'] = "Còn hàng";
        }
        if (!empty($row['category_id'])) {
            $db->sqlreset()
                ->select('*')
                ->from('nv4_categories')
                ->where('nv4_categories.id=' . $row['category_id']);
            $sql3 = $db->sql();
            $result = $db->query($sql3);
            $array_data = $result->fetch();
            $row['category_id'] = $array_data['category_name'];
            $row['product_price'] = number_format($row['product_price']);
        }


        $xtpl->assign('ROW', $row);
        $xtpl->parse('main.loop');
        $i++;

    }
}




$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main';


$generate_page = nv_generate_page($base_url, $total, $perpage, $page);
$xtpl->assign('GENERATE_PAGE', $generate_page);
$xtpl->parse('main.GENERATE_PAGE');


    //------------------

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_category_detail()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_category_detail($row_detail,$row_cate)
{
    global $module_info, $lang_module, $lang_global, $op, $module_name;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    
    $row_detail['product_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/'. $module_name . '/' . $row_detail['product_image'];
    $row_detail['product_price'] = number_format($row_detail['product_price']);
    $row_detail['url_order'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=order&amp;id='. $row_detail['id'];
    
    $xtpl->assign('ROWDETAIL', $row_detail);
    
    if (!empty($row_rd)) {
        foreach ($row_rd as $rd){
            $rd['product_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/'. $module_name . '/' . $rd['product_image'];
            $rd['url_detail'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=detail&amp;id='. $rd['id'];
            $xtpl->assign('ROWRD', $rd);
            $xtpl->parse('main.row_rd');
        }
    }
    
    $xtpl->assign('ROWCATE', $row_cate);
    //------------------
    // Viết code vào đây
    //------------------

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_category_search()
 * 
 * @param mixed $array_data
 * @return
 */
function nv_theme_category_search($array_data)
{
    global $module_info, $lang_module, $lang_global, $op, $page, $perpage, $row, $db, $module_name, $total, $row_cate;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);

    //------------------


    if (!empty($row_cate)) {
        foreach ($row_cate as $cate){
            $cate['url_product'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=search&amp;id='. $cate['id'];
            $xtpl->assign('CATE', $cate);
            $xtpl->parse('main.cate');
        }
    }


    if (!empty($array_data)) {
        $i = ($page - 1) * $perpage;
        foreach ($array_data as $row) {

            $row['stt'] = $i + 1;
            if (!empty($row['product_image']))
                $row['product_image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $row['product_image'];

            $row['url_detail'] = NV_BASE_SITEURL .'index.php?'. NV_LANG_VARIABLE .'='. NV_LANG_DATA .'&amp;'. NV_NAME_VARIABLE .'='. $module_name .'&amp;'. NV_OP_VARIABLE .'=detail&amp;id='. $row['id'];
            //Trạng thái hàng hoá
            if ($row['product_status'] == 0) {
                $row['product_status'] = "Tạm ngưng bán";
            } else {
                $row['product_status'] = "Còn hàng";
            }
            if (!empty($row['category_id'])) {
                $db->sqlreset()
                    ->select('*')
                    ->from('nv4_categories')
                    ->where('nv4_categories.id=' . $row['category_id']);
                $sql3 = $db->sql();
                $result = $db->query($sql3);
                $array_data = $result->fetch();
                $row['category_id'] = $array_data['category_name'];
                $row['product_price'] = number_format($row['product_price']);
            }


            $xtpl->assign('ROW', $row);
            $xtpl->parse('main.loop');
            $i++;

        }
    }




    $base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=main';


    $generate_page = nv_generate_page($base_url, $total, $perpage, $page);
    $xtpl->assign('GENERATE_PAGE', $generate_page);
    $xtpl->parse('main.GENERATE_PAGE');


    //------------------

    $xtpl->parse('main');
    return $xtpl->text('main');
}


function nv_theme_category_cart($array_data, $error, $alert)
{
    global $module_info, $lang_module, $lang_global, $op, $module_name, $post, $total_bill, $total_pro, $alert;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('GLANG', $lang_global);
    $xtpl->assign('OP', $op);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('POST', $post);
    $xtpl->assign('ERROR',implode('<br>',$error));
    if (!empty($error)){
        $xtpl->parse('main.error');
    }


    foreach ($_SESSION["cart"] as $key_cart => $val_cart_item)
    {
        $val_cart_item['id'] = $key_cart;

        $val_cart_item['image'] = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_name . '/' . $val_cart_item['image'];
        $val_cart_item['total'] = $val_cart_item['qty'] * $val_cart_item['price'];
        $total_bill += ($val_cart_item['qty'] * $val_cart_item['price']);
        $total_pro += $val_cart_item['qty'];
        $xtpl->assign('CART', $val_cart_item);
        $xtpl->parse('main.dataLoop');
    }
    $xtpl->assign('TOTAL_BILL', number_format($total_bill));
    $xtpl->assign('TOTAL_PRO', number_format($total_pro));
    //------------------

    /* Hiển thị alert */
    if (!empty($alert)) {
        $xtpl->assign('ALERT', $alert);
        //hiển thị khối main.alert
        $xtpl->parse('main.alert');
    }
    /* end alert */

    $xtpl->parse('main');
    return $xtpl->text('main');
}

