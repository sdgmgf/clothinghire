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
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/style.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/product.css">
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
    
    <style type="text/css">
        tr {
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
        tr th{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }

      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
       #popTable input,#popTable select{width:80%;}
       .secondTab .table>thead:first-child>tr:first-child>th{border-top:1px solid #ddd;border-bottom:0;}
  		.no-click{color:#626262 !important;background:#d0d0d0 !important;}
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body> 
<ul class="nav nav-tabs">
   <li class="active main_tab"><a href="#masterData" data-toggle="tab">主数据</a></li>
   <li id="taxEdit_tab" ><a href="#taxEdit" data-toggle="tab">税率设置</a></li>
</ul>
<div class="firstTab">
	<form id="supplier_form" name="supplier_form" method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>productSupplierList/editSupplier" enctype="multipart/form-data">
		<div>
	        	<button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        	<br><h4 style="margin-left:5%;" class="modal-title" >编辑供应商信息</h4>
	    </div>
	    <div class="modal-body" style="text-align: left; margin-left:5%">
			<div class='row'>
				<label  style="text-align: right;">编号：</label><input type="text" name="product_supplier_id" class="no-click" readonly="readonly" value= "<?php echo $product_supplier['product_supplier_id'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">供应商：</label><input type="text" name="product_supplier_name" class="no-click"  readonly="readonly" id="edit_product_supplier_name" value= "<?php echo $product_supplier['product_supplier_name'] ?>">
			</div>
			<div class='row'>
				<label  style="text-align: right;">类型：</label><select id="edit_product_type" name="product_type" class="no-click" disabled="disabled" readonly="readonly" style="width:175px;height:26px"  >
		                            <?php
		                                $product_type = $product_supplier['product_type'];
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
			<div class='row'>
				<label style="text-align: right;">供应商类型：</label><select readonly="readonly" name="supplier_type" value= "<?php echo $product_supplier['supplier_type'] ?>" style="width:175px;height:26px" >
					<option <?php	if($product_supplier['supplier_type'] =="company") 
										echo "selected = 'selected'";
										?> value="company">公司</option>
					<option <?php	if($product_supplier['supplier_type'] =="market") 
										echo "selected = 'selected'";
										?> value="market">市场档口</option>
					<option <?php	if($product_supplier['supplier_type'] =="cooperative") 
										echo "selected = 'selected'";
										?>  value="cooperative">产地合作社</option>
                </select>
			</div>
			<div class='row'>
				<label  style="text-align: right;vertical-align:top">地址：</label><textarea name="product_supplier_address" rows="2" cols="40" ><?php echo $product_supplier['product_supplier_address'] ?></textarea>
			</div>
			<div class='row'>
				<label  style="text-align: right;">联系人：</label><input type="text" name="supplier_contact_name"  value= "<?php echo $product_supplier['supplier_contact_name'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">联系方式：</label><input type="text"  name="supplier_contact_mobile" value= "<?php echo $product_supplier['supplier_contact_mobile'] ?>"  >
			</div>
			<div class='row'>
				<label  style="text-align: right;">营业执照：</label>
				<img width="20%" class="business_license" src=<?php if(!empty($product_supplier['business_license'] ))
                                             					echo $WEB_ROOT.$upload_path.$product_supplier['business_license'];
                                             				else 
                                             					echo "../uploads/index.jpg"?>   alt="证件照" />
			</div>
			<div class='row'>
				<label  style="text-align: right;"></label><br>
					<div class="row col-md-5 imgDiv" style="margin-left: 10%;margin-top: 10px;">
								<div id="imgDiv1">
									<input type="file" id="business_license" name="business_license" class="img" size="0" style="display:none" />
								</div>
								<div id="cover1" class="cover" style="position: absolute; background-color: White; z-index: 10;
								filter: alpha(opacity=100); -moz-opacity: 1; opacity: 1; ">
									<input id="selectImg1" type="button" value="选择图片" class="selectImg btn btn-primary" />
								</div>
								<div class="imgShow" id="imgShow1" style="width: 400px; margin-top: 60px;">
									<div class="productImg" id="productImg1"  hidden="true" >
										<div style="border: 1px solid #eeeeee; padding: 3px; max-height: 390px; max-width: 390px; overflow: hidden; text-align: center; ">
											<img class="imgHolder" id="imgHolder1" style="max-height: 390px; max-width: 390px;" />
										</div>
										<input id="delImg1" type="button" style="width: 65px; height: 30px" value="删除" class="delImg btn btn-danger"> 
									</div>
								</div>
					</div>
			</div>
			
			<div class='row'>
				<label  style="text-align: right;">开户银行：</label><input type="text" name="opening_bank"  value= "<?php echo $product_supplier['opening_bank'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">银行账户：</label><input type="text" name="bank_account" id="bank_account"  value= "<?php echo $product_supplier['bank_account'] ?>">
			</div>
			<div class='row'>
				<label  style="text-align: right;">账户姓名：</label><input type="text" name="bank_account_name"  value= "<?php echo $product_supplier['bank_account_name'] ?>">
			</div>
			<div class='row'>
				<label style="text-align: right;">付款周期：</label><input type="text"  name="payment_cycle" value= "<?php echo $product_supplier['payment_cycle'] ?>" >
			</div>
			<div class='row'>
				<label  style="text-align: right;">等级：</label><select name="supplier_level" value="<?php echo $product_supplier['supplier_level'] ?>"  style="width:175px;height:26px" >
					
					<option 
					<?php	if($product_supplier['supplier_level'] =="5") 
										echo "selected = 'selected'";
										?> value="5">5星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="4") 
										echo "selected = 'selected'";
										?> value="4">4星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="3") 
										echo "selected = 'selected'";
										?> value="3">3星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="2") 
										echo "selected = 'selected'";
										?> value="2">2星</option>
					<option 
					<?php	if($product_supplier['supplier_level'] =="1") 
										echo "selected = 'selected'";
										?> value="1">1星</option>
                </select>
			</div>
			
			<div class='row'>
				<label for="edit_note" style="text-align: right;vertical-align:top">备注：</label><textarea name="note"  rows="3" cols="40"><?php echo $product_supplier['note'] ?></textarea>
			</div>
	      </div>
	  </form>

	 <div style="margin-left: 15%;">
	    <?php  
			if( $this->helper->chechActionList(array('productSupplierEdit')) ){ ?>
				<input id="edit_supplier" type="button" class="btn btn-primary" style="text-align: right" value="提交">
		<?php }?>
	 </div><br><br><br>
	      
