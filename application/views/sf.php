<!doctype html>
<html>
<head>
<title>顺丰</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<!-- 丧心病狂的大鲵干完了 20130807 ljni@i9i8.com -->
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 88-35;} else {echo 88+8-35;}?>px;left:50px;"><?php echo $order['party_name'];?></div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 88-35;} else {echo 88+8-35;}?>px;left:237px;">拼好货</div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 108-35;} else {echo 108+8-35;}?>px;left:50px;"><?php echo $order['c_tel'];?></div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 135-35;} else {echo 135+8-35;}?>px;left:50px;"><?php echo $order['company_address'];?></div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 178-35;} else {echo 178+8-35;}?>px;left:50px;">0573</div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 213-35;} else {echo 213+8-35;}?>px;left:237px;"><?php echo $order['consignee'];?></div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 238-35;} else {echo 238+8-35;}?>px;left:50px;"><?php echo $order['tel'];?></div><!-- 电话 -->
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 238-35;} else {echo 238+8-35;}?>px;left:200px;"><?php echo $order['mobile'];?></div><!-- 电话 -->
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 253-35;} else {echo 253+8-35;}?>px;left:40px;width:260px;line-height:180%;"><?php if($order['province']) echo "[{$order['province']}]";if($order['city']) echo "[{$order['city']}]";if($order['district']) echo "[{$order['district']}]";echo $order['address'];?></div>
<div style="position:absolute;font-size:16pt;top:<?php if (intval($order['print_index']) == 0) {echo 328-35;} else {echo 328+8-35;}?>px;left:40px;font-weight:bolder;"><?php echo $order['product_type'];?></div>
<div style="position:absolute;font-size:12pt;top:<?php if (intval($order['print_index']) == 0) {echo 38-35;} else {echo 38+8-35;}?>px;left:495px;font-weight:bolder;">573AF</div>
<div style="position:absolute;font-size:30pt;top:<?php if (intval($order['print_index']) == 0) {echo 233-35;} else {echo 233+8-35;}?>px;left:329px;">√</div><!--寄方付 -->
<div style="position:absolute;font-size:12pt;top:<?php if (intval($order['print_index']) == 0) {echo 273-35;} else {echo 273+8-35;}?>px;left:437px;letter-spacing:14px;">5732026932</div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 325-35;} else {echo 325+8-35;}?>px;left:380px;"><?php echo $order['party_name'];?></div>
<div style="position:absolute;font-size:10pt;top:<?php if (intval($order['print_index']) == 0) {echo 365-35;} else {echo 365+8-35;}?>px;left:380px;">生鲜速配</div>
</body>
</html>
