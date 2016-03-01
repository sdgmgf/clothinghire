<!doctype html>
<html>
<head>
    <meta charset="utf-8">
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
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
</head>
<body>
<div class="container-fluid" style="width: 1000px" >
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
            <div class="row col-sm-10 " style="width: 100%">
            	<form>
            	<input type="hidden" id="hidden_facility_id" name="hidden_facility_id">
            	<input type="hidden" id="hidden_note" name="hidden_note">
                <table class="table table-striped table-bordered " id="bill_item_list_table">
                    <thead>
                        <th>虚拟PRODUCT_ID</th>
                        <th>虚拟商品</th>
                        <th>暗语</th>
                        <th style="width: 40%;">实体商品</th>
                        <th>包裹数</th>
                        <th></th>
                    </thead>
                    <tbody>
                    <?php if (isset($finished_product_list) && is_array($finished_product_list) && ! empty($finished_product_list))
                    		foreach ($finished_product_list as $finished_product) {
                    	?>
	                	<tr>
	                		<td style="text-align: center;">
	                    		<?php echo $finished_product['product_id']?>
	                    	</td>
	                    	<td style="text-align: center;">
	                    		<?php echo $finished_product['product_name']?>
	                    	</td>
	                    	<td>
	                    		<?php echo $finished_product['secrect_code']?>
	                    	</td>
	                    	<td>
                    			<?php 
                    				if (isset($finished_product['product_list']) && is_array($finished_product['product_list']) && ! empty($finished_product['product_list'])) 
                    					foreach ($finished_product['product_list'] as $product) {
                    			?>
	                    				<?php echo $product['quantity'];echo $product['unit_code'];echo $product['component_name'];?><br>
                    			<?php } ?>
	                    	</td>
	                    	<td>
	                    		<input type="text" name="quantity[]" autocomplete="off" value="0" />
	                    	</td>
	                    	<td>
                                <button class="btn btn-primary submit">提交包裹入库</button>
	                    		<input type="hidden" name="product_id[]" value="<?php echo $finished_product['product_id'];?>"/>
	                    	</td>
	                	</tr>
                    	<?php } ?>
                    	</tbody>
                </table>
                </form>
            </div>
            <!-- product list end -->
        </div>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
var WEB_ROOT = $("#WEB_ROOT").val();
$(".submit").click(function() {
    var btn = $(this);
    btn.attr("disabled", true);
    var hidden_facility_id = $("#facility_id").val();
    var product_id = btn.parent().parent().children("td").eq(0).html().trim();
    var quantity = btn.parent().parent().children("td").eq(4).find("input[name='quantity[]']").val();
    if (!quantity || quantity == 0) {
        alert('请输入数量');
        btn.removeAttr('disabled');
        return;
    };
    var note = prompt("请输入备注");
    if(note == null){
        btn.removeAttr('disabled');
        return ;
    }
    var hidden_note = note.trim();
    var items ={
        'hidden_facility_id': hidden_facility_id,
        'hidden_note': hidden_note,
        'product_id': product_id,
        'quantity': quantity
    };
	$.ajax({
        url: WEB_ROOT + 'packageIn/createPackageInTransaction',
        type: 'POST',
        data: items,
        dataType: "json",
        xhrFields: {
            withCredentials: true
        },
        success: function(data){
            console.log(data);
            if (data.success == 'success') {
                alert("入库成功");
                window.location.reload();
            }else{
                alert(data.error_info);
            }
        }
    })
});

function checkQuantity(input, quantity) {
	if (quantity == null ||  isNaN(quantity) || parseInt(quantity) < 0 || parseInt(quantity) != quantity) {
		alert("请输入正确的数字");
		$(input).focus();
	}
	
}
$("input[name='quantity[]'").blur(function (){
	checkQuantity(this, $(this).val().trim());
});
</script>
</body>
</html>
