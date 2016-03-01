<!doctype html>
<html>
<head>
<title>批量打印批拣</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onload="window.print()">

<?php
$i = 0;

 foreach ($order_list as $order ) {
 	$param = "{$webRoot}printGroupAction?batch_sn=" . $order['batch_sn'];
 	$param .= "&facility_name=" . $order['facility_name'];
 	$param .= "&secrect_code=" . $order['secrect_code'];
 	$param .= "&rg_info=" . $order['rg_info'];
 	$param .= "&rg_total=" . $order['rg_total'];
 	$param .= "&goods_number=" . $order['goods_number'];
 	$param .= "&tracking_number=" . $order['tracking_number'];
 	$param .= "&mobile=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['mobile']);
 	$param .= "&consignee=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['receive_name']);
 	$param .= "&batch_items=" . urlencode(json_encode($order['batch_items'], true));

 	
// 	if ($order['shipping_id'] == 44) {
//		$height = "355";
//	} else {
//		$height = "document.getElementById(\\\"iframe{$i}\\\").contentWindow.document.body.scrollHeight";
//	}
	$height = "document.getElementById(\\\"iframe{$i}\\\").contentWindow.document.body.scrollHeight";
?>
 	<script type="text/javascript">
		document.write("<iframe id='iframe<?php echo $i; ?>' src=\"<?php echo $param; ?>\"" + 
				"frameborder=0 scrolling=\"no\""+
				"onload='document.getElementById(\"iframe<?php echo $i; ?>\").height=<?php echo $height;?>;"+
				"document.getElementById(\"iframe<?php echo $i; ?>\").width=document.getElementById(\"iframe<?php echo $i; ?>\").contentWindow.document.body.scrollWidth;'"+
				"></iframe>");
	</script>
	<?php
	if (++$i < count($order_list) ) {
		echo "<div STYLE=\"page-break-after: always;\"></div>";
	}
} 

?>


</body>
</html>
