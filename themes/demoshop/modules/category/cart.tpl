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
        <td>{CART.qty}</td>
    </tr>
    <tr>
        <td>Giá sản phẩm</td>
        <td>{CART.price}</td>
    </tr>
    <tr>
        <td>Tổng tiền</td>
        <td>{CART.total}</td>
    </tr>
    <tr>
        <td>
         <a href="#" class="btn btn-danger">Xoá sản phẩm</a>
        </td>
    </tr>
</table>
<!-- END: dataLoop -->
<!-- END: main -->