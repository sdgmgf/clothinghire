<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="assets/css/normalize.css">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body id="body-menu" style="overflow-y:scroll;">  
<div id="menu-wrap">
    <ul id="main-menu">
    	<?php if($this->helper->chechActionList(array("wuliaoManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>物料管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
	    		<li>
	    			<a href="./loadingBillList" target="main-frame" >bol装车单列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseIn'))) {?>
	    		<li>
	    			<a href="./purchaseIn/index" target="main-frame" >收水果</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('productionOut'))) {?>
	    		<li>
	    			<a href="./productionOut/index" target="main-frame" >产线提货</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('saleReturn'))) {?>
	    		<li>
	    			<a href="./saleReturn/index" target="main-frame" >好果入库</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('packageIn'))) {?>
	    		<li>
	    			<a href="./packageIn/index" target="main-frame" >包裹入库</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('badProduct'))) {?>
	    		<li>
	    			<a href="./badProduct/query" target="main-frame" >坏次果录入</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('stocktakeMaterialList'))) {?>
	    		<li>
	    			<a href="./stocktakeMaterialList/query" target="main-frame" >原料盘点列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('stocktakePackageList'))) {?>
	    		<li>
	    			<a href="./stocktakePackageList/query" target="main-frame" >包裹盘点列表</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
	    		<li>
	    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
	    		</li>
    		<?php }?>
            <?php if($this->helper->chechActionList(array('badProductList'))) {?> 
                <li>
                    <a href="./badProduct/getBadProductList" target="main-frame" >坏次果列表</a>
                </li>
            <?php }?>
    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
	    		<li>
	    			<a href="./supplierReturnList/query?status=CHECKED" target="main-frame" >供应商退货申请列表</a>
	    		</li>
    		<?php }?>
            <?php if($this->helper->chechActionList(array('createStocktakeMaterial'))) {?>
                <li>
                    <a href="./stocktakeMaterialList/index" target="main-frame" >发起原料盘点</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('createStocktakePackage'))) {?>
                <li>
                    <a href="./stocktakePackageList/index" target="main-frame" >发起包裹盘点</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('transferOut'))) {?>
            <li>
    			<a href="./launchTransferInventoryList" target="main-frame" >仓库调拨</a>
    		</li>
	    	<?php }?>
            <?php if($this->helper->chechActionList(array('packageTransformList'))) {?>
            <li>
                <a href="./productTransformApply/packageTransformList" target="main-frame" >包裹转原料申请列表</a>
            </li>
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("shengchanManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>生产管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
	    		<?php if($this->helper->chechActionList(array('printOrderList'))) {?>
    			<li>
    				<a href="./printOrderList" target="main-frame" >生成批拣单</a>
    			</li>
    			<?php }?>
    			
    			<?php if($this->helper->chechActionList(array('batchPickPrint'))) {?>
    			<li>
    				<a href="./batchPickPrint" target="main-frame" >打印面单</a>
    			</li>
    			<?php }?>
                <?php if($this->helper->chechActionList(array('createproductionbatch'))) {?>
                    <li>
                        <a href="./CreateProductionBatch" target="main-frame" >创建波次</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('createproductionbatch'))) {?>
                    <li>
                        <a href="./CreateProductionBatch/orderIndex" target="main-frame" >按订单号创建波次</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('productionbatchlist'))) {?>
                    <li>
                        <a href="./ProductionBatchList" target="main-frame" >任务波次列表</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('shengchanManager'))) {?>
                    <li>
                        <a href="./abnormalShipment" target="main-frame" >异常订单</a>
                    </li>
                <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("fayunManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>发运管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('batchPickDeliver'))) {?>
	    			<li>
	    				<a href="./shipmentShipping/shipPage" target="main-frame" >发货</a>
	    			</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('batchPickDeliver'))) {?>
    			 <li>
    				<a href="./addWaybill" target="main-frame" >生成发运单</a>
    			</li>
	    	<?php }?>
            <?php if($this->helper->chechActionList(array('thermalDashboard'))) {?>
                <li>
                    <a href="./thermalDashboard/query?shipping_id=115" target="main-frame" >中通面单报警</a>
                </li>
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	
    	
    	<?php if($this->helper->chechActionList(array('facilityQuery'))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>仓库查询
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
	    		<?php if($this->helper->chechActionList(array('batchPrintList'))) {?>
	    			<li>
	    				<a href="./batchPrintList" target="main-frame" >待打印批次列表</a>
	    			</li>
	    		<?php }?>
	    		
	    		<?php if($this->helper->chechActionList(array('batchPrintList'))) {?>
	    			<li>
	    				<a href="./shipmentList" target="main-frame" >已打印未发货订单列表</a>
	    			</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('queryTrackingNumber'))) {?>
    			 <li>
    				<a href="./queryTrackingNumber" target="main-frame" >查询面单号</a>
    			</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('queryWaybill'))) {?>
    			 <li>
    				<a href="./waybillList" target="main-frame" >查询发运单</a>
    			</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('trackingPrint'))) {?>
	    			<li>
	    				<a href="./trackingPrint" target="main-frame" >按运单号打印</a>
	    			</li>
	    		<?php }?>
	    		
	    		<?php if($this->helper->chechActionList(array('allBatchPrintList'))) {?>
    			 <li>
    				<a href="./allBatchPrintList" target="main-frame" >查询批次</a>
    			</li>
	    		<?php }?>
                <?php if($this->helper->chechActionList(array('facilityDashboard'))) {?>
                    <li>
                        <a href="./facilityDashboard/query" target="main-frame" >仓库仪表盘</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('productionPlan'))) {?>
                    <li>
                        <a href="./shippingDistributedDetail" target="main-frame" >生产进度</a>
                    </li>
                    <li>
                        <a href="./OrdersNotInFacilityRegion" target="main-frame" >外围件订单</a>
                    </li>
                <?php }?>
    		</ul>
    	</li>
    	<?php }?>
    	
    	
    	<?php if($this->helper->chechActionList(array('ckyyManager'))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>仓库运营
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    			<li>
                <?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
                    <li>
                        <a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
                    <li>
                        <a href="./loadingBillList" target="main-frame" >bol装车单列表</a>
                    </li>
                <?php }?>
                <?php if($this->helper->chechActionList(array('facilityList'))) {?>
                    <li>
                        <a href="./facilityList" target="main-frame" >开仓</a>
                    </li>
                    <li>
                        <a href="./transferFacility/transferFacility" target="main-frame" >转仓</a>
                    </li>
                    <li>
                        <a href="./transferList/transferFacilityList" target="main-frame" >转仓列表</a>
                    </li>
                    <li>
                        <a href="./skuRegionFacility/getNotSetting" target="main-frame" >分仓规则异常</a>
                    </li>
                    <li>
                        <a href="./abnormalShipment" target="main-frame" >异常订单</a>
                    </li>
                <?php }?>
                
	    	</ul>
    	</li>
    	<?php }?>
    	
    	
    	
    	<?php if($this->helper->chechActionList(array("caigouManager"))) {?>
<!--     	<li class="has-sub-menu"> -->
<!--     		<i class="fa fa-chevron-down chevron"></i> -->
<!--     		<a href="#"> -->
<!--     			<i class="fa fa-laptop"></i>采购管理 -->
<!--     		</a> -->
<!--     		<ul class="sub-menu sub-menu-hidden"> -->
    		<?php if($this->helper->chechActionList(array('purchaseCommit'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseCommit" target="main-frame">采购承诺(PO)</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('loadingBill'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./loadingBill" target="main-frame" >创建装车单</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./loadingBillList" target="main-frame" >bol装车单列表</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('asnFinish'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./asnFinish" target="main-frame" >asn预到货通知单</a> -->
<!-- 		    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePrice'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchasePrice" target="main-frame" >采购价格录入</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseFinanceApply')) || $this->helper->chechActionList(array('purchaseManager'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseFinanceList" target="main-frame" >财务申请</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('arnormalBolItemList'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./arnormalBolItemList" target="main-frame" >bol异常清单</a> -->
<!-- 		    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a> -->
<!-- 	    		</li> -->
    		<?php }?>
            <?php if($this->helper->chechActionList(array('badProductList'))) {?>
<!--                 <li> -->
<!--                     <a href="./badProduct/getBadProductList" target="main-frame" >坏次果列表</a> -->
<!--                 </li> -->
            <?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseForecast" target="main-frame" >采购预估</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseForecastList" target="main-frame" >采购预估列表</a> -->
<!-- 	    		</li> -->
    		<?php }?> 
    		<?php if($this->helper->chechActionList(array('purchaseForecast'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./areaPurchaseForecast" target="main-frame" >采购预估汇总</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePlace'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchasePlace" target="main-frame" >采购地点列表</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('productPurchaseUser'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./productPurchaseUser" target="main-frame" >商品采购助理列表</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('transferException'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./transferException/unPurchaseIn" target="main-frame" >调度未入库</a> -->
<!-- 	    		</li> -->
<!-- 	    		<li> -->
<!-- 	    			<a href="./transferException/unTransferOut" target="main-frame" >调度未出库</a> -->
<!-- 	    		</li> -->
<!-- 	    		<li> -->
<!-- 	    			<a href="./transferException/facilityDiff" target="main-frame" >调拨与仓库差异</a> -->
<!-- 	    		</li> -->
<!-- 	    		<li> -->
<!-- 	    			<a href="./transferException/purchaseDiff" target="main-frame" >调度与采购差异</a> -->
<!-- 	    		</li> -->
			<?php }?>
			<?php if($this->helper->chechActionList(array('supplierReturn'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./supplierReturnList/index" target="main-frame" >供应商退货申请</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./supplierReturnList/query" target="main-frame" >供应商退货申请列表</a> -->
<!-- 	    		</li> -->
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('purchasePlaceFacility'))) {?>
<!--     			<li> -->
<!-- 	    			<a href="./purchasePlaceFacility" target="main-frame" >采购地仓库对应关系</a> -->
<!-- 	    		</li> -->
	    	<?php }?>
            <?php if($this->helper->chechActionList(array('packageTransformList'))) {?>
<!--             <li> -->
<!--                 <a href="./productTransformApply/packageTransformList" target="main-frame" >包裹转原料申请列表</a> -->
<!--             </li> -->
            <?php }?>
<!-- 	    	</ul> -->
<!--     	</li> -->
    	<?php }?>
    	<?php if($this->helper->chechActionList(array('caiwuManager'))) {?>
<!--     	<li class="has-sub-menu"> -->
<!--     		<i class="fa fa-chevron-down chevron"></i> -->
<!--     		<a href="#"> -->
<!--     			<i class="fa fa-laptop"></i>财务管理 -->
<!--     		</a> -->
<!--     		<ul class="sub-menu sub-menu-hidden"> -->
    			<?php if($this->helper->chechActionList(array('purchaseFinanceList'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseFinanceList" target="main-frame" >采购结算</a> -->
<!-- 	    		</li> -->
    			<?php }?>
    			<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./supplierReturnList/query?status=EXECUTED" target="main-frame" >供应商退货申请列表</a> -->
<!-- 	    		</li> -->
    			<?php }?>
<!-- 	    	</ul> -->
<!--     	</li> -->
    	<?php }?>
    	
    	<?php if($this->helper->chechActionList(array('transferManager'))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>调度管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
                 <li>
                    <a href="./loadingBillList" target="main-frame" >bol装车单列表</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('loadingBill'))) {?>
	    		<li>
	    			<a href="./loadingBill" target="main-frame" >创建装车单</a>
	    		</li>
    		<?php }?>
            <?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
                <li>
                    <a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('launchTransferInventoryList'))) {?>
                <li>
                    <a href="./launchTransferInventoryList" target="main-frame" >仓库调拨</a>
                </li>
                <li>
                    <a href="./launchTransferInventoryList/goodsDetailIndex" target="main-frame" >调拨明细列表</a>
                </li>
            <?php }?>
    		<?php if($this->helper->chechActionList(array('transferException'))) {?>
	    		<li>
	    			<a href="./transferException/unPurchaseIn" target="main-frame" >未入库</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/unTransferOut" target="main-frame" >未出库</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/facilityDiff?product_type=goods" target="main-frame" >调拨与仓库差异</a>
	    		</li>
	    		<li>
	    			<a href="./transferException/purchaseDiff?product_type=goods" target="main-frame" >调度与采购差异</a>
	    		</li>
    		<?php }?>
    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
		    	<li>
		    		<a href="./supplierReturnList/query?product_type=supplies" target="main-frame" >供应商退货申请列表</a>
		    	</li>
	    	<?php }?>
	    	</ul>
    	</li>
    	<?php }?>

        <?php if($this->helper->chechActionList(array('suppliesTransferManager'))) {?>
                <li class="has-sub-menu">
                    <i class="fa fa-chevron-down chevron" ></i>
                    <a href="#">
                        <i class="fa fa-laptop"></i>耗材调度管理
                    </a>
                    <ul class="sub-menu sub-menu-hidden">
                        <?php if($this->helper->chechActionList(array('launchTransferInventoryList'))) {?>
                            <li>
                                <a href="./launchTransferInventoryList/suppliesIndex" target="main-frame" >仓库调拨</a>
                            </li>
                            <li>
                                <a href="./launchTransferInventoryList/suppliesDetailIndex" target="main-frame" >调拨明细列表</a>
                            </li>
                            <li>
                                <a href="./transferException/facilityDiff?product_type=supplies" target="main-frame" >调拨与仓库差异</a>
                            </li>
                        <?php }?>
                    </ul>
                    
                </li>
            <?php }?>
    	
    	<?php if($this->helper->chechActionList(array('suppliesCaigouManager'))) {?>
<!--     	<li class="has-sub-menu"> -->
<!--     		<i class="fa fa-chevron-down chevron"></i> -->
<!--     		<a href="#"> -->
<!--     			<i class="fa fa-laptop"></i>耗材采购管理 -->
<!--     		</a> -->
<!--     		<ul class="sub-menu sub-menu-hidden"> -->
    			<?php if($this->helper->chechActionList(array('purchaseCommit'))) {?>
<!--     				<li> -->
<!--     					<a href="./purchaseCommit/suppliesIndex" target="main-frame" >采购承诺(PO)</a> -->
<!--     				</li> -->
    			<?php }?>
    			<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
<!--                     <li> -->
<!--                         <a href="./loadingBillList/suppliesIndex" target="main-frame" >bol装车单列表</a> -->
<!--                     </li> -->
                <?php }?>
	    		<?php if($this->helper->chechActionList(array('asnFinish'))) {?>
<!-- 			    		<li> -->
<!-- 			    			<a href="./asnFinish/suppliesIndex" target="main-frame" >asn预到货通知单</a> -->
<!-- 			    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('purchasePrice'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./purchasePrice/suppliesIndex" target="main-frame" >采购价格录入</a> -->
<!-- 		    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('purchaseFinanceApply')) || $this->helper->chechActionList(array('purchaseManager'))) {?>
<!-- 	    		<li> -->
<!-- 	    			<a href="./purchaseFinanceList" target="main-frame" >财务申请</a> -->
<!-- 	    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('arnormalBolItemList'))) {?>
<!-- 			    		<li> -->
<!-- 			    			<a href="./arnormalBolItemList" target="main-frame" >bol异常清单</a> -->
<!-- 			    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('inventoryTransactionList'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a> -->
<!-- 		    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('productSupplier'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./productSupplierList" target="main-frame" >耗材供应商列表</a> -->
<!-- 		    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('supplierReturn'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./supplierReturnList/index?product_type=supplies" target="main-frame" >供应商退货申请</a> -->
<!-- 		    		</li> -->
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
<!-- 		    		<li> -->
<!-- 		    			<a href="./supplierReturnList/query?product_type=supplies" target="main-frame" >供应商退货申请列表</a> -->
<!-- 		    		</li> -->
	    		<?php }?>
<!-- 	    	</ul> -->
<!--     	</li> -->
    	<?php }?>
    	
    	<?php if($this->helper->chechActionList(array('suppliesInventoryManager'))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>耗材物料管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
	    		<?php if($this->helper->chechActionList(array('loadingBillList'))) {?>
		    		<li>
		    			<a href="./loadingBillList/suppliesIndex" target="main-frame" >bol装车单列表</a>
		    		</li>
	    		<?php }?>
    			<?php if($this->helper->chechActionList(array('purchaseIn'))) {?>
		    		<li>
		    			<a href="./purchaseIn/index?product_type=supplies" target="main-frame" >收耗材</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('productionOut'))) {?>
		    		<li>
		    			<a href="./productionOut/supplies" target="main-frame" >产线提货</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('saleReturn'))) {?>
		    		<li>
		    			<a href="./saleReturn/index?product_type=supplies" target="main-frame" >耗材退回入库</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('suppliesInventoryTransactionList'))) {?>
		    		<li>
		    			<a href="./inventoryTransactionList/product_list" target="main-frame" >查看库存</a>
		    		</li>
	    		<?php }?>
	    		<?php if($this->helper->chechActionList(array('supplierReturnList'))) {?>
		    		<li>
		    			<a href="./supplierReturnList/query?status=CHECKED&product_type=supplies" target="main-frame" >供应商退货申请列表</a>
		    		</li>
	    		<?php }?>
	            <?php if($this->helper->chechActionList(array('createStocktakeMaterial'))) {?>
	                <li>
	                    <a href="./stocktakeMaterialList/index?product_type=supplies" target="main-frame" >发起盘点</a>
	                </li>
	            <?php }?>
	    		<?php if($this->helper->chechActionList(array('stocktakeMaterialList'))) {?>
		    		<li>
		    			<a href="./stocktakeMaterialList/query?product_type=supplies" target="main-frame" >盘点列表</a>
		    		</li>
	    		<?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	
        <?php if($this->helper->chechActionList(array("kdyyManager"))) {?>
        <li class="has-sub-menu">
            <i class="fa fa-chevron-down chevron"></i>
            <a href="#">
                <i class="fa fa-laptop"></i>快递运营
            </a>
            <ul class="sub-menu sub-menu-hidden">
            <?php if($this->helper->chechActionList(array('productionPlan'))) {?>
                <li>
                    <a href="./OrdersNotInFacilityRegion" target="main-frame" >外围件订单</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('facilityList'))) {?>
                <li>
                    <a href="./modifyFacility/facilityWithoutShipping" target="main-frame" >无区域快递</a>
                </li>
                <li>
                    <a href="./transferFacility/transferShipping" target="main-frame" >转快递</a>
                </li>
                <li>
                    <a href="./transferList/transferShippingList" target="main-frame" >转快递列表</a>
                </li>
                <li>
                    <a href="./facilityCoverage" target="main-frame" >快递覆盖范围</a>
                </li>
                <li>
                    <a href="./facilityInCityCoverage" target="main-frame" >仓库同城覆盖范围</a>
                </li>
                <li>
                    <a href="./abnormalShipment" target="main-frame" >异常订单</a>
                </li>
                <li>
                    <a href="./modifyFacility/viewModifyShipping" target="main-frame" >快递发货能力管理</a>
                </li>

            <?php }?>

            <?php if($this->helper->chechActionList(array('shippingBlack'))) {?>
                <li>
                    <a href="./shippingBlackList" target="main-frame" >快递黑名单</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('thermalDashboard'))) {?>
                <li>
                    <a href="./thermalDashboard/query?shipping_id=115" target="main-frame" >中通面单报警</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('OpenOrderList'))) {?>
                <li>
                    <a href="./OpenOrderList" target="main-frame" >落地配订单列表</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('readCarriageFreight','editCarriageFreight'))) {?>
                <li>
                    <a href="./addCarriage" target="main-frame" >快递费用</a>
                </li>
            <?php }?>
            </ul>
        </li>
        <?php }?>
        
        <?php if($this->helper->chechActionList(array('productSupplierManager'))) {?>
        <li class="has-sub-menu">
            <i class="fa fa-chevron-down chevron"></i>
            <a href="#">
                <i class="fa fa-laptop"></i>供应商管理
            </a>
            <ul class="sub-menu sub-menu-hidden">
                <?php if($this->helper->chechActionList(array('productSupplier'))) {?>
                <li>
                    <a href="./productSupplierList" target="main-frame" >供应商列表</a>
                </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
        <?php if($this->helper->chechActionList(array('merchantManagerTitle'))) {?>
        <li class="has-sub-menu">
            <i class="fa fa-chevron-down chevron"></i>
            <a href="#">
                <i class="fa fa-laptop"></i>商户档案管理
            </a>
            <ul class="sub-menu sub-menu-hidden">
                <?php if($this->helper->chechActionList(array('merchantList'))) {?>
                <li>
                    <a href="./merchantList" target="main-frame" >商户列表</a>
                </li>
                <?php }?>
            </ul>
        </li>
        <?php }?>
		<?php if($this->helper->chechActionList(array("goodsManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>商品档案管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
             <?php if($this->helper->chechActionList(array('goodsFinishedMaterial'))) {?>
                 <li>
                    <a href="./GoodsFinishedMaterial/" target="main-frame" >商品映射关系查询</a>
                 </li>
             <?php }?>
                          <?php if($this->helper->chechActionList(array('goodsProduct'))) {?>
                 <li>
                    <a href="./goodsApply/goodsProduct" target="main-frame" >OMS商品档案申请</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('goodsApplyList'))) {?>
                 <li>
                    <a href="./goodsApply/goodsApplyList" target="main-frame" >OMS商品档案申请列表</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('product'))) {?>
                 <li>
                    <a href="./product" target="main-frame" >产品档案</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('productFacilityShippingList'))) {?>
                 <li>
                    <a href="./productFacilityShippingList" target="main-frame" >商品仓库快递列表</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('showProductTransformMapping'))) {?>
<!-- 	            <li> -->
<!-- 	                <a href="./ProductTransformMappingList/query" target="main-frame" >AB果转换关系设置</a> -->
<!-- 	            </li> -->
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("suppliesManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>耗材档案管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
             <?php if($this->helper->chechActionList(array('product'))) {?>
                 <li>
                    <a href="./product" target="main-frame" >产品档案</a>
                 </li>
             <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("orderManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>订单管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		 <?php if($this->helper->chechActionList(array('orderList'))) {?>
                 <li>
                    <a href="./shipments" target="main-frame" >订单列表</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('orderCount'))) {?>
	    		<li>
	    			<a href="./orderCount" target="main-frame" >订单统计</a>
	    		</li>
	    	<?php }?>
            <?php if($this->helper->chechActionList(array('orderList'))) {?>
                 <li>
                    <a href="./orderCount/query" target="main-frame" >发货统计</a>
                 </li>
             <?php }?>
             <?php if($this->helper->chechActionList(array('orderList'))) {?>
                 <li>
                    <a href="./orderCount/confirmDeliver" target="main-frame" >成团统计</a>
                 </li>
             <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("systemManager"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>系统设置
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('assignCredit'))) {?>
	    		<li>
	    			<a href="./userRole" target="main-frame" >权限分配</a>
	    		</li>
	    		<li>
	    			<a href="./userRole/userRoleList" target="main-frame" >用户列表</a>
	    		</li>
    		<?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    	<?php if($this->helper->chechActionList(array("stationManage"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>拼小站奔奔站点管理
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
    		<?php if($this->helper->chechActionList(array('stationStatistics'))) {?>
	    		<li>
	    			<a href="./stationKeyword/availableShipments" target="main-frame" >关键词匹配订单数量</a>
	    		</li>
	    	<?php }?>
	    	<?php if($this->helper->chechActionList(array('stationList'))) {?>
	    		<li>
	    			<a href="./stationKeyword/stationList" target="main-frame" >站点管理</a>
	    		</li>
    		<?php }?>
            <?php if($this->helper->chechActionList(array('stationManage'))) {?>
                <li>
                    <a href="./PinXiaoZhanOpenOrder" target="main-frame" >拼小站揽件管理</a>
                </li>
            <?php }?>
            <?php if($this->helper->chechActionList(array('stationManage'))) {?>
                <li>
                    <a href="./PinXiaoZhanOpenOrder/BenbenCannotship" target="main-frame" >奔奔站点匹配异常</a>
                </li>
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
        <?php if($this->helper->chechActionList(array("carrierList","addCarrier","editCarrier"))) {?>
    	<li class="has-sub-menu">
    		<i class="fa fa-chevron-down chevron"></i>
    		<a href="#">
    			<i class="fa fa-laptop"></i>承运商档案
    		</a>
    		<ul class="sub-menu sub-menu-hidden">
            <?php if($this->helper->chechActionList(array("carrierList","addCarrier","editCarrier"))) {?>
                <li>
                    <a href="./carrier" target="main-frame" >承运商管理</a>
                </li>
            <?php }?>
	    	</ul>
    	</li>
    	<?php }?>
    </ul>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		
         $("#main-menu .has-sub-menu>a").on("click",function(){
			$(this).next().stop().slideToggle(300)
			.end()
			.prev().toggleClass("rotate-up")
			.end()
			.parent().siblings().find(".chevron").removeClass("rotate-up");

			$(this).parent().toggleClass("active")
			.siblings().removeClass("active").find(".sub-menu").stop().slideUp(300);
		});

		$(".sub-menu a").on("click",function(){
			$(this).addClass("active")
			.parent().siblings().find("a").removeClass("active")
			.end()
			.parents(".has-sub-menu").siblings().find(".sub-menu a").removeClass("active");
		});
	});
</script>
</body>
</html>
