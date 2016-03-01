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
                    <label for="receive_name" class="col-sm-2 control-label">仓库：</label>
            		<div  class="col-sm-3">
                    	<select  style="width: 45%;" name="facility_id" id="facility_id" class="form-control" <?php if(isset($production_batch)) echo "disabled=\"true\""?>>
                        	<?php
							foreach ($facility_list as $facility) {
								if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
									echo "<option value=\"{$facility['facility_id']}\" selected='true'>{$facility['facility_name']}</option>";
								} else {
									echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
								}
							}
							?>
                        </select>
                    </div> 
                    <label for="receive_name" class="col-sm-2 control-label">扫描波次号：</label>
                    <div class="col-md-2">
						<input type="text" name="pb_sn" id="pb_sn" class="form-control" <?php if(isset($production_batch)) echo " value=\"{$pb_sn}\" readOnly=\"true\""; ?>>
					</div>
                </div>
            </div>
            
            
            <?php if (isset($production_batch)){?>
            
            <!-- production_batch start -->
            <div class="row col-sm-10 " style="margin-left: 10px;margin-top: 10px;">
                <table class="table table-striped table-bordered ">
                    <thead>
                        <tr>
                            <th>仓库</th>
                            <th>生产批次号</th>
                            <th>生产批次日期</th>
                            <th>状态</th>
                            <th>任务单量</th>
                            <th>已提货单量</th>
                        </tr>
                    </thead>
                                                
                    <tbody >
                        <tr>
                        	<td hidden="true" class="production_batch_id"><?php echo $production_batch['production_batch_id']?></td>
                            <td><?php echo $production_batch['facility_name'] ?></td>
                            <td><?php echo $production_batch['production_batch_sn'] ?></td>
                            <td><?php echo $production_batch['production_batch_date'] ?></td>
                            <td><?php if($production_batch['status'] == 'DOING') { echo '未完成';} elseif($production_batch['status'] == 'FINISH') { echo '完成';}  ?></td>
                        	<td><?php echo $production_batch['plan_quantity'] ?></td>
                        	<td><?php echo $production_batch['finish_quantity'] ?></td>
                        </tr>
                    </tbody>
                      <tr colspan="7" style="height: 13px;">
                      </tr>

                </table>
            </div>
            <!-- production_batch end -->
            
            
            
            <!-- production_batch_item start -->
            <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
            <div class="col-md-10">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                        <!-- list start -->
                        <div class="row col-sm-12 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>任务单量</th>
                                        <th>已提货单量</th>
                                        <th>状态</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                                            
                                <?php if( isset($item_list) && is_array($item_list))  foreach ($item_list as $key => $item) { ?> 
                                <tbody >
                                    <tr>
                                    	<td hidden="true" class="container_list"><?php echo json_encode($item['product_list'])?></td>
                                    	<td hidden="true" class="key"><?php echo $key?></td>
                                    	<td hidden="true" class="production_batch_item_id"><?php echo $item['production_batch_item_id']?></td>
                                    	<td hidden="true" class="package_inventory_qoh"><?php echo $item['package_inventory_qoh']?></td>
                                    	<td class="product_id"><?php echo $item['product_id']?></td>
                                        <td class="product_name"><?php echo $item['product_name'] ?></td>
                                        <td class="plan_quantity"><?php echo $item['plan_quantity'] ?></td>
                                        <td class="finish_quantity"><?php echo $item['finish_quantity'] ?></td>
                                        <td class="status"><?php echo $item['status'] == "DOING" ? "进行中" : "已完成" ?></td>
                                        <td <?php if(($item['package_inventory_qoh'] > 0)) echo "hidden='hidden'"?>><?php if($item['status'] == 'DOING') {?><input type="button"  class="pickupmaterial btn btn-primary" value="领原料"><?php }?></td>
                                        <td <?php if((empty($item['package_inventory_qoh']) && $item['package_inventory_qoh'] <= 0) || $item['status'] == 'FINISH') echo "hidden='hidden'"?>><?php if($item['status'] == 'DOING') {?><input type="button"  class="pickuppackage btn btn-info" value="领包裹"><?php }?></td>
                                    </tr>
                                </tbody>
                                  <tr colspan="7" style="height: 13px;">
                                  </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <!--  list end -->
                </div>
            </div>
    </div>
            <!-- production_batch_item end -->
            <?php }?>
        </div>
    </div>
<div>
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="material_modal" role="dialog"  >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">领原料</h4>
	      </div>
	      <input type="hidden" id="material_production_batch_item_id">
	      <div class="modal-body ">
	      	<div class='row'>
		        <label for="material_product_name" style="width: 10%; text-align: right">商品：</label>
	            <input disabled="disabled" style="width: 30%" type="text" id="material_product_name" name="material_product_name" >
	            <label for="material_plan_quantity" style="width: 10%; text-align: right;">任务单量：</label>
	            <input disabled="disabled" style="width: 30%" type="text" id="material_plan_quantity" name="material_plan_quantity">  
	            <label for="material_finish_quantity" style="width: 10%; text-align: right">已提货单量：</label>
	            <input disabled="disabled" style="width: 30%" type="text" id="material_finish_quantity" name="material_finish_quantity" >
	      	</div>
	      	<div class='row'>
		    <table id="material_table" name="material_table" border=3 style="width:100%">
				<tr>
					<th style="width: 5%;">PRODUCT_ID</th>
					<th style="width: 45%;">商品</th>
					<th style="width: 10%;">箱规</th>
					<th style="width: 10%;">单位</th>
					<th style="width: 10%;">单量/箱</th>
					<th style="width: 10%;">可生产单量</th>
					<th style="width: 15%;">提货箱数</th>
				</tr>
			</table>
	      	</div>
	      </div>
	    <div class="modal-footer">
	    	<?php if(isset($multi_facility) && $multi_facility != 1) {?> 
	      	<input id="material_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交">
	      	<?php }?>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
    
<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="package_modal" role="dialog"  >
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title">领包裹</h4>
	      </div>
	      <input type="hidden" id="package_production_batch_item_id">
	      <div class="modal-body ">
	      	<div class='row'>
	      		<label for="package_product_id" style="width: 10%; text-align: right">PRODUCT_ID：</label>
	            <input disabled="disabled" style="width: 8%" type="text" id="package_product_id" name="package_product_id" >
		        <label for="package_product_name" style="width: 10%; text-align: right">商品：</label>
	            <input disabled="disabled" style="width: 20%" type="text" id="package_product_name" name="package_product_name" >
	            <label for="package_plan_quantity" style="width: 10%; text-align: right;">计划数量：</label>
	            <input disabled="disabled" style="width: 20%" type="text" id="package_plan_quantity" name="package_plan_quantity">  
	      	</div>
	      	<div class='row'>
		        <label for="package_finish_quantity" style="width: 10%; text-align: right">完成数量：</label>
	            <input disabled="disabled" style="width: 20%" type="text" id="package_finish_quantity" name="package_finish_quantity" >
	            <label for="package_quantity" style="width: 10%; text-align: right;">数量：</label>
	            <input style="width: 30%" type="number" id="package_quantity" name="package_quantity">  
	      	</div>
	      </div>
	    <div class="modal-footer">
	    	<?php if(isset($multi_facility) && $multi_facility != 1) {?> 
	      	<input id="package_sub" type="button" class="btn btn-primary" style="text-align: right" value="提交">
	      	<?php }?>
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    $('#pb_sn').bind('keyup', listen_pb_sn).focus();
});
var KEY = {
    RETURN: 13,  // 回车
    CTRL: 17,    // CTRL
    TAB: 9
};
function listen_pb_sn(event) {
    switch (event.keyCode) {
        case KEY.RETURN:
            load_pb_sn();
            event.preventDefault();
            break;
    }
}

