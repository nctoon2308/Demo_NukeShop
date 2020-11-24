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

$post = [];
$error = [];
$upload_info =[];

$db->sqlreset()
    ->select('*')
    ->from('nv4_categories')
    ->order("id ASC");
$sql3 = $db->sql();
$result = $db->query($sql3);
$array_row = $result->fetchAll();
/*echo "<pre>";
print_r($array_row);
echo "</pre>";
die();*/



//xu ly anh
if ($nv_Request->isset_request('submit', 'post') and isset($_FILES, $_FILES['product_image'], $_FILES['product_image']['tmp_name']) and is_uploaded_file($_FILES['product_image']['tmp_name'])) {
    //
    $upload = new NukeViet\Files\Upload($admin_info['allow_files_type'], $global_config['forbid_extensions'], $global_config['forbid_mimes'], NV_UPLOAD_MAX_FILESIZE, NV_MAX_WIDTH, NV_MAX_HEIGHT);

    $upload->setLanguage($lang_global);

    $upload_info = $upload->save_file($_FILES['product_image'], NV_UPLOADS_REAL_DIR.'/'.$module_name, false,$global_config['nv_auto_resize']);

   /*die($upload_info['basename']);*/
}



$post['id'] = $nv_Request->get_int('id','post,get',0);
$post['product_name'] = $nv_Request->get_title('product_name','post','');
$post['category_id'] = $nv_Request->get_int('category_id','post',0);
$post['product_status'] = $nv_Request->get_int('product_status','post',0);
$post['product_image'] = $upload_info['basename'];
$post['product_desc'] = $nv_Request->get_title('product_desc','post','');
$post['product_quantity'] = $nv_Request->get_int('product_quantity','post',0);
$post['product_price'] = $nv_Request->get_int('product_price','post',0);

$post['submit'] = $nv_Request->get_title('submit','post');

if (!empty($post['submit'])){
    if (empty($post['product_name'])){
        $error[] = "Chưa nhập tên";
    }

    if (empty($post['category_id'])){
        $error[] = "Chưa chọn danh mục";
    }

    if (empty($post['product_name'])){
        $error[] = "Chưa nhập tên";
    }

    if (empty($post['product_quantity'])){
        $error[] = "Chưa nhập số lượng";
    }

    if (empty($post['product_price'])){
        $error[] = "Chưa nhập giá";
    }
    if (empty($error)){
        if ($post['id']>0){
        //UPDATE
        }
        else {
            $db->sqlreset()
                ->select('COUNT(*)')
                ->from($db_config['prefix'] . '_' . 'product');
            $sql2 = $db->sql();
            $total = $db->query($sql2)->fetchColumn();
            /*$sql = "INSERT INTO `nv4_product`(`product_name`, `product_image`,`product_desc`, `product_quantity`,`product_price`,  `product_status`,
            `category_id`) VALUES (:product_name,:product_image, :product_desc, :product_quantity, :product_price,  :product_status, :category_id)";*/
            $sql = "INSERT INTO `nv4_product`(`product_name`, `product_image`,`product_desc`, `product_quantity`,`product_price`,`product_status`, `category_id`,`created_at`,`weight`) 
            VALUES (:product_name,:product_image, :product_desc,:product_quantity, :product_price,:product_status, :category_id,:created_at,:weight)";
            $sth = $db->prepare($sql);

            $sth->bindValue('weight', $total + 1);
            $sth->bindValue('created_at', NV_CURRENTTIME);

        }
        $sth->bindParam('product_name', $post['product_name']);
        $sth->bindParam('product_image', $post['product_image']);
        $sth->bindParam('product_desc', $post['product_desc']);
        $sth->bindParam('product_quantity', $post['product_quantity']);
        $sth->bindParam('product_price', $post['product_price']);
        $sth->bindParam('product_status', $post['product_status']);
        $sth->bindParam('category_id', $post['category_id']);

            /*$s->bindValue('weight',$total+1); */       /*$s->bindValue('addtime',NV_CURRENTTIME);
            $s->bindValue('updatetime',0);*/
        $exe = $sth->execute();

            if ($exe) {
                $error[] = "OK";
            } else {
                $error[] = "Khong insert dc";
            }
    }
}elseif ($post['id']>0){
    //nếu tồn tại id thì lấy dữ liệu ra
    $sql = "SELECT * FROM `nv4_product` WHERE id=".$post['id'];
    $post = $db->query($sql)->fetch();

    if (!empty($post['product_image'])){
        $post['product_image'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/'.$module_name.'/'. $post['product_image'];
    }

} else{
    $post['category_name'] = "";
    $post['category_slug'] = "";
    $post['category_desc'] = "";
    $post['category_image'] = "";
    $post['weight'] = "";
    $post['created_at'] = "";
}



//------------------------------
// Viết code xử lý chung vào đây
//------------------------------

$xtpl = new XTemplate('crud_product.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('NV_LANG_VARIABLE', NV_LANG_VARIABLE);
$xtpl->assign('NV_LANG_DATA', NV_LANG_DATA);
$xtpl->assign('NV_BASE_ADMINURL', NV_BASE_ADMINURL);
$xtpl->assign('NV_NAME_VARIABLE', NV_NAME_VARIABLE);
$xtpl->assign('NV_OP_VARIABLE', NV_OP_VARIABLE);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('OP', $op);

if (!empty($array_row)){
    foreach ($array_row as $row){
        $xtpl->assign('ROW',$row);
        $xtpl->parse('main.loop');
    }
}

$xtpl->assign('POST', $post);
$xtpl->assign('ERROR',implode('<br>',$error));
if (!empty($error)){
    $xtpl->parse('main.error');
}

//-------------------------------
// Viết code xuất ra site vào đây
//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
