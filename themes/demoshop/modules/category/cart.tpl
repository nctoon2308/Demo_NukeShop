<!-- BEGIN: main -->
<!-- BEGIN: dataLoop -->
<h1>Giỏ hàng</h1>
<table>
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
        <td><input type="number" value="{CART.qty}" name="qty" id="qty_{CART.id}" onchange="updateCart({CART.id}, 'update')"></td>
    </tr>
    <tr>
        <td>Giá sản phẩm</td>
        <td><span id="price_{CART.id}">{CART.price}</span></td>
    </tr>
    <tr>
        <td>Tổng tiền</td>
        <td><span id="total_{CART.id}">{CART.total}</span></td>
    </tr>
    <tr>
        <td>
         <a href="#" class="btn btn-danger" onclick="destroyCart({CART.id})">Xoá sản phẩm</a>
        </td>
    </tr>
</table>
<!-- END: dataLoop -->
<script type="text/javascript">
    function updateCart(id, action) {
        qty = $("#qty_"+id).val();
        price = $("#price_"+id).text();
        /*total = $("#total_"+id).text();*/
        $("#total_"+id).text(price*qty);
        total = qty * price;
        $.ajax({
            url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
            method: 'POST',
            dataType:"text",
            data: {id: id,qty: qty, action: action},
            success: function(data) {

            }
        });
    }

    function destroyCart(id) {
        qty = $("#qty_"+id).val();
        price = $("#price_"+id).text();
        /*total = $("#total_"+id).text();*/
        $("#total_"+id).text(price*qty);
        total = qty * price;
        $.ajax({
            url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
            method: 'POST',
            dataType:"text",
            data: {id: id,qty:0},
            success: function(data) {

            }
        });
    }

</script>
<!-- END: main -->