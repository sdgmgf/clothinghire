<!doctype html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>拼好货WMS</title>
	<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style type="text/css">
tr {
	height: 50px;
}
tr td:first-child {
	text-align: right;
	width: 15%;
}
input {
	height: 30px;
	margin-left: 15px;
	
}
select {
	height: 30px;
	margin-left: 15px;
}
</style>
</head>
<body>
	<div style="width: 900px;margin:0 auto;">
		<a href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>facilityList" class="btn btn-primary btn-sm">返回仓库列表</a>
		<table width="100%" class="table table-striped table-bordered ">
			<tr>
				<td	colspan="4">
					<div style="width: 100px;margin:0;">
			        	<p style="font-weight: bold;padding-top: 4px;font-size: 20px;">基本信息</p>
			        </div>
				</td>
			</tr>
			
			
			<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>facilityList">
			<tr>
				<td>仓库名:</td>
				<td width="40%">
					<input type="text" name="facility_name" id="facility_name" value="<?php echo $facility_info['facility_name'];?>"/>
				</td>
				
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">仓库类型:</td>
				<td>
					<select name="facility_type" id="facility_type">
						<option value="1" <?php if($facility_info['facility_type'] == '1'){echo "selected";}else{}?>>生产仓</option>
						<option value="2" <?php if($facility_info['facility_type'] == '2'){echo "selected";}else{}?>>生产仓</option>
						<option value="3" <?php if($facility_info['facility_type'] == '3'){echo "selected";}else{}?>>市场虚拟仓</option>
						<option value="4" <?php if($facility_info['facility_type'] == '4'){echo "selected";}else{}?>>产地虚拟仓</option>
						<option value="5" <?php if($facility_info['facility_type'] == '5'){echo "selected";}else{}?>>供应商虚拟仓</option>
						<option value="5" <?php if($facility_info['facility_type'] == '6'){echo "selected";}else{}?>>中转仓</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td>是否可用:</td>
				<td>
					<select name="enabled" id="enabled">
						<option value="1" <?php if($facility_info['enabled'] == '1'){echo "selected";}else{}?>>可用</option>
						<option value="0" <?php if($facility_info['enabled'] == '0'){echo "selected";}else{}?>>不可用</option>
					</select>
				</td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">面单选择:</td>
				<td>
					<select name="is_self_template" id="is_self_template">
						<option value="1" <?php if($facility_info['is_self_template'] == '1'){echo "selected";}else{}?>>自定义面单</option>
						<option value="0" <?php if($facility_info['is_self_template'] == '0'){echo "selected";}else{}?>>快递公司面单</option>
					</select>
				</td>
			</tr>
			<?php 
				$purchase1_time = "";
				$purchase2_time = "";
				$production1_time = "";
				$production2_time = "";
				$begin_time = "";
				$end_time = "";
				$stocktake_deadline = "";
				foreach ($attribute_info as $key => $value){
					if($value['attr_name'] == "purchase_plan1_time"){
						$purchase1_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "purchase_plan2_time"){
						$purchase2_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "production_plan1_time"){
						$production1_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "production_plan2_time"){
						$production2_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "fulfill_start_time"){
						$begin_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "fulfill_end_time"){
						$end_time = substr($value['attr_value'],0,5);
					}else if ($value['attr_name'] == "stocktake_deadline"){
						$stocktake_deadline = substr($value['attr_value'],0,5);
					}
				}
			
			?>
			
			<tr>
				<td>采购计划时间一:</td>
				<td>
					<input type="time" name="purchase1_time" id="purchase1_time" required="required" value="<?php echo $purchase1_time;?>"/>
					<em>&nbsp;&nbsp;&nbsp;&nbsp;( 时间格式：00:00   下同 )</em>
				</td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">采购计划时间二:</td>
				<td>
					<input type="time" name="purchase2_time" id="purchase2_time" required="required" value="<?php echo $purchase2_time;?>"/>
				</td>
			</tr>
			
			
			<tr>
				<td>生产计划时间一:</td>
				<td><input type="time" name="production1_time" id="production1_time" required="required" value="<?php echo $production1_time;?>"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">生产计划时间二:</td>
				<td><input type="time" name="production2_time" id="production2_time" required="required" value="<?php echo $production2_time;?>"/></td>
			</tr>
			
			
			<tr>
				<td>开始时间:</td>
				<td><input type="time" name="begin_time" id="begin_time" required="required" value="<?php echo $begin_time;?>"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">结束时间:</td>
				<td><input type="time" name="end_time" id="end_time" required="required" value="<?php echo $end_time;?>"/></td>
			</tr>
			
			
			<tr>
				<td>盘点截止时间:</td>
				<td><input type="time" name="stocktake_deadline" id="stocktake_deadline" required="required" value="<?php echo $stocktake_deadline;?>"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;"></td>
				<td>
				</td>
			</tr>
			</form>
			<tr>
				<td style="text-align: right;width:15%">仓库地址:</td>
				<td colspan="3"><input type="text" style="width: 70%;" name="facility_address" id="facility_address" value="<?php echo $facility_info['facility_address'];?>"/></td>
			</tr>
			
			<tr>
				<td style="text-align: right;width:10%">省:</td>
				<td><input type="text" style="width: 70%;" name="province_name" id="province_name" value="<?php echo $facility_info['province_name'];?>"/></td>
				<td style="text-align: right;width:10%">市:</td>
				<td><input type="text" style="width: 70%;" name="city_name" id="city_name" value="<?php echo $facility_info['city_name'];?>"/></td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">区:</td>
				<td><input type="text" style="width: 70%;" name="district_name" id="district_name" value="<?php echo $facility_info['district_name'];?>"/></td>
				<td style="text-align: right;width:10%">邮编:</td>
				<td><input type="text" style="width: 70%;" name="postcode" id="postcode" value="<?php echo $facility_info['postcode'];?>"/></td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">详细地址</td>
				<td colspan="3"><input type="text" style="width: 70%;" name="real_address" id="real_address" value="<?php echo $facility_info['real_address'];?>"/></td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">所属片区</td>
				<td colspan="3"><input type="text" style="width: 70%;" name="area_name" id="area_name" readonly="readonly" value="<?php if (isset($facility_info['area_name'])) echo $facility_info['area_name'];?>"/></td>
			</tr>
			<tr>
				<td colspan="4">
					<div style="width: 220px;margin:0 auto;">
						<input type="button" class="btn btn-primary btn-sm" name="submit" id="submit" value="提交修改"/>
					</div>
				</td>
			</tr>
			
			<tr>
				<td	style="text-align: right;width:15%">快递方式</td>
				<td colspan="2">
					<?php 
						if(isset($ship_list)){
							foreach ($ship_list as $key => $value){
								echo "{$value['shipping_name']}"." ";
							}
						}
					?>
				</td>
				<td style="text-align: center;">
					<a class="btn btn-primary btn-sm" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>modifyFacility/viewModifyShipping?facility_id=<?php echo $facility_info['facility_id'];?>">修改</a>
				</td>
			</tr>
			
			<tr>
				<td style="text-align: right;width:15%">覆盖区域</td>
				<td colspan="2">
					<?php 
					if(isset($region_list)){
						foreach ($region_list as $value){
							echo "{$value['region_name']}"." ";
						}
					}
					?>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;width:15%">商品白名单</td>
				<td colspan="2">
					<?php 
					if(isset($product_list)){
						foreach ($product_list as $value){
							echo "{$value['product_name']} </br>";
						}
					}
					?>
				</td>
				<td style="text-align: center;">
				</td>
			</tr>
		</table>
	</div>
