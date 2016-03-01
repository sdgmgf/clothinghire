<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <style type="text/css">
            fieldset{
                width: 1000px;
                padding: 15px;
                margin: 50px auto;
                border: 1px solid #eee;
            }
            p{
                padding: 0 10px;
            }
            select,input[type='text']{
                width: 280px;
                height: 40px;
                border: 1px solid #ddd;
                border-radius: 5px;
                padding: 0 0.5em;
                overflow: auto;
            }
            label{
              width: 100px;
            }
            label:nth-child(odd){
              margin-left: 60px;
            }
            input[type='text']{
                height: 36px;
            }
            .dtlBtn{
              background: #fff;
              border: 0;
              border-radius: 5px;
              background: #91bed4;
              color: #fff;
              font-weight: 300;
              font-size: 12px;
              padding: 8px 12px;
              margin:0 5px;
            }
            .dtlBtn:hover{
              background: #7cb8d3;
            }
            #search{
                margin-left: 345px;
                width: 100px;
                height: 36px;
                background: #fff;
                border: 0;
                border-radius: 5px;
                background: #1895e0;
                color: #fff;
                font-weight: 300;
                }
            #search:hover{
                background: #1584c4;
                cursor: pointer;
            }
            table,tr,td,th{
              border: 1px solid #ddd;
              padding: 8px;
              color: #232323;
              text-align: center;
            }
            th{
              background: #a2b7db;
              color: #fff;
            }
            tr:nth-child(even){
              background: #e8e8e8;
            }
            tr:hover{
              background: #d8dff2;
            }
            #addTable_wrapper,#addTable{
              width: 1000px!important;
              padding: 15px;
              margin: 0 auto;
            } 
            #addTable_processing{
              position: absolute;
              left: 45%;
              top: 45%;
              width: 100px;
              height: 36px;
              text-align: center;
              line-height: 36px;
              color: #1895e0;
              background: #ddd;
              filter:alpha(opacity=70); 
              opacity: 0.7;   
            }
            caption{
              margin-bottom: 10px;
            }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
  <!-- 表单开始 -->
  <fieldset>
    <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> > 
        <form action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>Shipments" method="post">
          <p>
            <label for="area_id">大区：</label>
            <select id="area_id" name="area_id">
              <option value="">请选择大区</option>
            </select>
            <label for="facility_id">仓库：</label>
            <select id="facility_id" name="facility_id">
              <option value="">请选择仓库</option>
            </select>
          </p>
          <p>
            <label for="shipping_id">快递：</label>
            <select id="shipping_id" name="shipping_id">
              <option value="">请选择快递</option>
            </select>
            <label for="tracking_number">快递面单号：</label>
            <input type="text" id="tracking_number">
          </p>
          <p>
            <label for="order_sn">订单号:</label>
            <input type="text" id="order_sn">
            <input type="button" id="search" value="搜索">
          </p>
        </form>
  </fieldset> <!-- 表单结束 -->

  <!-- 订单列表 -->
  <table id="addTable">
    <caption>订单列表</caption>
    <thead>
      <tr>
        <th>订单号</th>
        <th>快递面单号</th>
        <th>发运单号</th>
        <th>仓库</th>
        <th>快递名称</th>
        <th>产品名称</th>
        <th>成团时间</th>
        <th>推送时间</th>
        <th>发货时间</th>
        <th>收货人</th>
        <th>电话</th>
        <th>状态</th>
        <th width="40">详情</th>
      </tr>
    </thead>
  </table>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript">
