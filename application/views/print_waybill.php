<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
{literal}
	span{
		display: block;
		text-align: center;
		height: 60px;
		line-height: 60px;
	}
	span b{
		margin-left: 10px;
	}
	ul{
		list-style: none;
	}
	li{
		float:left;
		padding: 5px;
		border: 1px solid #d3d3d3;
	}

{/literal}
</style>
</head>
<body onload="window.print()">
<div>
	<span><b>快递:</b><?php echo $shipping_name;?><b>发运单号:</b><?php echo $waybill_sn;?><b>数量:</b><?php echo $shipment_number;?></span>
	<ul>
		<?php
		 foreach ($detail as $key => $tracking_number ) {
		 	echo '<li>'.$tracking_number.'</li>';
		 } 
		?>
	</ul>
</div>
</body>
</html>