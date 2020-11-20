<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->
<form enctype="multipart/form-data" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post" name="{MODULE_NAME}">
    <h1>Tạo mới danh mục</h1>
        <div class="form-group">
            <label for="category_name">Tên danh mục:</label>
            <input type="text" name="category_name" class="form-control" id="category_name" value="{POST.category_name}">
        </div>
        <div class="form-group">
            <label for="category_name">Tiêu đề danh mục:</label>
            <input type="text" name="category_slug" class="form-control" id="category_slug" value="{POST.category_slug}">
        </div>
        <div class="form-group">
            <label for="category_image">Ảnh danh mục:</label>
            <input type="file" class="form-control" name="category_image" id="category_image" value="">
        </div>
        <div class="form-group">
            <label for="category_image">Mô tả danh mục:</label>
            <textarea name="category_desc" class="form-control" id="category_desc"  rows="10">{POST.category_desc}</textarea>
        </div>
    <div class="text-center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>
<!-- END: main -->