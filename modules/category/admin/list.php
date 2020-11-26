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



//change weight
//thay doi stt
if ($nv_Request->isset_request('change_weight','post,get')){
    $id = $nv_Request->get_int('id','post,get',0);
    $new_weight = $nv_Request->get_int('new_weight','post,get',0);
    if ($id>0 && $new_weight>0){
        $sql = "SELECT id, weight FROM `nv4_categories` WHERE id != " .$id;
        $result = $db->query($sql);
        $weight = 0;
        while ($row = $result->fetch()){
            ++$weight;
            if ($weight == $new_weight){
                ++$weight;
            }
            $exe = $db->query("UPDATE `nv4_categories` SET weight = " . $weight ." WHERE id = ".$row['id']);
        }

        $exe = $db->query("UPDATE `nv4_categories` SET weight = " . $new_weight ." WHERE id = ".$id);
    }
}


//phan trang
$page_title = $lang_module['main'];

$perpage = 5;
$page = $nv_Request->get_int('page','get',1);

$keyword = $nv_Request->get_title('keyword','get','');
$db->sqlreset()
    ->select('COUNT(*)')
    ->from($db_config['prefix'].'_'.'categories')
    ->where('category_name LIKE '.$db->quote('%'.$keyword.'%'));
$sql = $db->sql();
$total = $db->query($sql)->fetchColumn();

$db->select('*')
    ->order('weight ASC')
    ->limit($perpage)
    ->offset(($page-1)*$perpage);

$sql = $db->sql();
$result = $db->query($sql);
while ($row = $result->fetch()){
    $array_row[$row['id']] = $row;
}



//------------------------------
// Viết code xử lý chung vào đây

//xoá sản phẩmd

if ($nv_Request->isset_request('action','post,get')){
    $id = $nv_Request->get_int('id','post,get',0);
    $checksess = $nv_Request->get_title('checksess','post,get',0);
    if($id>0 && $checksess==md5($id.NV_CHECK_SESSION)){
        $db->query("DELETE FROM `nv4_categories` WHERE id=".$id);
    }
}

//------------------------------

$xtpl = new XTemplate('list.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
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
        for ($j=1; $j<=$total;$j++){
            $xtpl->assign('J',$j);
            $xtpl->assign('J_SELECT',$j == $row['weight'] ? 'selected = "selected"' : '');
            $xtpl->parse('main.loop.weight');
        }
        $row['stt'] = $i+1;
        if (!empty($row['category_image']))
            $row['category_image'] = NV_BASE_SITEURL.NV_UPLOADS_DIR.'/'.$module_name.'/'. $row['category_image'];

        //hiển thị danh mục


        $row['url_delete'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name. '&amp;' . NV_OP_VARIABLE .'=list&amp;id='.$row['id'].'&action=delete&checksess='. md5($row['id'].NV_CHECK_SESSION) ;
        $row['url_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name.'&amp;' . NV_OP_VARIABLE . '=crud_cate&amp;id=' . $row['id'];

        $xtpl->assign('ROW',$row);
        $xtpl->parse('main.loop');
        $i++;

    }
}


$base_url =NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' .$module_name.'&amp;' . NV_OP_VARIABLE . '=list';
$generate_page=nv_generate_page($base_url,$total,$perpage,$page);
$xtpl->assign('GENERATE_PAGE',$generate_page);
$xtpl->parse('main.GENERATE_PAGE');
//-------------------------------

$xtpl->parse('main');
$contents = $xtpl->text('main');



include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
