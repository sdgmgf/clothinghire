<!doctype html>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="assets/css/arata.css">
</head>
<body>
<div class="inside" style="position:absolute;font-size:10pt;top:0px;left:0px;height:880px;width:500px;">

<div class="inside" style="position:absolute;font-size:10pt;top:0%;left:0%;height:2%;width:60%;text-align:left">
	始发网点：<?php echo $order['sender_branch']?>
</div>
<div class="inside" style="position:absolute;font-size:10pt;top:0%;left:60%;height:2%;width:30%;text-align:center">
	<?php echo date('Y-m-d H:i:s')?>
</div>
<div class="inside" style="position:absolute;font-size:15pt;top:3%;left:0%;height:6%;width:20%;text-align:center;">
	送达地址
</div>
<div class="inside" style="position:absolute;font-size:10pt;top:3%;left:23%;height:13%;width:63%;text-align:left;font-size: 20px;font-weight: bold;">
		收件人：<?php echo $order['consignee']; ?>  <br>
		收件人电话： <?php echo $order['mobile']; ?> <?php echo $order['tel']; ?><br>
		<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
</div>

<div class="inside" style="position:absolute;font-size:15pt;top:18%;left:00%;height:3%;width:45%;text-align:left;border-left:0px;">
	<?php echo $order['package'];?>
</div>
<div class="inside" style="position:absolute;font-size:15pt;top:20%;left:50%;height:3%;width:35%;text-align:left;border-left:0px;">
	<img src="<?php echo $packageImg;?>" style="position:absolute;top:5%;left:0%;width:90%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:10%;height:15%;width:90%;letter-spacing:6px;">
		*<?php echo $order['package_no']; ?>*
	</div>
</div>
<div class="left" style="position:absolute;font-size:20pt;top:25%;left:0%;height:20%;width:25%;text-align:center;border-bottom:0px;">
	<?php  if($arata['ztoSender'] == '拼好货商城') { ?>
    <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="70px" height="70px">
    <?php } ?>
</div>
<div class="left" style="position:absolute;font-size:10pt;top:25%;left:25%;height:20%;width:55%;text-align:left;border-right:0px;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:32pt;top:0%;left:3%;height:100%;width:95%;font-weight: bold;">
		<?php echo $order['station'];?><br>
		<?php echo $order['station_no']?><br>
		<?php echo $order['lattice_mouth_no']?>
	</div>
</div>

<div class="left right" style="position:absolute;font-size:10px;top:2%;left:90%;height:60%;line-height:60px;width:20%;text-align: left;border-top:0px;border-bottom:0px;letter-spacing:3px;">
	<img src="<?php echo $codeImg3;?>" style="position:absolute;top:0%;width:90%;height:90%;margin-top:2px; " />
	<div style="border: 0px;letter-spacing: 12px;position: absolute;transform: rotate(-90deg);left: -130px;top: 150px;"><?php echo $arata['tracking_number']; ?></div>
</div>

<div style="position:absolute;top:45%;left:0%;height:3%;width:80%;text-align:left;border-left:0px;border-right:0px;">
	<div class="inside" style="position:absolute;font-size:16pt;left:5%;height:100%;width:90%;border-bottom:3px;">
		运单编号：<?php echo $arata['tracking_number']; ?>
	</div>
</div>
<div class="left right" style="position:absolute;top:49%;left:0%;height:5%;width:80%;text-align:left;border-top:0px;">
	<div class="inside" style="position:absolute;font-size:10pt;left:5%;height:100%;width:90%;">
		收件人/代签人：  						
		<br>
		签收日期：&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;年&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;月&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;日
	</div>
</div>
<div class="inside" style="position:absolute;font-size:10pt;top:44%;left:0%;height:22%;width:100%;text-align:left;border-right:0px;">
	<div style="position:absolute;font-size:10pt;top:80%;left:80%;height:15%;width:15%;">
		已 验 视
	</div>
</div>

<div style="position:absolute;top:70%;left:5%;height:5%;width:50%;text-align:center;border:0px;">
	<img src="<?php echo $codeImg;?>" style="position:absolute;top:5%;left:0%;width:100%;height:70%;" />
	<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:2px;">
		*<?php echo $arata['tracking_number']; ?>*
	</div>
</div>
<div style="position:absolute;top:70%;left:70%;height:6%;width:30%;text-align:left;border:0px;font-size: 25px;vertical-align: middle;font-weight: bold;">
		<div style="letter-spacing: 9px;border: 0px;">YUNDA</div>
		韵达速递
</div>

<div class="left" style="position:absolute;font-size:10pt;top:77%;left:0%;height:18%;width:50%;text-align:center;border-right:0px;border-bottom:0px;">
	寄件人：<?php echo $arata['ztoSender']; ?><br>寄件人电话：<?php echo $order['c_tel']; ?><br>
	寄件人地址：<?php echo $order['company_address']; ?>
	<br>
	<br>
	收件人：<?php echo $order['consignee']; ?><br>
	收件人电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?><br>
	收件人地址：<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?>
</div>
<div class="right" style="position:absolute;font-size:20pt;top:77%;left:50%;height:18%;width:50%;text-align:center;border-bottom:0px;">
	<?php echo $arata['service_type']; ?>
</div>

<div class="left right" style="position:absolute;font-size:10pt;top:95%;left:0%;height:5%;width:100%;text-align:left;border-bottom:0px;">
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:6%;height:90%;width:90%;">
		官网地址:http://www.yundaex.com 客户热线 :95546  收件人联
	</div>
	<div class="inside" style="position:absolute;font-size:5pt;top:5%;left:96%;height:90%;width:5%;">
		<?php if(isset($order['page_index'])) echo $order['page_index'];?>
	</div>
</div>
</div>

</body>
</html>