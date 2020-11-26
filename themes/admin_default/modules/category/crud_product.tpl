<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->
<form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" name="{MODULE_NAME}">
    <div class="form-group">
        <label for="product_name">Tên sản phẩm:</label>
        <input type="text" name="product_name" class="form-control" id="product_name" value="{POST.product_name}">
    </div>
    <input type="hidden" name="id" value="{POST.id}">
    <div class="form-group">
        <label for="product_category">Danh mục sản phẩm:</label>
        <select name="category_id" id="">
            <option value="">--Chọn danh mục--</option>
            <!-- BEGIN: loop -->
            <option value="{ROW.id}">{ROW.category_name}</option>
            <!-- END: loop -->
        </select>
    </div>
    <div class="form-group">
        <label for="product_status">Trạng thái sản phẩm:</label>
        <input type="radio" checked name="product_status" id="product_status" value="1"> Đang mở bán
        <input type="radio" name="product_status" id="product_status" value="0"> Tạm ngừng bán
    </div>
    <div class="form-group">
        <label for="product_image">Ảnh sản phẩm:</label>
        <input type="file" class="form-control" name="product_image" id="product_image" value="">
    </div>
    <div class="form-group">
        <label for="product_image">Mô tả sản phẩm:</label>
        <textarea name="product_desc" class="form-control" id="product_desc"  rows="10">{POST.product_desc}</textarea>
    </div>
    <div class="form-group">
        <label for="product_quantity">Số lượng sản phẩm:</label>
        <input type="number" name="product_quantity" style="width: 250px" class="form-control" id="product_quantity" value="{POST.product_quantity}">
    </div>
    <div class="form-group">
        <label for="product_quantity">Giá bán sản phẩm:</label>
        <input type="number" name="product_price" style="width: 250px" class="form-control" id="product_price" value="{POST.product_price}">
    </div>
    <div class="text-center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
<!-- END: main -->