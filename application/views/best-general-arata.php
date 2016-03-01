<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="assets/css/arata.css">
</head>
<body>
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:880px;width:500px;">
<div class="left right" style="position:absolute;font-size:24pt;top:0%;left:0%;height:10%;width:15%;text-align:center;border-top:0px;">
	百世汇通
</div>

<div class="left-top" style="position:absolute;font-size:20pt;top:2%;left:15%;height:8%;width:23%;text-align:left;border-right:0px;border-bottom:0px;border-right:0px;">
	成就商业<br>
	精彩生活
</div>
<div class="right-top" style="position:absolute;font-size:20pt;top:0%;left:38%;height:10%;width:60%;text-align:center;border-bottom:0px;border-left:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;top:5%;left:3%;width:97%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:100%;letter-spacing:5px;">
		<?php echo $arata['tracking_number']; ?>
	</div>
</div>
<div class="left right" style="position:absolute;font-size:20pt;top:10%;left:0%;height:10%;width:100%;border-bottom:0px;">
	<div class="left-top" style="position:absolute;font-size:12pt;top:0%;left:3%;height:100%;width:5%;border-bottom:0px;">
		收件人
	</div>
	<div class="inside" style="position:absolute;font-size:12pt;top:00%;left:12%;height:100%;width:88%;">
		收件人：<?php echo $order['consignee']; ?>       
		<br>电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>　
		<br>
		地址：<?php if($order['province']) echo "{$order['province']}";if($order['city']) echo "{$order['city']}";if($order['district']) echo "{$order['district']}";echo $order['address'];?>
	</div>
</div>
<div class="left right" style="position:absolute;font-size:10pt;top:20%;left:0%;height:10%;width:100%;text-align:left;border-bottom:0px;">
	<div class="left-top" style="position:absolute;font-size:12pt;top:0%;left:3%;height:100%;width:5%;border-bottom:0px;">
		寄件人
	</div>
	<div class="inside" style="position:absolute;font-size:12pt;top:5%;left:12%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>
		<br> 联系方式：<?php echo $order['c_tel']; ?>
		<br> 地址：<?php echo $order['company_address']; ?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:20pt;top:30%;left:0%;height:10%;width:100%;border-bottom:0px;">
	<div class="left-top" style="position:absolute;font-size:12pt;top:0%;left:3%;height:100%;width:5%;border-bottom:0px;text-align:center;">
		目的地
	</div>
	<div class="inside" style="position:absolute;font-size:50pt;top:00%;left:12%;height:100%;width:88%;">
	 	<?php  echo $order['station_no']; ?>
	</div>
</div>

<div class="left-bottom" style="position:absolute;font-size:10pt;top:40%;left:0%;height:15%;width:60%;text-align:left;border-right:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;top:5%;left:30%;height:20%;width:70%;">
	收件人签收/日期:
	</div>
		<div class="inside" style="position:absolute;font-size:10pt;top:65%;left:30%;height:35%;width:70%;">
	运单编号：<?php echo $arata['tracking_number']; ?><br>
	打印日期：<?php echo date("Y-m-d")?>
	</div>
</div>
<div class="right-bottom" style="position:absolute;font-size:10pt;top:40%;left:60%;height:15%;width:40%;text-align:left;">
	
	<div class="inside" style="position:absolute;font-size:5pt;top:10%;left:2%;height:20%;width:95%;">
		已验视
	</div>
	<div class="inside" style="position:absolute;font-size:20pt;top:30%;left:5%;height:70%;width:80%;text-align:center;">
		<?php echo $arata['service_type']; ?>
	</div>
</div>
<div class="left right" style="position:absolute;font-size:5pt;top:55%;left:0%;height:5%;width:100%;text-align:left;border-bottom:0px;">
您对此单的签收，代表您已验收，确认商品信息无误，包装完好，没有华恒，破损等表面质量问题。
</div>


<!-- divide -->
<div style="position:absolute;top:65%;left:0%;height:10%;width:60%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;top:5%;left:3%;width:97%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:5px;">
		<?php echo $arata['tracking_number']; ?>
	</div>
</div>
<div style="position:absolute;top:65%;left:60%;height:10%;width:40%;text-align:center;border:0px;font-size: 20px">
	百世汇通
</div>
<div class="left right" style="position:absolute;font-size:20pt;top:75%;left:0%;height:10%;width:100%;border-bottom:0px;">
	<div class="left-top" style="position:absolute;font-size:12pt;top:0%;left:3%;height:100%;width:5%;border-bottom:0px;">
		收件人
	</div>
	<div class="inside" style="position:absolute;font-size:12pt;top:00%;left:12%;height:100%;width:88%;">
		收件人：<?php echo $order['consignee']; ?>       
		<br>电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>　
		<br>
		地址：<?php if($order['province']) echo "{$order['province']}";if($order['city']) echo "{$order['city']}";if($order['district']) echo "{$order['district']}";echo $order['address'];?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:10pt;top:85%;left:0%;height:10%;width:100%;text-align:left;border-bottom:0px;">
	<div class="left-top" style="position:absolute;font-size:12pt;top:0%;left:3%;height:100%;width:5%;border-bottom:0px;">
		寄件人
	</div>
	<div class="inside" style="position:absolute;font-size:12pt;top:5%;left:12%;height:90%;width:90%;">
		寄件人：<?php echo $arata['ztoSender']; ?>
		<br> 联系方式：<?php echo $order['c_tel']; ?>
		<br> 地址：<?php echo $order['company_address']; ?>
	</div>
</div>
<div class="left right" style="position:absolute;font-size:20pt;top:95%;left:0%;height:5%;width:100%;text-align:left;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:12pt;top:10%;left:0%;height:90%;width:8%;text-align:center;border-bottom:0px;">
		集包编码
	</div>
		<div class="inside" style="position:absolute;font-size:25pt;top:10%;left:8%;height:90%;width:62%;text-align:center;border-bottom:0px;">
		<?php  echo $order['station']; ?>
	</div>
	
		<div class="inside" style="position:absolute;font-size:20pt;top:10%;left:70%;height:90%;width:25%;text-align:center;border-bottom:0px;">
		<?php  if($arata['ztoSender'] == '拼好货商城') { ?>
        <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="60px" height="60px">
        <?php } ?>
    </div>
</div>

</div>

</body>
</html>