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
    <style>
		table,tr,td,th{
	        border: 1px solid #ddd;
	        padding: 8px;
	        color: #232323;
	        text-align: center;
      	}
      	th{
	        border: 1px solid #a2b7db;
	        background: #a2b7db;
	        color: #fff;
      	}
      	#transferTable{
      		width: 600px;
      	}
      	.operateBtn{
      		display: inline-block;
      		padding: 5px 10px;
      		background: #1895e0;
      		color: #fff;
      		border: 0;
      		margin:0 5px;
      		border-radius: 5px;
      	}
      	.operateBtn:hover{
      		background: #1584c4;
      	}
      	p{
      		width: 600px;
      		margin: 0 auto;
      	}
      	.modalCommon{
      		margin-left: 30px;
      		width: 280px;
      		height: 36px;
      		border-radius: 5px;
      		border: 1px solid #c1c1c1;
      		text-indent: 0.5em;
      	}
      	.hidden{
      		display: none;
      	}
    </style>
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
	<div style="width: 60%;margin: 0 auto;">
	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>transferFacility/searchProduct">
		<table class="table table-striped table-bordered ">
			<tr>
				<td width="20%">仓库:</td>
				<td>
					<select style="width: 40%;float: left;" name="facility_id" id="facilitySel">
						<option value=""></option>
						<?php 
							foreach ($facility_list as $facility){
								if(isset($data_list)){
									if($data_list[0]['facility_id'] == $facility['facility_id']){
										echo "<option value=\"{$facility['facility_id']}\" selected>{$facility['facility_name']}</option>";
									}else{
										echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
									}
								}else{
									echo "<option value=\"{$facility['facility_id']}\">{$facility['facility_name']}</option>";
								}
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>商品:</td>
				<td>
					<input type="text" style="width: 80%;" name="product_name" id="productSel" value="<?php if(isset($product_name)) echo str_replace("\"", "&quot;", $product_name);?>" />
			    	<input type="hidden" id="product_id" name="product_id" value="<?php if(isset($product_id)) echo $product_id?>"/><br/>
				</td>
			</tr>
			<tr>
				<td colspan="2"><button type="button" style="float: right;" class="btn btn-primary" id="search" >搜索</button></td>
			</tr>
		</table>
	</form>
		<table id="transferTable">
			<thead>
				<tr>
					<th>商品ID</th>
					<th>商品名称</th>
					<th>快递方式</th>
					<th>省份</th>
					<th>可转数量</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody id="transferBody">
				
			</tbody>
		</table>
	</div>
</div>
<!-- modal begin -->
<div class="modal fade" id="transfer-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <input type="hidden" id="from_shipping_id" name="from_shipping_id"/>
      <input type="hidden" id="from_province_id" name="from_province_id"/>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">订单转仓</h4>
      </div>
      
      <div class="modal-body">
		<p>
			<label for="from_facility_name">仓库: </label>
			<input id="from_facility_name" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="from_shipping_name">原快递方式: </label>
			<input id="from_shipping_name" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="product_name">商品名称: </label>
			<input id="product_name" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="province_name">省份: </label>
			<input id="province_name" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="shippingSelect">目的快递: </label>
			<select name="" class="modalCommon" id="shippingSelect"></select></p>
		</p>
		<p>
			<label for="support_transfer">可转数量: </label>
			<input id="support_transfer" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="plan_quantity">转移数量: </label>
			<input class="modalCommon" id="plan_quantity" type="number"  min="1" value="1">
		</p>
		<p>
			<label>落地配转换选择: </label>
			<label><input type="radio" id="transfer_cod_type_failed" name="transfer_cod_type" value="FAILED"/>只转同步失败的</label>
			<label><input type="radio" id="transfer_cod_type_all" name="transfer_cod_type" value="ALL"/>转全部</label>
		</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="transfer_submit" data-dismiss="modal">确定</button>
      </div>
    </div>
  </div>
