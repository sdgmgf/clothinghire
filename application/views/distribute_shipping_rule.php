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
                                    	<th> 仓库 </th>
                                        <th> 商品 </th>
                                        <th> 省 </th>
                                        <th> 市</th>
                                        <th> 快递</th>
                                        <th>包装方案</th>
                                        <th>详情</th>
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
	      <input type="hidden" id="shipping_id1" name="shipping_id">
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

	function onSave() {
		$("#package_sub").prop("disabled",true);
		var facility_id = $("#facility_id1").val();
		var shipping_id = $("#shipping_id1").val();
		var product_id = $("#product_id1").val();
		var districts = [];
		$("input.district").each(function() {
			if ($(this).prop("checked")) {
				if (parseInt($(this).val()) > 0) {
					districts.push($(this).val());
				}
			};
		});
		var submit_data = {
			"facility_id": facility_id,
			"shipping_id": shipping_id,
			"product_id": product_id,
			"district_ids": districts
		};

		var postUrl = $("#WEB_ROOT").val() + 'skuShipping/addDistributionShippingRule';
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
			if (data.result == "ok") {
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
			if(product_id == '' || product_id == null || product_id == undefined){
				alert("请选择商品");
				return;
			}
			$('tbody').empty();
			$('tbody').html(loadding);
			$("#query").prop("disabled",true);
			var facility_id = $("#facility_id").val();
			
			var param = 　 {
				"facility_id": facility_id,
				"product_id": product_id
			};

			$.ajax({
				url: '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>skuShipping/getSkuShippingList',
				type: 'POST',
				data: param,
				dataType: 'json',
			})
				.done(function(data) {
					$("#query").prop("disabled",false);
					$(".loadding").hide();
					for (var x in data['list']) {
						var facility_id = data['list'][x]['facility_id'];
						var facility_name = data['list'][x]['facility_name'];
						for (var y in data['list'][x]['products']) {
							var html = '<tr>';
							var count = data['list'][x]['products'][y]['length'];
							html += "<td rowspan=" + count + ">" + data['list'][x]['facility_name'] + "</td>";
							html += "<td rowspan=" + count + ">" + data['list'][x]['products'][y]['product_name'] + "</td>";
							var p_first = 1; //判断头
							var s_first = 1; //判断尾
							for (var z in data['list'][x]['products'][y]['shippings']) {
								var shippings = data['list'][x]['products'][y]['shippings'][z];
								var ship_name = shippings['shipping_name'];
								if (shippings['supplies_product_id'] != "0") {
									var ship_product = shippings['supplies_product_name'];
								} else {
									var ship_product = '';
								}
								
								var s_first = 1; //判断尾
								if (shippings['provinces'].length == 0) { //判断省
									html += "<td></td><td></td>";
									if (s_first == 1) {
										html += "<td rowspan=" + shippings['length'] + ">" + ship_name + "</td>";
										html += "<td rowspan=" + shippings['length'] + ">" + ship_product + "</td>";
										if (shippings['supplies_product_id'] != "0") {
											html += "<td rowspan=" + shippings['length'] + ">" + "<button type='button' class='btn btn-primary btn-sm detail'  data-target='#myModal' data-sid=" + shippings['shipping_id'] + " data-pid=" + data['list'][x]['products'][y]['product_id'] + " data-fid=" + facility_id + " data-sname=" + shippings['shipping_name'] + " data-pname=" + data['list'][x]['products'][y]['product_name'] + " data-fname=" + facility_name + " >详情 </button>" + "</td>";
										} else {
											html += "<td rowspan=" + shippings['length'] + ">" + "<button type='button' class='btn btn-primary btn-sm to_set_package_page'  data-toggle='modal' data-target='#myModal' data-sid=" + shippings['shipping_id'] + " data-pid=" + data['list'][x]['products'][y]['product_id'] + " data-fid=" + facility_id + " data-sname=" + shippings['shipping_name'] + " data-pname=" + data['list'][x]['products'][y]['product_name'] + " data-fname=" + facility_name + " >去设置包装方案 </button>" + "</td>";
										}
										s_first = 0;
									}

									html += "</tr>";
								} else {
									for (var w in shippings['provinces']) {
										var city = ''; //市
										if (p_first != 1) { //判断不是第一个，则加上<tr>
											html += "<tr>";
										}
										html += "<td>" + shippings['provinces'][w]['province_name'] + "</td>";
										p_first = 0;
										for (var q in shippings['provinces'][w]['citys']) {
											city += shippings['provinces'][w]['citys'][q]['city_name'] + ' ';
										}
										html += "<td>" + city + "</td>";
										if (s_first == 1) {
											html += "<td rowspan=" + shippings['length'] + ">" + ship_name + "</td>";
											html += "<td rowspan=" + shippings['length'] + ">" + ship_product + "</td>";
											if (shippings['supplies_product_id'] != "0") {
												html += "<td rowspan=" + shippings['length'] + ">" + "<button type='button' class='btn btn-primary btn-sm detail'  data-target='#myModal' data-sid=" + shippings['shipping_id'] + " data-pid=" + data['list'][x]['products'][y]['product_id'] + " data-fid=" + facility_id + " data-sname=" + shippings['shipping_name'] + " data-pname=" + data['list'][x]['products'][y]['product_name'] + " data-fname=" + facility_name + " >详情 </button>" + "</td>";
											} else {
												html += "<td rowspan=" + shippings['length'] + ">" + "<button type='button' class='btn btn-primary btn-sm to_set_package_page'  data-toggle='modal' data-target='#myModal' data-sid=" + shippings['shipping_id'] + " data-pid=" + data['list'][x]['products'][y]['product_id'] + " data-fid=" + facility_id + " data-sname=" + shippings['shipping_name'] + " data-pname=" + data['list'][x]['products'][y]['product_name'] + " data-fname=" + facility_name + " >去设置包装方案 </button>" + "</td>";
											}
											s_first = 0;
										}

										html += "</tr>";
									}
								}


							}
							$('tbody').append(html);

						}

					}
					$(".detail").each(function() {
						$(this).on('click', function() {
							var getUrl = "skuShipping/getDistributionShippingDetail";
							var title = $(this).attr("data-fname") + ' ' + $(this).attr("data-pname") + ' ' + $(this).attr("data-sname");

							onEdit($(this).attr("data-fid"), $(this).attr("data-sid"), $(this).attr("data-pid"), title, getUrl);
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
