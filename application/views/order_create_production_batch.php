<!doctype html>
<html>
<head>
<title>按订单号创建波次</title>
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
		<form class="col-sm-10 clearfix" action="" method="get" style="padding-left:0">
			<div class="form-group">
	        	<label for="out_order_sn" style="text-align:left">订单号：</label>
	        	<input type="text" class="form-control" id="out_order_sn" name="out_order_sn" placeholder="请输入订单号多个订单号可用逗号隔开，例'a,b,c'"/>
	    	</div>
			<button type="button" class="btn btn-primary btn-sm" id="query" style="float:right">搜索 </button>
		</form>
		<div class="row  col-sm-10 " style="margin-top: 10px;">
			<p>提示：红色列表表示订单号已经创建波次。</p>
            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th> 订单号 </th>
                        <th> 面单号 </th>
                        <th> 快递公司</th>
                        <th> 仓库 </th>
                        <th> 状态</th>
                        <th> 省</th>
                        <th>市</th>
                        <th>区</th>
                    </tr>
                </thead>
            	<tbody>
                                	
                </tbody>
            </table>
            <button type="button" class="btn btn-primary btn-sm" id="create" style="float:right;display:none">创建波次 </button>
        </div>    

	</div>
	<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
	<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
	<script type="text/javascript">
	var WEB_ROOT = "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT; ?>";
	var facility_ids = [];
	var shipment = [];
	var out_order_sn = '';
	function initTable(data) {
		var html = '';		
		out_order_sn = '';
		facility_ids = [];
		shipment = [];
		$('tbody').empty();
		$("#create").hide();
		if(data.shipment.length ==0){
			alert("该订单号不正确");
			return false;
		}
		$.each(data.shipment, function(index, elem) {
			console.log(elem);
			html += "<tr data-pbi="+elem.production_batch_id+"><td>" + elem.out_order_sn + "</td><td>" + elem.tracking_number +
				"</td><td>" + elem.shipping_name + "</td><td>" + elem.facility_name + "</td><td>" +
				elem.status + "</td><td>" + elem.province_name + "</td><td>" + elem.city_name +
				"</td><td>" + elem.district_name + "</td></tr>";

			if (elem.production_batch_id == '') {
				shipment.push(elem.shipment_id);
				out_order_sn += (elem.out_order_sn + ' ');
			}

			if (facility_ids.indexOf(elem.facility_id) == -1) {
				facility_ids.push(elem.facility_id);
			}
			// facility_id = elem.facility_id;

		});
		console.log(shipment);
		$('tbody').append(html);
		$("tbody tr[data-pbi!='']").css("background",'red');
		$("#create").show();
	}
	$(function() {
		$("#query").on("click", function() {
			
			//标准化out_order_sn
			var out_order_sn = $("#out_order_sn").val();
			if(out_order_sn == ''){
				alert("请输入订单号");
				return false;
			}			
			out_order_sn = out_order_sn.replace(/，/g, ",");
			if(!(/^(.+)(,.+)*$/.test(out_order_sn))){
				alert("请输入正确的订单号格式");
				return false;
			}
			$(this).attr("disabled", true);
			console.log(out_order_sn);
			$.ajax({
				url: WEB_ROOT + "CreateProductionBatch/getOrderIndex",
				type: 'get',
				data: {
					"out_order_sn": out_order_sn
				},
				dataType: "json",
				xhrFields: {
					withCredentials: true
				}
			}).done(function(data) {
				console.log(data);
				$("#query").attr("disabled", false);
				if (data.result == 'ok') {
					initTable(data);

				} else {
					alert("出错," + data.error_info);
				}

			});
		});
	});

	$(function() {
		$("#create").on("click", function() {
			$(this).attr("disabled", true);
			if (facility_ids.length != 1) {
				alert("仓库不一致，无法创建波次");
				$("#create").attr("disabled", false);
				return false;
			}
			var facility_id = facility_ids[0];
			if(shipment.length == 0){
				alert("该订单号已创建波次");
				$("#create").attr("disabled", false);
				return false;
			}
			$.ajax({
				url: WEB_ROOT + "CreateProductionBatch/orderCreateProductionBatch",
				type: 'post',
				data: {
					"shipment_ids": shipment,
					"facility_id": facility_id
				},
				dataType: "json",
				xhrFields: {
					withCredentials: true
				}
			}).done(function(data) {
				$("#create").attr("disabled", false);
				console.log(data);
				if (data.result == 'ok') {
					alert('订单号：' + out_order_sn + "创建成功");
					location.reload();
				} else {
					alert("出错," + data.error_info);
				}

			});
		});
	});
	</script>
</body>
