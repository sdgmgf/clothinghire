<!doctype html>
<html>
<head>
<title>批量打印快递面单</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<script type="text/javascript">
window.onload = test();
function test(){
	window.print();
	window.close();
}
</script>
<?php
if($order)
 	$station = isset($order['station']) ? $order['station'] : "";
 	$station_no = isset($order['station_no']) ? $order['station_no'] : "";
 	$shipping_name = isset($order['shipping_name']) ? $order['shipping_name'] : "";
 	$order['shipping_address'] = urlencode($order['shipping_address']);
 	$param = "{$webRoot}printAction";
 	$param .= "?order_amount=" . $order['order_amount'];
 	$param .= "&product_amount=" . $order['product_amount'];
 	$param .= "&order_sn=" . $order['order_sn'];
 	$param .= "&province=" . $order['province'];
 	$param .= "&city=" . $order['city'];
 	$param .= "&district=" . $order['district'];
 	$param .= "&mobile=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['mobile']);
 	$param .= "&tel=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['tel']);
 	$param .= "&consignee=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['receive_name']);
 	$param .= "&address=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['shipping_address']);
 	$param .= "&tracking_number=" . $order['tracking_number'];
 	$param .= "&shipping_id=" . $order['shipping_id'];
 	$param .= "&print_index=" . $i;
 	$param .= "&station=" . $station;
 	$param .= "&station_no=" . $station_no;
 	$param .= "&title=" . $order['title'];
 	$param .= "&facility_address=" . $order['facility_address'];
 	$param .= "&secrect_code=".$order['secrect_code'];
 	$param .= "&shipping_name=".$shipping_name;
 	

	$height = "document.getElementById(\\\"iframe0\\\").contentWindow.document.body.scrollHeight";
?>
 	<script type="text/javascript">
		document.write("<iframe id='iframe0' src=\"<?php echo $param; ?>\"" + 
				"frameborder=0 scrolling=\"no\""+
				"onload='document.getElementById(\"iframe0\").height=<?php echo $height;?>;"+
				"document.getElementById(\"iframe<?php echo $i; ?>\").width=document.getElementById(\"iframe0\").contentWindow.document.body.scrollWidth;'"+
				"></iframe>");
	</script>
} 
<iframe id='iframe0' frameborder=0 scrolling="no" >

</iframe>
</body>
</html>
