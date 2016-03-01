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
<body>
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:680px;width:400px;">
<div class="left-top" style="position:absolute;font-size:10pt;top:2%;left:0%;height:15%;width:100%;text-align:center;border-right:0px;border-bottom:0px;">
	<h3>快递单号:<?php echo $order['tracking_number']?></h3>
</div>

<div class="left-top" style="position:absolute;font-size:10pt;top:6%;left:0%;height:15%;width:100%;text-align:center;border-right:0px;border-bottom:0px;">
	<img src="<?php echo $tracking_number;?>" style="position:absolute;top:5%;left:0%;width:100%;height:70%;text-align:center;" /> <br>
</div>

<div style="position:absolute;top:25%;left:0%;height:8%;width:100%;border:0px;">
	<div class="inside" style="position:absolute;font-size:12pt;left:5%;height:40%;width:100%">
		仓库:<?php echo $order['facility_name'];?><br/>
		暗语:<?php echo $order['secrect_code'];?><br/>
		实体商品:<?php echo $order['rg_info'];?><br/>
		订单数:<?php echo $order['goods_number'];?><br/>
		总数:<?php echo $order['rg_total'];?>
	</div>
</div>

<div style="position:absolute;top:40%;left:5%;width:100%;text-align:center;border:0px;">
<table width="100%" cellpadding="10" border="1" cellspacing="0">
	<tr>
		<td>收件人</td>
		<td>手机</td>
		<td></td>
	</tr>
	<?php 
		foreach ($order['batch_items'] as $batch_item) {
			?>
	<tr>
		<td><?php echo $batch_item['receive_name']?></td>
		<td><?php echo $batch_item['mobile']?></td>
		<td><?php if($batch_item['is_owner'] == "Y") echo "团长"?></td>
	</tr>
			<?php
		}
	?>
</table>
</div>

</div>

</body>
</html>