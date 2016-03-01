<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    
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
<body>  
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                        	<input type="button" value="返回" class="btn btn-primary" id="rt-btn">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>订单号</th>
                                    	<th>成团时间</th>
                                        <th>订单同步时间</th>
                                        <th>商品ID</th>
                                        <th>商品</th>
                                        <th>快递</th>
                                        <th>面单号</th>
                                        <th>地址类型</th>
                                    </tr>
                                </thead>
                                	总数:<?php echo count($shipment_detail_list);?>                            
                                <?php if( isset($shipment_detail_list) && is_array($shipment_detail_list))  foreach ($shipment_detail_list as $key => $item) { ?> 
                                <tbody >
                                    <tr>
                                    	<td>
                                        	<?php echo $item['out_order_sn']?>
                                        </td>
                                        <td>
                                        	<?php echo $item['confirm_time']?>
                                        </td>
                                        <td>
                                        	<?php echo $item['created_time']?>
                                        </td>
                                        <td>
                                            <?php echo $item['product_id']?>
                                        </td>
                                        <td>
                                            <?php echo $item['product_name'] ?> 
                                        </td>
                                        <td>
                                        	<?php echo $item['shipping_name']?>
                                        </td>
                                        <td>
                                        	<?php echo $item['tracking_number']?>
                                        </td>
                                        <td>
                                        	<?php echo $item['address_name']?>
                                        </td>
                                    </tr>
                                </tbody>
                                  <tr colspan="7" style="height: 13px;">
                                    </tr>
                                <?php } ?>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
$('#rt-btn').click(function(){
	history.back();
});
</script>
</body>
</html>