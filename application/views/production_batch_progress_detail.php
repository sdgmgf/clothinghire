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
<body>
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                        <a class='btn btn-primary btn-sm' href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./ProductionBatchList">返回</a>
                        <input class="btn btn-success btn-sm" value='刷新' id='refresh_btn' style="width: 50px">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>PRODUCT_ID</th>
                                    	<th>商品</th>
                                    	<th width="8%">待绑定快递</th>
                                        <th width="8%">待绑定面单</th>
                                        <th width="8%">待产线提货</th>
										<th width="8%">待生成批次</th>
										<th width="8%">待打印</th>
										<th width="8%">待发货</th>
										<th width="8%">待快递确认</th>
										<th width="8%">今日完成</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($total_list) && is_array($total_list))  foreach ($total_list as $key => $entry) { ?> 
                                <tbody >
                                    <tr>
                                    	<td class="product_id"><?php echo $entry['product_id']?></td>
                                    	<td class="product_name"><?php echo $entry['product_name']?></td>
                                    	<td class="to_be_binding"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&shipping_id=0&status=0"><?php echo !empty($entry['quantity'][-1])?$entry['quantity'][-1]:0 ?></a></td>
                                        <td class="to_be_binding"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=0"><?php echo !empty($entry['quantity'][0])?$entry['quantity'][0]:0 ?></a></td>
                                        <td class="to_be_production_out"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=1"><?php echo !empty($entry['quantity'][1])?$entry['quantity'][1]:0 ?></a></td>
                                        <td class="to_be_batch"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=6"><?php echo !empty($entry['quantity'][6])?$entry['quantity'][6]:0 ?></a></td>
                                        <td class="to_be_print"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=4"><?php echo !empty($entry['quantity'][4])?$entry['quantity'][4]:0 ?></a></td>
                                        <td class="to_be_shipping"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=2"><?php echo !empty($entry['quantity'][2])?$entry['quantity'][2]:0 ?></a></td>
                                        <td class="to_be_waybill"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=3"><?php echo !empty($entry['quantity'][3])?$entry['quantity'][3]:0 ?></a></td>
                                        <td class="finish"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $key?>&is_shipping=1&status=5"><?php echo !empty($entry['quantity'][5])?$entry['quantity'][5]:0 ?></a></td>
                                    </tr>
                                </tbody>
                                <?php } ?>
                            </table>
                            
                            <?php if(isset($detail_list) && is_array($detail_list)) foreach ($detail_list as $shipping_id=> $shipping_entry) {?>
                           
                            <?php if($shipping_id != 0 ) {?>
                             <?php echo $shipping_entry['shipping_name']?>
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>PRODUCT_ID</th>
                                    	<th>商品</th>
                                        <th width="8%">待绑定面单</th>
                                        <th width="8%">待产线提货</th>
										<th width="8%">待生成批次</th>
										<th width="8%">待打印</th>
										<th width="8%">待发货</th>
										<th width="8%">待快递确认</th>
										<th width="8%">今日完成</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($shipping_entry['product_list']) && is_array($shipping_entry['product_list']))  foreach ($shipping_entry['product_list'] as $product_id => $product_entry) { ?> 
                                <tbody >
                                    <tr>
                                    	<td class="product_id"><?php echo $product_entry['product_id']?></td>
                                    	<td class="product_name"><?php echo $product_entry['product_name']?></td>
                                        <td class="to_be_binding"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=0"><?php echo !empty($product_entry['quantity'][0])?$product_entry['quantity'][0]:0 ?></a></td>
                                        <td class="to_be_production_out"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=1"><?php echo !empty($product_entry['quantity'][1])?$product_entry['quantity'][1]:0 ?></a></td>
                                        <td class="to_be_batch"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=6"><?php echo !empty($product_entry['quantity'][6])?$product_entry['quantity'][6]:0 ?></a></td>
                                        <td class="to_be_print"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=4"><?php echo !empty($product_entry['quantity'][4])?$product_entry['quantity'][4]:0 ?></a></td>
                                        <td class="to_be_shipping"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=2"><?php echo !empty($product_entry['quantity'][2])?$product_entry['quantity'][2]:0 ?></a></td>
                                        <td class="to_be_waybill"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=3"><?php echo !empty($product_entry['quantity'][3])?$product_entry['quantity'][3]:0 ?></a></td>
                                        <td class="finish"><a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>CreateProductionBatch/getShipmentDetailList?production_batch_id=<?php echo $production_batch_id?>&product_id=<?php echo $product_id?>&shipping_id=<?php echo $shipping_id?>&status=5"><?php echo !empty($product_entry['quantity'][5])?$product_entry['quantity'][5]:0 ?></a></td>
                                    </tr>
                                </tbody>
                                <?php } ?>
                            </table>
                            <?php }?>
                            <?php }?>
                        </div>
                        <!--  list end -->
                </div>
            </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript">
	$('#refresh_btn').click(function(){
		location.reload();
	});
</script>
</body>
</html>
