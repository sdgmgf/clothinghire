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
	#region_modal p {
		text-indent: 20px;
	}
</style>
</head>
<body id="main">
<div id="loadding"><img src="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/img/loadding.gif"></div>
	<div class="container">
		<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
		<form class="col-sm-10" method="get">
			
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
              <option value="">请选择仓库</option>
            </select>
            <label for="shipping_id">快递：</label>
            <select id="shipping_id" name="shipping_id">
               <option value="">请选择快递</option>
            </select><br />
            <label for="type_name">类型：</label>
            <select id="type_name" name="type_name">
              <option value="">请选择类型</option>
            </select>
            <label for="status_name">状态：</label>
            <select id="status_name" name="status_name">
              <option value="">请选择状态</option>
            </select><br />
            <label for="out_order_sn"> 订单号：</label>
            <input type="text" id='out_order_sn' name='out_order_sn' />
            
          
			<button type="button" class="btn btn-primary btn-sm" id="query" style="margin-left:20%">搜索 </button>
		</form>

		<div class="row  col-sm-10 " style="margin-top: 10px;">
            <table class="table table-striped table-bordered main-table">
                <thead>
                    <tr>
                        <th> 订单号 </th>
                        <th> 类型 </th>
                        <th> 请求时间 </th>
                        <th> 请求数据</th>
                        <th> 返回数据</th>
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
	      <div class="modal-body">
<!-- 	      		<table id="info_table" name="info_table" border=3>
		      		
	      		</table> -->
	      </div>
	    <div class="modal-footer">
<!-- 	      	<input id="package_sub" type="button" class="btn btn-primary" style="text-align: right;" value="保存" onclick="onSave()"> -->
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

	
	function getType() {
		post = $('#WEB_ROOT').val() + 'ShipmentRequestLog/getType';
		$.ajax({
			type: "post",
			url: post,
			data: {}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				$("#loadding").hide();
				if (data.result == "ok") {
					var html = '<option value="">请选择类型</option>';
					$.each(data.data,function(index,elem){
						html += '<option value='+elem.request_type+'>'+elem.request_type+'</option>';
					});
					$("#type_name").empty().append(html);

				} else {
					alert(data.error_info);

				}
			},
			error: function() {
				alert('参数错误');
			}
		});
	}
	function getStatus() {
		post = $('#WEB_ROOT').val() + 'ShipmentRequestLog/getStatus';
		$.ajax({
			type: "post",
			url: post,
			data: {}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				$("#loadding").hide();
				if (data.result == "ok") {
					var html = '<option value="">请选择状态</option>';
					$.each(data.data,function(index,elem){
						html += '<option value='+elem.status+'>'+elem.status+'</option>';
					});
					$("#status_name").empty().append(html);

				} else {
					alert(data.error_info);

				}
			},
			error: function() {
				alert('参数错误');
			}
		});
	}
	function getFacility() {
		post = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
		$("#facility_id").html('<option value="">请选择仓库</option>');
		$.ajax({
			type: "post",
			url: post,
			data: {}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				$("#loadding").hide();
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

	function getShipping() {
		post = $('#WEB_ROOT').val() + 'Commons/getShippingList';
		var facility_id = $("#facility_id").val();
		$.ajax({
			type: "post",
			url: post,
			data: {"facility_id":facility_id}, // 传入获取到的大区id
			dataType: "json",
			success: function(data) {
				if (data.result == "ok") {
					var html = '<option value="">请选择快递</option>';
					$.each(data.shipping,function(index,elem){
						html += "<option value="+elem.shipping_id+">"+elem.shipping_name+"</option>"
					});
					$("#shipping_id").empty();
					$("#shipping_id").append(html);

				} else {
					alert(data.error_info);

				}
			},
			error: function() {
				alert('参数错误');
			}
		});
	}

	function initTable(data){
		var html = '';		
		console.log(data);
		$.each(data,function(index,elem){
			html += "<tr><td>"+elem.out_order_sn+"</td><td>"+elem.request_type+"</td><td>"+elem.created_time+"</td><td>"+elem.request+"</td><td>"+elem.response+"</td><td><button data-sn="+elem.out_order_sn+" data-id="+elem.ws_express_request_id+" class='btn btn-primary btn-sm detail'>详情</button></td></tr>";
		});
		$(".main-table tbody").empty().append(html);
		$(".main-table .detail").on('click',function(){
			var $this = $(this);
			$this.attr("disabled",true);
			onDetail($this);
		});
	}
	function onDetail($this) {
		var postUrl = $("#WEB_ROOT").val() + 'ShipmentRequestLog/getDetail';
		var submit_data = {
			'ws_express_request_id': $this.attr("data-id")
		};
		$.ajax({
			url: postUrl,
			type: 'GET',
			data: submit_data,
			dataType: "json",
			xhrFields: {
				withCredentials: true
			}
		}).done(function(data) {
			$this.attr("disabled",false);
			if (data.result == "ok") {
				var html = '';
				$("#region_modal").modal('show');
				$("#region_title").html($this.attr("data-sn")+"请求日志");
				html +="<div><label>请求时间：</label><p>"+data.data[0].created_time+"</p></div>";
				html +="<div><label>请求类型：</label><p>"+data.data[0].request_type+"</p></div>";
				html +="<div><label>请求数据：</label><p>"+data.data[0].request+"</p></div>";
				html +="<div><label>返回数据：</label><p>"+data.data[0].response+"</p></div>";			
				$(".modal-body").empty().append(html);
			} else {
				alert("失败。" + data.error_info);
			}
		});
	}
	$(function() {
		var table;
		var flag = true;
		getStatus();
		getType();
		getFacility();
		$("#facility_id").on("change",function(){
			getShipping();
		});
		$("#query").click(function() {
			$(this).attr("disabled",true);
			var submit_data = {
				"facility_id":$("#facility_id").val(),
				"shipping_id":$("#shipping_id").val(),
				"type":$("#type_name").val(),
				"status":$("#status_name").val(),
				"out_order_sn":$("#out_order_sn").val()
			}
			$.ajax({
				url: '<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>ShipmentRequestLog/getData',
				type: 'POST',
				data: submit_data,
				dataType: 'json',
			})
				.done(function(data) {
					$("#query").attr("disabled",false);
					if(data.result == 'ok'){
						initTable(data.data);
					} else{
						alert("出错。"+data.error_info);
					}
					
				});
		});
	});
</script>
</body>
