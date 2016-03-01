<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <style>
      .orderDtl,.orderLight,.productDtl{
        width: 66%;
        float: left;
      }
      h4{
        padding-left: 20px;
        background: #1590d2;
        font-size: 16px;
        color: #fff;
        height: 26px;
        line-height: 26px;
        border-radius: 5px 5px 0 0;
      }
      .orderLight li,.orderDtl ul{
        list-style: none;
      }
      li{
        border-bottom:1px solid #e2e2e2;
        padding: 20px 0;
      }
      li span{
        padding-right: 20px;
      }
      label{
        color: #1590d2;
        float: left;
        width: 120px;
      }
      .operateBody{
        float: right;
        width: 32%;
      }
      #operateDtlDiv{
        height: 200px;
        overflow-y: auto
      };
      .operateDtl{
        float: right;
        width: 100%;
      }
      .operateDtl thead{
        font-size: 0;
      }
      .operateDtl th{
        display: inline-block;
        width: 25%;
        font-size: 14px;
      }
      #operateDtlBody,.productDtlTable{
        width: 100%;
      }
      #operateDtlBody{

      }
      #shippingUl, #pinxiaodianUl{
        height: 140px;
        overflow-y: auto;
      }
      #shippingUl li, #pinxiaodianUl li{
        padding: 5px 0;
      }
      table,tr,td,th{
        border: 1px solid #ddd;
        padding: 8px;
        color: #232323;
        text-align: center;
      }
      th{
        border: 1px solid #1895e0;
        background: #1895e0;
        color: #fff;
      }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
  <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> > 
  <div class="orderBody">
    <div class="operateBody">
      <h4>操作信息</h4>
      <table class="operateDtl" style="width:100%">
        <thead>
          <tr>
            <th>操作类型</th>
            <th>操作时间</th>
            <th>操作人</th>
            <th>备注</th>
          </tr>
        </thead>
      </table>
      <div id="operateDtlDiv">
        <table id="operateDtlBody">
        <!-- 操作信息数据 -->
        </table>
      </div>
      <div class="shippingBody">
        <h4>物流信息</h4>
        <ul id="shippingUl">
        </ul>
      </div>
    </div>
    <div class="orderLight">
      <h4>订单信息</h4>
      <ul>
        <li>
          <label for="">平台信息</label>
          <b>订购平台：</b>
          <span id="merchant_name"></span>
          <b>外部订单号：</b>
          <span id="out_order_sn"></span> 
          <b>OMS订单状态：</b>
          <span id="order_status"></span>  
          <b>成团时间：</b>
          <span id="confirm_time"></span> 
        </li>   
        <li>
          <label for="">订单基本信息</label>
          <b>快递面单号：</b>
          <span id="tracking_number"></span>
          <b>订单号：</b>
          <span id="shipment_id"></span>
        </li> 
      </ul>
    </div>
    <div class="orderDtl">
      <h4>订单详细信息</h4>
      <ul>
        <li>
          <label for="">收货人信息</label>
          <b>姓名：</b>
          <span id="receive_name"></span>
          <b>联系方式：</b>
          <span id="mobile"></span>          
        </li>
        <li>
          <label for="">地址信息</label>
          <b>收货地址：</b>
          <span id="placeInfo"></span>
          <b>详细地址：</b>
          <span id="placeDtlInfo"></span>
        </li>
        <li>
          <label for="">配送仓</label>
          <b>仓库：</b>
          <span id="station"></span>
          <b>仓库编号：</b>
          <span id="station_no"></span>
        </li>
        <li>
          <label for="">快递方式</label>
          <b>快递名称：</b>
          <span id="shipping_name"></span>
        </li>
      </ul>
    </div>
    <div class="productDtl">
      <h4>商品详情</h4>
      <table class="productDtlTable">
        <thead>
          <tr>
            <th>商品ID</th>
            <th>商品名称</th>
            <th>商品暗语</th>
          </tr>
        </thead>
        <tbody id="productDtlBody">
          <tr>
            <td id="product_id"></td>
            <td id="product_name"></td>
            <td id="secrect_code"></td>
          </tr>
        </tbody>
      </table>
    </div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    LoadDtlData();
});
  //点击搜索订单列表