</div>

<!-- modal end  -->

<!-- 设置税率Modal -->
<div class="secondTab" style="display:none">
<div class="panel panel-default">
	<div class="panel-body">
		<label>设置税率
			<input type="button" id="setSupplierProductMappingBtn" value="编辑" class="btn btn-primary btn-sm"></label>
		<table style="width: 60%;border:3px;" class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th>商品</th>
							<th>类型</th>
							<th>税率</th>
							<th>创建时间</th>
							<th>创建人</th>
						</tr>
					</thead>
					<tbody style="text-align: left;" id="showProductInfo">
					<?php 
					foreach ($SupplierProductMappingList as $item) {
						echo "<tr><td>".$item['product_name']."</td><td>".$item['invoice_type']."</td><td>".($item['tax_rate']*100)."%</td><td>".$item['created_time']."</td><td>".$item['created_user']."</td><tr>";
					}
					 ?>
					</tbody>
				</table>
	</div>
</div>

<!-- Start popWin -->
<div class="popWin modal fade" style="display:none" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" 
	               data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">税率设置</h4>
				</div>
				<div class="modal-body">
				<?php  
			if( $this->helper->chechActionList(array('productEdit')) ){ ?>
				<em class="btn btn-sm btn-primary" style="margin-bottom:10px;font-style:normal;" id="newAdd">新增</em>
		<?php }?>
	      <table style="border: 3;" class="table table-striped table-bordered ">
					<thead>
						<tr>
							<th>商品</th><th>类型</th><th>税率</th><th>操作</th>
						</tr>
					</thead>
					<tbody style="text-align: left;" id="popTable"></tbody>
				</table>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" 
	               data-dismiss="modal" id="popWinClose">关闭</button>
					<!--<button type="button" class="btn btn-primary" id="productSubmit">保存</button>
				--></div>
			</div>
		</div>
	</div>
