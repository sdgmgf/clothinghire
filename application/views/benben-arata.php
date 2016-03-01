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
<!-- 丧心病狂的大鲵干完了 20130807 ljni@i9i8.com -->
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:780px;width:400px;">
<div class="left-top" style="position:absolute;font-size:20pt;top:2%;left:0%;height:5%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	<?php echo $order['station_no']; ?>
</div>
<div class="right-top" style="position:absolute;font-size:20pt;top:2%;left:50%;height:5%;width:50%;text-align:center;border-bottom:0px;">
	<?php echo $arata['sentBranch']; ?>
</div>

<div class="left" style="position:absolute;font-size:20pt;top:7%;left:0%;height:5%;width:75%;border-right:0px;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:10%;height:90%;width:40%;">
		<?php echo $arata['tracking_number']; ?>
	</div>
	<div class="inside" style="position:absolute;font-size:5pt;top:50%;left:50%;height:30%;width:40%;">
		日期：<?php echo date('Y-m-d'); ?>
	</div>
</div>
<div class="left" style="position:absolute;font-size:10pt;top:12%;left:0%;height:5%;width:75%;text-align:left;border-right:0px;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:8%;height:90%;width:89%;">
		寄件人：<?php echo $arata['ztoSender']; ?>   联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
	</div>
</div>
<div class="right" style="position:absolute;font-size:20pt;top:7%;left:75%;height:10%;width:25%;text-align:center;border-bottom:0px;">
    <?php  if($arata['ztoSender'] == '拼好货商城') { ?>
    <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="70px" height="70px">
    <?php } ?>
</div>
<div class="left right" style="position:absolute;font-size:20pt;top:17%;left:0%;height:10%;width:100%;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:10%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>       电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>　
		<br>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:20pt;top:27%;left:0%;height:8%;line-height:60px;width:100%;text-align:center;vertical-align:middle;letter-spacing:5px;filter:dropshadow(color=black,offx=1,offy=0) dropshadow(color=black,offx=2,offy=0) dropshadow(color=black,offx=3,offy=0)">
	<?php echo $order['city'];echo $order['district'];echo $order['station'];?>
</div>

<div style="position:absolute;top:35%;left:0%;height:12%;width:100%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;left:5%;top:5%;width:90%;height:70%;margin-top:2px;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:15px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>
<!-- divide -->
<div style="position:absolute;top:57%;left:0%;height:10%;width:100%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;top:5%;left:5%;width:90%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:15px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>

<div class="left" style="position:absolute;font-size:20pt;top:67%;left:0%;height:4%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	<?php echo $arata['service_type']; ?>
</div>
<div class="right" style="position:absolute;font-size:15pt;top:67%;left:50%;height:4%;width:50%;text-align:center;border-bottom:0px;">
	<?php echo $arata['tracking_number']; ?>
</div>

<div class="left right" style="position:absolute;font-size:10pt;top:71%;left:0%;height:5%;width:100%;text-align:left;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:6%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>       联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:20pt;top:76%;left:0%;height:12%;width:100%;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>  电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
		<br>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
	</div>
</div>

<div class="left-bottom" style="position:absolute;font-size:5pt;top:88%;left:0%;height:10%;width:50%;text-align:left;border-right:0px;">
	<div class="inside" style="position:absolute;font-size:3pt;top:5%;left:15%;height:90%;width:85%;">
		您对此单的签收，代表您已验货，确认商品信息无误，包装完好，没有划痕、破损等表面质量问题。
	</div>
</div>
<div class="right-bottom" style="position:absolute;font-size:10pt;top:88%;left:50%;height:10%;width:50%;text-align:left;">
	<div class="inside" style="position:absolute;font-size:15pt;top:10%;left:5%;height:90%;width:80%;">
		签收
	</div>
</div>
</div>

</body>
</html>