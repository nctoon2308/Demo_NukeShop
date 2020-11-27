<!-- BEGIN: main -->
<!-- BEGIN: keyword -->
<div class="well">
    <form action="" method="get">
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}"/>
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}"/>
        <div class="row">
            <div class="col-xs-12 col-md-6">
                <div class="form-group">
                    <input class="form-control" type="text" value="{KEYWORD}" maxlength="64" name="keyword"
                           placeholder="{LANG.search_key}"/>
                </div>
            </div>

            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <select class="form-control" name="order_by">
                        <option value="" selected="selected">---Sắp xếp theo---</option>
                        <option value="weight">Số thứ tự</option>
                        <option value="category_name">Tên danh mục</option>
                        <option value="category_desc">Tiêu đề</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="form-group">
                    <select class="form-control" name="stype">
                        <option value="" selected="selected">---Kiểu sắp xếp---</option>
                        <option value="ASC">Tăng dần</option>
                        <option value="DESC">Giảm dần</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-md-2">
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{LANG.search}"/>
                </div>
            </div>
        </div>


    </form>
</div>
<!-- END: keyword -->
<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr class="text-center">
            <th class="text-nowrap">
                Số thứ tự
            </th>
            <th class="text-nowrap">
                Tên danh mục
            </th>
            <th class="text-nowrap">
                Tiêu đề
            </th>
            <th class="text-nowrap">Ảnh</th>
            <th class="text-nowrap">
                Mô tả
            </th>
            <th class="text-nowrap text-center">Chức năng</th>
        </tr>
        </thead>
        <tbody>
        <!-- BEGIN: loop -->
        <tr class="text-center">
            <td class="">
                <select onchange="nv_change_weight({ROW.id})" name="weight" class="form-control weight_{ROW.id}" id="">
                    <!-- BEGIN: weight -->
                    <option value="{J}" {J_SELECT}>{J}</option>
                    <!-- END: weight -->
                </select>
            </td>
            <td class="">{ROW.category_name}</td>
            <td class="">{ROW.category_slug}</td>

            <td class="">
                <img src="{ROW.category_image}" width="100px" height="100px">
            </td>
            <td class="">{ROW.category_desc}</td>
            <td class="text-center text-nowrap">
                <a href="{ROW.url_edit}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i>Sửa</a>
                <a href="{ROW.url_delete}" class="btn btn-danger btn-sm delete"><i class="fa fa-edit"></i>Xoá</a>
            </td>
        </tr>
        <!-- END: loop -->
        </tbody>
    </table>
    <!-- BEGIN: GENERATE_PAGE -->
    {GENERATE_PAGE}
    <!-- END: GENERATE_PAGE -->
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('.delete').click(function () {
            if (confirm("Bạn có muốn xoá?")) {
                return true;
            } else {
                return false;
            }
        });
    });

    function nv_change_weight(id) {
        var new_weight = $('.weight_' + id).val();
        $.ajax({
            url: script_name + '?' + nv_name_variable + '=' + nv_module_name
                + '&' + nv_fc_variable
                + '=list&change_weight=1&id=' + id + '&new_weight=' + new_weight,
            success: function (result) {
                if (result != 'ERR') {
                    location.reload();
                }

            }
        });
    }


</script>
<!-- END: main -->