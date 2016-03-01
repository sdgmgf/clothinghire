<!doctype html>
<html>
<head>
<meta charset="UTF-8" />
<title>拼好货WMS</title>
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
<link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
<style>
form .form-group { margin-right: 20px; margin-bottom: 10px !important; margin-top: 10px; }
.modal-body label{
	display: inline-block;
	width: 60px;
	margin-left:50px;
}
.modalCommon{
	margin-left: 30px;
	width: 280px;
	height: 36px;
	border-radius: 5px;
	border: 1px solid #c1c1c1;
	text-indent: 0.5em;
}
</style>
</head>
<body>
	<form style="width:1000px;" class="form-inline center-block" role="form" method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>carrier">
		<div class="form-group">
			<label class="control-label">快递类型：
				<select class="form-control input-sm" id="shipping_type" name="shipping_type">
                    <option value="">全部</option>
                    <option value="is_not_cod" <?php if(isset($is_cod) && $is_cod == '0') echo "selected=true"; ?>>普通快递</option>
                    <option value="is_cod" <?php if(isset($is_cod) && $is_cod == '1') echo "selected=true"; ?>>落地配</option>
	           </select>
           </label>
        </div>
        <div class="form-group">
            <label class="control-label">转仓支持：
	            <select class="form-control" id="support_transfer" name="support_transfer">
                    <option value="">全部</option>
                    <option value="1" <?php if(isset($support_transfer) && $support_transfer == '1') echo "selected=true"; ?>>支持</option>
                    <option value="0" <?php if(isset($support_transfer) && $support_transfer == '0') echo "selected=true"; ?>>不支持</option>
				</select> 
			</label>
		</div>
        <div class="form-group">
            <label class="control-label">热敏支持：
	            <select class="form-control" id="support_thermal" name="support_thermal">
					<option value="">全部</option>
                    <option value="1" <?php if(isset($support_thermal) && $support_thermal == '1') echo "selected=true"; ?>>支持</option>
                    <option value="0" <?php if(isset($support_thermal) && $support_thermal == '0') echo "selected=true"; ?>>不支持</option>
				</select> 
			</label>
		</div>
		<div class="form-group">
            <label class="control-label">快递状态：
	            <select class="form-control" id="enabled" name="enabled">
                    <option value="">全部</option>
                    <option value="1" <?php if(isset($enabled) && !empty($enabled)) echo "selected = true"; ?>>启用</option>
                    <option value="0" <?php if(isset($enabled) && empty($enabled)) echo "selected = true"; ?>>禁用</option>
				</select> 
			</label>
		</div>
		</br>
		<div class="form-group">
			<label class="control-label">快递名称：
				<input class="form-control" type="text" id="shipping_name" name="shipping_name" value="<?php if(!empty($shipping_name)){echo $shipping_name;}?>" />
			</label>
		</div>
		<div class="form-group">
			<input type="submit" id="query" style="float: right;" class="btn btn-primary form-control btn-search"  value="查询"> 
		</div>
		<!-- 隐藏的 input  end  -->
	</form>
	<input type="hidden" id="WEB_ROOT" value="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>">
	<div style=" margin: 20px auto 0;">
		<?php  
		if($this->helper->chechActionList(array('addCarrier'))){ ?>
			<a class="btn btn-primary btn-sm"  style="float: right; height:34px" id="addCarrier">添加</a>
		<?php } ?>		
		<table id="product_list_table" class="table table-striped table-bordered ">
			<thead>
				<tr>
					<th width="3%">SHIPPING ID</th>
					<th width="10%">快递名称</th>
					<th width="5%">服务等级</th>
					<th width="5%">快递类型</th>
					<th width="10%">支持热敏</th>
					<th width="10%">支持转仓</th>
                    <th width="3%">快递状态</th>
                    <?php if($this->helper->chechActionList(array('addCarrier','editCarrier'))){ ?>
					<th width="15%">查询站点地址</th>
					<th width="15%">下单地址</th>
					<th width="8%">密钥</th>
					<th width="8%">正则表达式</th>
					<th width="5%">同步类型</th>
                    <?php } ?>
					<th width="10%">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(isset($carrier_list)) { foreach($carrier_list as $record){?>
				<tr>
					<td class="shipping_id"><?php echo $record['shipping_id']; ?></td>
					<td><?php echo $record['shipping_name']; ?></td>
					<td><?php echo $record['service_id']; ?></td>
					<td><?php 
                        if(empty($record['is_cod'])){ 
                            echo '普通快递';
                        } else{
                            echo '落地配';
						}?>
					</td>
					<td><?php if($record['support_thermal']) echo '支持'; else echo '不支持';?></td>
					<td><?php if($record['support_transfer']) echo '支持'; else echo '不支持';?></td>
                    <td><?php if(isset($record['enabled']) && $record['enabled'] == 1) echo '启用'; else echo '禁用'; ?></td>
                    <?php if($this->helper->chechActionList(array('addCarrier','editCarrier'))){ ?>
					<td><?php echo $record['get_station_url'];?></td>
					<td><?php echo $record['send_order_url'];?></td>
					<td><?php echo $record['open_key'];?></td>
					<td><?php echo $record['regex'];?></td>
					<td><?php echo $record['sync_type'];?></td>
                     <?php } ?>
                    <td>
                        <?php if(isset($record['enabled']) && $record['enabled'] == 1){ ?>
                        <a class="btn btn-danger btn-sm remove" href="#" id="disableShipping" onclick="isEnabled(<?php echo $record['shipping_id']; ?>,<?php echo 1^$record['enabled'];?>)">禁用</a>
                        <?php } else { ?>
                        <a class="btn btn-success btn-sm remove" href="#" id="enableShipping" onclick="isEnabled(<?php echo $record['shipping_id']; ?>,<?php echo 1^$record['enabled'];?>)">启用</a>
                        <?php } ?>
                        <a class="btn btn-primary btn-sm remove" href="#" id="editShipping" onclick="editCarrier(<?php echo $record['shipping_id'];?>)">编辑</a>
					</td>
				</tr>
			<?php }}?>
			</tbody>
		</table>
	</div>