//大区、仓库、快递联动
$(document).ready(function() {
    var keyVal = GetRequests();
    $("#area_id").val(keyVal.area_id);
    $("#facility_id").val(keyVal.facility_id);
    $("#shipping_id").val(keyVal.shipping_id);            
    $("#tracking_number").val(keyVal.tracking_number);
    $("#order_sn").val(keyVal.order_sn);
//    LoadData();
  var table;
  var flag  = true;
  var postArea = $('#WEB_ROOT').val() + 'Commons/getArealist';
     //加载所有的大区
    $.ajax({
        type: "post",
        url: postArea,
        data: {},
        dataType: "json",
        success: function(data) {
            $.each(data.data, function(i, item) {
              var dataArea = item;
              $("#area_id").append("<option value='" + dataArea.area_id + "'>" + dataArea.area_name + "</option>");
            });
        },
        error: function() {
          alert('参数错误');
        }
    });
    
    $("#area_id").change(function() {
      var areaId = $('#area_id').val(),
          postFacility = $('#WEB_ROOT').val() + 'Commons/getFacilityList';
      $("#facility_id").html('<option value="">请选择仓库</option>');
      $("#shipping_id").html('<option value="">请选择快递</option>');
        $.ajax({
            type: "post",
            url: postFacility,
            data: {"area_id" : areaId}, // 传入获取到的大区id
            dataType: "json",
            success: function(data) {
                $.each(data.data, function(i, item) {
                  var facilityArea = item;
                  $("#facility_id").append("<option value='" + facilityArea.facility_id + "'>" + facilityArea.facility_name + "</option>");
                });
            },
            error: function() {
              alert('参数错误');
            }
        });
    });

    $("#facility_id").change(function() {
      var facilityId = $('#facility_id').val(),
          postShipping = $('#WEB_ROOT').val() + 'Commons/getShippingList';
          $("#shipping_id").html('<option value="">请选择快递</option>');
        $.ajax({
            type: "post",
            url: postShipping,
            data: {"facility_id" : facilityId}, // 传入获取到的仓库id
            dataType: "json",
            success: function(data) {
                $.each(data.shipping, function(i, item) {
                  var shippingArea = item;
                  $("#shipping_id").append("<option value='" + shippingArea.shipping_id + "'>" + shippingArea.shipping_name + "</option>");
                });
            },
            error: function() {
              alert('参数错误');
            }
        });
    });
    function isNullOrEmpty(strVal) {
		if (strVal == '' || strVal == null || strVal == undefined) {
			return true;
		} else {
			return false;
		}
	}
    //点击搜索订单列表
    function LoadData() {
      var tableData = $('#WEB_ROOT').val() + 'Shipments/showList',
          dtlData = $('#WEB_ROOT').val() + 'Shipments/showdetail',
          area_id,
          facility_id,
          shipping_id,
          areaVal = $('#area_id').val(),
          facilityVal = $('#facility_id').val(),
          shippingVal = $('#shipping_id').val(),
          tracking_number = $('#tracking_number').val(), 
          order_sn = $('#order_sn').val();
      if(isNullOrEmpty(tracking_number) && isNullOrEmpty(order_sn)){
      	alert('请输入订单号或快递面单号');
      	return;
      }
      (areaVal == null) ? area_id = keyVal.area_id : area_id = areaVal;
      (facilityVal == null) ? facility_id = keyVal.facility_id : facility_id = facilityVal;
      (shippingVal == null) ? shipping_id = keyVal.facility_id : shipping_id = shippingVal;
        var params = {
            'area_id' : area_id,
            'facility_id' : facility_id,
            'shipping_id' : shipping_id,
            'tracking_number' : tracking_number, 
            'order_sn' : order_sn
          };
      table = $('#addTable').DataTable( {
        "processing": true,
        "serverSide": true,
        "searching" : false,
        "bSort": false,
        "ordering": false,
        "DeferRender": true,
        "StateSave": true,
        "ajax": {
            "url": tableData,
            "type": 'post',
            "dataSrc": "list",
            "data": params
        },
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
        "language": {
                "url": "<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/Chinese.lang"
            },
        "columns": [
            { "data": "out_order_sn"},
            { "data": "tracking_number" },
            { "data": "waybill_sn" },
            { "data": "facility_name" },
            { "data": "shipping_name" },
            { "data": "product_name" },
            { "data": "confirm_time" },
            { "data": "created_time" },
            { "data": "shipping_time" },
            { "data": "receive_name" },
            { "data": "mobile" },
            { "data": "status" } 
        ],
        "columnDefs": [
                  // 增加一列，包括删除和修改，同时将我们需要传递的数据传递到链接中
                  {
                      "targets": [12], // 目标列位置，下标从0开始
                      "data": "out_order_sn", // 数据列名
                      "render": function(out_order_sn) { // 返回自定义内容
                          return "<a href='"+dtlData+"?out_order_sn="+out_order_sn+"'>详情</a>";
                      }
                  },
                  {
                    "targets": [11], // 目标列位置，下标从0开始
                    "data": "status", // 数据列名
                    "render": function(status) { // 返回自定义内容
                     //console.log(status);
                      var str;
                        switch(status){
                          case "0": str = "待绑定面单";
                          break;
                          case "1": str = "已绑定订单";
                          break;
                          case "6": str = "已提货放单";
                          break;
                          case "4": str = "已生成批检单";
                          break;
                          case "2": str = "已打印，待发货";
                          break;
                          case "3": str = "已发货待发运";
                          break;
                          case "5": str = "已发运";
                          break;
                        }
                        return str;
                      }
                  }
              ],
              "initComplete": function(){
                flag = false;
              }
      } );
    };
    $("#search").click(function () {
      if(!flag){
        table.destroy();
      }
      LoadData();
    }); 
});

</script>

</body>
</html>