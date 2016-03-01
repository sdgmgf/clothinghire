<!doctype html>
<html>
<head>
<title>批量打印快递面单</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onload="test()">
<script type="text/javascript">
var relocation_url = "<?php echo $webRoot . "/" . isset($from_page)?$from_page :''; ?>";
var from_page = "<?php echo isset($from_page)?$from_page :''?>";
function test(){
	window.print();
	if (from_page == "printPage") {
		window.location.href = relocation_url;
	}
}
</script> 

<?php
$i = 0;
if (! empty($order_list) && isset($order_list[0]['batch_pick_sn'])) {
	$param = "{$webRoot}printAction/first?batch_pick_sn=" . $order_list[0]['batch_pick_sn'];
	$height = "document.getElementById(\\\"iframeFirst\\\").contentWindow.document.body.scrollHeight";
?>

<script type="text/javascript">
		document.write("<iframe id='iframeFirst' src=\"<?php echo $param; ?>\"" + 
				"frameborder=0 scrolling=\"no\""+
				"onload='document.getElementById(\"iframeFirst\").height=<?php echo $height;?>;"+
				"document.getElementById(\"iframeFirst\").width=document.getElementById(\"iframeFirst\").contentWindow.document.body.scrollWidth;'"+
				"></iframe>");
	</script>
<?php 
	echo "<div STYLE=\"page-break-after: always;\"></div>";
}

 foreach ($order_list as $key=>$order ) {
 	$station = isset($order['station']) ? $order['station'] : "";
 	$shipping_name = isset($order['shipping_name']) ? $order['shipping_name'] : "";
 	$station_no = isset($order['station_no']) ? $order['station_no'] : "";
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
 	$param .= "&consignee=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\", "#"),'',$order['receive_name']);
 	$param .= "&address=" . str_replace(array("\r\n", "\r", "\n", ",", "\'", "'", "\"", "?", "\\"),'',$order['shipping_address']);
 	$param .= "&tracking_number=" . $order['tracking_number'];
 	$param .= "&shipping_id=" . $order['shipping_id'];
 	$param .= "&product_id=" . $order['product_id'];
 	$param .= "&print_index=" . $i;
 	$param .= "&station=" . $station;
 	$param .= "&station_no=" . $station_no;
 	$param .= "&title=" . $order['title'];
 	$param .= "&facility_address=" . $order['facility_address'];
 	$param .= "&secrect_code=".$order['secrect_code'];
 	$param .= "&facility_id=" . $order['facility_id'];
 	$param .= "&is_self_template=" . $order['is_self_template'];
 	$param .= "&send_addr_code=" . $order['send_addr_code'];
 	$param .= "&sf_account=" . $order['sf_account'];
    $param .= "&shipment_id=" . $order['shipment_id'];
    $param .= "&page_index=" .($key + 1);
    $param .= "&package_no=" .$order['package_no'];
    $param .= "&package=" .$order['package'];
    $param .= "&sender_branch=" .$order['sender_branch'];
    $param .= "&sender_branch_no=" .$order['sender_branch_no'];
    $param .= "&lattice_mouth_no=" .$order['lattice_mouth_no'];
    $param .= "&shipping_name=" .$shipping_name;
 	
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
