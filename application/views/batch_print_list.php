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
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>batchPrintList/query">
						<div style="width:30%;float: left;padding: 0px;">
                          <div style="width:100%;">
                                         <label for="receive_name"  style="width: 40%;">仓库：</label>
                                    <select  style="width: 35%;" name="facility_id" id="facility_id">
                                    	<?php foreach ($facility_list as $facility) {
                                			if(isset($facility_id) && $facility['facility_id'] ==$facility_id) {
	                                			echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
                                			} else {
                                				echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                                			}
                                		}?>
                                    </select>
                                </div> 
                              
                         </div>
                         <div style="width:30%;float: left;padding: 0px;">
                               <div style="width:100%;">
                                    <label for="shippingSel"  style="width: 40%;">快递方式：</label>
                                    <select  style="width: 35%;"  name="shipping_id" id="shippingSel">
                                    <?php foreach ($shipping_list['shipping'] as $shipping) {
                                			if(isset($shipping_id) && $shipping['shipping_id'] == $shipping_id) {
	                                			echo "<option value=\"{$shipping['shipping_id']}\" selected='true'>{$shipping['shipping_name']}</option>";
                                			} else {
                                				echo "<option value=\"{$shipping['shipping_id']}\">{$shipping['shipping_name']}</option>";
                                			}
                                		}?>
                                    </select>
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
                                        <th >批拣单号</th>
                                        <th>快递</th>
                                        <th>仓库</th>
                                        <th>PRODUCT_ID</th>
                                        <th style="width:30%;" >商品</th>
                                        <th>状态</th>
                                        <th>数量</th>
                                        <th>时间 </th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $order['batch_pick_sn'] ?>  <!--  单价  -->
                                        </td>
                                         <td class="product_cell">
                                            <?php echo $order['shipping_name'] ?>  <!--  单价  -->
                                        </td>
                                         <td class="product_cell">
                                            <?php echo $order['facility_name'] ?>  <!--  单价  -->
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['product_id'] ?>    <!--    数量  -->
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['product_name'] ?>    <!--    数量  -->
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['status'] ?>    <!--    数量  -->
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['shipment_number'] ?>    <!--    数量  -->
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['created_time'] ?>    <!--    数量  -->
                                        </td>
                                    </tr>
                                  
                                </tbody>
                                  <tr colspan="6" style="height: 13px;">
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
	$("#facility_id").change(function(){
		facility_id = $("#facility_id").val();
		changeShipping(facility_id);
	});
	function changeShipping(facility_id) {
		var myurl = $("#WEB_ROOT").val()+"BatchPrintList/facilityShipping?facility_id="+facility_id;
	     $.ajax({
	                url: myurl,
	                type: 'get',
	                dataType: "json", 
	                xhrFields: {
	                     withCredentials: true
	                }
	          }).done(function(data){
	          	if (data.shipping_list != undefined) {
	          		$("#shippingSel").empty();
	          		for (var i =0; i < data.shipping_list.length; i++) {
	          			var shipping = data.shipping_list[i];
	          			var option = $("<option>").val(shipping.shipping_id).text(shipping.shipping_name);
	          			$("#shippingSel").append(option);
	          		}
	          	} 
	          });
	}
   //  点击发货  弹出发货框 
   $('a.print_order').click(function(){
        var print_batch_pick_sn = $(this).attr("print_batch_pick_sn");
        $('#print_batch_pick_sn').val(print_batch_pick_sn);
        $("#act").val("batch_print");
        $("form").submit();
   }); 
  // 是查询 还是 下载 excel 
      // 
     $("#query").click(function(){
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