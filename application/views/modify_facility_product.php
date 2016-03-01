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
	<div style="width: 60%;margin: 0 auto;">
		<table class="table table-striped table-bordered ">
			<tr>
				<td width="20%">店铺:</td>
				<td>
					<input style="width: 80%;float: left;" type="text" readonly="readonly" id="merchantSel" name="merchant_list" value="<?php echo $merchant_name;?>"/>
				</td>
			</tr>
			<tr>
				<td>商品:</td>
				<td>
					<input type="text" style="width: 80%;" name="product_ids" id="productSel" />
			    	<input type="hidden" id="product_id" name="product_id" <?php if(isset($product_id)) echo "value='{$product_id}'"; ?>  /><br/>
				</td>
			</tr>
			<tr>
				<td colspan="2"><button type="button" style="float: right;" class="btn btn-primary" id="submit" >添加</button></td>
			</tr>
		</table>
    	
	</div>
	<table class="table table-striped table-bordered ">
		<tr>
			<td	colspan="3">
				<div style="width: 100px;margin:0;">
					<p style="font-weight: bold;padding-top: 4px;font-size: 20px;">商品</p>
				</div>
			</td>
		</tr>
		<tr>
			<td width="35%">所属店铺</td>
			<td width="35%">PRODUCT_ID</td>
			<td width="35%">商品名称</td>
			<td width="35%">操作</td>
		</tr>
		<?php 
			if(isset($facility_product_list) && $facility_product_list != null){
				foreach ($facility_product_list as $row){ 
					echo "<tr>";
					echo "<td>".$row['merchant_name']."</td>";
					echo "<td>".$row['product_id']."</td>";
					echo "<td>".$row['product_name']."</td>";
					echo "<td>";
					echo "<input type='button' onclick='javascript:deleteFacilityProduct(".$row['product_id'].")' class='btn btn-primary btn-sm' style='margin-left: 20px;' value='删除'/>";
					echo "</td>";
					echo "</tr>";
				}
			}
		?>
	</table>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
$(document).ready(function(){
	function getproductList(){
		$("#productSel").unautocomplete();
		$.ajax({
	        url: WEB_ROOT+"addFacility/getProductList",
	        type: 'get',
	        dataType: "json", 
	        data: {"merchant_id":<?php echo $merchant_id;?>},
	        xhrFields: {
	             withCredentials: true
	        }
		  }).done(function(data){
			  $("#productSel").unautocomplete();
			  $("#productSel").autocomplete(data.product_list, {
				    minChars: 0,
				    width: 310,
				    max: 100,
				    matchContains: true,
				    autoFill: false,
				    formatItem: function(row, i, max) {
				        return i + "/" + max + ": \"" + row.product_name;
				    },
				    formatMatch: function(row, i, max) {
				        return row.product_name ;
				    },
				    formatResult: function(row) {
				    	return(row.product_name);
				    }
				}).result(function(event, row, formatted) {
			 		$('#product_id').val(row.product_id);
				});
		  });
	}
	
	$("#submit").click(function(){
		var product_id = $("#product_id").val();
		var facility_id = "<?php echo $facility_id;?>";
		$.ajax({
			url: WEB_ROOT+"modifyFacility/addFacilityProduct",
 			type: 'POST',
 			data : {"facility_id":facility_id,"product_id":product_id}, 
 			dataType: "json", 
 			xhrFields: {
 			    withCredentials: true
 			}
		}).done(function(data){
			if(data['result'] == 'ok'){
				window.location.reload();
			} else {
				alert(data['error_info']);
			}
		});
	});
	getproductList();
});

function deleteFacilityProduct(product_id){
	var facility_id = "<?php echo $facility_id;?>";
    console.log(product_id);
	$.ajax({
        url: WEB_ROOT+"modifyFacility/deleteFacilityProduct",
        type: 'POST',
        data : {"facility_id":facility_id,"product_id":product_id}, 
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
    }).done(function(data){
          if(data.result == "ok"){
            window.location.reload();
          }else{
            alert(data.error_info);
          }
    });
}
</script>
</body>
</html>