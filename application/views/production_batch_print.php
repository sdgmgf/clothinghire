<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr {
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }


      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body onload="window.print()">
	<div class="left-top" style="position:absolute;font-size:10pt;top:10px;left:0px;height:100px;width:400px;text-align:center;border-right:0px;border-bottom:0px;">
		<h3>生产批次号:<?php echo $summary['production_batch_sn']?></h3>
	</div>
	<div style="position:absolute;top:110px;left:100px;height:50px;width:400px;border:0px;">
		<div class="inside" style="position:absolute;font-size:12pt;left:5%;height:40%;width:80%">
			仓库:<?php echo $summary['facility_name'];?>  数量:<?php echo $summary['plan_quantity'];?>
		</div>
	</div>
    <div style="position:absolute;top:160px;left:10px;width:400px;border:0px;" >
         <table class="table table-striped table-bordered ">
             <tr>
             		<th>PRODUCT_ID</th>
                    <th>商品</th>
                    <th>任务单量</th>
            </tr>                  
            <?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
                <tr>
                	<td class="product_name"><?php echo $item['product_id'] ?></td>
                    <td class="product_name"><?php echo $item['product_name'] ?></td>
                    <td class="plan_quantity"><?php echo $item['plan_quantity'] ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
