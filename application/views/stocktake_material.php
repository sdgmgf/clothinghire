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
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
                <!-- Tab panes -->
                <div class="tab-content">
                	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>stocktakeMaterialList/index">
                    
							<div class="row">
								<label for="start_time" class="col-sm-2 control-label"><h4>仓库</h4></label>
								<div class="col-sm-3">
									<select  style="width: 50%;" name="facility_id" id="facility_id" class="form-control">
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
								<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
								<div class="col-sm-3">
									<input type="text" style="width: 50%;" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
								</div>
							</div>
							
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="submit" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                    <?php if (!empty ($product_list)&&$product_type=='supplies') {?>
                                    <button type="button" style="margin-left: 20px;" class="btn btn-primary btn-sm"  id="total_submit" onclick="createStocktakeMaterialBatch(this);" >全部发起盘点 </button>
                                    <?php }?>
                                    <input type="hidden"  id="product_type" name="product_type"
                                        <?php if(isset($product_type)) echo "value='{$product_type}'"; ?> /> 
                                </div>
                         </div>
                 	</form>
                    
                    
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                        	<form method="post" action="">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>PRODUCT_ID</th>
                                        <th>商品</th>
                                        <th>仓储单位</th>
                                        <th>规格</th>
                                        <th>仓库</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($product_list)) {
									foreach ($product_list as $product) {
								?>
                            		<tr>
                                        <td class="product_cell"><?php echo $product['product_id']?></td>
                            			<td class="product_cell"><?php echo $product['product_name']?></td>
                                        <td class="product_cell"><?php echo $product['container_unit_code_name']?></td>
                            			<td class="product_cell"><?php echo $product['quantity'] . $product['unit_code_name'] .'/'. $product['container_unit_code_name']?></td>
                            			<td class="product_cell"><?php 
										foreach ($facility_list as $facility) {
											if ($facility['facility_id'] == $facility_id) {
												echo $facility['facility_name'];
											}
										}

?></td>
                            			<td class="product_cell">
                            			<input type="hidden" name="product_ids[]" value="<?php echo  $product['product_id'];?>" />
                            			<button type="button" class="btn btn-primary btn-sm"  onClick="createStocktakeMaterial(this, <?php echo $product['product_id'];?>, <?php echo $product['container_id'];?>);">发起盘点</button></td>
                            		</tr>
                            	<?php


									}
								}
								?>
                                                            
                            </table>
                            </form>
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script>
var WEB_ROOT = "<?php echo $WEB_ROOT; ?>",
    def = (function(){
    var pro = $.ajax({
        url: WEB_ROOT+'BadProduct/getProductList',
        type: 'GET',
        dataType: 'json'
    });
    return pro;
})(jQuery);
def.then(function(data){
    if(data['success'] === 'success' ){
        $('#product_name').autocomplete(data.product_list, {
            minChars: 0,
            width: 310,
            max: 100,
            matchContains: true,
            autoFill: false,
            formatItem: function(row, i, max) {
                return row.product_id + "[" + row.product_name + "]";
            },
            formatMatch: function(row, i, max) {
                return row.product_id + "[" + row.product_name + "]";
            },
            formatResult: function(row) {
                return row.product_id + "[" + row.product_name + "]";
            }
        }).result(function(event, row, formatted){
            $(this).val(row.product_name);
        });
    }
});
function createStocktakeMaterial(button, product_id, container_id) {
	$(button).attr("disabled", true); 
	var facility_id = "<?php echo isset($facility_id) ? $facility_id : "0";?>";
	
	var myurl = $("#WEB_ROOT").val()+"stocktakeMaterialList/createStocktakeMaterial";
	var mydata = {
	    "product_id":product_id,
	    "container_id":container_id,
	    "facility_id":facility_id,
	  }; 
	  
	  console.log(mydata);
	  $.ajax({
	      url: myurl,
	      type: 'POST',
	      data:mydata, 
	      dataType: "json", 
	      xhrFields: {
	           withCredentials: true
	      }
	}).done(function(data){
		console.log(data);
		if(data.success == "OK"){
            window.location.reload();
        }else{
          alert("发起盘点失败"+data.error_info);
        }
	});
	
}

function createStocktakeMaterialBatch(button) {
	$(button).attr("disabled",true);
		var facility_id = "<?php echo isset($facility_id) ? $facility_id : "0";?>";
		var product_type = "<?php echo isset($product_type) ? $product_type : null;?>";
		var myurl = $("#WEB_ROOT").val()+"stocktakeMaterialList/createStocktakeMaterialBatch";
		var mydata = {
		    "facility_id":facility_id,
		    "product_type":product_type
		  }; 
		  
		  console.log(mydata);
		$.ajax({
		      url: myurl,
		      type: 'POST',
		      data:mydata, 
		      dataType: "json", 
		      xhrFields: {
		           withCredentials: true
		      }
		}).done(function(data){
			console.log(data);
			if(data.success == "OK"){
	            window.location.reload();
	        }else{
	          alert("发起盘点失败"+data.error_info);
	        }
		});
}		
</script>
</body>
</html>
