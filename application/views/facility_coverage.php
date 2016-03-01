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
		#district_info_table label {
			width: 24%;
			text-align: left;
		}
	</style>
</head>
<body>
<div style="width: 1000px;margin: 0 auto;">
	<input type="hidden" id="WEB_ROOT" name="WEB_ROOT"
					<?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?>>
	<div id="list">
		<table id="list" class="table table-striped table-bordered ">
		<tr>
			<td width="10%">仓库</td>
			<td width="10%">快递</td>
			<td width="10%">覆盖省份</td>
			<td width="60%">覆盖城市</td>
			<td width="10%">操作</td>
		</tr>
			<?php
			if (isset( $list ) && $list != null) {
				foreach ( $list as $facility ) {
					$facility_id = $facility['facility_id'];
					$facility_name = $facility['facility_name'];
					$shippings = $facility['shippings'];
					echo "<tr>";
					echo "<td rowspan=".count($shippings).">" . $facility_name . "</td>";
					$first = 1;
					foreach($shippings as $shipping){
						if(!$first){
							echo "<tr>";
						}
						$shipping_id = $shipping['shipping_id'];
						$shipping_name = $shipping['shipping_name'];
						$title_name = $facility_name.$shipping_name;
						echo "<td>" . $shipping_name . "</td>";
						$provinces = $shipping['provinces'];
						$province_names = '';
						$city_names = '';
						foreach($provinces as $province){
							$province_id = $province['province_id'];
							$province_name = $province['province_name'];
							$province_names .= $province_name." ";
							
							$citys = $province['citys'];
							foreach($citys as $city){
								$city_id = $city['city_id'];
								$city_name = $city['city_name'];
								$city_names .= $city_name." ";
								$districts = $city['districts'];
								foreach($districts as $district){
									$district_id = $district['district_id'];
									$district_name = $district['district_name'];
								}
							}
						}
						echo "<td>" . $province_names . "</td>";
						echo "<td>" . $city_names . "</td>";
						echo "<td><a class='btn btn-primary btn-sm' target='_blank' href='javascript:void(0)' onclick='onEdit({$facility_id},{$shipping_id},\"{$title_name}\")'>修改</a></td>";
						echo "</tr>";
						$first = 0;
					}
					echo "</tr>";
				}
			}?>
		</table>
	</div>
</div>

