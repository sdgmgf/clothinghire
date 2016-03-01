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
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet"
	href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<!--[if lt IE 9]>
<script src="http://assets.yqphh.com/assets/js/html5shiv.min-3.7.2.js"></script>
<![endif]-->
<style type="text/css">
	label {
		text-align: left;
	}
</style>

</head>
<body id="main">
	<div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
	<div class="container">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<form class="col-sm-10" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>getSkuShippingList" method="get">
			<p>
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
              <option value="">请选择仓库</option>
            </select><br />
            <label for="product_id">商品：</label>
            <!-- <select id="product_id" name="product_id"> -->

              <!-- <option value="">请选择商品</option> -->
            <!-- </select> -->
            <input type="text" style="width: 45%;" id="product_id" name="product_id" />
            <input type="hidden"  id="product_id_real" name="product_id1" />
          </p>
			<!-- <div class="form-div"><label></label><input type="text"></div> -->
			<button type="button" class="btn btn-primary btn-sm" id="query" style="margin-left:50%">搜索 </button>
		</form>

		<div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                    	<th> PRODUCT_ID</th>                                    
                                        <th> 商品 </th>
                                        <th> 仓库 </th>
                                        <th> 已设置省 </th>
                                        <th> 已设置市</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	
                                </tbody>
                            </table>

	</div>
	<!-- Modal -->
<div>
	<div class="modal fade ui-draggable" id="region_modal" role="dialog"  >
	  <div class="modal-dialog" style="width: 700px">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" id="btnClose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="region_title" name="region_title"></h4>
	      </div>
	      <input type="hidden" id="facility_id1" name="facility_id">
	      <input type="hidden" id="product_id1" name="product_id">
	      <div class="modal-body ">
	      		<table id="district_info_table" name="district_info_table" border=3>
		      		
	      		</table>
	      </div>
	    <div class="modal-footer">
	      	<input id="package_sub" type="button" class="btn btn-primary" style="text-align: right;" value="保存" onclick="onSave()">
	      </div>
	    </div>
	  </div>
	</div>