<!-- End popWin -->
</div>
<input type="text" hidden="true" id="WEB_ROOT" value="<?php echo $WEB_ROOT?>">
<input type="text" hidden="true" id="current_user" value="<?php 
            $CI =& get_instance();
    $CI->load->library('session');
    echo $CI->session->userdata('username');
?>"> 
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>

<script type="text/javascript">
	webUrl = $('#WEB_ROOT').val();	

	current_user=$("#current_user").val();
	invoice_type_lists=<?php echo json_encode($invoice_type_list); ?>;
	taxrate_lists=<?php echo json_encode($tax_rate_list); ?>;
	SupplierProductMappingList=<?php echo json_encode($SupplierProductMappingList); ?>;
	all_product_list=null;
	$(document).ready(function(){
		//console.log(webUrl+"product/getProductList?product_type=goods&product_sub_type=raw_material");
		$.ajax({
			url:webUrl+"product/getProductList?product_type=goods&product_sub_type=raw_material",
			type:"get",
			dataType:"json",
			xhrFields: {
	            withCredentials: true
	        }
		}).done(function(data){
			if(data.res == "success"){
				all_product_list=data.product_list;
			}	
			else{
				alert("获取商品失败");}
			});
		$("#bank_account").keydown(function(event){
			//bank_account_val=this.value;
		});
		$("#bank_account").keyup(function(){
			this.value =this.value.replace(/\D/g,'').replace(/(\d{4})(?=\d)/g,"$1 ");
		});
	});	

	$('#edit_supplier').click(function(){
		
        var cf=confirm( "无论是否更改,提交都将重新审核\n是否提交?" )
        if(!cf){
            	return;
       	}     
    	btn = $(this);
    	btn.attr('disabled','disabled');
    	$("#edit_product_type").removeAttr("disabled");
    	$('#supplier_form').submit();
	});
	

		$("#supplier_form").submit(function(){
		
	        //var val = $("#edit_product_type").val();
	        //alert(val);
	        options = {
        		dataType: 'json',
        		success: function (data) {
	        		if(data.success == "true"){
	        		    alert('修改成功');
	        		    window.history.back(-1);
	        		} else{
	        		    alert("修改失败"+data.error_info);
	        		    btn.removeAttr('disabled');
	        		}
	            	$("#edit_product_type").attr('disabled','disabled');
        		},
        		fail:function(data){
        		    console.log(data);
        		}
	        };
	        $("#supplier_form").ajaxSubmit(options);
	        return false;
		});

	    $('#taxEdit_tab').click(function(){
	 		 //var obj = $(this).parent().parent();
	 		 var code = $("#edit_product_supplier_name").val();
	 		// alert(code);
	 		 
	 		 $("#add_product_supplier_name").val($.trim(code));
			 //$("#tax_edit_modal").modal('show');
	 		$(".firstTab").hide();
	 		$(".secondTab").show();
		 });

	     $(".tax_edit").click(function(){
	         //$("#tax_edit_modal").modal('toggle');
	     }); 
	     $('.main_tab').click(function(){
	    	$(".firstTab").show();
		 	$(".secondTab").hide();
		 	
		 });
		 $("#setSupplierProductMappingBtn").click(function(){
			 var str="";
			 for(var i=0;i<SupplierProductMappingList.length;i++){
				 var t=SupplierProductMappingList[i];
				 str+="<tr><td><input type='text'  name='product_name' class='product_name no-click' data-product-id='"+t["product_id"]+"' value='"+t["product_name"]+"' disabled='disabled'></td>";
				 str+="<td><select class='invoice_type no-click' name='invoice_type' disabled='disabled'>";
				 str+="<option value='0' selected='selected'>"+t["invoice_type"]+"</option></select></td>";
				 str+="<td><select class='tax_rate no-click' name='tax_rate' disabled='disabled'>";
				 str+="<option value='0' selected='selected'>"+(t["tax_rate"]*100)+"%</option></select></td>";
				 str+="<td><a href='javascript:'>删除</a></td></tr>";
			 }
			 $("#popTable").html(str);
	    	 $(".popWin").modal('show');
		 });
		 $("#newAdd").click(function(){ 
			 var str="";
			 str+="<tr><td><input type='text'  name='product_name' class='product_name'></td>";
					str+="<td><select class='invoice_type' name='invoice_type'>";
				for(var i=0;i<invoice_type_lists.length;i++){
					str+="<option value='"+invoice_type_lists[i]["invoice_id"]+"'>"+invoice_type_lists[i]["invoice_type"]+"</option>";
				}
			str+="</select></td>";
			str+="<td><select class='tax_rate' name='tax_rate'>";
				for(var i=0;i<taxrate_lists.length;i++){
					str+="<option value='"+taxrate_lists[i]["tax_id"]+"'>"+(taxrate_lists[i]["tax_rate"]*100)+"%</option>";
				}
				str+="</select></td>";
			str+="<td><button class='btn btn-default btn-xs'>保存</button></td></tr>";
			 $("#popTable").append(str);
		 });
		 //delete
		 $("#popTable").click(function(e){
			 if(e.target.tagName.toLowerCase()=="a"){
				 var pCon=$(e.target.parentNode.parentNode);
				 var delData = {
			                'product_supplier_id': <?php echo '"'.$product_supplier['product_supplier_id'].'"'; ?>,
			                'product_id': pCon.find("[name=product_name]").attr("data-product-id")
			            };
				 $.ajax({
						url : webUrl+"ProductSupplierList/delSupplierProductMapping/taxrate/delete",
						type : 'POST',
						data : delData,
						dataType : "json",
						xhrFields:{
							withCredentials : true
						}
					}).done(function(data){
						if(data.success == "true"){
							delData['product_id'];
							for(var i=0;SupplierProductMappingList.length;i++){
								if(SupplierProductMappingList[i]['product_id']==delData['product_id']){
									SupplierProductMappingList.splice(i,1);
									break;
								}
							}
							var str="";
							for(var i=0;i<SupplierProductMappingList.length;i++){
								var tmp=SupplierProductMappingList[i];
								str+="<tr><td>"+tmp['product_name']+"</td><td>"+tmp['invoice_type']+"</td><td>"+(tmp['tax_rate']*100)+"%</td><tr>";
							}
							$("#showProductInfo").html(str);
							$(e.target.parentNode.parentNode).remove();
						}else{
							alert("删除失败!");
						}
					});
			 }
			 if(e.target.tagName.toLowerCase()=="button"){
				 var pCon=$(e.target.parentNode.parentNode);
				 var tmpProduct=pCon.find("[name=product_name]");
				 if(!tmpProduct.attr("data-product-id")){
					 tmpProduct.removeAttr("data-product-id");
					 alert("输入了不存在的商品,请重新输入");
					 pCon.find("[name=product_name]").focus();
					 return false;
				 }else{
					 var tmpId=-1;
					 for(var i=0;i<all_product_list.length;i++){
						 if(all_product_list[i]['product_id']==tmpProduct.attr("data-product-id")){
							 tmpId=i;
							 break;
						 }
					 }
					 if(tmpId!=-1 && $.trim(all_product_list[tmpId]['product_name'])!=$.trim(tmpProduct.val())){
						 tmpProduct.removeAttr("data-product-id");
						 alert("输入了不存在的商品,请重新输入");
						 pCon.find("[name=product_name]").focus();
						 return false;
					 }
				 }
				 var newAddData = {
			                'product_supplier_id': <?php echo '"'.$product_supplier['product_supplier_id'].'"'; ?>,
			                'product_id': pCon.find("[name=product_name]").attr("data-product-id"),
			                'invoice_type': pCon.find("[name=invoice_type]").val(),
			                'tax_rate': pCon.find("[name=tax_rate]").val()
			            };
				 $.ajax({
						url : webUrl+"ProductSupplierList/addSupplierProductMapping",
						type : 'POST',
						data : newAddData,
						dataType : "json",
						xhrFields:{
							withCredentials : true
						}
					}).done(function(data){
						if(data.success == "true"){
							var tmp={
									"invoice_type":pCon.find("[name=invoice_type] option:selected").text(),
									"product_id":newAddData['product_id'],
									"product_name":pCon.find("[name=product_name]").val(),
									"tax_rate":parseFloat(pCon.find("[name=tax_rate] option:selected").text())/100,
									"created_time":new Date(),
					                "created_user":current_user
								};
							SupplierProductMappingList.push(tmp);
							var t={ "y":tmp['created_time'].getFullYear(),
								    "m":tmp['created_time'].getMonth()+1,
								    "d":tmp['created_time'].getDate(),
								    "h":tmp['created_time'].getHours(),
								    "i":tmp['created_time'].getMinutes(),
								    "s":tmp['created_time'].getSeconds()};
							t.y=t.y<10?"0"+t.y:t.y;
							t.m=t.m<10?"0"+t.m:t.m;
							t.d=t.d<10?"0"+t.d:t.d;
							t.h=t.h<10?"0"+t.h:t.h;
							t.i=t.i<10?"0"+t.i:t.i;
							t.s=t.s<10?"0"+t.s:t.s;
							
							var str="<tr><td>"+tmp['product_name']+"</td><td>"+tmp['invoice_type']+"</td><td>"+(tmp['tax_rate']*100)+"%</td><td>"+
							t.y+"-"+t.m+"-"+t.d+" "+t.h+":"+t.i+":"+t.s+"</td><td>"+tmp['created_user']+"</td><tr>";
							$("#showProductInfo").append(str);
							pCon.children().children().attr("disabled","disabled").addClass("no-click");
							pCon.children(":last").html("<a href='javascript:'>删除</a>");
						}else{
							alert("新增失败!");
						}
					});
			 }
			 if(e.target.tagName.toLowerCase()=="input" && $(e.target).prop("disabled")!="true"){
				 if(all_product_list==null){
					 alert("未获取商品,请重新刷新页面!");
					 return false;
				 }
				 //$(e.target).attr("data-product-id",3);
				 $(e.target).autocomplete(all_product_list, {
				        minChars: 0,
				        width: 280,
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
				        $(this).attr("data-product-id",row.product_id);
				    });
			 }
		 });
		 $("#popWinClose").click(function(){
		    	//alert(123);
		 });
	
		 $(".img", ".imgDiv").mouseover(function () {
			    $(this).blur();
			});

			$(".img", ".imgDiv").change(function () {
			    productImg =$(this).parent().siblings('.imgShow').children('.productImg').attr('id');
			    imgHolder = $(this).parent().siblings('.imgShow').children('.productImg').children(0).children('.imgHolder').attr('id');
			    PreviewImage(this, imgHolder, productImg);
			});
			$('.selectImg').on('click',function(){
			    var $this = $(this),
			        $tInput = $this.parents('.imgDiv').find("input[type='file']");
			    $tInput.trigger('click');
			});
</script>
</body>
</html>