<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="region_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 900px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="region_title" name="region_title"></h4>
	      </div>
	      <input type="hidden" id="facility_id" name="facility_id">
	      <input type="hidden" id="shipping_id" name="shipping_id">
	      <div class="modal-body ">
	      		<table id="district_info_table" name="district_info_table" border=3>
		      		
	      		</table>
	      </div>
	    <div class="modal-footer">
	      	<input id="package_sub" type="button" class="btn btn-primary" style="text-align: right" value="保存" onclick="onSave()">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
}) ;  // end document ready function 
function onEdit(facility_id,shipping_id,title_name) {
	$('#district_info_table tr.content').remove();
	var submit_data = {
				"facility_id":facility_id,
				"shipping_id":shipping_id
			};
	  $("#facility_id").val(facility_id);
	  $("#shipping_id").val(shipping_id);
	  $("#region_title").text(title_name+'覆盖区域设置');
	  $("#district_info_table").empty();
	  $("#district_info_table").append("<tr><th id='province_title' style='width: 10%'>省</th><th id='city_title' style='width: 10%'>市</th><th id='district_title' style='width: 80%'>区县</th></tr>");
	    
	  var postUrl = $("#WEB_ROOT").val() + 'facilityCoverage/avaible';
	  $.ajax({
	     url: postUrl,
	     type: 'POST',
	     data:submit_data, 
	     dataType: "json", 
	     xhrFields: {
	       withCredentials: true
	     }
	  	}).done(function(data){
	  	  console.log(data);
	      
	      	  var shipping_name = data.shipping_name;
	      	  for(var province_id in data.provinces){
	      	  	var is_first = 1;
	      	  	var province_name = data.provinces[province_id].province_name;
	      	  	var tr = $("<tr>");
	      	  	var td = $("<td>");
	      	  	td.attr('rowspan', data.provinces[province_id].length);
	      	  	
	      	  	var label = $("<label>");
	      	  	var input = $("<input>");
	      	  	input.attr('type', 'checkbox');
	      	  	input.attr('value', province_id);
	      	  	input.attr('class', 'province');
	      	  	label.append(input);
	      	  	label.append(province_name);
	      	  	td.append(label);
	      	    tr.append(td);
	      	  	for(var city_id in data.provinces[province_id].citys){
	      	  		var city_name = data.provinces[province_id].citys[city_id].city_name;
	      	  		if(!is_first){
	      	  			var tr = $("<tr>");
	      	  		}
	      	  		var td = $("<td>");
	      	  		var label = $("<label>");
		      	  	var input = $("<input>");
		      	  	input.attr('type', 'checkbox');
		      	  	input.attr('value', city_id);
		      	  	input.attr('class', 'city');
		      	  	input.attr('data-parentID', province_id);
		      	  	input.attr('data-rootID', province_id);
		      	  	label.append(input);
		      	  	label.append(city_name);
		      	  	td.append(label);
		      	    tr.append(td);
		      	    var td = $("<td>");
	      	  		for(var district_id in data.provinces[province_id].citys[city_id].districts){
	      	  			var district_name = data.provinces[province_id].citys[city_id].districts[district_id].district_name;
	      	  			var district_id = data.provinces[province_id].citys[city_id].districts[district_id].district_id;
	      	  			var is_already_set = data.provinces[province_id].citys[city_id].districts[district_id].is_already_set;
	      	  			var ignore_wms_address = data.provinces[province_id].citys[city_id].districts[district_id].ignore_wms_address;
			      	  	var label = $("<label>");
			      	  	var input = $("<input>");
			      	  	var button = $("<button>");
			      	  	input.attr('type', 'checkbox');
			      	  	input.attr('value', district_id);
			      	  	input.attr('class', 'district');
			      	  	input.attr('data-parentID', city_id);
			      	  	input.attr('data-rootID', province_id);
			      	  	button.addClass('btn btn-primary btn-sm ignore_wms_address');
			      	  	button.css('float','right');
			      	  	button.css('padding-left','0');
			      	  	button.css('padding-right','0');
			      	  	button.attr('data-whole',ignore_wms_address);
			      	  	button.attr('data-id',district_id);
			      	  	button.attr('data-set',is_already_set);
			      	  	button.html((ignore_wms_address =='1'?'忽略':'考虑')+"wms地址库");
			      	  	button.hide();
			      	  	if (is_already_set == 1) {
							input.attr('checked', 'checked');
							button.show();	
			      	  	}
			      	  	label.append(input);
			      	  	label.append(district_name);
			      	  	if(data.is_self == '1'){
			      	  		label.append(button);
			      	  	}
			      	  	
			      	  	td.append(label);
	      	  		}
	      	  		tr.append(td);
					$("#district_info_table").append(tr);
			      	is_first = 0;
	      	  	}
	      	  }
	      	  $("input.city").each(function(){
	      	  	var length = $(this).parents(td).next('td').find("input.district:checked").length;
		      	  	if($(this).parents(td).next('td').find("input.district").length == length ){
				      $(this).prop("checked",true);
				      $(this).next('button').show();
				  }	
	      	  });

	      	  $("input.province").each(function(){
		      	  	var val = $(this).attr("value");
		      	  	var length = $(this).parents("tbody").find("input.city[data-parentID="+val+"]:checked").length;
		      	  	if($(this).parents("tbody").find("input.city[data-parentID="+val+"]").length == length ){
		      	  		$(this).prop("checked",true);
		      	  	}
	      	  });
	      	  
	      	  $("#region_modal").modal("show");
	      	  $('button.ignore_wms_address').on("click",function(){
	      	  	$(this).attr("disabled",true);
	      	  	var ignore_wms_address = $(this).attr("data-whole");
	      	  	var district_id = $(this).attr("data-id");
	      	  	var is_already_set = $(this).attr("data-set");
	      	      setEnable($(this),facility_id,shipping_id,district_id,ignore_wms_address,is_already_set);
	      	  });

	      	  $("input.province").each(function(){
					$(this).on('change' ,function(){
						if ($(this).prop("checked") == true){
							var parentID = $(this).val();
							$("input[data-rootID="+parentID+"]").each(function(){
								$(this).prop("checked",true);
								$(this).next('button').show();
								
							});
						}else{
							var parentID = $(this).val();
							$("input[data-rootID="+parentID+"]").each(function(){
								$(this).prop("checked",false);
								$(this).next('button').hide();
								
							});
						}
					});
				});
				$("input.city").each(function(){
					$(this).on('change' ,function(){
						if ($(this).prop("checked") == true){
							var parentID = $(this).val();
							$("input[data-parentID="+parentID+"]").each(function(){
								$(this).prop("checked",true);
								$(this).next('button').show();

							});
						}else{
							var parentID = $(this).val();
							$("input[data-parentID="+parentID+"]").each(function(){
								$(this).prop("checked",false);
								$(this).next('button').hide();
							});
						}
					});
				});

				$("input.district").on("change",function(){
					if($(this).parents("td").find("input.district").length == $(this).parents("td").find("input.district:checked").length){
						$("input[value="+$(this).attr('data-parentID')+"]").prop("checked",true);
					}else {
						$("input[value="+$(this).attr('data-parentID')+"]").prop("checked",false);
					}
					if($(this).prop('checked')){
						$(this).next('button').show();
					}else{
						$(this).next('button').hide();
					}
					var dataP = $(this).attr("data-rootID");
					if($(this).parents("tbody").find("input.city[data-parentID="+dataP+"]").length == $(this).parents("tbody").find("input.city[data-parentID="+dataP+"]:checked").length){
						$("input[value="+$(this).attr('data-rootID')+"]").prop("checked",true);
					}else {
						$("input[value="+$(this).attr('data-rootID')+"]").prop("checked",false);
					}
				});

				$("input.city").on("change",function(){
					var dataP = $(this).attr("data-parentID");
					if($(this).parents("tbody").find("input.city[data-parentID="+dataP+"]").length == $(this).parents("tbody").find("input.city[data-parentID="+dataP+"]:checked").length){
						$("input[value="+$(this).attr('data-parentID')+"]").prop("checked",true);
					}else {
						$("input[value="+$(this).attr('data-parentID')+"]").prop("checked",false);
					}
				});
	    });  
}
function setEnable($this,facility_id, shipping_id, district_id, ignore_wms_address, is_already_set) {
	var submit_data = {
		"facility_id": facility_id,
		"shipping_id": shipping_id,
		"district_id": district_id,
		"ignore_wms_address" : ignore_wms_address,
		"is_already_set":is_already_set
	};
	console.log(submit_data);

	var postUrl = $("#WEB_ROOT").val() + 'facilityCoverage/setIgnoreWmsAddress';
	$.ajax({
		url: postUrl,
		type: 'POST',
		data: submit_data,
		dataType: "json",
		xhrFields: {
			withCredentials: true
		}
	}).done(function(data) {
		console.log(data);
		$this.attr("disabled",false);
		if (data.result == "ok") {
			if(ignore_wms_address =="1"){
				$this.html("考虑wms地址库");
				$this.attr("data-whole",'0');
			}else{
				$this.html("忽略wms地址库");
				$this.attr("data-whole",'1');
			}
			
		} else {
			alert("错误。" + data.error_info);
		}
	}).fail(function(data) {
		console.log(data);
	});
}
function onSave() {
	$("#package_sub").attr('disabled',true);
	var facility_id = $("#facility_id").val();
	var shipping_id = $("#shipping_id").val();
	var city_ids = {},
		province_ids = {},
		district_ids = {};

	city_ids.region_type='2';
	city_ids.region_ids=[];
	province_ids.region_type='1';
	province_ids.region_ids=[];
	district_ids.region_type='3';
	district_ids.region_ids=[];

	$("input.province:checked").each(function() {
			if (parseInt($(this).val()) > 0) {
				province_ids.region_ids.push($(this).val());
			}
	});

	$("input.city:checked").each(function() {
		if ( (province_ids.region_ids.indexOf($(this).attr("data-parentid")) ==-1 )) {
			if (parseInt($(this).val()) > 0) {
				city_ids.region_ids.push($(this).val());
			}
		};
	});

	$("input.district:checked").each(function() {
		if ( (city_ids.region_ids.indexOf($(this).attr("data-parentid")))==-1 && (province_ids.region_ids.indexOf($(this).attr("data-rootid")))==-1 ) {
			if (parseInt($(this).val()) > 0) {
				district_ids.region_ids.push($(this).val());
			}
		};
	});

	var districts = {
		city_ids,province_ids,district_ids
	};
	console.log(districts);
	var submit_data = {
		"facility_id": facility_id,
		"shipping_id": shipping_id,
		"districts": districts
	};
	console.log(submit_data);

	var postUrl = $("#WEB_ROOT").val() + 'facilityCoverage/add';
	$.ajax({
		url: postUrl,
		type: 'POST',
		data: submit_data,
		dataType: "json",
		xhrFields: {
			withCredentials: true
		}
	}).done(function(data) {
		$("#package_sub").attr('disabled',false);
		console.log(data);
		if (data.success == "true") {
			alert("保存成功。");
			location.reload();
		} else {
			alert("保存失败。" + data.error_info);
		}
	}).fail(function(data) {
		$("#package_sub").attr('disabled',false);
		console.log(data);
	});
}
</script>
</body>
</html>