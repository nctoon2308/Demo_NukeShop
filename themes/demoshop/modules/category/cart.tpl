<!-- BEGIN: main -->
<!-- BEGIN: error -->
<div class="alert alert-warning" role="alert">{ERROR}</div>
<!-- END: error -->
<!-- BEGIN: alert -->
<div class='alert alert-info' role="alert">{ALERT}</div>
<!-- END: alert -->
<form action="{NV_BASE_SITEURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
<!-- BEGIN: dataLoop -->
<h1>Giỏ hàng</h1>
<div class="listCart">
<table id="tableCart">
    <input type="hidden" class="form-control" name="product_id[]" aria-label="..." value="{CART.id}"/>
    <input type="hidden" class="form-control" name="qty_pro[]" aria-label="..." value="{CART.qty}"/>
    <tr>
        <td>Ảnh sản phẩm</td>
        <td>
            <img src="{CART.image}" alt="" width="75" height="75">
        </td>
    </tr>
    <tr>
        <td>Tên sản phẩm</td>
        <td>{CART.name}</td>
    </tr>
    <tr>
        <td>Số lượng sản phẩm</td>
        <td><input min="1" type="number" value="{CART.qty}" name="qty" id="qty_{CART.id}" onchange="updateCart({CART.id}, 'update')"></td>
    </tr>
    <tr>
        <td>Giá sản phẩm</td>
        <td><span class="product_price" id="price_{CART.id}">{CART.price}</span></td>
    </tr>
    <tr>
        <td>Tổng tiền</td>
        <td><span class="product_price_total" id="total_{CART.id}">{CART.total}</span></td>
    </tr>
    <tr>
        <td>
         <a href="#" class="btn btn-danger" onclick="destroyCart({CART.id})">Xoá sản phẩm</a>
        </td>
    </tr>
</table>
</div>

<!-- END: dataLoop -->
      <h2>Tổng tiền đơn hàng: <b id="total_bill2">{TOTAL_BILL}</b> đ</h2>


    <h1>Thông tin khách hàng</h1>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Tên khách hàng: (*)</label>
            <input type="text" class="form-control" name="customer_name" value="">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Eamil: (*)</label>
            <input type="text" class="form-control" name="customer_email" value="">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Số điện thoại: (*)</label>
            <input type="text" class="form-control" name="customer_phone" value="">

            <input type="hidden" value="{TOTAL_BILL}" id="total_bill" name="total_bill">
            <input type="hidden" value="{TOTAL_PRO}" id="total_product" name="total_product">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Địa chỉ: (*)</label>
            <textarea name="customer_address" id="" cols="37" rows="3"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="">Ghi chú: </label>
            <textarea name="order_note" id="" cols="37" rows="3"></textarea>
        </div>
    </div>
    <div class="text-center" ><input style="margin-top:10px;" class="btn btn-primary" name="submit" type="submit" value="Đặt hàng" /></div>
</form>
    <script type="text/javascript">


        function updateCart(id, action) {
            var total = 0, total_product = 0;
            $("input[name='qty']").each(function (index, value) {
                var t = $(this);
                var tr = t.closest("div.listCart");
                var qty = t.val();
                qty = parseInt(qty);
                var pro =+ qty;
                total_product += pro;
                var price = tr.find("span.product_price").text();
                price = parseFloat(price);
                var tt = qty*price;
                tr.find("span.product_price_total").text( new Intl.NumberFormat().format(tt));
                total += tt;
                $("#total_bill2").text(new Intl.NumberFormat().format(total));
                $("#total_bill").attr({
                    'value': new Intl.NumberFormat().format(total),
                });
                $("#total_product").attr({
                    'value': new Intl.NumberFormat().format(total_product),
                });

                $.ajax({
                    url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
                    method: 'POST',
                    dataType:"text",
                    data: {id: id,qty: qty, action: action},
                    success: function(data) {
                    }
                });
            });
        }
    function destroyCart(id) {
        qty = 0;
        console.log(qty);

        $.ajax({
            url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
            method: 'POST',
            dataType:"text",
            data: {id: id,qty: qty},
            success: function(data) {
                location.reload();
            }
        });
    }

</script>
<!-- END: main -->