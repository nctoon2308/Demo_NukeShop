<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->
<form  enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" name="{MODULE_NAME}">
   <div class="form-group">
       <div class="form-group">
           <label for="customer_name">Tên khách hàng:</label>
           <input type="text" name="customer_name" class="form-control" id="customer_name" value="">
       </div>
       <div class="form-group">
           <label for="customer_email">Email:</label>
           <input type="text" name="customer_email" class="form-control" id="customer_email" value="">
       </div>
       <div class="form-group">
           <label for="customer_phone">Số điện thoại:</label>
           <input type="text" name="customer_phone" class="form-control" id="customer_phone" value="">
       </div>
       <div class="form-group">
           <label for="order_status">Trạng thái đơn hàng:</label>
           <select name="order_status" class="form-control" style="width: 250px">
               <option value="1" >Đang chờ xác nhận</option>
               <option value="2" >Đã xác nhận</option>
               <option value="3" >Đang vận chuyển</option>
               <option value="4" >Hoàn tất</option>
               <option value="5" >Đơn hủy</option>
               <option value="6" >Đã hoàn tiền ( hủy đơn )</option>
           </select>
       </div>
       <div class="form-group">
           <label for="customer_address">Địa chỉ:</label>
           <textarea name="customer_address" class="form-control" rows="3" id="customer_address"></textarea>
       </div>
       <div class="form-group">
           <label for="order_note">Ghi chú:</label>
           <textarea name="order_note" class="form-control" rows="3" id="order_note"></textarea>
       </div>

       <div class="form-group">
           <div class="table-responsive">
               <table class="table table-striped table-bordered table-hover">
                   <thead>
                   <tr class="text-center">
                       <th class="text-nowrap">Số thứ tự</th>
                       <th class="text-nowrap">Tên sản phẩm</th>
                       <th class="text-nowrap">Danh mục</th>
                       <th class="text-nowrap">Ảnh</th>
                       <th class="text-nowrap">Mô tả</th>
                       <th class="text-nowrap">Số lượng</th>
                       <th class="text-nowrap">Giá 1 sản phẩm</th>
                       <th class="text-nowrap">Tổng giá sản phẩm</th>
                       <th class="text-nowrap text-center">Chức năng</th>
                   </tr>
                   </thead>
                   <tbody>
                   <!-- BEGIN: loop -->
                   <tr class="text-center">
                       <td class="">{ROW.stt}</td>
                       <td class="">{ROW.product_name}</td>
                       <td class="">{ROW.category_id}</td>

                       <td class="">
                           <img src="{ROW.product_image}" width="100px" height="100px">
                       </td>
                       <td class="">{ROW.product_desc}</td>
                       <td class="">{ROW.quantity}</td>
                       <td class="">{ROW.product_price}</td>
                       <td class="">4</td>
                       <td class="text-center text-nowrap">
                           <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><i class="fa fa-edit"></i>Xoá</a>
                       </td>
                   </tr>
                   <!-- END: loop -->
                   </tbody>
               </table>


           </div>
       </div>
        <div class="text-center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
   </div>
</form>
<!-- END: main -->