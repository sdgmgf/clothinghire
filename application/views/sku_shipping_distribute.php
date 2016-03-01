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
		<table class="table table-striped table-bordered ">
			
			<?php
			echo "<tr>";
			echo "<th style='width:200px;'>PRODUCT_ID</td>";
			echo "<th style='width:200px;'>商品</td>";
			echo "<th style='width:200px;'>城市</td>";
			echo "<th style='width:200px;'>区县</td>";
			echo "</tr>";
			 foreach($products as $product){
				echo "<tr>";
				echo "<td style='width:200px;'>".$product['product_id']."</td>";
				echo "<td style='width:200px;'>".$product['product_name']."</td>";
				echo "<td style='width:200px;'>".$product['city_name']."</td>";
				echo "<td style='width:200px;'>".$product['district_name']."</td>";
				echo "</tr>";
			}?>
		</table>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
</body>
</html>