function load_pb_sn() {
    var pb_sn = $.trim($('#pb_sn').val());
    var facility_id = $('#facility_id').val();
    if (pb_sn == '') {
        alert('请先输入装车单号');
        return; 
    }
    
    location.href =  $("#WEB_ROOT").val()+"productionOut/index?pb_sn="+pb_sn+"&facility_id="+facility_id;
}

$('.pickuppackage').click(function(){
	product_name = $(this).parent().parent().find('td.product_name').html();
	product_id = $(this).parent().parent().find('td.product_id').html();
	production_batch_item_id = $(this).parent().parent().find('td.production_batch_item_id').html();
	plan_quantity = $(this).parent().parent().find('td.plan_quantity').html();
	finish_quantity = $(this).parent().parent().find('td.finish_quantity').html();
	package_inventory_qoh = $(this).parent().parent().find('td.package_inventory_qoh').html();
	if(production_batch_item_id == ''){
		alert('系统异常');
		return false;
	}
	$('#package_production_batch_item_id').val(production_batch_item_id);
	$('#package_product_id').val(product_id);
	$('#package_product_name').val(product_name);
	$('#package_plan_quantity').val(plan_quantity);
	$('#package_finish_quantity').val(finish_quantity);
	$('#package_quantity').attr('placeholder',parseInt(package_inventory_qoh));
	$('#package_modal').modal('show').on();
});

$('#package_sub').click(function(){
	production_batch_item_id = $('#package_production_batch_item_id').val();
	quantity = $('#package_quantity').val();
	if(quantity == '' || isNaN(quantity) || quantity <= 0 || parseInt(quantity) != quantity) {
		alert("请输入正确的包裹数");
		return false;
	} 

	if(production_batch_item_id == '') {
		alert('提货失败');
		return false;
	}
	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	submit_data = {
			'production_batch_item_id':production_batch_item_id,
			'quantity':quantity}
	var postUrl = $('#WEB_ROOT').val() + 'productionOut/packagePickUp';
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
      if(data.success == "success"){
	      alert("提交成功");
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
       }
    }).fail(function(data){
    	btn.removeAttr('disabled');
    });
    $('#price_keyin_sub').attr('disabled',"true");
});

