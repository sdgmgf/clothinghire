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
    <!-- <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/js/calendar/GooCalendar.css"/> -->
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        th{
            text-align: center;
            vertical-align: middle  !important;
            height: 100%;
        }
        td{
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
</head>
<body> 

<form style="width:100%;" method="post"  action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>warehouseDashboard">
    <!-- 隐藏的 input  start  -->
    <input type="hidden" name="act" id="act">
    <input type="hidden"  id="page_current" name="page_current"  
            <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
    <input type="hidden"  id="page_count" name="page_count"  
            <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
         
    <input type="hidden"  id="page_limit" name="page_limit"
            <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
    <input type="hidden"  id="print_batch_pick_sn" name="print_batch_pick_sn" />
    <!-- 隐藏的 input  end  -->
    </form>
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
     
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <div class="row  col-sm-8" style="margin-top: 10px;">
                            <div>&nbsp;&nbsp;&nbsp;<b>到货仪表盘</b></div>
                            <table class="table table-striped table-bordered ">
                                    <tr>
                                    	<th>PRODUCT_ID</th>
                                    	<th valign="middle">商品名称</th>
                                        <th>应到</th>
                                        <th>实到</th>
                                        <th>到货率</th>
                                    </tr>
                                         <?php if(isset($real_dashboard)) foreach ($real_dashboard as $key => $dashboard) { ?>         
                                    <tr>
                                    	<td> <?php echo isset($dashboard['product_id']) ? "{$dashboard['product_id']}" : "";  ?> </td>
                                        <td> <?php echo "{$dashboard['product_name']}"; ?> </td>
                                        <td><?php echo (isset($dashboard['asn_amount']) ? $dashboard['asn_amount'] : 0)?></td>
                                        <td><?php echo (isset($dashboard['asn_finish_amount']) ? $dashboard['asn_finish_amount'] : 0)?></td>
                                        <td><?php echo 
                                        	sprintf("%.2f", (isset($dashboard['asn_amount']) ? $dashboard['asn_amount'] : 0) ? 
                                        (isset($dashboard['asn_finish_amount']) ? $dashboard['asn_finish_amount'] : 0) / (isset($dashboard['asn_amount']) ? $dashboard['asn_amount'] : 0)
                                        : 0)?></td>
                                    </tr>
								<?php }?>
                            </table> 
                        </div>
                        
                        <div class="row  col-sm-8" style="margin-top: 10px;">
                            <div>&nbsp;&nbsp;&nbsp;<b>紧急，昨日未发订单</b><br>
                            如果是家庭地址，并且成团时间在昨天十二点前的，属于昨日未发订单。<br>
         如果是公司住址，并且今天是周一到周五，并且成团时间在昨天十二点前的，属于昨日未发订单。<br>
         如果是公司住址，并且今天是周六到周日，并且成团时间在周四十二点前的，属于昨日未发订单。<br>
         </div>
                            <table class="table table-striped table-bordered ">
                                    <tr>
                                     	<th>PRODUCT_ID</th>
                                    	<th valign="middle">商品名称</th>
                                        <th>待打单</th>
                                        <th>待发货</th>
                                    </tr>
                                         <?php if(isset($unshipping_dashboard)) foreach ($unshipping_dashboard as $key => $dashboard) { ?>         
                                    <tr>
                                    	<td><?php echo isset($dashboard['product_id']) ? "{$dashboard['product_id']}" : ""; ?> </td>
                                        <td><?php echo "{$dashboard['product_name']}"; ?> </td>
                                        <td><?php echo (isset($dashboard['un_print_amount']) ? $dashboard['un_print_amount'] : 0)?></td>
                                        <td><?php echo (isset($dashboard['un_shipping_amount']) ? $dashboard['un_shipping_amount'] : 0)?></td>
                                    </tr>
								<?php }?>
                            </table> 
                        </div>
                        <div class="row  col-sm-8" style="margin-top: 10px;">
                            <div>&nbsp;&nbsp;&nbsp;<b>发货仪表盘</b></div>
                            <table class="table table-striped table-bordered ">
                                    <tr>
                                        <th>小时</th>
                                        <th>发货量</th>
                                    </tr>
                                         <?php if(isset($shipping_hour_dashboard)) foreach ($shipping_hour_dashboard as $key => $dashboard) { ?>         
                                    <tr>
                                        <td><?php echo (isset($dashboard['shipping_hour']) ? $dashboard['shipping_hour'] : 0)?></td>
                                        <td><?php echo (isset($dashboard['shipping_amount']) ? $dashboard['shipping_amount'] : 0)?></td>
                                    </tr>
								<?php }?>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>
</html>
