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
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">

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
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                        <form style="width:100%;" method="post"   action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>allBatchPrintList/query">
                         <div style="width:30%;float: left;padding: 0px;">
                               <div style="width: 100%;">
                                   <label for="productSel" style="width: 40%;" >商品：</label>
                                   <input  type="text" style="width: 50%;"  name="product_name" id="product_name" value="<?php if(isset($product_name)) echo $product_name; ?>" >
                                   <input  type="hidden" name="product_id" id="productSel" value="<?php if(isset($product_id)) echo $product_id; ?>" >
                               </div>
                                
                               <div style="width: 100%;">
                                     <label for="shipping_id"  style="width: 40%;">快递方式：</label>
                                    <select  style="width: 50%;"   name="shipping_id" id="shipping_id">
                                     <option value="">全部</option>
                                    <?php 
                                    	if($shipping_list && isset($shipping_list['result']) && $shipping_list['result'] == 'ok' && $shipping_list["shipping"] ) {
                                    		foreach ($shipping_list["shipping"] as $shipping) {
                                    			echo "<option value=\"{$shipping['shipping_id']}\" " . (isset($shipping_id) && $shipping_id == $shipping['shipping_id'] ? " selected='true'" : ""). ">{$shipping['shipping_name']}</option>";
                                    		}
                                    	}
                                    ?>
                                    </select>
                                </div>
                                  <div style="width: 100%;">
                            <label for="start_time"  style="width: 40%;">开始时间：</label>
                                <input type="text" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo "{$start_time}"; ?>">
                               </div>
                               
                               <div style="width: 100%;">
                                     <label for="facility_id"  style="width: 40%;">仓库：</label>
                                    <select  style="width: 50%;"   name="facility_id" id="facility_id">
                                    <?php foreach ($facility_list as $facility) {
                                			if(isset($facility_id) && $facility['facility_id'] ==$facility_id) {
	                                			echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
                                			} else {
                                				echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
                                			}
                                		}?>
                                    </select>
                                </div>
                                <div style="width: 100%;">
                                     <label for="print_user"  style="width: 40%;">打印人：</label>
                                     <input style="width: 50%;" required="required" type="text" name="print_user" id="print_user" value="<?php if(isset($print_user)) echo "{$print_user}"; ?>">
                                </div>
                               </div>
                        
                         <div style="width: 65%;float: left;"> <!--  right div start  -->
                            <div style="width: 100%;float: left;">  <!-- float left start  -->
                                 <div style="width: 100%;">
                                    <label for="batch_pick_sn" >批拣单号：</label>
                                    <input type="text" style="width: 30%;" name="batch_pick_sn" id="batch_pick_sn"  <?php if(isset($batch_pick_sn)){ echo "value='{$batch_pick_sn}'"; }  ?>  >
                                 </div>
                                  <div style="width: 100%;">
                                    <label for="tracking_number" >快递面单号：</label>
                                    <input type="text" style="width: 30%;" name="tracking_number"  id="tracking_number" <?php if(isset($tracking_number)){ echo "value='{$tracking_number}'"; }  ?>  >
                                 </div>
                                 <div style="width: 100%;">
                            <label for="end_time" >结束时间：</label>
                                <input type="text" name="end_time" id="end_time"  value="<?php if(isset($end_time)) echo "{$end_time}"; ?>">
                               </div>
                             <div style="width: 100%;">
                            <label for="mobile" >手机号码：</label>
                                <input type="text" name="mobile" id="mobile"  value="<?php if(isset($mobile)) echo "{$mobile}"; ?>">
                               </div>
                               
                                <div style="width: 100%;">
                                     <label for="shipping_user" >发货人：</label>
                                     <input  required="required" type="text" name="shipping_user" id="shipping_user" value="<?php if(isset($shipping_user)) echo "{$shipping_user}"; ?>">
                                </div>
                            </div>     <!--  float left end  -->
                            </div>  <!--  float right end  -->
                        
                         </div>                                 <!-- right div end  -->
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  id="page_current" name="page_current"   <?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                                <input type="hidden"  id="page_count" name="page_count"   <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                         </div>
                        </form>

                        <div class="row  col-sm-12 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th style="width:10%;">批拣单号</th>
                                        <th style="width:5%;" >PRODUCT_ID</th>
                                        <th style="width:30%;" >商品</th>
                                        <th style="width:8%;">快递方式 </th>
                                        <th style="width:5%;">仓库</th>
                                        <th style="width:5%;">状态</th>
                                        <th style="width:5%;">数量</th>
                                        <th style="width:5%">打印人</th> 
                                        <th style="width:5%">发货人</th>
                                        <th style="width:15%;">最后更新时间 </th>
                                        <th style="width:10%;">操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo $order['batch_pick_sn'] ?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['product_id'] ?>  
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['product_name'] ?>  
                                        </td>
                                         <td class="product_cell">
                                             <?php echo $order['shipping_name'] ?>  
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['facility_name'] ?>  
                                        </td>
                                        <td class="product_cell">
                                       	<?php 
                                       		if($order['status'] == 'PRINTED') {
                                             	echo '已打印';
                                			} else if( $order['status'] == 'FINISH') {
                                				echo '已发货';
                                			} else if( $order['status'] == 'INIT') {
                                				echo '未打印';
                                			} else {
                                				echo $order['status'];
                                			}
                                		?>
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['shipment_number'] ?>
                                        </td>
                                          <td class="product_cell">
                                             <?php echo  isset($order['print_user']) ? $order['print_user'] : ""?>  
                                        </td>
                                        <td class="product_cell">
                                              <?php echo  isset($order['shipping_user']) ? $order['shipping_user'] : ""?>  
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['last_updated_time'] ?>
                                        </td>
                                        <td class="product_cell">
                                        <a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT?>./AllBatchPrintList/printBatchPick?batch_pick_id=<?php echo $order['batch_pick_id'] ?>" >打印批拣单</a>
                                        <a href="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT?>./BatchPrintList/batchPickDetail?batch_pick_id=<?php echo $order['batch_pick_id'] ?>" >详情</a>
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
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>

