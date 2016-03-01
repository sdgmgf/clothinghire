<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
	<table class="table table-striped table-bordered ">
	<tr>
		<td colspan = 4 style='text-align:center;font-size:xx-large;vertical-align:middle;color:green;'>
			<label > PRODUCT_ID：<?php echo $product['product_id'];?></label> <br>
			<label > 商品：<?php echo $product['product_name'];?></label>
		</td>
	</tr>
		<tr>
			<td width="20%">市</td>
			<td width="30%">区/县</td>
			<td width="30%">快递方式</td>
			<td width="20%">操作</td>
		</tr>
		<?php 
			if(isset($region_shipping) && $region_shipping != null){
				$lastCity = "";
				foreach ($region_shipping as $record){ 
					echo "<tr>";
					if(empty($lastCity) || $lastCity != $record['city']){
						$lastCity = $record['city'];
						echo "<td rowspan=".$city_num[$record['city']]." style='text-align:center;font-size:xx-large;vertical-align:middle;color:green;'>".$record['city']."</td>";
					}
					echo "<td style='font-size:large;color:blue;'>".$record['district']."</td>";
					echo "<td style='font-size:large;color:purple;'>".$record['shipping_name']."</td>";
					echo "<td>";
					echo "<input type='button' onclick='javascript:modifyRegionShipping(".$record['sku_region_shipping_id'].",".$record['shipping_id'].")' class='btn btn-primary btn-sm' style='margin-left: 20px;' value='修改'/>";
					echo "<input type='button' onclick='javascript:deleteRegionShipping(".$record['sku_region_shipping_id'].")' class='btn btn-primary btn-sm' style='margin-left: 20px;' value='删除'/>";
					echo "</td>";
					echo "</tr>";
				}
			}
		?>
	</table>
</div>

	<!-- Modal -->
	<div class="modal fade" id="changeRegionShipping-modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" id="btnClose"
						data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<h4 class="modal-title">更改区域快递</h4>
				</div>
				<div class="modal-body">
					<div class="container">
						<input type="hidden" id="region_shipping_id" name="region_shipping_id" style="width:40%;" />
						<div>快递方式：</div>
						<select style="width: 40%;float: left;" name="facility_shipping_list" id="facility_shipping_list">
						<?php 
							foreach ($facility_shipping_list as $shipping) {
								echo "<option value=\"{$shipping['shipping_id']}\">{$shipping['shipping_name']}</option>"; 
							}
						?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" id="change_shipping" data-dismiss="modal">确定</button>
				</div>
			</div>
		</div>
	</div>
	<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
$(document).ready(function(){

});

function modifyRegionShipping(id,shipping_id){
	$("#region_shipping_id").val(id);
	$("#facility_shipping_list option").each(function(){
		if($(this).val() == shipping_id){
			$(this).attr("selected","selected");
		}
	});
	$("#changeRegionShipping-modal").modal("show");
}

function deleteRegionShipping(id){
	$.ajax({
        url: WEB_ROOT+"skuShipping/deleteRegionShipping",
        type: 'post',
        data: {"sku_region_shipping_id":id},
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
  }).done(function(data){
	  if(data.success == "true"){
		  	alert("删除成功！");
	  		window.location.reload();
	  }
	  else 
		  alert("删除失败："+data.error_info);
  });
}

$('#change_shipping').click(function(){
	var sku_region_shipping_id = $("#region_shipping_id").val();
	var shipping_id = $("#facility_shipping_list option:selected").val();
	
	$.ajax({
        url: WEB_ROOT+"skuShipping/modifyRegionShipping",
        type: 'post',
        data: {"sku_region_shipping_id":sku_region_shipping_id, "shipping_id":shipping_id},
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
  }).done(function(data){
	  if(data.success == "true"){
		  	alert("修改成功！");
	  		window.location.reload();
	  }
	  else 
		  alert("修改失败："+data.error_info);
  });
});


</script>
</body>
</html>