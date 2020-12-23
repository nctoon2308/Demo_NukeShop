
<!-- BEGIN: main -->
<div class="row">
	<div class="col-md-24">
		<div id="cp_widget_f084c050-4ced-461a-a3b7-e0a9ff73da17">...</div><script type="text/javascript"> var cpo = []; cpo["_object"] ="cp_widget_f084c050-4ced-461a-a3b7-e0a9ff73da17"; cpo["_fid"] = "AsCAVve1qj-V"; var _cpmp = _cpmp || []; _cpmp.push(cpo); (function() { var cp = document.createElement("script"); cp.type = "text/javascript"; cp.async = true; cp.src = "//www.cincopa.com/media-platform/runtime/libasync.js"; var c = document.getElementsByTagName("script")[0]; c.parentNode.insertBefore(cp, c); })(); </script>
	</div>
</div>


<div class="col-xs-5 col-sm-5 col-md-5">
<div class="panel panel-default">
	<div class="panel-heading text-center"><h1> <i class="fa fa-folder-o"></i> Danh mục sản phẩm</h1></div>
	<p>
    <!-- BEGIN: cate -->
    <table class="table">
		<h3> <i class="fa fa-laptop"></i> - <a href ="{CATE.url_product}">{CATE.category_name} </a>
		<p>
    </table>
    <!-- END: cate -->

</div>
</div>


<div class="col-xs-19 col-sm-19 col-md-19">
    <!-- BEGIN: loop -->
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
<div class="panel panel-default"  >
    
	<a href="{ROW.url_detail}" >
	<div class="thumbnail">
		<div class="panel">
				<img id="anh" src="{ROW.product_image}" style="border: 1px solid white; height:300px; width:300px">
		</div>
	</div>
		
  <div class="thumbnail">
    	<div class="panel-body" style="height: 35px" >
    		<h3 class="name"><span id="nameProduct">{ROW.product_name}</span></h3>
    	</div>
	</div>

	<div class="caption">
			<div class="panel-footer">
				<h3><span id="priceProduct">{ROW.product_price}</span> VNĐ </h3>
			</p></div>
			</a>
			<div class="text-center">
				
				<a href="" class="btn btn-danger" role="button" onclick="addCart({ROW.id}, 'add')"><i class="fa fa-shopping-cart"></i> Add to cart</a>
			</div>
	</div>
	</div>
</div>
    <!-- END: loop -->
    <!-- BEGIN: GENERATE_PAGE -->
    {GENERATE_PAGE} 
    <!-- END: GENERATE_PAGE -->

</div>

<div id="showCart" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="gridSystemModalLabel">Thông tin mua hàng</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<img alt=""  style="width:250px; height: 250px; " id="anh_showcart">
					</div>
					<div class="col-md-12">
						<p>Tên sản phẩm:<span id="nameCart"> </span></p>
						<p>Giá:<span id="priceCart"></span> VNĐ</p>
						<p>Số lượng:<span id="qtyCart">1</span></p>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>

<script type="text/javascript">
	function addCart(id, action) {
		qty = $("#qty").val();
		$.ajax({
			url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
			method: 'POST',
			dataType:"text",
			data: {id: id,qty: qty, action: action},
			success: function(data) {
				img = $("#anh").attr("src");
				$("#nameCart").text($("#nameProduct").text());
				$("#priceCart").text($("#priceProduct").text());
				$("#anh_showcart").attr({
					'src': img,
				});
				$('#showCart').modal();
			}
		});
	}
</script>
<!-- END: main --> 