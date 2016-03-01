<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="assets/css/arata.css">
</head>
<body>
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:880px;width:500px;">
<div class="left-top" style="position:absolute;font-size:20pt;top:2%;left:0%;height:5%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	圆通快递
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
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:3%;height:90%;width:95%;">
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
	<div class="inside" style="position:absolute;font-size:15pt;top:10%;left:6%;height:90%;width:90%;">
		<b>收件人：<?php echo $order['consignee']; ?>       电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?></b>　
		<br>
		<b>地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?></b>
	</div>
</div>
<div class="left right" style="position:absolute;font-size:52pt;top:32%;left:0%;height:8%;line-height:60px;width:100%;text-align:center;vertical-align:middle;letter-spacing:5px;filter:dropshadow(color=black,offx=1,offy=0) dropshadow(color=black,offx=2,offy=0) dropshadow(color=black,offx=3,offy=0)">
	<?php  echo $order['station_no']; ?>
</div>		
<div style="position:absolute;top:40%;left:0%;height:9%;width:100%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;left:0;top:5%;width:100%;margin-top:2px;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:15px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>
<div class="left-bottom" style="position:absolute;font-size:10pt;top:50%;left:0%;height:10%;width:70%;text-align:left;border-right:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:5%;height:90%;width:95%;">
	圆通速递讲快件送达收件人地址，经收件人或收件人（寄件人）允许的代收人签字，视为送达。
	</div>
</div>
<div class="right-bottom" style="position:absolute;font-size:10pt;top:50%;left:70%;height:10%;width:30%;text-align:left;">
	<div class="inside" style="position:absolute;font-size:15pt;top:10%;left:5%;height:90%;width:80%;">
		签收
	</div>
</div>

<!-- divide -->
<div style="position:absolute;top:65%;left:3%;height:5%;width:100%;text-align:left;border:0px;font-size: 20px">
		圆通快递
</div>
<div style="position:absolute;top:70%;left:0%;height:10%;width:100%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;top:5%;left:0;width:100%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:15px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>

<div class="left" style="position:absolute;font-size:20pt;top:80%;left:0%;height:4%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	<?php echo $arata['service_type']; ?>
</div>
<div class="right" style="position:absolute;font-size:15pt;top:80%;left:50%;height:4%;width:50%;text-align:center;border-bottom:0px;">
	<?php echo $arata['tracking_number']; ?>
</div>

<div class="left right" style="position:absolute;font-size:10pt;top:84%;left:0%;height:5%;width:100%;text-align:left;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:6%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>       联系方式：<?php echo $order['c_tel']; ?>
		<br>
		地址：<?php echo $order['company_address']; ?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:20pt;top:89%;left:0%;height:12%;width:100%;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:6%;height:90%;width:90%;">
		收件人：<?php echo $order['consignee']; ?>  电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
		<br>
		地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
		<br>
		此运单仅供圆通速递签约客户使用，相关责任义务以双方合作合同为准
	</div>
	
	<div class="inside" style="position:absolute;font-size:10pt;top:75%;left:90%;height:10%;width:5%;">
		<?php if(isset($order['page_index'])) echo $order['page_index'];?>
	</div>
</div>
</div>

</body>
</html>