function LoadDtlData() {
  var tableData = $('#WEB_ROOT').val() + 'Shipments/getDetail',
      keyVal = GetRequests();                                   //获取URL参数
      out_order_sn = keyVal.out_order_sn;
      $.ajax({
        url: tableData,
        type: "post",
        dataType: "json",
        data: {out_order_sn: out_order_sn},
      })
      .done(function(data) {
        var dataList = data.shipment;
        //商品详情
        $('#product_id').html(dataList.product_id);
        $('#product_name').html(dataList.product_name);
        $('#secrect_code').html(dataList.secrect_code);

        // oms订单状态
        switch(dataList.order_status){
          case '1' : $('#order_status').html('确认');
            break;
          case '2' : $('#order_status').html('取消');
            break;
          case '3' : $('#order_status').html('已回传');
            break;
          case '4' : $('#order_status').html('回传失败');
            break;
        }
        //订单信息
        $('#merchant_name').html(dataList.merchant_name);
        $('#out_order_sn').html(dataList.out_order_sn);
        $('#confirm_time').html(dataList.confirm_time);
        $('#tracking_number').html(dataList.tracking_number);
        $('#shipment_id').html(dataList.shipment_id);
        $('#receive_name').html(dataList.receive_name);
        $('#mobile').html(dataList.mobile);
        $('#placeInfo').html(dataList.province_name+dataList.city_name+dataList.district_name);
        $('#placeDtlInfo').html(dataList.shipping_address);
        $('#station').html(dataList.area_name+dataList.facility_name+dataList.address_name+dataList.station);
        $('#station_no').html(dataList.station_no);
        $('#shipping_name').html(dataList.shipping_name);
        if(!(dataList.shipping_id == "87")){
          $("#shippingUl").css("height","280px");
          $(".pinxiaodianBody").hide();
        }else{
            $(".operateBody").append("<div class='pinxiaodianBody'><h4>拼小店信息</h4><ul id='pinxiaodianUl'></ul></div>")      
        }
      
        //物流信息
        ShippingInfo(dataList.out_order_sn);
      })
      .fail(function() {
        console.log("error");
      });        
};
   //物流信息
function ShippingInfo(out_order_sn){
  var shippingData = $('#WEB_ROOT').val() + 'Shipments/getWmsLogInfo?out_order_sn='+out_order_sn;
      $.ajax({
        url: shippingData,
        type: "post",
        dataType: "json"
      })
      .done(function(data) {
        var i,
            shippingList,
            pinxiaodianList;
        //物流信息
        if (data.data.fetch_log) {
            if(data.data.fetch_log.format_route_info){
                var shippingInfo = data.data.fetch_log.format_route_info;
                $.each(shippingInfo, function(i, item) {
                shippingList = '<li>'+item.time+'<br/>['+item.address+'] '+item.remark+'</li>';
                $('#shippingUl').append(shippingList);
                }); 
            }
        }
        //拼小店信息
        if (data.data.pinxiaodian_log) {
            var pinxiaodianInfo = data.data.pinxiaodian_log;
            $.each(pinxiaodianInfo, function(i, item) {
            pinxiaodianList = '<li>'+item.action_time+'<br/>['+item.action_type_id+'] '+item.action_type_name+'</li>';
            $('#pinxiaodianUl').prepend(pinxiaodianList);
            });
        }
        //操作信息
        $('#operateDtlBody').text('');
        var statusControl = "";
        $.each(data.data.order_action, function(i, item) {
          statusControl = '<tr><td width="25%">'+item.action_type_name+'</td><td width="25%">'+item.action_time+'</td><td width="25%">'+item.action_user +'</td><td>'+item.action_note +'</td></tr>';
           $('#operateDtlBody').append(statusControl);
        });
          
      })
      .fail(function() {
        console.log("error");
      });
}
</script>
</body>
</html>  