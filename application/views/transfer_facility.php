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
					<th>省份</th>
					<th>快递</th>
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
      <input type="hidden" id="from_province_id" name="from_province_id"/>
      <input type="hidden" id="from_shipping_id" name="from_shipping_id"/>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">订单转仓</h4>
      </div>
      <div class="modal-body">
		<p>
			<label for="from_facility_name">原仓库: </label>
			<input id="from_facility_name" class="modalCommon" type="text" readonly="readonly">
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
			<label for="from_shipping_name">快递: </label>
			<input id="from_shipping_name" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="facilitySelect">目的仓库: </label>
			<select name="" class="modalCommon" id="facilitySelect">
				<option value="1">dsf</option>
			</select>
		</p>
		<p>
			<label for="support_transfer">可转数量: </label>
			<input id="support_transfer" class="modalCommon" type="text" readonly="readonly">
		</p>
		<p>
			<label for="plan_quantity">转移数量: </label>
			<input class="modalCommon" id="plan_quantity" type="number"  min="1" value="1">
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
function transferFacility(from_province_id,facility_name,product_name,province_name,shipping_id,shipping_name,support_transfer){
	var facility_name = $("#facilitySel").find("option:selected").text();
	$("#from_facility_name").val(facility_name);
    $("#from_province_id").val(from_province_id);
	$("#product_name").val(product_name);
	$("#province_name").val(province_name);
	$("#from_shipping_id").val(shipping_id);
	$("#from_shipping_name").val(shipping_name);
	$("#support_transfer").val(support_transfer);
	facility_id = $("#facilitySel").val(),
	product_id = $("#product_id").val();
	facilityList(product_id,from_province_id,facility_id);//可转移的仓库列表
	
}
$(document).ready(function(){
	var facility_id = $("#facilitySel").val();
	if(facility_id !=''){
		getProductList(facility_id);
	}	

	//点击搜索获取可转仓的商品列表
	$("#search").click(function(){
	    var url = $('#WEB_ROOT').val() + 'transferFacility/getCanTransferData',
	    	facility_id = $("#facilitySel").val(),
	    	product_id = $("#product_id").val();
			params = {
				"facility_id" : facility_id,
				"product_id" : product_id,
				"transfer_type" : 1  //1为转仓;2为转快递
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
						transferList = "<tr><td>"+item.product_id+"</td><td>"+item.product_name+"</td><td>"+item.province_name+"</td><td>"+item.shipping_name+"</td>"
						 			 + "<td>"+item.num+"</td><td><input type='button' value='转仓' class='operateBtn' onclick='transferFacility(\""+item.province_id+"\",\""+item.facility_name+"\",\""+item.product_name+"\",\""+item.province_name+"\",\""+item.shipping_id+"\",\""+item.shipping_name+"\",\""+item.num+"\")'/></td></tr>";						
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
		var  from_province_id = $("#from_province_id").val();
		var  from_shipping_id = $("#from_shipping_id").val();
		var  plan_quantity = $("#plan_quantity").val();
		var  to_facility_id = $("#facilitySelect").val();
		var  support_transfer = parseInt($("#support_transfer").val());
		if(to_facility_id =="" || to_facility_id == null){
			alert("请选择目的仓库！");
			return false;
		}else if(plan_quantity =="" || plan_quantity == null){
			alert("请输入转仓的数量！");
			return false;
		}else if(plan_quantity <= 0 || plan_quantity > support_transfer){
			alert("转仓的数量必须是小于可转数量的正整数！");
			return false;
		}else{
			transferFacilityIng(plan_quantity,to_facility_id,from_province_id,from_shipping_id);
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

//获得转仓仓库列表
function facilityList(product_id,from_province_id,exclude_facility_id){
	var url = WEB_ROOT+"transferFacility/getFacilityListByShippingRule";
	$.ajax({
		url: url,
		type: 'post',
		dataType: 'json',
		data : { "product_id" : product_id, "province_id" : from_province_id, "facility_id" : exclude_facility_id}
	})
	.done(function(e) {
		if(e.data.list){
			$("#facilitySelect").empty();
			var facilitySel = "";
			var hasFacility = 0;
			$.each(e.data.list, function(i, item) {
				$("#facilitySelect").append('<option value="'+item.facility_id+'">'+ item.facility_name +'</option>');
				hasFacility = 1;
			});
			if(hasFacility){
				$("#myModalLabel").html("转仓");
				$("#transfer-modal").modal('show');
			}else{
				alert('没有可转的仓库,请设置目的仓库的商品快递');
			}
			
		}else{
			alert(e.error_info);
		}
	})
	.fail(function() {
		console.log("error");
	});
	
}


//转仓请求
function transferFacilityIng(plan_quantity,to_facility_id,from_province_id,from_shipping_id){
	var product_id = $("#product_id").val();
	var from_facility_id = $("#facilitySel").val();
	var support_transfer = parseInt($("#support_transfer").val()),
		url = WEB_ROOT+"transferFacility/transfer",
		params = {
		"from_facility_id":from_facility_id,
		"product_id"      :product_id,
		"to_facility_id"  :to_facility_id,
		"plan_quantity"   :plan_quantity,
		"from_province_id":from_province_id,
		"from_shipping_id":from_shipping_id,
		"transfer_type"   :1
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
