<!-- BEGIN: main -->

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <!-- BEGIN: loop -->
        <tr class="text-center" category_id="20">
            <th class=""><a href="">{ROW.product_name}</th>
            <td class="">{ROW.category_id}</td>
            <td class="">{ROW.product_status}</td>

            <td class="">
                <img src="{ROW.product_image}" width="100px" height="100px">
            </td>
            <td class="">{ROW.product_desc}</td>
            <td class="">{ROW.product_quantity}</td>
            <td class="">{ROW.product_price}</td>
        </tr>
        <!-- END: loop -->
        </tbody>
    </table>
    <!-- BEGIN: GENERATE_PAGE -->
    {GENERATE_PAGE}
    <!-- END: GENERATE_PAGE -->
</div>
<!-- END: main -->