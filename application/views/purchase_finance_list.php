<!doctype html>
<html>
<head>
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <style type="text/css">
    .button_margin {
        margin: 8%;
       }
    </style>
</head>
<body>
<?php  $CI =& get_instance();
       $CI->load->library('session');?>
<div style="width: 98%;margin: 10px;">
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active">
			<form method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>purchaseFinanceList/query">
				<div class="row">
					<label for="facilitySel" class="col-sm-2 control-label">仓库:</label>
					<div class="col-sm-3">
						<select class="form-control" name="facility_id" id="facilitySel">
							<?php 
							if ($this->helper->chechActionList(array('purchaseFinanceList')) || $this->helper->chechActionList(array('purchaseManager'))) {
								echo "<option value=\"\" >全部</option>";
							}
								foreach ($facility_list as $facility){
									if (isset ($facility_id) && $facility['facility_id'] == $facility_id) {
										echo "<option value=\"{$facility['facility_id']}\" selected>{$facility['facility_name']}</option>";
									}else {
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								}
							?>
						</select>
					</div>
					<label for="product_name" class="col-sm-2 control-label">商品:</label>
					<div class="col-sm-3">
						<input type="text" class="form-control"  style="width: 50%;" name="product_name" id="product_name" 
                                            <?php if(isset($product_name)) echo "value='{$product_name}'"; ?>  >
					</div>
				</div>
					<div class="row">
						<label for="" class="col-sm-2 control-label">状态:</label>
						<div class="col-sm-3">
							<select id="statusSel" name="status" class="form-control">
								<option value="INIT" <?php if(isset($status) && $status == "INIT") echo "selected";?>>待申请</option>
								<option value="APPLIED" <?php if(isset($status) && $status == "APPLIED") echo "selected";?>>已申请</option>
								<option value="MANAGERCHECKED" <?php if(isset($status) && $status == "MANAGERCHECKED") echo "selected";?>>区总成功</option>
								<option value="MANAGERCHECKFAIL" <?php if(isset($status) && $status == "MANAGERCHECKFAIL") echo "selected";?>>区总失败</option>
								<option value="DIRECTORCHECKED" <?php if(isset($status) && $status == "DIRECTORCHECKED") echo "selected";?>>主管审批成功</option>
								<option value="DIRECTORCKFAIL" <?php if(isset($status) && $status == "DIRECTORCKFAIL") echo "selected";?>>主管审批失败</option>
								<option value="FREEZED" <?php if(isset($status) && $status == "FREEZED") echo "selected";?>>已冻结</option>
								<option value="CHECKED" <?php if(isset($status) && $status == "CHECKED") echo "selected";?>>财务已确认</option>
								<option value="CHECKFAIL" <?php if(isset($status) && $status == "CHECKFAIL") echo "selected";?>>审核作废</option>
								<option value="PAID" <?php if(isset($status) && $status == "PAID") echo "selected";?>>财务已支付</option>
							</select>
						</div>
						<label for="asn_date_start" class="col-sm-2 control-label">ASN开始日期:</label>
						<div class="col-sm-3">
							<input class="form-control"  id="asn_date_start" name="asn_date_start" value="<?php if(isset($asn_date_start)) echo $asn_date_start;?>" autocomplete="off"/>
						</div>
					</div>
					<div class="row">
						<label for="product_type" class="col-sm-2 control-label">产品类型:</label>
						<div class="col-sm-3">
							<select style="width:200px" name="product_type" id="product_type" class="form-control">
                                    	<?php
								foreach ($product_type_list as $item) {
									if (isset ($product_type) && $item['product_type'] == $product_type) {
										echo "<option value=\"{$item['product_type']}\" selected='true'>{$item['product_type_name']}</option>";
									} else {
										echo "<option value=\"{$item['product_type']}\">{$item['product_type_name']}</option>";
									}
								}
								?>
                               </select>
						</div>
						<label for="asn_date_end" class="col-sm-2 control-label">ASN结束日期:</label>
						<div class="col-sm-3">
							<input class="form-control"  id="asn_date_end" name="asn_date_end" value="<?php if(isset($asn_date_end)) echo $asn_date_end;?>" autocomplete="off"/>
						</div>
					</div>
					<div class="row">
						<label for="asn_item_id" class="col-sm-2 control-label">ASN ITEM ID:</label>
						<div class="col-sm-3">
							<input class="form-control"  id="asn_item_id" name="asn_item_id" value="<?php if(isset($asn_item_id)) echo $asn_item_id;?>"/>
						</div>
						<label for="apply_user" class="col-sm-2 control-label">申请人:</label>
						<div class="col-sm-3">
							<input class="form-control"  id="apply_user" name="apply_user" value="<?php if(isset($apply_user)) echo $apply_user;?>"/>
						</div>
					</div>
					<div class="row" style="text-align: center;">
						<input type="button" class="btn btn-primary" id="search" value="搜索"/>
						<input type="button" class="btn btn-primary" id="download" value="导出"/>
						</div>
					
					<div style="width: 100px;margin: 0 auto;">
						<input type="hidden"  id="act" name="act"  >
						<input type="hidden"  id="page_current" name="page_current"  
                        	<?php if(isset($page_current)) echo "value={$page_current}"; ?> /> 
                    	<input type="hidden"  id="page_count" name="page_count"  
                        	<?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                    	<input type="hidden"  id="page_limit" name="page_limit"
                        	<?php if(isset($page_limit)) echo "value={$page_limit}"; ?> /> 
                    	<!-- 隐藏的 input  end  -->
					</div>
			</form>
		</div>
	</div>
	虚拟仓入库数量 = 实体仓入库数量+虚拟仓在途盘亏数量+虚拟仓暂存盘亏数量+虚拟仓供应商退货数量<br/>
   \只能查看用户自己拥有的条目
	<table class="table table-striped table-bordered " style="width: 100%;margin-top:10px;margin-right:10px;">
		<tr>
			<th rowspan="2">ASN ITEM ID</th>
			<th rowspan="2">ASN日期</th>
			<th rowspan="2">区域</th>
			<th rowspan="2">仓库</th>
			<th rowspan="2">商品名称</th>
			<th rowspan="2">PRODUCT_ID</th>
            <th rowspan="2">采购员</th>
            <th rowspan="2">供应商</th>
			<th rowspan="2">申请人</th>
			<th colspan="6" style="text-align: center;">采购</th>
			<th colspan="6" style="text-align: center;">调度</th>
			<th colspan="8" style="text-align: center;">仓库</th>
			<th rowspan="2">入库总金额</th>
			<th colspan="7" style="text-align: center;">供应商退货</th>
			<th rowspan="2">单位</th>
			<th rowspan="2">区总备注</th>
			<th rowspan="2">主管审核备注</th>
			<th rowspan="2">审核作废备注</th>
			<th rowspan="2">操作</th>
		</tr>
		<tr>
			<th>时间</th>
			<th>价格录入员</th>
			<th>总数</th>
			<th>箱数</th>
			<th>录价格箱数</th>
			<th>箱规</th>
			<th>总箱数</th>
			<th>虚拟仓在途盘亏数量</th>
			<th>虚拟仓暂存盘亏数量</th>
			<th>时间</th>
			<th>箱数</th>
			<th>入库员</th>
			<th>总数</th>
			<th>总箱数</th>
			<th>时间</th>
			<th>仓库</th>
			<th>箱数</th>
			<th>箱规</th>
			<th>入库员</th>
			<th>入库单价</th>
			<th>类型</th>
			<th>单价</th>
			<th>箱数</th>
			<th>箱规</th>
            <th>申请总金额</th>
            <th>退货金额</th>
            <th>收款总金额</th>
		</tr>
        <tbody >
	        <?php 
	        function min_multiple($a, $b) {
	        	//将初始值保存起来
	        	$i = $a;
	        	$j = $b;
	        	//辗转相除法求最大公约数
	        	while ($b <> 0) {
	        		$p = $a % $b;
	        		$a = $b;
	        		$b = $p;
	        	}
	        	return $i * $j / $a;
	        }
	        if( isset($purchase_finance_price_list) && is_array($purchase_finance_price_list))  foreach ($purchase_finance_price_list as $key => $order) { 
	        	$inventory_count = count($order['inventory_list']);
	        	$virtual_inventory_count = count($order['virtual_inventory_list']);
	        	$supplier_return_count = count($order['supplier_return_list']);
	        	
	        	if($inventory_count == 0) {
	        		$inventory_count = 1;
	        	} 
	        	if($virtual_inventory_count == 0) {
	        		$virtual_inventory_count = 1;
	        	}
	        	if($supplier_return_count == 0) {
	        		$supplier_return_count = 1;
	        	}
	        	$rowspans = min_multiple($inventory_count, $virtual_inventory_count);
	        	$rowspans = min_multiple($rowspans, $supplier_return_count);
	        	$virtual_rowspans = $rowspans/$virtual_inventory_count;
	        	$general_rowspans = $rowspans/$inventory_count;
	        	$supplier_rowspans = $rowspans/$supplier_return_count;
	        	?> 
        	<tr <?php if (!$order['is_identity_ok']) echo "style=\"color: red;\""?> >
        	<td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['asn_item_id'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['asn_date'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['area_name'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['facility_name'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['product_name'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['product_id'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_user'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['product_supplier_name'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo !empty($order['apply_user']) ? $order['apply_user'] : ''; ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['created_time'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['created_user'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_total_num'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_case_num'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['price_case_num'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_container_quantity'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['virtual_arrival_case_num'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['in_transit_variance_quantity'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['in_stock_variance_quantity'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $virtual_rowspans?>" class="product_cell">
                <?php echo !empty($order['virtual_inventory_list'][0]['created_time'])?$order['virtual_inventory_list'][0]['created_time']:'' ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $virtual_rowspans?>" class="product_cell">
                <?php echo !empty($order['virtual_inventory_list'][0]['quantity'])? sprintf("%.2f", $order['virtual_inventory_list'][0]['quantity']):0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $virtual_rowspans?>" class="product_cell">
                <?php echo !empty($order['virtual_inventory_list'][0]['created_user'])?$order['virtual_inventory_list'][0]['created_user']:0 ?>  
            </td>
            
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['arrival_real_quantity'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['arrival_case_num'] ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php echo !empty($order['inventory_list'][0]['created_time'])?$order['inventory_list'][0]['created_time']:'' ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php echo !empty($order['inventory_list'][0]['facility_name'])?$order['inventory_list'][0]['facility_name']:'' ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php echo !empty($order['inventory_list'][0]['quantity'])?sprintf("%.2f", $order['inventory_list'][0]['quantity']):0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php echo !empty($order['inventory_list'][0]['unit_quantity'])?$order['inventory_list'][0]['unit_quantity']:0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php echo !empty($order['inventory_list'][0]['created_user'])?$order['inventory_list'][0]['created_user']:0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
                <?php
					if(!empty($order['inventory_list'][0]['unit_price'])) {
						echo $order['inventory_list'][0]['unit_price'];
					} elseif(!empty($order['inventory_list'][0]['estimated_unit_price'])) {
						echo $order['inventory_list'][0]['estimated_unit_price'];
					} else {
						echo 0;
					}
               ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_total_price'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php
                if( ! empty($order['supplier_return_list'][0]['return_type'])) {
                	if ($order['supplier_return_list'][0]['return_type'] == "exchange")
                		echo "换货";
                	else if ($order['supplier_return_list'][0]['return_type'] == "return")
                		echo "退货";
                	else if ($order['supplier_return_list'][0]['return_type'] == "sale")
                		echo "销售";
                } else {
                	echo "";
                }
                ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['unit_price'])?$order['supplier_return_list'][0]['unit_price']:'' ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['quantity'])?$order['supplier_return_list'][0]['quantity']:'' ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['container_quantity'])?$order['supplier_return_list'][0]['container_quantity']:0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['apply_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['apply_amount']):0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['transaction_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['transaction_amount']):0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                <?php echo !empty($order['supplier_return_list'][0]['finance_amount'])?sprintf('%.2f',$order['supplier_return_list'][0]['finance_amount']):0 ?>  
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['product_unit_code'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_manager_note'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['purchase_director_note'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
                <?php echo $order['note'] ?>
            </td>
            <td style="vertical-align:middle;" rowspan="<?php echo $rowspans?>" class="product_cell">
            	<?php if ($this->helper->chechActionList(array('purchaseFinanceApply')) && ($status == "INIT" || $status == 'CHECKFAIL' || $status == 'MANAGERCHECKFAIL' || $status == 'DIRECTORCKFAIL') && $CI->session->userdata('username') == $order['created_user']) {?>
    				<button type="button" class="btn btn-primary btn-sm"  onClick="purchaseFinance('apply', this, '<?php echo $order['asn_item_id'];?>');" >申请</button>
    			<?php }?>
    			<?php if ($this->helper->chechActionList(array('purchaseManagerCheckPurchaseFinance')) && $status == "APPLIED") {?>
    				<button type="button" class="btn btn-success btn-sm button_margin"  onClick="purchaseFinance('purchaseManagerChecked', this, '<?php echo $order['asn_item_id'];?>');" >区总通过</button></br>
    				<button type="button" class="btn btn-danger btn-sm button_margin"  onClick="purchaseFinance('purchaseManagerCheckfail', this, '<?php echo $order['asn_item_id'];?>');" >区总失败</button>
    				<?php 
    			}?>
    			<?php if ($this->helper->chechActionList(array('purchaseDirectorCheckPurchaseFinance')) && $status == "MANAGERCHECKED") {?>
    				<button type="button" class="btn btn-success btn-sm button_margin"  onClick="purchaseFinance('purchaseDirectorChecked', this, '<?php echo $order['asn_item_id'];?>');" >主管审批通过</button></br>
    				<button type="button" class="btn btn-danger btn-sm button_margin"  onClick="purchaseFinance('purchaseDirectorCheckfail', this, '<?php echo $order['asn_item_id'];?>');" >主管审批失败</button>
    				<?php 
    			}?>
    			<?php if ($this->helper->chechActionList(array('purchaseFinance')) && $status == "DIRECTORCHECKED") {?>
    				<button type="button" class="btn btn-primary btn-sm"  onClick="purchaseFinance('freezed', this, '<?php echo $order['asn_item_id'];?>');" >冻结</button>
                    <?php
                }?>
                <?php if ($this->helper->chechActionList(array('purchaseFinance')) && $status == "FREEZED") {?>
    				<button type="button" class="btn btn-success btn-sm button_margin"  onClick="purchaseFinance('checked', this, '<?php echo $order['asn_item_id'];?>');" >确认</button>
    				<br>
    				<button type="button" class="btn btn-danger btn-sm button_margin"  onClick="purchaseFinance('checkfail', this, '<?php echo $order['asn_item_id'];?>');" >作废</button>
    				<?php 
    			}?>
    			<?php if ($this->helper->chechActionList(array('purchaseFinance')) && $status == "CHECKED") {?>
    				<button type="button" class="btn btn-success btn-sm"  onClick="purchaseFinance('paid', this, '<?php echo $order['asn_item_id'];?>');" >支付</button>
    				<?php 
    			}?>
            </td>
            </tr>
            
            <?php for($i=1; $i< $rowspans; $i++) {
            	?>
            <tr <?php if (!$order['is_identity_ok']) echo "style=\"color: red;\""?>>
            	<?php if($i % $virtual_rowspans == 0) {?>
            	<td rowspan="<?php echo $virtual_rowspans ?>" class="product_cell">
	             <?php echo !empty($order['virtual_inventory_list'][$i/$virtual_rowspans]['created_time'])?$order['virtual_inventory_list'][$i/$virtual_rowspans]['created_time']:'' ?> 
	            </td>
	            <td rowspan="<?php echo $virtual_rowspans ?>" class="product_cell">
	             <?php echo !empty($order['virtual_inventory_list'][$i/$virtual_rowspans]['quantity'])?sprintf("%.2f",$order['virtual_inventory_list'][$i/$virtual_rowspans]['quantity']):0 ?> 
	            </td>
	            <td rowspan="<?php echo $virtual_rowspans ?>" class="product_cell">
	              <?php echo !empty($order['virtual_inventory_list'][$i/$virtual_rowspans]['created_user'])?$order['virtual_inventory_list'][$i/$virtual_rowspans]['created_user']:0 ?>  
	            </td>
	            <?php }?>
	            <?php if($i % $general_rowspans == 0) {?>
	            <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
	            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['created_time'])?$order['inventory_list'][$i/$general_rowspans]['created_time']:'' ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
	            <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['facility_name'])?$order['inventory_list'][$i/$general_rowspans]['facility_name']:'' ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
	             <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['quantity'])?sprintf("%.2f",$order['inventory_list'][$i/$general_rowspans]['quantity']):0 ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $general_rowspans ?>">
	              <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['unit_quantity'])?$order['inventory_list'][$i/$general_rowspans]['unit_quantity']:0 ?>  
	            </td>
	            <td rowspan="<?php echo $general_rowspans?>" class="product_cell">
	              <?php echo !empty($order['inventory_list'][$i/$general_rowspans]['created_user'])?$order['inventory_list'][$i/$general_rowspans]['created_user']:0 ?>  
	            </td>
	            <td style="vertical-align:middle;" rowspan="<?php echo $general_rowspans?>" class="product_cell">
	              <?php 
	              if(!empty($order['inventory_list'][$i/$general_rowspans]['unit_price'])) {
	              	echo $order['inventory_list'][$i/$general_rowspans]['unit_price'];
	              } elseif(!empty($order['inventory_list'][$i/$general_rowspans]['estimated_unit_price'])) {
	              	echo $order['inventory_list'][$i/$general_rowspans]['estimated_unit_price'];
	              } else {
	              	echo 0;
	              }
	             ?>  
            	</td>
	            <?php }?>
	            <?php if($i % $supplier_rowspans == 0) {?>
	            <td style="vertical-align:middle;" rowspan="<?php echo $supplier_rowspans?>" class="product_cell">
                  <?php
                if( ! empty($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'])) {
                	if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "exchange")
                		echo "换货";
                	else if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "return")
                		echo "退货";
                	else if ($order['supplier_return_list'][$i/$supplier_rowspans]['return_type'] == "sale")
                		echo "销售";
                } else {
                	echo "";
                }
                ?>
            	</td>
	            <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
	            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['unit_price'])?$order['supplier_return_list'][$i/$supplier_rowspans]['unit_price']:'' ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
	            <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['quantity'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['quantity']):'' ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
	             <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['container_quantity'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['container_quantity']):'' ?> 
	            </td>
	            <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
	              <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['apply_amount'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['apply_amount']):'' ?> 
	            </td>
                <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                  <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['transaction_amountfinance_amount'])?sprintf("%.2f",$order['supplier_return_list'][$i/$supplier_rowspans]['transaction_amountfinance_amount']):'' ?> 
                </td>
                <td class="product_cell"  rowspan="<?php echo $supplier_rowspans ?>">
                  <?php echo !empty($order['supplier_return_list'][$i/$supplier_rowspans]['finance_amount'])?$order['supplier_return_list'][$i/$supplier_rowspans]['finance_amount']:'' ?> 
                </td>
	            <?php }?>
            </tr>
            <?php }?>
            <?php }?>
        </tbody>
		
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
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
var property={
	    divId:"demo1",
	    needTime:true,
	    yearRange:[1970,2030],
	    week:['日','一','二','三','四','五','六'],
	    month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
	    format:"yyyy-MM-dd hh:mm:00"
	};

	(function(config){
	    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
	    config['lock'] = true;
	    config['fixed'] = true;
	    config['okVal'] = 'Ok';
	    config['format'] = 'yyyy-MM-dd HH:mm:ss';
	    // [more..]
	})($.calendar.setting);


	$(document).ready(function(){
	    $("#asn_date_start").calendar({btnBar:true,
	                               minDate:'2010-05-01', 
	                               maxDate:'2022-05-01'});
	    $("#asn_date_end").calendar({  btnBar:true,
	                               minDate:'#asn_date_start',
	                               maxDate:'2022-05-01'});
       $("#asn_date").calendar({  btnBar:true,
	                               minDate:'2010-05-01',
	                               maxDate:'2022-05-01',
	                               format:'yyyy-MM-dd'});
	}) ;  // end document ready function 
	
	var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";

	// 点击下载 excel 按钮 
    $('#download').click(function(){
       $("#act").val("download");
       $("form").submit();
       $("#act").val("query");
    }); 
	
	function purchaseFinance(action, button, asn_item_id){
		var note = null;
		var btn = $(this);
		if (action == "checkfail" || action == "purchaseDirectorCheckfail" || action == "purchaseManagerCheckfail") {
			note = prompt("请输入原因");
	     	if(note == null){
	     	    return ;
	     	} 
		} else {
			note = "";
		}
     	  $(button).attr("disabled", true);
          var myurl = WEB_ROOT+"purchaseFinanceList/" + action;
          var mydata = {
                      "asn_item_id":asn_item_id,
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
              if(data.result == "ok"){
                  alert('操作成功');
                 $(button).parent().parent().remove();
              }else{
                alert("操作失败"+data.error_info);
                $(button).removeAttr("disabled");
              }
          }).fail(function(data){
              console.log(data);
                alert('操作失败');
                $(button).removeAttr("disabled");
            });
     }
	
	$("#search").click(function(){
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
	$("#asn_item_id").keyup(function(){
		this.value=this.value.replace(/\D/g,"");
	});
</script>
</body>
</html>
