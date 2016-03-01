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
	div.none {
		border:0px solid black;font-family: 黑体;
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
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:650px;width:400px;">
<div class="left-top" style="position:absolute;font-size:10pt;top:2%;left:0%;height:5%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	<!--icon-->	
</div>

<div class="left" style="position:absolute;font-size:20pt;top:7%;left:0%;height:8%;width:75%;border-right:0px;border-bottom:0px;text-align:center;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;left:20%;top:5%;width:60%;height:80%;margin-top:2px;text-align:center;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:90%;left:30%;height:100%;width:30%;letter-spacing:2px;">
		<?php echo $arata['tracking_number']; ?>
	</div>
</div>
<div class="right" style="position:absolute;top:7%;left:75%;height:10%;width:25%;text-align:center;border-bottom:0px;">
	<div class="none" style="font-size:14pt;top:5px;">生鲜速配</div>
	<div class="none" style="font-size:10pt;top:10px;text-align:left;">目的地</div>
	<div class="none" style="font-size:48pt;top:90%;text-align:center;"><b><?php echo $order['station_no']?></b></div>
</div>
<div class="left right" style="position:absolute;font-size:20pt;top:17%;left:0%;height:20%;width:100%;border-bottom:0px;">
	<div class="none" style="position:absolute;font-size:10pt;top:10%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>       电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
		<br>
		地址：<b><?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";?></b>
		<?php echo $order['address'];?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:12pt;top:27%;left:0%;height:5%;line-height:40px;width:100%;text-align:center;vertical-align:middle;filter:dropshadow(color=black,offx=1,offy=0) dropshadow(color=black,offx=2,offy=0) dropshadow(color=black,offx=3,offy=0);border-bottom:0px;">
	付款方式：寄件月结  月结账号：<?php echo $order['sf_account']; ?>
</div>
<div class="left" style="position:absolute;font-size:10pt;top:33%;left:0%;height:5%;width:50%;text-align:left;border-right:0px;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:8%;height:90%;width:89%;">
		寄件人：<?php echo $arata['ztoSender']; ?> 
		<br>  联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
		<br>原寄地:<?php echo $order['send_addr_code']; ?>
	</div>
</div>

<div class="right-bottom" style="position:absolute;font-size:10pt;top:33%;left:50%;height:10%;width:50%;text-align:left;">
	<div class="inside" style="position:absolute;font-size:15pt;top:10%;left:5%;height:90%;width:80%;">
		签收
	</div>
</div>

<!-- divide -->
<div style="position:absolute;top:62%;left:0%;height:10%;width:100%;text-align:center;border:0px;">
	<div class="inside" style="position:absolute;font-size:15pt;top:5%;left:5%;height:40%;width:40%;">
		<?php  if($arata['ztoSender'] == '拼好货商城') { ?>
        <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="70px" height="70px"> 
        <?php } ?>
	</div>
	<img src="<?php echo $codeImg2;?>" style="position:absolute;top:5%;left:50%;width:50%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:50%;height:15%;width:40%;letter-spacing:2px;text-align:center;">
		<?php echo $arata['tracking_number']; ?>
	</div>
</div>

<div class="left" style="position:absolute;font-size:20pt;top:77%;left:0%;height:6%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	<?php echo $arata['service_type']; ?>
</div>
<div class="right" style="position:absolute;font-size:15pt;top:77%;left:50%;height:6%;width:50%;text-align:center;border-bottom:0px;">
	<?php echo $arata['tracking_number']; ?>
</div>

<div class="left right" style="position:absolute;font-size:10pt;top:83%;left:0%;height:5%;width:50%;text-align:left;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:6%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>       联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
	</div>
</div>

<div class="right-bottom" style="position:absolute;font-size:20pt;top:83%;left:50%;height:12%;width:50%;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>  电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
		<br>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
	</div>
</div>
</div>

</body>
</html>
