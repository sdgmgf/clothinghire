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
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
	<div style="width: 60%;margin: 0 auto;">
		<input type="hidden" id="old_product_id" name="old_product_id"/>
		<table class="table table-striped table-bordered ">
			<tr>
				<td width="20%">仓库:</td>
				<td>
					<input id="facility_id" name="facility_id" style="width: 90%; float:left;display:none;" readonly="readonly" value="<?php echo $facility['facility_id'];?>" />
					<input id="facility_name" name="facility_name" style="width: 90%; float:left;" readonly="readonly" value="<?php echo $facility['facility_name'];?>" />
				</td>
			</tr>
			<tr>
				<td>商品:</td>
				<td>
					<select style="width: 90%;float: left;" name="product_list" id="product_list">
						<?php if(isset($product_list) && count($product_list)>0){
							foreach ($product_list as $product) {
								echo "<option value=\"{$product['product_id']}\">{$product['product_name']}</option>"; 
							}}
						?>
					</select>
			    	<input  type="hidden" style="width: 10%;"  readonly="readonly" id="product_id" name="product_id" value="<?php if(isset($product_list) && count($product_list)>0){echo $product_list[0]['product_id'];}?>"/><br/>
				</td>
			</tr>
			<tr>
			<td>省：</td>
			<td>
				<select  style="width: 69%;"  name="province_id" id="provinceSel">
                        <?php
                            if ($province_list) {
                                foreach($province_list as $region) {
                                    echo "<option value=\"{$region['region_id']}\" >{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
                    <label><input type="checkbox" onclick="if(this.checked) { $('#l2').css('display','none'); $('#citySel').css('display','none'); $('#districtSel').css('display','none'); } else { $('#citySel').css('display','inline'); $('#districtSel').css('display','inline'); $('#l2').css('display','inline-block');$('#s2').prop('checked',false); }">整个省</label>
                    <select  style="width: 69%;"  name="city_id" id="citySel">
                        <?php
                            if ($city_list) {
                                foreach($city_list as $region) {
                                    echo "<option value=\"{$region['region_id']}\" >{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
                    <label id="l2"><input id="s2" type="checkbox" onclick="if(this.checked) $('#districtSel').css('display','none'); else $('#districtSel').css('display','inline');">整个市</label>
                    <select  style="width: 69%;"  name="district_id" id="districtSel">
                        <?php
                            if ($district_list ) {
                                foreach($district_list as $region) {
                                    echo "<option value=\"{$region['region_id']}\" >{$region['region_name']}</option>";
                                }
                            }
                         ?>
                    </select>
			</td>
			</tr>
			<tr>
				<td>快递方式:</td>
				<td>
					<select style="width: 90%;float: left;" name="facility_shipping_list" id="facility_shipping_list">
						<?php 
							foreach ($facility_shipping_list as $shipping) {
								echo "<option value=\"{$shipping['shipping_id']}\">{$shipping['shipping_name']}</option>"; 
							}
						?>
					</select>
				</td>
				<input  type="hidden" style="width: 10%;"  readonly="readonly" id="shipping_id" name="shipping_id" value="<?php if(isset($facility_shipping_list) && count($facility_shipping_list)>0){echo $facility_shipping_list[0]['shipping_id'];}?>"/><br/>
			</tr>
			<tr>
				<td>包装方案:</td>
				<td>
				<input id="supplies_product_name" name="supplies_product_name" style="width: 90%; float:left;" readonly="readonly" />
				</td>
			</tr>
			<tr><td colspan="2">
				<a style='float: left;' class='btn btn-primary btn-sm' target='_blank' href='<?php echo $WEB_ROOT;?>skuShipping/skuShippingDistribute?facility_id=<?php echo $facility['facility_id'];?>'>查看商品快递</a>
				<button style="float: right;display:none;" class="btn btn-primary" id="to_set_package_page" >未设置包装方案,去设置</button>
				<button style="float: right;display:none;" class="btn btn-primary" id="submit" >添加</button></td>
			</tr>
			<input  type="hidden" style="width: 10%;"  readonly="readonly" id="supplier_product_name" name="supplier_product_name" value="<?php if(isset($supplier_product_name)){echo $supplier_product_name;}?>"/><br/>
		</table>
	</div>
	<div id="list">
	</div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
$(document).ready(function(){
	$.ajax({
        url: WEB_ROOT+"skuShipping/shippingList?facility_id="+$("#facility_id").val(),
        type: 'get',
        dataType: "text", 
        xhrFields: {
             withCredentials: true
        }
  }).done(function(vm){
	  $("#list").html(vm);
  });
  check_product_package();
	  
	$('#product_list').change(function () {
   	   var product_id = $("#product_list option:selected").val();
   	   $("#product_id").val(product_id);
   	   check_product_package();
   });
   $('#facility_shipping_list').change(function () {
   	   var shipping_id = $("#facility_shipping_list option:selected").val();
   	   $("#shipping_id").val(shipping_id);
   	   check_product_package();
   });
});
function check_product_package(){
	var facility_id = $("#facility_id").val();
	var product_id = $("#product_id").val();
	var shipping_id = $("#shipping_id").val();
	var myurl = WEB_ROOT+"skuShipping/getProductPackagingName?facility_id="+facility_id+"&goods_product_id="+product_id+"&shipping_id="+shipping_id;
	$.ajax({
	    url: myurl,
	    type: 'get',
	    dataType: "json", 
	    xhrFields: {
	         withCredentials: true
	    }
	 }).done(function(data){
		if(data.result == "ok"){
			var supplies_product_name = data.data.supplies_product_name;
			$("#supplies_product_name").val(supplies_product_name);
			var supplies_product_id = data.data.supplies_product_id;
			if(isNullOrEmpty(supplies_product_id)){
				$('#to_set_package_page')[0].style.display = "block";
				$('#submit')[0].style.display = "none";
			}else{
				$('#to_set_package_page')[0].style.display = "none";
				$('#submit')[0].style.display = "block";
			}
		}else{
		  	 alert("添加失败！"+data.error_info);
		}
	 });
}
$('#to_set_package_page').click(function(){
	var facility_id = $("#facility_id").val();
	var product_id = $("#product_id").val();
	var shipping_id = $("#shipping_id").val();
	var url =WEB_ROOT+'SetPackaging/query?facility_id='+facility_id+'&goods_product_id='+product_id+'&shipping_id='+shipping_id;
	location.href = url;
});
$('#submit').click(function(){
	var facility_id = $("#facility_id").val();
	var product_id = $("#product_id").val();
	var region_type = 3;//默认region为区
    if ($("#citySel").css("display") == "none") {
        region_type = 1;
        var region_id = $("#provinceSel option:selected").val();
    } else if($("#districtSel").css("display") == "none"){//取市的id
		region_type = 2;
		var region_id = $("#citySel option:selected").val();
	}else{//取区的id
		var region_id = $("#districtSel option:selected").val();
	}
	var shipping_id = $("#facility_shipping_list option:selected").val();

	if(isNullOrEmpty(facility_id)){
		alert("无效的仓库！");return false;
	}
	if(isNullOrEmpty(product_id)){
		alert("未指定商品！");return false;
	}
	if(isNullOrEmpty(region_id)){
		alert("未指定配送区域！");return false;
	}
	if(isNullOrEmpty(shipping_id)){
		alert("未指定快递！");return false;
	}
	$.ajax({
        url: WEB_ROOT+"skuShipping/addSkuShipping",
        type: 'post',
        data: {"facility_id":facility_id, "product_id":product_id, "region_id":region_id, "region_type":region_type, "shipping_id":shipping_id},
        dataType: "json", 
        xhrFields: {
             withCredentials: true
        }
  }).done(function(data){
	  if(data.success == "true"){
		  	alert("商品快递添加成功！");
		  	$.ajax({
		        url: WEB_ROOT+"skuShipping/shippingList?facility_id="+facility_id,
		        type: 'get',
		        dataType: "text", 
		        xhrFields: {
		             withCredentials: true
		        }
		  }).done(function(vm){
			  $("#list").html(vm);
		  });
	  }
	  else{
	  	 alert("添加失败！"+data.error_info);
	  }
		  
  });
});

$('#provinceSel').change(function () {
	 province_id = $("#provinceSel").val();
	 changeRegion(province_id, $("#citySel"), 2);
});

$('#citySel').change(function () {
	 city_id = $("#citySel").val();
	 changeRegion(city_id, $("#districtSel"), 3);
});

function changeRegion(parent_id, sel, region_type) {
	var facility_id = $("#facility_id").val();
	var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
	var myurl = WEB_ROOT+"facilityCoverage/getFacilityCoverageRegion?facility_id="+facility_id+"&region_type="+region_type+"&parent_region_id="+parent_id;
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
          	if (data != null && data.data != null && data.data.list != null) {
          		$(sel).empty();
          		for (var i =0; i < data.data.list.length; i++) {
          			var region = data.data.list[i];
          			var option = $("<option>").val(region.region_id).text(region.region_name);
          			$(sel).append(option);
          		}
          		
          		if (region_type == 2) {
	          		city_id = $("#citySel").val();
	    	        changeRegion(city_id, $("#districtSel"),3);
          		}
          	} else {
          		$(sel).empty();
          		if (region_type == 2) {
	          		$("#districtSel").empty();
          		}
          	}
          });
}
</script>
</body>
</html>
