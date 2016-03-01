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
                	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>badProduct/query">
                    
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
                                    <input id="cur_facility_id" style="display: none;" <?php if(isset($facility_id)) echo 'value="'.$facility_id.'"';?>>
								</div>
								<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
								<div class="col-sm-3">
									<input type="text" style="width: 50%;" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
								</div>
							</div>
							
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="submit" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                         </div>
                 	</form>
                    
                    
                        <!-- product list start -->
                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th>PRODUCT_ID</th>
                                        <th>商品 </th>
                                        <th>单位</th>
                                        <th>仓库</th>
                                        <th>坏果操作</th>
                                        <th>次果操作</th>
                                    </tr>
                                </thead>
                            	<?php
								if (!empty ($product_list)) {
									foreach ($product_list as $product) {
								?>
                            		<tr>
                            			<td class="product_cell"><?php echo $product['product_id']?></td>
                            			<td class="product_cell"><?php echo $product['product_name']?></td>
                            			<td class="product_cell"><?php echo $product['unit_code']?></td>
                            			<td class="product_cell"><?php 
										foreach ($facility_list as $facility) {
											if ($facility['facility_id'] == $facility_id) {
												echo $facility['facility_name'];
											}
										}?></td>
                            			<td class="product_cell"><button type="button" class="btn btn-primary btn-sm"  onClick="recordBadProduct(this, <?php echo $product['product_id'];?>);" <?php if($product['bad_recorded']=='true') echo 'disabled="'.$product['bad_recorded'].'"';?> >录入坏果</button></td>
                                        <td class="product_cell"><button type="button" class="btn btn-primary btn-sm"  onClick="recordDefectiveProduct(this, <?php echo $product['product_id'];?>);" <?php if($product['defective_recorded']=='true') echo 'disabled="'.$product['defective_recorded'].'"';?> >录入次果</button></td>
                            		</tr>
                            	<?php }}?>
                            </table>
                        </div>
                        <!-- product list end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="bad-product-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">坏果录入</h4>
      </div>
      
      <div class="modal-body">
        <div class="container">

            <div class="row col-md-10">
                         
             <div class="col-md-2">
                   <h5>  坏果量: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control"  id="quantity">
                   <input type="text"  class="form-control"  id="product_id" style="display: none;" >
            		<input type="text"  class="form-control"  id="mod_facility_id" style="display: none;" >  
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row col-md-10">
                <div class="col-md-2">
                   <h5>  备注: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control" id="badproduct_note">
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="bad_product_ok" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="defective-product-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">次果录入</h4>
      </div>
      
      <div class="modal-body">
        <div class="container">

            <div class="row col-md-10">
                         
             <div class="col-md-2">
                   <h5>  次果量: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control"  id="defective_quantity">
                   <input type="text"  class="form-control"  id="defective_product_id" style="display: none;" >
            		<input type="text"  class="form-control"  id="defective_mod_facility_id" style="display: none;" >  
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row col-md-10">
                <div class="col-md-2">
                   <h5>  备注: </h5>
                </div>
                <div class="col-md-4" >
                   <input type="text"  class="form-control" id="defectiveproduct_note">
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="defective_product_ok" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
function recordBadProduct(button, product_id) {
	$(button).attr("disabled", true); 
	var facility_id = $("#cur_facility_id").val();
	if(facility_id == null || facility_id == undefined || facility_id == "" || isNaN(facility_id)){
		alert("请查询后，再录入坏果。");return false;
	}
	$("#product_id").val(product_id);
	$("#mod_facility_id").val(facility_id);
	$("#bad-product-modal").modal("show");
}
	$("#bad_product_ok").click(function(){
		var product_id = $("#product_id").val();
		var facility_id = $("#mod_facility_id").val();
		var quantity = $("#quantity").val();
		if(quantity == null || quantity == undefined || quantity == "" || isNaN(quantity) || quantity<0){
			alert("无效的坏果量！");
			return false;
		}
		var myurl = $("#WEB_ROOT").val()+"badProduct/recordBadProduct";
		var mydata = {
		    "product_id":product_id,
		    "facility_id":facility_id,
		    "quantity":quantity,
		    "note":$("#badproduct_note").val()
		  }; 
		  $.ajax({
		      url: myurl,
		      type: 'POST',
		      data: mydata, 
		      dataType: "json", 
		      xhrFields: {
		           withCredentials: true
		      }
		}).done(function(data){
			if(data.success == "true"){
	            window.location.reload();
	        }else{
	          alert("坏果录入失败: "+data.error_info);
	        }
		});	
});

function recordDefectiveProduct(button, product_id) {
	$(button).attr("disabled", true); 
	var facility_id = $("#cur_facility_id").val();
	if(facility_id == null || facility_id == undefined || facility_id == "" || isNaN(facility_id)){
		alert("请查询后，再录入次果。");return false;
	}
	$("#defective_product_id").val(product_id);
	$("#defective_mod_facility_id").val(facility_id);
	$("#defective-product-modal").modal("show");
}
$("#defective_product_ok").click(function(){
		var product_id = $("#defective_product_id").val();
		var facility_id = $("#defective_mod_facility_id").val();
		var quantity = $("#defective_quantity").val();
		if(quantity == null || quantity == undefined || quantity == "" || isNaN(quantity) || quantity<0){
			alert("无效的次果量！");
			return false;
		}
		var myurl = $("#WEB_ROOT").val()+"badProduct/recordDefectiveProduct";
		var mydata = {
		    "product_id":product_id,
		    "facility_id":facility_id,
		    "quantity":quantity,
		    "note":$("#defectiveproduct_note").val()
		  }; 
		  $.ajax({
		      url: myurl,
		      type: 'POST',
		      data: mydata, 
		      dataType: "json", 
		      xhrFields: {
		           withCredentials: true
		      }
		}).done(function(data){
			if(data.success == "true"){
	            window.location.reload();
	        }else{
	          alert("次果录入失败: "+data.error_info);
	        }
		});	
});

</script>
</body>
</html>