<!-- modal begin -->
<div class="modal fade" id="carrier_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">承运商</h4>
            </div>
            <div class="modal-body">
					<input type="hidden" name="Mshipping_id" id="Mshipping_id"/>
                <p>
                    <label for="Mshipping_name">快递名称: </label>
					<input type="text" name="Mshipping_name" class="modalCommon" id="Mshipping_name"/>
                </p>
				<p>
					<label for="Mservice_id">服务等级: </label>
					<input type="text" name="Mservice_id" class="modalCommon" id="Mservice_id"/>
				</p>
				<p id="PMis_cod">
					<label for="Mis_cod">快递类型: </label>
					<select name="Mis_cod" class="modalCommon" id="Mis_cod">
						<option value="0">普通快递</option>
						<option value="1">落地配</option>
					</select>
				</p>
				<p id="PMis_self" style="display: none">
					<label for="Mis_self">是否自营: </label>
					<select name="Mis_self" class="modalCommon" id="Mis_self">
						<option value="0">非自营</option>
						<option value="1">自营</option>
					</select>
				</p>
				<p>
					<label for="Msupport_thermal">是否支持热敏: </label>
					<select name="Msupport_thermal" class="modalCommon" id="Msupport_thermal">
						<option value="1">支持</option>
						<option value="0">不支持</option>
					</select>
				</p>
				<p>
					<label for="Msupport_transfer">是否支持转仓: </label>
					<select name="Msupport_transfer" class="modalCommon" id="Msupport_transfer">
						<option value="1">支持</option>
						<option value="0">不支持</option>
					</select>
				</p>
                <?php if($this->helper->chechActionList(array('addCarrier','editCarrier'))){ ?>
				<p>
					<label for="Mget_station_url">查询站点地址: </label>
					<input type="text" name="Mget_station_url" class="modalCommon" id="Mget_station_url"/>
				</p>
				<p>
					<label for="Msend_order_url">下单地址: </label>
					<input type="text" name="Msend_order_url" class="modalCommon" id="Msend_order_url"/>
				</p>
                <p>
					<label for="Mopen_key">密钥: </label>
					<input type="text" name="Mopen_key" class="modalCommon" id="Mopen_key"/>
				</p>
                <p>
					<label for="Mregex">正则表达式: </label>
					<input type="text" name="Mregex" class="modalCommon" id="Mregex"/>
				</p>
				<p>
					<label for="Msync_type">同步类型: </label>
					<input type="text" name="Msync_type" class="modalCommon" id="Msync_type"/>
				</p>
                <?php } ?>
                <p>
					<label for="Menabled">快递状态: </label>
					<select name="Menabled" class="modalCommon" id="Menabled">
						<option value="1">启用</option>
						<option value="0">禁用</option>
					</select>
				</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="add_save">保存</button>
            </div>
        </div>
    </div>
