
<!-- BEGIN: main -->
<a href="http://localhost/shoplaptop/category/cart/">Gio hang</a>
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
			</div>
	</div>
	</div>
</div>
    <!-- END: loop -->
    <!-- BEGIN: GENERATE_PAGE -->
    {GENERATE_PAGE} 
    <!-- END: GENERATE_PAGE -->

</div>

<!-- END: main --> 