</div>
<!-- modal end  -->
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/distruct.js"></script>
	<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
	<script type="text/javascript">
	var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
	var loadding = '<div id="loadding" class="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>';
	function onEdit(facility_id, product_id, title_name, getUrl) {
		$('#district_info_table tr.content').remove();
		var submit_data = {
			"facility_id": facility_id,
			"product_id": product_id
		};
		$("#facility_id1").val(facility_id);
		$("#product_id1").val(product_id);
		$("#region_title").text(title_name + '覆盖区域设置');
		$("#district_info_table").empty();
		$("#district_info_table").append("<tr><th id='province_title' style='width: 30%'>省</th><th id='city_title' style='width: 70%'>市</th></tr>");

		var postUrl = $("#WEB_ROOT").val() + getUrl;
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
			var html = '';
			if(data.list.length == 0){
				$('#region_modal').modal('hide');
				alert("请先设置分快递规则！");
				return false;
			}
			$('#region_modal').modal('show');
			for(var x in data.list){
				var province = data.list[x];
				html += "<tr>";
				html += "<td><label><input type='checkbox' class='province' value="+province['province_id']+">"+province['province_name']+"</label></td>";
				html += "<td>";
				for(var y in province['citys']) {
					var city = province['citys'][y];
					if(city['is_already_set'] == 0){
						html += "<label><input type='checkbox' class='city' value="+city['city_id']+">"+city['city_name']+"</label>";
					} else {
						html += "<label><input type='checkbox' class='city' checked value="+city['city_id']+">"+city['city_name']+"</label>";
					}
					
				}
				html += "</td>";
			}
			$("#district_info_table").append(html);
			$("input.province").each(function(){
				if($(this).parents('td').next().find(".city").length == $(this).parents('td').next().find(".city:checked").length){
						$(this).prop("checked",true);
					}else {
						$(this).prop("checked",false);
					}
				$(this).on("change",function(){
					
					if($(this).prop("checked")==true){
						$(this).parents('td').next().find(".city").prop("checked",true);
					}else {
						$(this).parents('td').next().find(".city").prop("checked",false);
					}
				});
			});

			$("input.city").on("change",function(){
				if($(this).parents('td').find('.city').length == $(this).parents('td').find('.city:checked').length){
					$(this).parents('td').prev().find('.province').prop("checked",true);
				} else {
					$(this).parents('td').prev().find('.province').prop("checked",false);
				}
			});

		});
	}
	function onSave() {
		$("#package_sub").prop("disabled",true);
		var facility_id = $("#facility_id1").val();
		var product_id = $("#product_id1").val();
		var citys = [];
		$("input.city").each(function() {
			if ($(this).prop("checked")) {
				if (parseInt($(this).val()) > 0) {
					citys.push($(this).val());
				}
			};
		});
		var submit_data = {
			"facility_id": facility_id,
			"product_id": product_id,
			"city_ids": citys
		};

		var postUrl = $("#WEB_ROOT").val() + 'skuRegionFacility/addSkuRegionFacility';
		$.ajax({
			url: postUrl,
			type: 'POST',
			data: submit_data,
			dataType: "json",
			xhrFields: {
				withCredentials: true
			}
		}).done(function(data) {
			$("#package_sub").prop("disabled",false);
			console.log(data);
			if (data.success == "true") {
				alert("保存成功。");
				$('#region_modal').modal('hide');
				$("#query").trigger('click');
			} else {
				alert("保存失败。" + data.error_info);
			}
		}).fail(function(data) {
			console.log(data);
		});
	}
	function getFacility() {
		postFacility = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
		$("#facility_id").html('<option value="">请选择仓库</option>');
		$.ajax({
			type: "post",
			url: postFacility,
			data: {}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				if (data.result == "ok") {
					for (var n in data.data) {
						$("#facility_id").append("<option value='" + data.data[n].facility_id + "'>" + data.data[n].facility_name + "</option>");
					}
				} else {
					alert(data.error_info);

				}
			},
			error: function() {
				alert('参数错误');
			}
		});
	}
	function getProduct() {

		$("#product_id").unautocomplete();
		$("#product_id").val('');
		var facilityId = $('#facility_id').val() || ' ',
			postShipping = $('#WEB_ROOT').val() + 'Commons/getAvaiableProduct';
		$.ajax({
			type: "post",
			url: postShipping,
			data: {
				"facility_id": facilityId
			}, // 传入获取到的仓库id
			dataType: "json",
			success: function(data) {
				$("#loadding").hide();
				if(data.result == "ok"){
				$("#product_id").unautocomplete();
				$("#product_id").autocomplete(data.data.list, {
					minChars: 0,
					width: 310,
					max: 100,
					matchContains: true,
					autoFill: false,
					formatItem: function(row, i, max) {
						return i + "/" + max + ": \"" + row.product_name;
					},
					formatMatch: function(row, i, max) {
						return row.product_name;
					},
					formatResult: function(row) {
						return (row.product_name);
					}
				}).result(function(event, row, formatted) {
					$('#product_id_real').val(row.product_id);
				});
					// for (var n in data.data.list){
					// 	$("#product_id").append("<option value='" + data.data.list[n]['product_id'] + "'>" + data.data.list[n]['product_name'] + "</option>");

					// }
				}else {
					alert(data.error_info);
				}
			},
			error: function() {
				alert('参数错误');
			}
		});
	}
	$(function() {
		var table;
		var flag = true;
		getFacility();
		getProduct();


		$("#facility_id").change(function() {
			getProduct();
		});


		$("#query").click(function() {
			var product_id = $("#product_id_real").val();
			if (product_id == '' || product_id == null || product_id == undefined) {
				alert("请选择商品");
				return;
			}
			$('tbody').empty();
			$('tbody').html(loadding);
			$("#query").prop("disabled", true);
			var facility_id = $("#facility_id").val();

			var param = 　 {
				"facility_id": facility_id,
				"product_id": product_id
			};

			$.ajax({
				url: '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>skuRegionFacility/getSkuRegionFacilityListData',
				type: 'POST',
				data: param,
				dataType: 'json',
			})
				.done(function(data) {
					$("#query").prop("disabled", false);
					$(".loadding").hide();
					html = "";
					for (var x in data['list']) {
						html += "<tr>";
						var product_id = data['list'][x]['product_id'];
						var product_name = data['list'][x]['product_name'];
						var length = data['list'][x]['length'];
						html += "<td rowspan=" + length + ">" + product_id + "</td>";
						html += "<td rowspan=" + length + ">" + product_name + "</td>";
						var p_first = 1;
						for (var y in data['list'][x]['facilitys']) {
							if (p_first != 1) {
								html += "<tr>";
							}
							var facility = data['list'][x]['facilitys'];
							var length = facility[y]['length'];
							html += "<td rowspan=" + length + ">" + facility[y]['facility_name'] + "</td>";
							p_first = 0;
							// console.log()

							var f_first = 1;
							var last = 1;
							if (facility[y]['provinces'].length == 0) {
								if (f_first != 1) {
									html += "<tr>";
								}
								html += "<td></td><td></td>";
								f_first = 0;
								html += "<td rowspan=" + length + ">" + "<button type='button' class='btn btn-primary btn-sm detail'  data-target='#region_modal' data-fid="+facility[y]['facility_id']+ " data-pid="+product_id+" data-pname="+product_name+" data-fname="+facility[y]['facility_name']+">操作</button>" + "</td>";
							} else {
								for (var z in facility[y]['provinces']) {
									if (f_first != 1) {
										html += "<tr>";
										console.log("a");
									}
									var province = facility[y]['provinces'][z];
									var city = '';
									html += "<td>" + province['province_name'] + "</td>";
									for (var w in province['citys']) {
										city += province['citys'][w]['city_name'] + ' ';
									}
									html += "<td>" + city + "</td>";
									f_first = 0;
									if (last == 1) {
										html += "<td rowspan=" + length + ">" + "<button type='button' class='btn btn-primary btn-sm detail' data-toggle='modal' data-target='#region_modal' data-fid="+facility[y]['facility_id']+ " data-pid="+product_id+" data-pname="+product_name+" data-fname="+facility[y]['facility_name']+">操作</button>" + "</td>";
										last = 0;
									}
								}
							}
						}
						html += "</tr>";
					}
					$('tbody').append(html);
					$(".detail").each(function() {
						$(this).on('click', function() {
							var getUrl = "skuRegionFacility/getSkuFacilityAvaiableRegion";
							var title = $(this).attr("data-pname") + ' ' + $(this).attr("data-fname");

							onEdit($(this).attr("data-fid"), $(this).attr("data-pid"), title, getUrl);
						});
					});

					$(".to_set_package_page").each(function() {
						$(this).on('click', function() {
							var facility_id = $(this).attr("data-fid");
							var product_id = $(this).attr("data-pid");
							var shipping_id = $(this).attr("data-sid");
							var url = WEB_ROOT + 'SetPackaging/query?facility_id=' + facility_id + '&goods_product_id=' + product_id + '&shipping_id=' + shipping_id;
							location.href = url;
						});
					});

				})
				.fail(function(s) {
					console.log("error" + s);
				})
				.always(function() {
					console.log("complete");
				});
		});
	});
</script>
</body>
