<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/js_wms/sinri_print_iframe.js"></script> 
<style type="text/css">
{literal}
	div {
		border:1px solid black;font-family: 黑体;
	}
	div.right-top {		
		border-right:0px solid black;
		border-top:0px solid black;
	}
	div.left-top {		
		border-left:0px solid black;
		border-top:0px solid black;
	}
	div.left {		
		border-left:0px solid black;
	}	
	div.right {		
		border-right:0px solid black;
	}	
	div.left-bottom {		
		border-left:0px solid black;
		border-bottom:0px solid black;
	}
	div.right-bottom {		
		border-right:0px solid black;
		border-bottom:0px solid black;
	}
	div.inside {
		border:0px solid black;
	}
{/literal}
</style>
</head>
<body onload="window.print()">
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:780px;width:400px;">
<div class="left-top" style="position:absolute;font-size:10pt;top:2%;left:0%;height:15%;width:100%;text-align:center;border-right:0px;border-bottom:0px;">
	<h3>打印批拣单:<?php echo $order['batch_pick_sn']?></h3>
</div>

<div class="left-top" style="position:absolute;font-size:10pt;top:7%;left:0%;height:15%;width:100%;text-align:center;border-right:0px;border-bottom:0px;">
	<img src="<?php echo $sn_code_img;?>" style="position:absolute;top:5%;left:0%;width:100%;height:70%;text-align:center;" /> <br>
</div>

<div style="position:absolute;top:25%;left:0%;height:10%;width:100%;border:0px;">
	<div class="inside" style="position:absolute;font-size:12pt;left:5%;height:40%;width:40%">
		PRODUCT_ID:<?php echo $order['product_id'];?><br/>
		商品:<?php echo $order['product_name'];?><br/>
		快递:<?php echo $order['shipping_name'];?><br/>
		数量:<?php echo $order['shipment_number'];?>
	</div>
</div>

<div style="position:absolute;top:40%;left:5%;width:100%;text-align:center;border:0px;">
<table width="100%" cellpadding="10" border="1" cellspacing="0">
	<tr>
		<td colspan="2">收件人</td>
		<td>手机号</td>
		<td>运单号</td>
		<td>运单条码</td>
	</tr>
	<tr>
		<td>开头</td>
		<td><?php echo $order['min_order']['receive_name']?></td>
		<td><?php echo $order['min_order']['mobile']?></td>
		<td><?php echo $order['min_order']['tracking_number']?></td>
		<td><img src="<?php echo $min_code_img;?>" width="120" height="50" /></td>
	</tr>
	<tr>
		<td>结尾</td>
		<td><?php echo $order['max_order']['receive_name']?></td>
		<td><?php echo $order['max_order']['mobile']?></td>
		<td><?php echo $order['max_order']['tracking_number']?></td>
		<td><img src="<?php echo $min_code_img;?>" width="120" height="50"/></td>
	</tr>
</table>
</div>

</div>

</body>
</html>