<script type="text/javascript">
$('#facility_id').change(function () {
    facility_id = $("#facility_id").val();
	changeproduct(facility_id);
	changeShipping(facility_id);
});

function changeShipping(facility_id) {
	var myurl = $("#WEB_ROOT").val()+"allBatchPrintList/facilityShipping?facility_id="+facility_id;
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
          	if (data.shipping_list != undefined) {
          		$("#shipping_id").empty();
          		var option = $("<option>").val('').text('全部');
      			$("#shipping_id").append(option);
          		for (var i =0; i < data.shipping_list.length; i++) {
          			var shipping = data.shipping_list[i];
          			var option = $("<option>").val(shipping.shipping_id).text(shipping.shipping_name);
          			$("#shipping_id").append(option);
          		}
          	} 
          });
}

function changeproduct(facility_id) {
	var myurl = $("#WEB_ROOT").val()+"allBatchPrintList/facilityproduct?facility_id="+facility_id;
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
          	if (data.product_list != undefined) {
          		$("#productSel").empty();
          		var option = $("<option>").val('').text('全部');
      			$("#productSel").append(option);
          		for (var i =0; i < data.product_list.length; i++) {
          			var product = data.product_list[i];
          			var option = $("<option>").val(product.product_id).text(product.product_name);
          			$("#productSel").append(option);
          		}
          	} 
          });
}

$(document).ready(function(){

    (function(config){
        config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
        config['lock'] = true;
        config['fixed'] = true;
        config['okVal'] = 'Ok';
        config['format'] = 'yyyy-MM-dd HH:mm:ss';
    })($.calendar.setting);

    $("#start_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
    $("#end_time").calendar({btnBar:true,
                   minDate:'2010-05-01', 
                   maxDate:'2022-05-01'});
});

    (function($){//从页面获取商品列表并使用autocomplete插件
        var product_list = <?php 
            if ($product_list && isset($product_list['result']) && $product_list['result'] == 'ok' && $product_list['product']){
                echo json_encode($product_list);
            }else{
                $arr = array('product'=>array());
                echo json_encode($arr);
            }
         ?>;
        console.log(product_list);
        $('#product_name').autocomplete(product_list.product,{
            minChars: 0,
            width: 310,
            max: 100,
            matchContains: true,
            autoFill: false,
            formatItem: function(row, i, max) {
                return row.product_name;
            },
            formatMatch: function(row, i, max) {
                return row.product_name;
            },
            formatResult: function(row) {
                return row.product_name;
            }
        }).result(function(event, row, formatted) {
            $('#productSel').val(row.product_id);
            $(this).val(row.product_name);
        });
    })(jQuery);
  // 是查询 还是 下载 excel 
      // 
     $("#query").click(function(){
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
</script>
</body>
</html>