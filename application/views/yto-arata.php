<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="js/js_wms/sinri_print_iframe.js"></script> 
<style type="text/css">
{literal}
	div {
		font-family: 黑体;
	}
	div.top {
		border-top:1px dashed black;
	}
	div.bottom {
		border-bottom:1px dashed black;
	}
	div.right {
		border-right:1px dashed black;
	}
	div.left {
		border-left:1px dashed black;
	}
{/literal}
</style>
</head>
<body>
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:760px;width:400px;">
<div class="right"style="position:absolute;font-size:20pt;top:10%;left:2%;height:70px;width:25%;text-align:center;border-bottom:0px;">
    <?php  if($arata['ztoSender'] == '拼好货商城') { ?>
    <img src="assets/img/Shop2DBarcodes/1953.png"  width="70px" height="70px">
    <?php } ?>
</div>
<div class="top bottom" style="position:absolute;font-size:22pt;top:10%;left:0%;height:70px;width:100%;text-align:right;vertical-align:center;letter-spacing:5px;filter:dropshadow(color=black,offx=1,offy=0) dropshadow(color=black,offx=2,offy=0) dropshadow(color=black,offx=3,offy=0)">
	<div style="margin-top:2px;margin-left:5%;"><?php echo $order['station_no'];?></div>
</div>

<div class="bottom" style="position:absolute;top:20%;left:0%;height:12%;width:100%;text-align:center;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;left:5%;top:5%;width:90%;height:70%;margin-top:2px;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:10px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>

<div class="bottom" style="position:absolute;top:33%;left:0%;height:10%;width:100%;">
	<div class="inside" style="position:absolute;font-size:12pt;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>       电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>　
		<br>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
	</div>
</div>

<div class="left-bottom" style="position:absolute;font-size:5pt;top:43%;left:0%;height:10%;width:50%;text-align:left;border-right:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:5%;height:90%;width:85%;">
		您对此单的签收，代表您已验货，确认商品信息无误，包装完好，没有划痕、破损等表面质量问题。
	</div>
</div>
<div class="right-bottom" style="position:absolute;font-size:10pt;top:43%;left:50%;height:10%;width:50%;text-align:left;">
	<div class="inside" style="position:absolute;font-size:15pt;top:10%;left:5%;height:50%;width:80%;">
		周末正常派送 
	</div>
	<div class="inside" style="position:absolute;font-size:15pt;top:60%;left:5%;height:40%;width:80%;">
		  签收
	</div>
</div>
</div>

<!-- divide -->
<div style="position:absolute;top:63%;left:0%;height:10%;width:100%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg2;?>" style="position:absolute;top:5%;left:50%;width:50%;height:50%;" />
	<div class="inside" style="position:absolute;font-size:12pt;top:55%;left:55%;height:15%;width:40%;letter-spacing:2px;text-align:center;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>
<div class="bottom" style="position:absolute;font-size:10pt;top:73%;left:0%;height:7%;width:100%;text-align:left;">
	<div class="inside" style="position:absolute;font-size:12pt;top:5%;left:6%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>       联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
	</div>
</div>

<div class="bottom" style="position:absolute;top:80%;left:0%;height:8%;width:100%;">
	<div class="inside" style="position:absolute;font-size:12pt;top:5%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>  电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
	</div>
</div>

<div style="position:absolute;font-size:20pt;top:90%;left:0%;height:4%;width:50%;text-align:center;border-bottom:0px;">
	<div style="margin-top:10px;"><?php echo $arata['service_type']; ?></div>
</div>
<div class="left" style="position:absolute;font-size:20pt;top:90%;left:50%;height:50px;width:25%;text-align:center;border-bottom:0px;">
	<?php  if($arata['ztoSender'] == '拼好货商城') { ?>
    <img src="assets/img/Shop2DBarcodes/1953.png"  width="50px" height="50px">
    <?php } ?>
</div>
</body>
</html>