</div>
<!-- modal end  -->
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
$(document).ready(function() {

});
//重置modal
function resetModal(){
	$("#PMis_self").hide();
	$(".modal-body select").val('0');
	$(".modal-body input").val('');
}
//显示modal层
$("#addCarrier").on("click",function(){
	resetModal();
	$("#carrier_modal").modal("show");
})
//显示是否自取
$("#Mis_cod").on("change",function(){
	if($("#Mis_cod").val() == "1"){
		$("#PMis_self").show();
	}else{
		$("#PMis_self").hide();
	}
})
//保存承运商
$("#add_save").on("click",function(){
	saveCarrier();
})
//改变状态
function isEnabled(shipping_id, enabled){
	var url = $('#WEB_ROOT').val() + 'Carrier/changeCarrierStatus';
	var params = {
		"enabled": enabled,
        "shipping_id": shipping_id,
	}
	$.ajax({
		url: url,
		type: "post",
		dataType: "json",
		data: params
	})
	.done(function(data){
        if(data.error_info){
            alert(data.error_info);
        } else{
            alert('成功');  
        }
		window.location.reload();
	})
	.fail(function(){
		console.log("error")
	})
}
//编辑承运商
function editCarrier(shipping_id){
	getEditCarrier(shipping_id);
	resetModal();
	$("#Mshipping_id").val(shipping_id);
}
//点击编辑获取到shipping_id对应的数据
function getEditCarrier(shipping_id) {
	var url = $('#WEB_ROOT').val() + 'Carrier/getCarrierDetail';
	$.ajax({
		url: url,
		type: "get",
		dataType: "json",
		data: {"shipping_id": shipping_id}
	})
	.done(function(data){
		if(!data.error_info && data.carrier_detail){
			var detail = data.carrier_detail;
			$("#Mshipping_name").val(detail.shipping_name);
			$("#Mservice_id").val(detail.service_id);
			$("#Mis_cod").val(detail.is_cod);
			//落地配需显示是否自营选项
			if(detail.is_cod == "1"){
				$("#Mis_self").val(detail.is_self);
				$("#PMis_self").show();
			}
			$("#Msupport_thermal").val(detail.support_thermal);
			$("#Msupport_transfer").val(detail.support_transfer);
			$("#Mget_station_url").val(detail.get_station_url);
			$("#Msend_order_url").val(detail.send_order_url);
			$("#Menabled").val(detail.enabled);
			$("#Msync_type").val(detail.sync_type);
            $("#Mregex").val(detail.regex);
            $("#Mopen_key").val(detail.open_key);
            $("#carrier_modal").modal("show");
		}else{
			alert("目前不可编辑")
		}
	})
	.fail(function(){
		console.log("error")
	})
}
//编辑或新增承运商
function saveCarrier(){
	var url = $('#WEB_ROOT').val() + 'Carrier/createOrModifyCarrier';
	var params = {
        "open_key": $('#Mopen_key').val(),
		"shipping_id": $("#Mshipping_id").val(),
		"shipping_name": $("#Mshipping_name").val(),
		"service_id": $("#Mservice_id").val(),
		"is_cod": $("#Mis_cod").val(),
		"is_self": $("#Mis_self").val(),
		"support_thermal": $("#Msupport_thermal").val(),
		"support_transfer": $("#Msupport_transfer").val(),
		"get_station_url": $("#Mget_station_url").val(),
		"send_order_url": $("#Msend_order_url").val(),
		"enabled": $("#Menabled").val(),
		"sync_type": $("#Msync_type").val(),
        "regex": $('#Mregex').val(),
	};
	$.ajax({
		url: url,
		type: "post",
		dataType: "json",
		data: params
	})
	.done(function(data){
        if(data.error_info){
           alert(data.error_info) 
        } else {
            alert("操作成功");
        }
		window.location.reload();
	})
	.fail(function(){
		console.log("error")
	})
}
var table = $('#product_list_table').DataTable({
	dom: 'lBfrtip',
	buttons: [
		{
			extend: 'colvis',
			text: '设置列可见'
		},
		{
			extend: 'copyFlash',
			text: '复制'
		},
		'excelFlash',
	],
	"aaSorting": [
		[ 0, "desc" ]
	],
	language: {
		"url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
	},
	aLengthMenu: [[20, 10, 50, -1], [20, 10, 50, "所有"]],
	scrollY: '100%',
	scrollX: '100%',
});


</script>
</body>
</html>