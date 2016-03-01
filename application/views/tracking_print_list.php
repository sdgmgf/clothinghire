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
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>./trackingPrint/query">

                         <div style="width:30%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                         <label for="receive_name"  style="width: 40%;">快递单号：</label>
                                            <input type="text"  id="tracking_number" name="tracking_number" 
                                             <?php if(isset($tracking_number))  echo "value={$tracking_number}"; ?> >
                                </div> 
                         </div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
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
                         </div>
                        </form>
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>快递单号</th>
                                        <th>快递方式</th>
                                        <th>仓库</th>
                                        <th>PRODUCT_ID</th>
                                        <th style="width:30%;" >商品</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($tracking_detail) && is_array($tracking_detail))  foreach ($tracking_detail as $key => $tracking) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $tracking['tracking_number'] ?> 
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $tracking['shipping_name'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $tracking['facility_name'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $tracking['product_id'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $tracking['product_name'] ?>   
                                        </td>
                                        <td class="product_cell">
                                             <?php
												if ($tracking['status'] == '1') {
													echo '待生成批次';
												} else if($tracking['status'] == '2') {
													echo '已打印';
												} else if($tracking['status'] == '3') {
													echo '已发货';
												} else if($tracking['status'] == '4') {
													echo '待打印';
												} else if($tracking['status'] == '5') {
													echo '已生成发运单';
												} else if($tracking['status'] == '6') {
													echo '待提货';
												}
                                           ?>   
                                        </td>
                                        <td class="product_cell">
                                        	<a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT?>./ShipmentShipping/doPrint?shipment_id=<?php echo $tracking['shipment_id']?>" >打单</a>
                                        </td>
                                    </tr>
                                  
                                </tbody>
                                  <tr colspan="7" style="height: 13px;">
                                    </tr>
                                <?php } ?>

                            </table>
                                    <div class="row">
                                            <nav style="float: right;margin-top: -7px;">
                                                <ul class="pagination">
                                                    <li>
                                                        <a href="#"   id="page_prev">
                                                            <span aria-hidden="true">&laquo;</span>
                                                        </a>
                                                    </li>
                                                    <?php if(isset($page)) echo $page; ?>
                                                    <li>
                                                        <a href="#" id="page_next" >
                                                            <span aria-hidden="true">&raquo;</span>
                                                        </a>
                                                    </li>
                                                    <li><a href='#'>
                                                     <?php if(isset($page_count)) echo "共{$page_count}页 &nbsp;"; 
                                                          if(isset($record_total))  echo  "共{$record_total}条记录"; 
                                                     ?>
                                                     </a></li>
                                                </ul>
                                            </nav>
                                    </div>
                                      
                        </div>
                        <!-- product list end -->
                    </div>
                    <div role="tabpanel" class="tab-pane" id="undercarriage">
                         
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
         var tracking_number = $("#tracking_number").val();
         if($.trim(tracking_number) == '' )
         {
             alert("请输入快递单号");
             return;
         }
         $("#act").val("query");
         $("#page_current").val("1");
         $("form").submit();
     }); 

    // 分页 
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page); 
        $("form").submit();
    }); 

    // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1; 
        }else{
            page = parseInt(page); 
            if(page > 1 ){
                page = page - 1; 
               $('#page_current').val(page);
               $("form").submit(); 
            }
        }
    }); 

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val(); 
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1; 
            $("#page_current").val(page);
            $("form").submit(); 
        }
    }); 

    $("button#toggleShow").click(function(){
        $("div#searchDiv").toggle(); 
    }); 
//
</script>
</body>
</html>