</div>
<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
function transferShipping(from_province_id,from_shipping_id,shipping_name,product_name,province_name,support_transfer,is_cod,sync_type){
	var facility_id = $("#facilitySel").val();
	var facility_name = $("#facilitySel").find("option:selected").text();
	if (is_cod == 1 && sync_type == "BEFORE_PRODUCTION") {
		$("#transfer_cod_type_failed").parent().parent().show();
		$('input:radio[name=transfer_cod_type]:nth(0)').prop('checked',true);
	} else {
		$("#transfer_cod_type_all").parent().parent().hide();
		$('input:radio[name=transfer_cod_type]:nth(1)').prop('checked',true);
	}
	$("#from_facility_name").val(facility_name);
	$("#from_province_id").val(from_province_id);
	$("#from_shipping_id").val(from_shipping_id);
	$("#product_name").val(product_name);
	$("#province_name").val(province_name);
	$("#support_transfer").val(support_transfer);
	$("#from_shipping_name").val(shipping_name);
	$("#myModalLabel").html("转快递");
	shippingList(facility_id,from_province_id,from_shipping_id);
	$("#transfer-modal").modal('show');
}
$(document).ready(function(){
	var facility_id = $("#facilitySel").val();
	if(facility_id !=''){
		getProductList(facility_id);
	}	

	//点击搜索获取可转快递的商品列表
	$("#search").click(function(){
	    var url = $('#WEB_ROOT').val() + 'transferFacility/getCanTransferData',
	    	facility_id = $("#facilitySel").val(),
	    	product_id = $("#product_id").val();
			params = {
				"facility_id" : facility_id,
				"product_id" : product_id,
				"transfer_type" : 2  //1为转仓;2为转快递
			};
		if(facility_id == "" || facility_id == null){
			alert("请选择仓库");
			return false;
		}else if(product_id == "" || product_id == null){
			alert("请选择商品");
		}else{
			$.ajax({
				url: url,
				type: 'post',
				dataType: 'json',
				data: params
			})
			.done(function(e) {
				var transferList = "";
				$('#transferBody').html("");
				var dataList = e.data.data_list;
				if(dataList == ""){
					alert("暂无转仓转快递商品")
				}else{
					$.each(dataList, function(i, item) {
						transferList = "<tr><td>"+item.product_id+"</td><td>"+item.product_name+"</td><td>"+item.shipping_name+"</td><td>"+item.province_name+"</td>"
						 			 + "<td>"+item.num+"</td><td><input type='button' value='转快递' class='operateBtn' onclick='transferShipping(\""+item.province_id+"\",\""+item.shipping_id+"\",\""+item.shipping_name+"\",\""+item.product_name+"\",\""+item.province_name+"\",\""+item.num+"\",\""+item.is_cod+"\",\""+item.sync_type+"\")'/></td></tr>";						
						$('#transferBody').append(transferList);
					});
								
				}
			})
			.fail(function() {
				console.log("error");
			});
		}
	});

	$("#transfer_submit").click(function(){
		var plan_quantity = $("#plan_quantity").val();
		var	from_shipping_id = $("#from_shipping_id").val();
		var	to_shipping_id = $("#shippingSelect").val();
		var from_province_id = $("#from_province_id").val();
		var support_transfer = parseInt($("#support_transfer").val());
		var transfer_cod_type = $("input:radio[name='transfer_cod_type']:checked").val();
		
		if(to_shipping_id =="" || to_shipping_id == null){
			alert("请选择目的快递方式！");
			return false;
		}else if(plan_quantity =="" || plan_quantity == null){
			alert("请输入转移的数量！");
			return false;
		}else if(plan_quantity <= 0 || plan_quantity > support_transfer){
			alert("转移的数量必须是小于可转数量的正整数！");
			return false;
		}else{
			transferShippingIng(plan_quantity,from_shipping_id,to_shipping_id,from_province_id, transfer_cod_type);
		}
	});
});


function getProductList(facility_id){
	$("#productSel").unautocomplete();
	$.ajax({
        url: WEB_ROOT+"transferFacility/getProductList",
        type: 'get',
        dataType: "json",
        data: {"facility_id":facility_id},
        xhrFields: {
             withCredentials: true
        }
	  }).done(function(data){
		  $("#productSel").unautocomplete();
		  $("#productSel").autocomplete(data, {
			    minChars: 0,
			    width: 310,
			    max: 100,
			    matchContains: true,
			    autoFill: false,
			    formatItem: function(row, i, max) {
			        return i + "/" + max + ": \"" + row.product_name;
			    },
			    formatMatch: function(row, i, max) {
			        return row.product_name ;
			    },
			    formatResult: function(row) {
			    	return(row.product_name);
			    }
			}).result(function(event, row, formatted) {
		 		$('#product_id').val(row.product_id);
			});
	  });
}

$("#facilitySel").change(function(){
	var facility_id = $("#facilitySel").val();
	getProductList(facility_id);
});

//获得转仓快递列表
function shippingList(facility_id,from_province_id,from_shipping_id){
	var url = WEB_ROOT+"transferFacility/getShippingListByCoverage";
	$.ajax({
		url: url,
		type: 'post',
		dataType: 'json',
		data : { "facility_id" : facility_id, "province_id" : from_province_id, "shipping_id" : from_shipping_id}
	})
	.done(function(data) {
		var shippingSel = "";
		$("#shippingSelect").empty();
		$.each(data.list, function(i, item) {
			shippingSel = '<option value="'+item.shipping_id+'">'+item.shipping_name+'</option>';
			$("#shippingSelect").append(shippingSel);
		});
	})
	.fail(function() {
		console.log("error");
	});
	
}

//转快递请求
function transferShippingIng(plan_quantity,from_shipping_id,to_shipping_id,from_province_id, transfer_cod_type){
	var product_id = $("#product_id").val();
	var from_facility_id = $("#facilitySel").val();
	var	url = WEB_ROOT+"transferFacility/transfer";
	var	params = {
		"from_facility_id":from_facility_id,
		"product_id":product_id,
		"from_shipping_id":from_shipping_id,
		"to_shipping_id":to_shipping_id,
		"plan_quantity":plan_quantity,
		"from_province_id":from_province_id,
		"transfer_type":2,
		"transfer_cod_type":transfer_cod_type
	};
	$.ajax({
        url: url,
        type: 'get',
        dataType: "json", 
        data: params
  	}).done(function(data){
  		//结果处理
  		if(data.result == "ok"){
	        alert("操作成功！");
	        // $("#facilitySelect").val('');
	        // $("#plan_quantity").val('')
        }else{
        	alert(data.error_info)
        }
  	}).fail(function(){
  		console.log('error')
  	});
}

</script>
</body>
</html>
