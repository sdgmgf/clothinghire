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
                    <div role="tabpanel" class="tab-pane active" id="onsale">


                        <form style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>stocktakePackageList/query">

                         <div class="row">
								<label for="start_time" class="col-sm-2 control-label"><h4>发起开始时间</h4></label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo "{$start_time}"; ?>">
								</div>
								<label for="end_time" class="col-sm-2 control-label"><h4>发起结束时间</h4></label>
								<div class="col-sm-3">
									<input required="required" type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($end_time)) echo "{$end_time}"; ?>">
								</div>
							</div>
							<div class="row">
								<label class="col-sm-2 control-label"><h4>盘点状态</h4></label>
								<div class="col-sm-3">
									<select  style="width: 50%;"  name="status" id="status" class="form-control" >
									    <option value="all" <?php if (!isset($status) || $status == "all") echo "selected='true'"?>> 全部</option>
		                                <option value="0"  <?php if(isset($status) && intval($status) === 0) echo "selected='true'" ?>> 待盘点</option>
                                		<option value="1"  <?php if(isset($status) && intval($status) === 1) echo "selected='true'" ?>> 待审核</option>
                                		<option value="2"  <?php if(isset($status) && intval($status) === 2) echo "selected='true'" ?>> 已审核</option>
                                    </select>
								</div>
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
							</div>
							
							<div class="row">
								<label class="col-sm-2 control-label"><h4>商品名称</h4></label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="product_name" value="<?php if(isset($product_name)) echo "{$product_name}"; ?>">
								</div>
							</div>
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                </div>
                                <!-- 隐藏的 input  start  -->
                                <input type="hidden"  <?php if(isset($refund_start)) echo "value='{$refund_start}'"; ?> id="hide_start_time" >
                                <input type="hidden"  <?php if(isset($refund_end)) echo "value='{$refund_end}'"; ?> id="hide_end_time" >
                                <input type="hidden" name="act" id="act">
                                <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> > 
                                <input type="hidden"  id="page_count" name="page_count"  <?php if(isset($page_count)) echo "value={$page_count}"; ?> >
                                <input type="hidden" id="need_transaction" name="need_transaction" value="<?php if(isset($need_transaction)) echo $need_transaction?>" >;
                                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> > 
                                <!-- 隐藏的 input  end  -->
                         </div>

                        </form>
        			</div>
