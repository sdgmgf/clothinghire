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
                    	<select  style="width: 45%;" name="facility_id" id="facility_id" class="form-control" disabled="disabled">
                        	<?php
							foreach ($facility_list as $facility) {
								echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
							}
							?>
                        </select>
                    </div> 
                </div>
            </div>
            
            <!-- product list start -->
            <div class="row col-sm-10 " style="margin-left: 10px;margin-top: 10px;">
            	<form>
            	<input type="hidden" id="hidden_facility_id" name="hidden_facility_id">
                <table class="table table-striped table-bordered" id="bill_item_list_table">
                    <tr>
                        <th>商品</th>
                        <th>条码</th>
                        <th>规格</th>
                        <th>数量</th>
                        <th></th>
                    </tr>
                    
                    <?php if (isset($product_list) && is_array($product_list) && ! empty($product_list)) foreach ($product_list as $product) {
                    	?>
                	<tr>
                    	<td><?php echo $product['product_name']?></td>
                    	<td><?php echo $product['container_code']?></td>
                    	<td><?php echo $product['quantity'] . $product['unit_code_name'] . "/" . $product['container_unit_code_name']?></td>
                    	<td><input type="text" name="real_quantity[]" autocomplete="off" value="0" quantity="<?php echo $product['qoh']?>"/> <?php echo $product['container_unit_code_name']?></td>
                    	<td>
                            <button class="btn btn-primary submit">提交出库</button>
	                    	<!--<button type="button" class="btn btn-danger" id="delete"  >删除</button>-->
	                    	<input type="hidden" name="container_code[]" id="container_code<?php echo $product['container_code']?>" value="<?php echo $product['container_code']?>"/>
	                    	<input type="hidden" name="quantity[]" id="" value=""/>
	                    </td>
                	</tr>
                    	<?php 
                    }?>
                </table>
                </form>
                <table style="display:none;">
	                <tr id="aa">
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td><input type="text" name="real_quantity[]"/></td>
	                    <td>
	                    	<!--<button type="button" class="btn btn-danger" id="delete"  >删除</button>-->
	                    	<input type="hidden" name="container_code[]" id="" value=""/>
	                    	<input type="hidden" name="quantity[]" id="" value=""/>
	                    </td>
	                </tr>
                </table>
            </div>
            <!-- product list end -->
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
var WEB_ROOT = $("#WEB_ROOT").val();
$(".submit").click(function() {
    var btn = $(this);
    btn.attr("disabled", true);
    var hidden_facility_id = $("#facility_id").val();
    var real_quantity = btn.parent().parent().children("td").eq(3).find("input[name='real_quantity[]']").val();
    var container_code = btn.parent().parent().children("td").eq(1).html().trim();
    var items = {
        'hidden_facility_id': hidden_facility_id,
        'real_quantity': real_quantity,
        'container_code': container_code
    }
    if (!real_quantity || real_quantity == 0) {
        alert('请输入数量');
        btn.removeAttr('disabled');
        return;
    };
	if (confirm("确定出库吗？")) {
		$.ajax({
            url: WEB_ROOT + 'ProductionOut/createProductionOutSuppliesTransaction',
            type: 'POST',
            data: items,
            dataType: "json",
            xhrFields: {
                withCredentials: true
            },
            success: function(data){
                console.log(data);
                if (data.success == 'success') {
                    alert("操作成功");
                    window.location.reload();
                }else{
                    alert(data.error_info);
                }  
            }
        })
	}else{
        btn.removeAttr('disabled');
    }
});


function checkQuantity(input, quantity, can_sale_return_quantity) {
	if (quantity == null || isNaN(quantity) || parseFloat(quantity) < 0) {
		alert("请输入正确的数字");
		$(input).focus();
	} else {
		if (parseFloat(quantity) > parseFloat(can_sale_return_quantity)) {
			alert("没有这么多可用库存");
			$(input).focus();
		}
	}
	
}

$("input[name='real_quantity[]'").blur(function (){
	checkQuantity(this, $(this).val().trim(), $(this).attr('quantity'));
});
</script>
</body>
</html>
