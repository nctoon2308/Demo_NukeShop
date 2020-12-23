<!-- BEGIN: main -->

       <div class="container">
	<div class="row">
		<div>
			<div class="col-xs-8 col-sm-8 col-md-9 text-center">		
				<img src="{ROWDETAIL.product_image}" alt="" class="avt" style="width:400px; height: 400px; border: red 2px solid ">
			</div>
			<div class="col-xs-8 col-sm-8 col-md-8 ">
				<h1>{ROWDETAIL.product_name}</h1>
				<br>
				<div class="container">
				<h2>
					   {ROWDETAIL.product_price}
					
				</h2>
				<p>{ROWDETAIL.category_name}</p>
				</div>
				<p>
					<a href="#" class="btn btn-danger" onclick="nv_add_to_cart({ROWDETAIL.id}, 'add')"><i class="fa fa-shopping-cart"></i> Add to cart</a>
				</p>
                <br>
                <p>{ROWDETAIL.product_desc}</p>
			</div>
		</div>	
	</div>
    </div>
</div>

<script type="text/javascript">
function nv_add_to_cart(id, action) {
  $.ajax({
          url: nv_base_siteurl + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=cart',
          method: 'POST',
          dataType:"text",
          data: {id: id, action: action},
          success: function(data) {
              alert(data);
          }
        });
}

</script>
<!-- END: main -->

