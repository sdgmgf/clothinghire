<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
<div style="width: 1400px;margin: 0 auto;">
	<div id="list">
		<table id="list" class="table table-striped table-bordered ">
		<tr>
			<td width="10%">GOODS_ID</td>
			<td width="30%">OMS商品档案</td>
			<td width="10%">PRODUCT_ID</td>
			<td width="30%">商品</td>
			<td width="5%">省</td>
			<td width="10%">市</td>
			<td width="5%">影响数量</td>
			
		</tr>
			<?php
			if (isset( $list ) && $list != null) { //isset检查变量
				foreach ( $list as $record ) {
					echo "<tr>";
					echo "<td>" . $record ['goods_id'] . "</td>";	
					echo "<td>" . $record ['goods_name'] . "</td>";
					echo "<td>" . $record ['product_id'] . "</td>";	
					echo "<td>" . $record ['product_name'] . "</td>";	
					echo "<td>" . $record ['province_name'] . "</td>";								
					echo "<td>" . $record ['city_name'] . "</td>";
					echo "<td>" . $record ['num'] . "</td>";						
					echo "</tr>";
				}
			}
			?>
		</table>
	</div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
</script>
</body>
</html>