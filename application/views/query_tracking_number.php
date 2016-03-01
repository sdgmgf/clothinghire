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

                        <form style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>queryTrackingNumber/queryTrackingNumber">

                         <div style="width:30%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                         <label for="mobile"  style="width: 40%;">手机：</label>
                                            <input type="text"  id="mobile" name="mobile" 
                                             <?php if(isset($mobile))  echo "value={$mobile}"; ?> >
                                </div> 
                         </div>
                         <div style="width:30%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                         <label for="receive_name"  style="width: 40%;">收件人：</label>
                                            <input type="text"  id="receive_name" name="receive_name" 
                                             <?php if(isset($receive_name))  echo "value={$receive_name}"; ?> >
                                </div> 
                         </div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                         </div>
                        </form>
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>面单号</th>
                                        <th>手机</th>
                                        <th>收件人</th>
                                        <th>快递方式</th>
                                        <th>订单号</th>
                                        <th>成团时间</th>
                                        <th>仓库</th>
                                        <th>状态</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $order['tracking_number'] ?> 
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['mobile'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['receive_name'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['shipping_name'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['order_sn'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['confirm_time'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['facility_name'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php
												if ($order['status'] == '1') {
													echo '待打印';
												} else if($order['status'] == '2') {
													echo '已打印';
												} else if($order['status'] == '3') {
													echo '已发货';
												}
                                           ?>   
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
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript">
  // 是查询 还是 下载 excel 
      // 
     $("#query").click(function(){
         var mobile = $("#mobile").val();
         var receive_name = $("#receive_name").val();
         if($.trim(mobile) == '' && $.trim(receive_name) == '')
         {
             alert("手机和收件人必须填一项");
             return;
         }
         $("#act").val("query");
         $("#page_current").val("1");
         $("form").submit();
     }); 
</script>


</body>
</html>