<br/>
<br/>
					<table class="table table-striped table-bordered ">
						<thead>
							<thead>
                                    <tr>
                                        <th rowspan="2" style="width: 5%;">仓库</th>
                                        <th rowspan="2" style="width: 5%;">PRODUCT_ID</th>
                                        <th rowspan="2" style="width: 10%;">虚拟商品 </th>
                                        <th rowspan="2" style="width: 5%;">暗语 </th>
                                        <th colspan="4" style="width: 10%;">实体商品</th>
                                        <th rowspan="2" style="width: 2%;">包裹数</th>
                                        <th rowspan="2" style="width: 2%;">差异包裹数</th>
                                        <th rowspan="2" style="width: 22%;">备注</th>
                                        <th rowspan="2" style="width: 5%;">状态</th>
                                        <th rowspan="2" style="width: 5%;">发起人</th>
                                        <th rowspan="2" style="width: 5%;">发起时间</th>
                                        <th rowspan="2" style="width: 5%;">执行人</th>
                                        <th rowspan="2" style="width: 5%;">执行时间</th>
                                        <th rowspan="2" style="width: 5%;">审核人</th>
                                        <th rowspan="2" style="width: 5%;">审核时间</th>
                                        <th rowspan="2" style="width: 5%;">已盘次数</th>
                                        <th rowspan="2" style="width: 5%;">操作</th>
                                    </tr>
                                    <tr>
						            	<th style="text-align: center;">数量</th>
										<th style="text-align: center;">单位</th>
										<th style="text-align: center;">PRODUCT_ID</th>
										<th style="text-align: center;">商品</th>
						            </tr>
                    	</thead>
                    	<tbody>
                    		<?php 
                    			if(!empty($stocktake_list) && isset($stocktake_list)){
                    				foreach ($stocktake_list as $stocktake){
                    					
                    					$rowspans_num = 1;
                    					if(isset($stocktake['raw_material_product_list']) && is_array($stocktake['raw_material_product_list']) && !empty($stocktake['raw_material_product_list'])) {
                    						$rowspans_num = count($stocktake['raw_material_product_list']);
                    					}
                    		?>
                    			<tr>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['facility_name']?></td>
                                    <td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['product_id']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['product_name']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['secrect_code']?></td>
                    					<?php 
				                    		if (isset($stocktake['raw_material_product_list']) && is_array($stocktake['raw_material_product_list']) && ! empty($stocktake['raw_material_product_list'])) {
					                    	?>
						               			<td><?php echo $stocktake['raw_material_product_list'][0]['quantity']?></td>
						                    	<td><?php echo $stocktake['raw_material_product_list'][0]['unit_code']?></td>
						                    	<td><?php echo $stocktake['raw_material_product_list'][0]['product_component_id']?></td>
						                    	<td><?php echo $stocktake['raw_material_product_list'][0]['component_name']?></td>
				                    	<?php } ?>
                    				<td rowspan="<?php echo $rowspans_num?>"><input type="text" id="quantity<?php echo $stocktake['stocktake_package_id'];?>" value="<?php echo intval($stocktake["quantity"])?>" name="quantity" <?php if($stocktake['status'] != 0) echo "disabled";?> style="width: 50px"/></td>
                    				<td rowspan="<?php echo $rowspans_num?>">
                    				<?php 
                            			
                            			if($stocktake['status'] == 1) {
                            				if ($stocktake['variance_quantity'] == 0) {
                            					echo "无差异";
                            				} elseif (abs($stocktake['variance_quantity']) < 5) {
                            					echo "<span style='color:red;font-size:16px;font-weight:bold;'>小于5</span>";
                            				} elseif (abs($stocktake['variance_quantity']) >= 5 && abs($stocktake['variance_quantity']) < 100) {
                            					echo "<span style='color:red;font-size:16px;font-weight:bold;'>大于5，小于100</span>";
                            				} elseif (abs($stocktake['variance_quantity']) >= 100 && abs($stocktake['variance_quantity']) < 1000) {
                            					echo "<span style='color:red;font-size:16px;font-weight:bold;'>大于100，小于1000</span>";
                            				} else {
                            					echo "<span style='color:red;font-size:16px;font-weight:bold;'>大于1000</span>";
                            				}
                            			}
                            			if($stocktake['status'] == 2) {
                            				if ($stocktake['variance_quantity'] == 0) {
                            					echo "无差异";
                            				} else {
                            					echo "<span style='color:red;font-size:16px;font-weight:bold;'>{$stocktake['variance_quantity']}</span>";
                            				}
                            			}
                            			
                            			?>
                    				</td>
                    				<td rowspan="<?php echo $rowspans_num?>"><input  style="width: 100%;" type="text"  id="note<?php echo $stocktake['stocktake_package_id'];?>" value="<?php echo $stocktake["note"]?>" name="note" <?php if($stocktake['status'] != 1) echo "disabled";?> style="width: 70px"/></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php 
                    					if (intval($stocktake['status']) === 0) {
                    						echo "待录入";
                    					} elseif (intval($stocktake['status']) === 1) {
                    						echo "待确认";
                    					} else {
                    						echo "已调整";
                    					}
                    			?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['created_user']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['created_time']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['execute_user']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['execute_time']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['check_user']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['check_time']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>"><?php echo $stocktake['execute_count']?></td>
                    				<td rowspan="<?php echo $rowspans_num?>">
                    					<?php if ($this->helper->chechActionList(array('executeStocktake')) && intval($stocktake['status']) === 0) {?>
                            				<button type="button" class="btn btn-primary btn-sm"  onClick="executeStocktakePackage(this, '<?php echo $stocktake['stocktake_package_id'];?>');" >录入结果</button>
                            				<?php 
                            			}?>
                            			<?php if ($this->helper->chechActionList(array('checkStocktake')) && intval($stocktake['status']) === 1) {?>
                            				<button type="button" class="btn btn-success btn-sm"  onClick="checkStocktake(this, '<?php echo $stocktake['stocktake_package_id'];?>','APPROVE', '<?php echo $stocktake['variance_quantity']?>');" >确认并调整库存</button><br/>
                            				<?php 
                            			}?>
                            			<?php if ($this->helper->chechActionList(array('resetStocktake')) && intval($stocktake['status']) === 1 && intval($stocktake['execute_count']) <= 2) {?>
                            				<button type="button" class="btn btn-warning btn-sm" id="checkStocktake<?php echo $stocktake['stocktake_package_id'];?>"  onClick="checkStocktake(this, '<?php echo $stocktake['stocktake_package_id'];?>','DISAPPROVE');" >重新盘</button>
                            				<?php 
                            			}?>
                    				</td>
                    			</tr>
                    			
                    			<?php 
                    		if ($rowspans_num > 1) {
                    			foreach ($stocktake['raw_material_product_list'] as $key=>$raw_material_product) {
                    				if($key == 0)
                    					continue;
			                    	?>
			                    	<tr>
			                    	<td><?php echo $raw_material_product['quantity']?></td>
			                    	<td><?php echo $raw_material_product['unit_code']?></td>
			                    	<td><?php echo $raw_material_product['product_component_id']?></td>
			                    	<td><?php echo $raw_material_product['component_name']?></td>
			                    	</tr>
		                    	<?php } }?>
                    		<?php
                    			 	}
                    			}
                    		?>
                    		
                    	</tbody>
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
	</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    var WEB_ROOT = "<?php echo $WEB_ROOT; ?>",
        def = (function(){
        var pro = $.ajax({
            url: WEB_ROOT+'stocktakePackageList/getProductList',
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
});

function executeStocktakePackage(button,stocktake_package_id) {
	var quantity = $("#quantity" + stocktake_package_id).val();
	
	if (quantity == null || quantity == "" || isNaN(quantity) || quantity < 0 || parseInt(quantity) != quantity) {
		alert("请输入正确的数量数");
		return ;
	}
	
	$(button).attr("disabled", true);
	var mydata = {
			"stocktake_package_id" : stocktake_package_id,
			"quantity" : quantity
			};
	var myurl = $("#WEB_ROOT").val()+"stocktakePackageList/executeStocktakePackage";
	if (confirm("确定吗？")) {
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
	          if(data.data.result == "ok"){
	          	window.location.reload();
	          }else{
	            alert("录入失败"+data.error_info);
	           $('#btnDistribute').removeAttr("disabled");
	          }
	      });
	} else {
		return ;
	}
}

function checkStocktake(button,stocktake_package_id,check, variance_quantity) {
	var note = "";
	if (check == "DISAPPROVE") {
		if (! confirm("真的要重新盘吗？")) {
			return ;
		}
	} else {
		if (parseFloat(variance_quantity) != 0) {
			note = $("#note" + stocktake_package_id).val().trim();
			if (note == null || note == "") {
				alert("请输入备注");
				return ;
			} 
		}
	}
	
	$(button).attr("disabled", true);
	$("#checkStocktake" + stocktake_package_id).attr("disabled", true);
	var myurl = $("#WEB_ROOT").val()+"stocktakePackageList/checkStocktakePackage";
    var mydata = {
      "stocktake_package_id":stocktake_package_id,
      "check":check,
      "note":note,
    }; 
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
          if(data.result == "ok"){
          	window.location.reload();
          }else{
            alert("操作失败"+data.error_info);
            $(button).removeAttr("disabled");
			$("#checkStocktake" + stocktake_package_id).removeAttr("disabled");
          }
      });
}
</script>
</body>
</html>
