<!doctype html>
<html>
<head>
<title>商品</title>
<meta charset="utf-8">
<meta name="viewport"
	content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-store">
<meta http-equiv="Expires" content="0">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">	
<link rel="stylesheet"
	href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">	
<link rel="stylesheet"
	href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--[if lt IE 9]>
<script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
<![endif]-->

</head>
<body id="main">
	<!-- <div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div> -->
	<div class="container">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<form action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>getSkuShippingList" method="get">
			<p>
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
              <option value="">请选择仓库</option>
            </select>
            <label for="product_id">商品：</label>
            <select id="product_id" name="product_id">
              <option value="">请选择商品</option>
            </select>
            <label for="shipping_id">快递：</label>
            <select id="shipping_id" name="shipping_id">
              <option value="">请选择快递</option>
            </select>
            <label for="supplies_product_id">包装方案：</label>
            <select id="supplies_product_id" name="supplies_product_id">
              <option value="">请选择包装方案</option>
            </select>
          </p>
			<!-- <div class="form-div"><label></label><input type="text"></div> -->
			<button type="button" class="btn btn-primary btn-sm" id="query">添加 </button>
		</form>

		<div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th> 省 </th>
                                        <th> 市</th>
                                        <th> 区 </th>
                                        <th> 快递</th>
                                        <th>包装方案</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	
                                </tbody>
                            </table>

	</div>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
		      </div>
		      <div class="modal-body">
		        
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        <button type="button" class="btn btn-primary">Save changes</button>
		      </div>
		    </div>
  		</div>
	</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	
	$(function(){
		var table;
		var flag  = true;
		var areaId = $('#area_id').val(),
			postFacility = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
		$("#facility_id").html('<option value="">请选择仓库</option>');
		$("#product_id").html('<option value="">请选择商品</option>');
		$.ajax({
			type: "post",
			url: postFacility,
			data: {
				"area_id": areaId
			}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				$.each(data, function(i, item) {
					var facilityArea = item[0];
					$("#facility_id").append("<option value='" + facilityArea.facility_id + "'>" + facilityArea.facility_name + "</option>");
				});
			},
			error: function() {
				alert('参数错误');
			}
		});
	


	$("#facility_id").change(function() {
      var facilityId = $('#facility_id').val(),
          postShipping = $('#WEB_ROOT').val() + 'Commons/getAvaiableProduct';
          $("#product_id").html('<option value="">请选择商品</option>');
        $.ajax({
            type: "post",
            url: postShipping,
            data: {"facility_id" : facilityId}, // 传入获取到的仓库id
            dataType: "json",
            success: function(data) {
                $.each(data, function(i, item) {
                 // console.log($(this));
                  $("#product_id").append("<option value='" + $(this)[0]['product_id'] + "'>" + $(this)[0]['product_name'] + "</option>");
                });
            },
            error: function() {
              alert('参数错误');
            }
        });

        var shippingId = $('#shipping_id').val(),
          postShipping = $('#WEB_ROOT').val() + 'Commons/getShippingList';
          $("#shipping_id").html('<option value="">请选择快递</option>');
         $.ajax({
            type: "post",
            url: postShipping,
            data: {"facility_id" : facilityId}, // 传入获取到的仓库id
            dataType: "json",
            success: function(data) {
            	console.log(data['shipping']);
                $.each(data['shipping'], function(i, item) {
                 console.log($(this)[0]);
                  $("#shipping_id").append("<option value='" + $(this)[0]['shipping_id'] + "'>" + $(this)[0]['shipping_name'] + "</option>");
                });
            },
            error: function() {
              alert('参数错误');
            }
        });
    });

	$("#supplies_product_id").change(function() {
		var shippingId = $('#shipping_id').val(),
			postShipping = $('#WEB_ROOT').val() + 'Commons/getAvaiableProduct';
		$("#product_id").html('<option value="">请选择商品</option>');
		$.ajax({
			type: "post",
			url: postShipping,
			data: {
				"shipping_id": shippingId
			}, // 传入获取到的仓库id
			dataType: "json",
			success: function(data) {
				$.each(data, function(i, item) {
					// console.log($(this));
					$("#supplies_product_id").append("<option value='" + $(this)[0]['#supplies_product_id'] + "'>" + $(this)[0]['#supplies_product_name'] + "</option>");
				});
			},
			error: function() {
				alert('参数错误');
			}
		});

		
	});
	

	$("#query").click(function(){
		$('tbody').empty();
		var shipping_id = $("#shipping_id").val();
		var facility_id = $("#facility_id").val();
		var product_id = $("#product_id").val();
		var supplies_product_id = $("#supplies_product_id").val();
		var param = {
			"shipping_id":shipping_id,
			"facility_id":facility_id,
			"product_id":product_id,
			"supplies_product_id":supplies_product_id
		};

		$.ajax({
			url: '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>skuShipping/getDistributionShippingDetail',
			type: 'POST',
			data: param,
			dataType: 'json',
		})
		.done(function(data) {
			if(data['success'] == "false"){
				alert(data['error_info']);
				return false;
			}
	    	console.log(data['list']);
	    	var html = '<tr>';
	    	for(var x in data['list']){
	    		
	    		console.log(data['list'][x]['provinces']);
	    		// html += "<td>"+data['list'][x]['facility_name']+"</td>";
	    		for(var y in data['list'][x]['provinces']){
	    			console.log(data['list'][x]['provinces'][y]['province_name'])
	    			var length =data['list'][x]['provinces'][y].length;
	    			html += "<td rowspan="+length+">"+data['list'][x]['provinces'][y]['province_name']+"</td>";
	    			
	    			for(var z in data['list'][x]['provinces'][y]['citys']){
	    				var citys = data['list'][x]['provinces'][y]['citys'];
	    				console.log(citys);
	    				html += "<td>"+citys[z]['city_name']+"</td>";
	    				var districts = '';
	    				for(var w in citys[z]['districts']){
	    					districts += citys[z]['districts'][w]['district_name']+' ';
	    				}
	    				html += "<td>"+districts+"</td>";
	    			}
	    			
	    			
	    		}

	    		html+= "<td>"+data['list'][x]['shipping_name']+"</td>";
	    		html+= "<td>"+data['list'][x]['supplies_product_name']+"</td>";

	    	}
	    	html += "<td rowspan="+length+">"+"<button type='button' class='btn btn-primary btn-sm' id='detail' data-toggle='modal' data-target='#myModal'>详情 </button>"+"</td>";
	    	html += "</tr>";
	    	$('tbody').append(html);
		})
		
	});


	$("#myModal").click(function(){
		var postUrl = $("#WEB_ROOT").val() + 'facilityCoverage/avaible';
		$.ajax({
	     url: postUrl,
	     type: 'POST',
	     // data:submit_data, 
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
	      	  			var is_already_set = data.provinces[province_id].citys[city_id].districts[district_id].is_already_set;
			      	  	var label = $("<label>");
			      	  	var input = $("<input>");
			      	  	input.attr('type', 'checkbox');
			      	  	input.attr('value', district_id);
			      	  	input.attr('class', 'district');
			      	  	input.attr('data-parentID', city_id);
			      	  	input.attr('data-rootID', province_id);
			      	  	if (is_already_set == 1) {
			      	  		input.attr('checked', 'checked');
			      	  	}
			      	  	label.append(input);
			      	  	label.append(district_name);
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
	      	  $("input.province").each(function(){
					$(this).on('change' ,function(){
						if ($(this).prop("checked") == true){
							var parentID = $(this).val();
							$("input[data-rootID="+parentID+"]").each(function(){
								$(this).prop("checked",true);
							});
						}else{
							var parentID = $(this).val();
							$("input[data-rootID="+parentID+"]").each(function(){
								$(this).prop("checked",false);
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
							});
						}else{
							var parentID = $(this).val();
							$("input[data-parentID="+parentID+"]").each(function(){
								$(this).prop("checked",false);
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
	});
});
</script>
</body>
