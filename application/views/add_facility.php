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
	<form method="post" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>addFacility">
		<table width="100%">
			<tr>
				<td>仓库名:</td>
				<td width="30%"><input type="text" name="facility_name" id="facility_name"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">仓库类型:</td>
				<td>
					<select name="facility_type" id="facility_type">
						<option value="1">中心仓</option>
						<option value="2">城市仓</option>
						<option value="3">市场虚拟仓</option>
						<option value="4">产地虚拟仓</option>
						<option value="5">供应商虚拟仓</option>
						<option value="6">中转仓</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>是否可用:</td>
				<td>
					<select name="enabled" id="enabled">
						<option value="1">可用</option>
						<option value="0">不可用</option>
					</select>
				</td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">面单选择:</td>
				<td>
					<select name="is_self_template" id="is_self_template">
						<option value="1">自定义面单</option>
						<option value="0">快递公司面单</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>采购计划时间一:</td>
				<td><input type="time" name="purchase1_time" id="purchase1_time" required="required"/><em>&nbsp;&nbsp;&nbsp;&nbsp;( 时间格式：00:00   下同 )</em></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">采购计划时间二:</td>
				<td><input type="time" name="purchase2_time" id="purchase2_time" required="required"/></td>
			</tr>
			<tr>
				<td>生产计划时间一:</td>
				<td><input type="time" name="production1_time" id="production1_time" required="required"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">生产计划时间二:</td>
				<td><input type="time" name="production2_time" id="production2_time" required="required"/></td>
			</tr>
			<tr>
				<td>开始时间:</td>
				<td><input type="time" name="begin_time" id="begin_time" required="required"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">结束时间:</td>
				<td><input type="time" name="end_time" id="end_time" required="required"/></td>
			</tr>
			<tr>
				<td>盘点截止时间:</td>
				<td><input type="time" name="stocktake_deadline" id="stocktake_deadline" required="required"/></td>
				<td style="text-align: right;width:15%;border-left: 1px solid #000;">分配方式:</td>
				<td>
					<select name="schedule_mode" id="schedule_mode">
						<option value="manual_schedule_manual_shipping">纯手动分配</option>
						<option value="manual_schedule_auto_shipping">手动安排自动发送</option>
						<option value="auto_schedule_auto_shipping">全自动分配</option>
					</select>
				</td>
			</tr>
			
			<tr>
				<td style="text-align: right;width:15%">仓库地址:</td>
				<td colspan="3"><input type="text" style="width: 70%;" name="facility_address" id="facility_address"/></td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">省:</td>
				<td>
					<select style="width: 60%;" name="province_name" id="province_name">
						<option value="all" >全部</option>
                        <?php
                            if (isset($province_list)) {
                                foreach($province_list['regions'] as $region) {
                                    echo "<option value=\"{$region['region_id']}\" " . (isset($province_id) && $province_id == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                }
                            }
                         ?>
					</select>
				</td>
				<td style="text-align: right;width:10%">市:</td>
				<td>
					<select style="width: 36%;" name="city_name" id="city_name">
						<option value="all" >全部</option>
					</select>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">区:</td>
				<td>
					<select style="width: 60%;" name="district_name" id="district_name" >
	                    <option value="">全部</option>
	                </select>
				</td>
				<td style="text-align: right;width:10%">邮编:</td>
				<td><input type="text" style="width: 36%;" name="postcode" id="postcode" required="required"/></td>
			</tr>
			<tr>
				<td style="text-align: right;width:10%">所属片区:</td>
				<td>
					<select style="width: 60%;float: left;" name="area_id" id="area_id">
					<?php if (isset($area_list)) {foreach ($area_list['data'] as $area) {
								echo "<option value=\"{$area['area_id']}\">{$area['area_name']}</option>"; 
							}}
					?>
					</select>
				</td>
				<td style="text-align: right;width:10%">详细地址</td>
				<td colspan="3"><input type="text" style="width: 70%;" name="real_address" id="real_address" required="required"/></td>
			</tr>
			<tr>
				<td colspan="4">
					<div style="width:140px;margin:0 auto;">
						<input type="button" class="btn btn-primary btn-sm" name="submit" id="submit" value="提交"/>
						<input type="button" class="btn btn-primary btn-sm" name="reset" id="reset" value="重置"/>
					</div>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.core-2.5.2-zh.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/mobiscroll.datetime-2.5.1-zh.js"></script> 
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
			$("#purchase1_time").val("23:00");
			$("#purchase2_time").val("05:00");
			$("#production1_time").val("09:00");
			$("#production2_time").val("12:00");
			$("#begin_time").val("12:00");
			$("#end_time").val("12:00");
			$("#stocktake_deadline").val("04:00");

			$('#reset').click(function() {
				window.location.reload();
			});

		    $("#submit").click(function(){
		    	var province_name = $("#province_name").val();
				var city_name = $("#city_name").val();
				if(isNullOrEmpty(province_name)) {
					alert("省必须填");
					return false;
				}else if(isNullOrEmpty(city_name)) {
					alert("市必须填");
					return false;
				}
				submitFacility(province_name, city_name);
		    });
			
		});

		function submitFacility(province_name, city_id){
			//取值
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
			var facility_address = $("#facility_address").val();
			var province_name = $("#province_name").find('option:selected').text();
			var city_name = $("#city_name").find('option:selected').text();
			var district_name = $("#district_name").find('option:selected').text();
			var real_address = $("#real_address").val();
			var postcode = $("#postcode").val();
			var schedule_mode = $("#schedule_mode").val();
			var area_id = $("#area_id").val();
			//验证
			console.log(typeof(purchase1_time)+"\n"+purchase2_time+"\n"+production1_time+"\n"+production2_time+"\n"+begin_time+"\n"+end_time);
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
			}else if(facility_address == "" || facility_address == null) {
				alert("请输入仓库地址！");
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
			}else if(isNullOrEmpty(schedule_mode)){
				alert("分配方式必须填");
				return false;
			}

			$("#submit").attr("disabled","disabled");
			
			add_facility(facility_name,facility_type,enabled,is_self_template,
					purchase1_time,purchase2_time,production1_time,production2_time,
					begin_time,end_time,stocktake_deadline,facility_address,province_name,city_name,
					district_name,real_address,postcode,schedule_mode,area_id,city_id);
			$("#submit").removeAttr("disabled");
		}

		function testProvince(province_name, city_name){
			$.ajax({
                url: WEB_ROOT+"region/getRegionId",
                type: 'POST',
                data : {"region_name":province_name}, 
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
	        }).done(function(data){
	              if(!isNullOrEmpty(data) && !isNullOrEmpty(data.region) && data.region.region_id > 0){
					var province_id = data.region.region_id;
					testCity(province_name, city_name);
		          }else{
	                alert("您填写的省份名称无效！");
	                return false;
	              }
	        });
		}

		function testCity(province_name, city_name){
			$.ajax({
                url: WEB_ROOT+"region/getRegionId",
                type: 'POST',
                data : {"region_name":city_name}, 
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
	        }).done(function(data){
	              if(!isNullOrEmpty(data) && !isNullOrEmpty(data.region) && data.region.region_id > 0){
					submitFacility(province_name, data.region.region_id);
		          }else{
	                alert("您填写的市名称无效！");
	                return false;
	              }
	        });
		}
		function add_facility(facility_name,facility_type,enabled,is_self_template,
				purchase1_time,purchase2_time,production1_time,production2_time,
				begin_time,end_time,stocktake_deadline,facility_address,province_name,city_name,
				district_name,real_address,postcode,schedule_mode,area_id,city_id){
			
			var myurl = WEB_ROOT+"addFacility/insertFacilityData";
			var mydata = {
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
					"postcode":postcode,
					"schedule_mode":schedule_mode,
					"area_id":area_id,
					"city_id":city_id
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
	                alert("仓库添加成功！");
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

$('#province_name').change(function () {
     province_id = $("#province_name").val();
     changeRegion(province_id, $('#city_name'),0);
});   

$('#city_name').change(function () {
    var city_id = $("#city_name").val();
    changeRegion(city_id, $("#district_name"), 3);
});

function changeRegion(parent_id, sel, region_type) {
    var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
    var myurl = WEB_ROOT+"region/cityList?parent_id="+parent_id;
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
            if (data != null && data.data != null) {
                $(sel).empty();
                var option = $("<option>").val("").text("全部");
                $(sel).append(option);
                for (var i =0; i < data.data.length; i++) {
                    var region = data.data[i];
                    var option = $("<option>").val(region.region_id).text(region.region_name);
                    $(sel).append(option);
                }
                
                if (region_type == 2) {
                    city_id = $("#citySel").val();
                    changeRegion(city_id, $("#district_name"));
                }
            } else {
                $(sel).empty();
                if (region_type == 2) {
                    $("#district_name").empty();
                }
            }
          });
}
	</script>
</body>
</html>