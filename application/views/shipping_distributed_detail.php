<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
</head>
<body>
<div style="width: 1000px;margin:0 auto;">
	<form name="facility_form" style="width:100%;" method="get"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./shippingDistributedDetail">
    	<label for="facility_id" class="col-sm-2 control-label" style="width:120px"><h4>仓库</h4></label>
    	<select   class="col-sm-2" style="width:156px;height:26px" name="facility_id" id="facility_Sel" class="form-control" required="required">
        	<?php 
            	if(!empty($facility_list)) {
                	foreach ($facility_list as $facility) {
                    	if(!empty($facility_id) && $facility_id == $facility['facility_id']) { 
                    		echo "<option value=\"{$facility['facility_id']}\" " . (" title=\"{$facility['facility_name']}\""). " selected=\"selected\">{$facility['facility_name']}</option>" ;
                    	}
                    	else {
                        	echo "<option value=\"{$facility['facility_id']}\" " . (" title=\"{$facility['facility_name']}\""). " >{$facility['facility_name']}</option>" ;
                    	}
                	}
            	}
        	?>
		</select>
	</form>
<?php  
	if( isset($distributedList) && is_array($distributedList))  foreach ($distributedList as $key => $distributed) {
?>
	<div class="row  col-sm-6 col-sm-offset-0" style="margin-top: 10px;width: 100%;">
		<div style="width:100%">
			<?php 
				echo  $distributed['shipping_name']
			?>  
		</div>
		<table class="table table-striped table-bordered "  style="width:100%;margin: 0 auto;">
        	<thead>
				<tr>
					<th width="5%">PRODUCT_ID</th>
					<th width="40%">商品</th>
					<th width="8%">待绑定面单</th>
					<th width="8%">待产线提货</th>
					<th width="8%">待生成批次</th>
					<th width="8%">待打印</th>
					<th width="8%">待发货</th>
					<th width="8%">待快递确认</th>
					<th width="8%">今日完成</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					foreach ($distributed as $key=>$shippingDistributed) {
						if(is_array($shippingDistributed)) {
				?>
				<tr>
					<td class="product_cell">
						<?php echo $shippingDistributed['product_id']?>
					</td>
					<td class="product_cell">
						<?php echo $shippingDistributed['product_name']?>
					</td>
					<td class="product_cell">
						<?php echo !empty($shippingDistributed['to_be_tracking'])?$shippingDistributed['to_be_tracking']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($shippingDistributed['to_be_production_out'])?$shippingDistributed['to_be_production_out']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($shippingDistributed['to_be_batch'])?$shippingDistributed['to_be_batch']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($shippingDistributed['to_be_print'])?$shippingDistributed['to_be_print']:0?>
					</td>
	                <td class="product_cell">
	                    <?php echo !empty($shippingDistributed['to_be_ship'])?$shippingDistributed['to_be_ship']: 0?>
	                </td>
	                <td class="product_cell">
	                    <?php echo !empty($shippingDistributed['to_be_waybill'])?$shippingDistributed['to_be_waybill']: 0?>
	                </td>
	                <td class="product_cell">
	                    <?php echo !empty($shippingDistributed['finish_quantity'])?$shippingDistributed['finish_quantity']: 0 ?>
	                </td>
				</tr>
				<?php } }?>
                                    
                <tr>
               		<td class="product_cell">
 						
                    </td>
                	<td class="product_cell">
 						总数
                    </td>
                 	<td class="product_cell">
                    	<?php echo !empty($distributed['total_to_be_tracking'])?$distributed['total_to_be_tracking']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_to_be_production_out'])?$distributed['total_to_be_production_out']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_to_be_batch'])?$distributed['total_to_be_batch']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_to_be_print'])?$distributed['total_to_be_print']:0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_to_be_ship'])?$distributed['total_to_be_ship']: 0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_to_be_waybill'])?$distributed['total_to_be_waybill']: 0?>
					</td>
					<td class="product_cell">
						<?php echo !empty($distributed['total_finish_quantity'])?$distributed['total_finish_quantity']: 0 ?>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
<?php }?>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#facility_Sel').change(function () {
		$("form[name='facility_form']").submit();
	});
});
</script>
</body>
</html>