$('.pickupmaterial').click(function(){
	$('#material_table tr.content').remove();
	
	product_name = $(this).parent().parent().find('td.product_name').html();
	production_batch_item_id = $(this).parent().parent().find('td.production_batch_item_id').html();
	plan_quantity = $(this).parent().parent().find('td.plan_quantity').html();
	finish_quantity = $(this).parent().parent().find('td.finish_quantity').html();
	product_list = JSON.parse($(this).parent().parent().find('td.container_list').html());
	if(production_batch_item_id == ''){
		alert('系统异常');
		return false;
	}
	$('#material_production_batch_item_id').val(production_batch_item_id);
	$('#material_product_name').val(product_name);
	$('#material_plan_quantity').val(plan_quantity);
	$('#material_finish_quantity').val(finish_quantity);
	$('#material_modal').modal('show').on();
	for(var i = 0;i<product_list.length;i++){
		for(var j=0;j<product_list[i].product_container_list.length;j++){
			var lineIndex = $("#material_table tr.content").size();
			 var tr = $("<tr>");
			 tr.addClass('content');
			 var td = $("<td>");
			 td.html(product_list[i].product_container_list[j].product_id);
			 tr.append(td);
			 var td = $("<td>");
			 td.html(product_list[i].product_container_list[j].product_name);
			 tr.append(td);
			 var td = $("<td>");
			 td.addClass('container_quantity');
			 td.html(product_list[i].product_container_list[j].quantity);
			 tr.append(td);
			 var td = $("<td>");
			 td.attr('hidden','hidden');
			 td.html(product_list[i].product_container_list[j].container_code);
			 td.addClass('container_code');
			 tr.append(td);
			 var td = $("<td>");
			 td.html(product_list[i].product_container_list[j].unit_code);
			 tr.append(td);

			 var td = $("<td>");
			 td.html((product_list[i].product_container_list[j].quantity / product_list[i].quantity).toFixed(2));
			 tr.append(td);
			 var td = $("<td>");
			 td.addClass('production_quantity');
			 td.html(0);
			 tr.append(td);
			 var td = $("<td>");
			 td.addClass('mapping_quantity');
			 td.attr('hidden','hidden');
			 td.html(product_list[i].quantity);
			 tr.append(td);
			 
			 var td = $("<td>");
			 td.addClass('quantity');
			 var quantityInput = $("<input>");
			 quantityInput.attr('type','number');
			 quantityInput.attr('placeholder',product_list[i].product_container_list[j].material_inventory_qoh);
			 quantityInput.on('input',calc);
			 td.append(quantityInput);
			 tr.append(td);
			 $("#material_table tr").eq(lineIndex).after(tr);
		}
	}
});

function calc(){
	container_quantity = $(this).parent().parent().find('td.container_quantity').html();
	mapping_quantity = $(this).parent().parent().find('td.mapping_quantity').html();
	production_quantity = container_quantity * $(this).val() / mapping_quantity ;
	$(this).parent().parent().find('td.production_quantity').html(parseInt(production_quantity));
}
$('#material_sub').click(function(){
	production_batch_item_id = $('#material_production_batch_item_id').val();
	var items = [];
	var available = true;
	$('#material_table tr.content').each(function(){
		container_code = $(this).find('td.container_code').html();
		quantity = $(this).find('td.quantity').find('input').val();
		if(quantity == '' ) {
			return true;
		} 
		var item = { 
				'container_code': container_code,
				'quantity':quantity
				}
		items.push(item);
	});
	if(!available){
		return false;
	}

	if(production_batch_item_id == '') {
		alert('提货失败');
		return false;
	}

	if(items.length == 0){
		alert('先填数量再提交');
		return false;
	}
	
	btn = $(this);
	var cf=confirm('是否确认');
	if (cf==false)
		return false;
	btn.attr('disabled',"true");
	submit_data = {
			'production_batch_item_id':production_batch_item_id,
			'items':items
			}
	var postUrl = $('#WEB_ROOT').val() + 'productionOut/materialPickUp';
    $.ajax({
        url: postUrl,
        type: 'POST',
        data:submit_data, 
        dataType: "json", 
        xhrFields: {
          withCredentials: true
        }
  	}).done(function(data){
      if(data.success == "success"){
	      alert("提交成功");
	      location.reload();
      }else{
    	  btn.removeAttr('disabled');
          alert(data.error_info);
       }
    }).fail(function(data){
    	btn.removeAttr('disabled');
    });
    $('#price_keyin_sub').attr('disabled',"true");
});
</script>
</body>
</html>
