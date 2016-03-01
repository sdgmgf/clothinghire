<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
{literal}
	body {
	    -ms-transform: rotate(0deg); /* IE 9 */
	    -webkit-transform: rotate(0deg); /* Chrome, Safari, Opera */
	    transform: rotate(0deg);

	    font-weight: bold;
	    font-family: 黑体,sans-serif;
	}
	div {
		border:0px solid black;font-family: 黑体;
	}
	div.inside {
		border:0px solid black;
	}
	p {
		margin: 0px;
		padding: 0px;
	}
{/literal}
</style>
</head>
<body >
<div class="inside" style="position:absolute;font-size:12pt;top:0px;left:0px;height:650px;width:400px;border-right:0px;">
	<div style="position:absolute;font-size:12pt;left:0%;height:10%;width:99%;text-align:center;border-right:0px;border-left:0px;border-top:0px;">
		<img  src="<?php echo $codeImg;?>" style="position:absolute;left:1%;top:5%;width:95%;height:75%;margin-top:2px;" />
			<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:5px;text-align:center;">
				<?php echo $arata['tracking_number']; ?>
			</div>
	</div>
	<div style="position:absolute;font-size:12pt;top:10%;left:0%;height:50%;width:99%;text-align:left;">
		<div class='inside' style="position:absolute;font-size:12pt;top:0%;left:0%;height:30%;width:100%;border-right:0px;">
			<p>
				收件：<span style="font-size: 20px"><?php echo $order['consignee']; ?></span>
			<br>
				电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
			<br>
				<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";?>
		<?php echo $order['address'];?>
			</p>
		</div>
		<div class='inside' style="position:absolute;font-size:12pt;top:30%;left:0%;height:20%;width:50%;">
			<p >
			寄件：<?php echo $arata['ztoSender']; ?><br>
			电话：<?php echo $order['c_tel']; ?>
			</p>
			<br>
			<div class="inside" style="position:absolute;font-size:22pt;top:40pt;left:0%;height:15%;width:100%;letter-spacing:5px;text-align:left;">
				<b><?php echo $arata['service_type']; ?></b>
			</div>
			
			<div class="inside" style="position:absolute;font-size:10pt;top:95pt;left:5%;height:5%;width:90%;letter-spacing:5px;text-align:center;">
				签约客户已抽检
			</div>
		</div>
		<div class='inside' style="position:absolute;font-size:10pt;top:25%;left:30%;height:20%;width:70%;border-right:0px;">
			<p style="text-align:right; font-size:55px;margin:0px; padding:0px;">
				<b><?php if($order['province']) echo "{$order['province']}";?></b><br>
				<?php if($order['city']) echo "{$order['city']}";?><br>
				<?php if($order['district']) echo "{$order['district']}";?>
			</p>
		</div>
		<div class='inside' style="position:absolute;font-size:10pt;top:55%;left:0%;height:20%;width:100%;margin:0px;border-right:0px;">
			<p style="text-align:right; font-size:12px;margin:0px; padding:0px;">
				
			</p> 
		</div>
	</div>
	<div style="position:absolute;font-size:12pt;top:62%;left:0%;height:13%;width:99%;text-align:center;">
	<div class='inside' style="position:absolute;font-size:15pt;top:0%;left:0%;height:100%;width:100%;">
			<p style="margin:5px;">
				寄件：<?php echo $arata['ztoSender']; ?>
			<br>
				<?php echo $order['company_address']; ?>
			</p>
		</div>
		</div>
	<div style="position:absolute;font-size:12pt;top:75%;left:0%;height:13%;width:99%;text-align:center;">
		<div class='inside' style="position:absolute;font-size:15pt;top:0%;left:00%;height:100%;width:100%;border-right:0px;"> 
			<img  src="<?php echo $codeImg;?>" style="position:absolute;left:1%;top:5%;width:95%;height:75%;margin-top:2px;" />
			<div class="inside" style="position:absolute;font-size:10pt;top:80%;left:5%;height:15%;width:90%;letter-spacing:5px;">
				<?php echo $arata['tracking_number']; ?>
			</div>
		</div>
	</div>
	<div style="position:absolute;font-size:15pt;top:87%;left:0%;height:9%;width:99%;text-align:left;padding:0px;">
		<p>
			收件：<?php echo $order['consignee']; ?> 电话：<?php echo $order['mobile']; ?> <?php echo $order['tel']; ?>
			<br>
				<?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";?>
		<?php echo $order['address'];?>
			<br>
			收件人签收：
		</p>
		<div class="inside" style="position:absolute;font-size:15pt;top:90%;left:70%;height:40%;width:40%;">
		<?php  if($arata['ztoSender'] == '拼好货商城') { ?>
        <img src="assets/img/Shop2DBarcodes/1953.png" style="margin-top:2px;" width="70px" height="70px">
        <?php } ?>
	</div>
		
	</div>
</div>
</body>
</html>