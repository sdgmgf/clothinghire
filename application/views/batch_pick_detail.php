<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
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
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>序号</th>
                                    	<th> 快递 </th>
                                    	<th>快递单号</th>
                                    	<th> 发货单 </th>
                                    	<th> PRODUCT_ID </th>
                                    	<th> 商品 </th>
                                    	<th> 订单号 </th>
                                    	<th> 客户名 </th>
                                        <th> 打单状态 </th>
                                    </tr>
                                </thead>
                                
                                <?php $i = 0;?>
                                <?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
                                <tbody >
                                    <tr>
                                    	<td class="product_cell">
                                    		<?php echo ++$i;?>
                                        </td>
                                    	<td class="product_cell">
                                    		<?php echo $order['shipping_name'] ?>
                                        </td>
                                         <td class="product_cell">
                                            <p> <?php echo $order['tracking_number'] ?>  </p>
                                        </td>
                                    	<td class="product_cell">
                                    		<input type="hidden" name="shipmentIds[]" value="<?php echo $order['shipment_id'] ?>"/><?php echo $order['shipment_id'] ?>
                                        </td>
                                        <td class="product_cell">
                                            <p> <?php echo $order['product_id'] ?>  </p>
                                        </td>
                                        <td class="product_cell">
                                            <p> <?php echo $order['product_name'] ?>  </p>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $order['order_sn'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['receive_name'] ?> 
                                        </td>
                                        <td class="product_cell"  >
                                        	<p><?php
												if ($order['print_status'] == 2) {
                                                            echo "已打单,次数 {$order['print_count']}";
                                                	}else if($order['print_status'] == 3){
                                                    		echo "已发货";
                                                   }else if($order['print_status'] == 4){
                                                            echo "未打单";
                                                    }else if($order['print_status'] == 5){
                                                            echo "已发运";
                                                    } 
                                        	?></p>
                                        	 <p id='fa-{$order['shipment_id']}' ><?php if(isset($order['tracking_number']) && !empty($order['tracking_number']) ){?> <a href='<?php if(isset($WEB_ROOT)) echo $WEB_ROOT?>./ShipmentShipping/doPrint?shipment_id=<?php echo $order['shipment_id']?>' class='print_order' shipment_id="<?php echo $order['shipment_id']; ?>" >打单</a><?php }?> </p>
                                        </td>
                                    </tr>
                                  
                                </tbody>
                                <?php } ?>

                            </table>
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