</body>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript">
function isNullOrEmpty(strVal) {
	if (strVal == '' || strVal == null || strVal == undefined) {
		return true;
	} else {
		return false;
	}
}
var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
$(document).ready(function(){
	$("#submit").click(function(){
		//取值
		var facility_id = "<?php echo $facility_info['facility_id'];?>";
		var facility_name = $("#facility_name").val();
		var facility_type = $("#facility_type").val();
		var enabled = $("#enabled").val();
		var is_self_template = $("#is_self_template").val();
		var purchase1_time = $("#purchase1_time").val()+":00";
		var purchase2_time = $("#purchase2_time").val()+":00";
		var production1_time = $("#production1_time").val()+":00";
		var production2_time = $("#production2_time").val()+":00";
		var begin_time = $("#begin_time").val()+":00";
		var end_time = $("#end_time").val()+":00";
		var stocktake_deadline = $("#stocktake_deadline").val()+":00";
		var province_name = $("#province_name").val();
		var city_name = $("#city_name").val();
		var district_name = $("#district_name").val();
		var real_address = $("#real_address").val();
		var postcode = $("#postcode").val();
		var facility_address = $("#facility_address").val();
		//验证
		if(facility_name == "" ||facility_name == null){
			alert("请输入仓库名称！");
			return false;
		}else if(!isTime(purchase1_time)) {
			alert("采购计划一时间格式不正确");
			return false;
		}else if(!isTime(purchase2_time)) {
			alert("采购计划二时间格式不正确");
			return false;
		}else if(!isTime(production1_time)) {
			alert("生产计划一时间格式不正确");
			return false;
		}else if(!isTime(production2_time)) {
			alert("生产计划二时间格式不正确");
			return false;
		}else if(!isTime(begin_time)) {
			alert("开始时间格式不正确");
			return false;
		}else if(!isTime(end_time)) {
			alert("结束时间格式不正确");
			return false;
		}else if(!isTime(stocktake_deadline)) {
			alert("盘点截止时间格式不正确");
			return false;
		}else if(isNullOrEmpty(province_name)) {
			alert("省必须填");
			return false;
		}else if(isNullOrEmpty(city_name)) {
			alert("市必须填");
			return false;
		}else if(isNullOrEmpty(district_name)) {
			alert("区必须填");
			return false;
		}else if(isNullOrEmpty(real_address)) {
			alert("详细地址必须填");
			return false;
		}else if(isNullOrEmpty(postcode)) {
			alert("邮编必须填");
			return false;
		}
		
		else if(facility_address == "" || facility_address == null) {
			alert("请输入仓库地址！");
			return false;
		}
		update_facility(facility_id,facility_name,facility_type,enabled,is_self_template,
				purchase1_time,purchase2_time,production1_time,production2_time,
				begin_time,end_time,stocktake_deadline,facility_address,province_name,city_name,
				district_name,real_address,postcode);
	});
	function update_facility(facility_id,facility_name,facility_type,enabled,is_self_template,
			purchase1_time,purchase2_time,production1_time,production2_time,
			begin_time,end_time,stocktake_deadline,facility_address,province_name,city_name,
			district_name,real_address,postcode){
		var myurl = WEB_ROOT+"facilityList/updateFacility";
		var mydata = {
				"facility_id":facility_id,
				"facility_name":facility_name,
				"facility_type":facility_type,
				"enabled":enabled,
				"is_self_template":is_self_template,
				"purchase1_time":purchase1_time,
				"purchase2_time":purchase2_time,
				"production1_time":production1_time,
				"production2_time":production2_time,
				"begin_time":begin_time,
				"end_time":end_time,
				"stocktake_deadline":stocktake_deadline,
				"facility_address":facility_address,
				"province_name":province_name,
				"city_name":city_name,
				"district_name":district_name,
				"real_address":real_address,
				"postcode":postcode
				};
		$.ajax({
	        url: myurl,
	        type: 'POST',
	        data : mydata, 
	        dataType: "json", 
	        xhrFields: {
	             withCredentials: true
	        }
	    }).done(function(data){
	          if(data.success == "OK"){
	            alert("仓库修改成功！");
	            window.location.href = "<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>facilityList";
	          }else{
	            alert(data.error_info);
	          }
	    });
	}
	function isTime(str){
	   var a = str.match(/^(\d{1,2})(:)?(\d{1,2})\2(\d{1,2})$/);
	   if (a == null) {return false;}
	   if (a[1]>=24 || a[3]>=60 || a[4]>=60)
	   {
	       return false;
	   }
	    return true;
	}
});
</script>
</html>
