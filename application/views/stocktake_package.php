<html>
<head>
    <meta charset="utf-8">
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
	<style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
       }


      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
    </style> 
</head>
<body>
<div style="width: 1000px;margin: 0 auto;"><!-- Nav tabs -->
    <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>stocktakePackageList/index">
	<div class="tab-content">
		<div class="row">
			<label for="start_time" class="col-sm-2 control-label"><h4>仓库</h4></label>
			<div class="col-sm-3">
				<select  style="width: 100%;" name="facility_id" id="facility_id" class="form-control">
                	<?php
						foreach ($facility_list as $facility) {
							if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
								echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
							} else {
								echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
							}
						}
					?>
            	 </select>
			</div>
			<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
			<div class="col-sm-3">
				<input type="text" style="width: 100%;" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
			</div>
		</div>
		<div style="width: 100%;float:left;">
        	<div style="width:66%;float:left;text-align: center;">
            	<button type="submit" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                	<?php if (!empty ($product_list)) {?>
                    	<button type="button" style="margin-left: 20px;display:none;" class="btn btn-primary btn-sm"  id="total_submit"  >全部发起盘点 </button> 
                	<?php }?>
           	</div>
      	</div>
  	</div>
	</form>
	<table class="table table-striped table-bordered ">
		<thead>
			<tr>
				<th rowspan="2" style="text-align: center;">PRODUCT_ID</th>
	        	<th rowspan="2" style="text-align: center;">虚拟商品</th>
	        	<th rowspan="2" style="text-align: center;">暗语</th>
	        	<th colspan="4" style="text-align: center;">实体商品</th>
	        	<th rowspan="2" style="text-align: center;">操作</th>
			</tr>
            <tr>
            	<th style="text-align: center;">数量</th>
				<th style="text-align: center;">单位</th>
				<th style="text-align: center;">PRODUCT_ID</th>
				<th style="text-align: center;">商品</th>
            </tr>
  		</thead>
  		<tbody>
  			<?php 
  				if (isset($product_list) && is_array($product_list) && ! empty($product_list))
  					foreach ($product_list as $product) {
  					$rowspans_num = 1;
  					if(isset($product['raw_material_product_list']) && is_array($product['raw_material_product_list']) && !empty($product['raw_material_product_list'])) {
  						$rowspans_num = count($product['raw_material_product_list']);
  					}
  			?>
  				<tr>
                    <td rowspan="<?php echo $rowspans_num?>"><?php echo $product['product_id']?></td>
  					<td rowspan="<?php echo $rowspans_num?>"><?php echo $product['product_name']?></td>
  					<td rowspan="<?php echo $rowspans_num?>"><?php echo $product['secrect_code']?></td>
  						<?php 
                    		if (isset($product['raw_material_product_list']) && is_array($product['raw_material_product_list']) && ! empty($product['raw_material_product_list']))  {
	                    ?>
	                    	<td><?php echo $product['raw_material_product_list'][0]['quantity']?></td>
	                    	<td><?php echo $product['raw_material_product_list'][0]['unit_code']?></td>
	                    	<td><?php echo $product['raw_material_product_list'][0]['product_component_id']?></td>
	                    	<td><?php echo $product['raw_material_product_list'][0]['component_name']?></td>
                    	<?php } ?>
  					<td rowspan="<?php echo $rowspans_num?>">
	                	<input type="hidden" name="product_id[]" value="<?php echo $product['product_id'];?>"/>
                        <button type="button" class="btn btn-primary btn-sm"  onClick="createStocktake(this, <?php echo $product['product_id'];?>);">发起盘点</button>
	            	</td>
  				</tr>
  				
  					<?php 
                    		if ($rowspans_num > 1) {
                    			foreach ($product['raw_material_product_list'] as $key=>$raw_material_product) {
                    				if($key == 0)
                    					continue;
	                    	?>
	                    	<tr>
	                    	<td><?php echo $raw_material_product['quantity']?></td>
	                    	<td><?php echo $raw_material_product['unit_code']?></td>
	                    	<td><?php echo $raw_material_product['product_component_id']?></td>
	                    	<td><?php echo $raw_material_product['component_name']?></td>
	                    	</tr>
                    	<?php } }?>
  				
  			<?php 
  					}
  			?>
  		</tbody>
	</table>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	var WEB_ROOT = "<?php echo $WEB_ROOT; ?>",
        def = (function(){
        var pro = $.ajax({
            url: WEB_ROOT+'StocktakePackageList/getProductList',
            type: 'GET',
            dataType: 'json'
        });
        return pro;
    })(jQuery);
    def.then(function(data){
        if(data['success'] === 'success' ){
            $('#product_name').autocomplete(data.product_list, {
                minChars: 0,
                width: 310,
                max: 100,
                matchContains: true,
                autoFill: false,
                formatItem: function(row, i, max) {
                    return row.product_id + "[" + row.product_name + "]";
                },
                formatMatch: function(row, i, max) {
                    return row.product_id + "[" + row.product_name + "]";
                },
                formatResult: function(row) {
                    return row.product_id + "[" + row.product_name + "]";
                }
            }).result(function(event, row, formatted){
                $(this).val(row.product_name);
            });
        }
    });
    
	$("#total_submit").click(function(){
		$("button").attr("disabled", true); 
		var product_id = "";
		$("input[name='product_id[]']").each(function(index, element) {
			if(index == 0){
				product_id  += $(this).val();
			}else {
				product_id  += ","+$(this).val();
			}
	    });
		var facility_id = "<?php echo isset($facility_id) ? $facility_id : "0";?>";
		
		var myurl = $("#WEB_ROOT").val()+"stocktakePackageList/createStocktakePackage";
		var mydata = {
		    "product_id":product_id,
		    "facility_id":facility_id,
		  }; 
		$.ajax({
		      url: myurl,
		      type: 'POST',
		      data:mydata, 
		      dataType: "json", 
		      xhrFields: {
		           withCredentials: true
		      }
		}).done(function(data){
			console.log(data);
			if(data.data.result == "ok"){
	            window.location.reload();
	        }else{
	          alert("发起盘点失败"+data.error_info);
	        }
		});
	});
});
function createStocktake(button,product_id){
	$(button).attr("disabled", true); 
	var facility_id = "<?php echo isset($facility_id) ? $facility_id : "0";?>";
	
	var myurl = $("#WEB_ROOT").val()+"stocktakePackageList/createStocktakePackage";
	var mydata = {
	    "product_id":product_id,
	    "facility_id":facility_id,
	  }; 
	  
	  console.log(mydata);
	  $.ajax({
	      url: myurl,
	      type: 'POST',
	      data:mydata, 
	      dataType: "json", 
	      xhrFields: {
	           withCredentials: true
	      }
	}).done(function(data){
		console.log(data);
		if(data.data.result == "ok"){
            window.location.reload();
        }else{
          alert("发起盘点失败"+data.error_info);
        }
	});
}
</script>
</body>
</html>
