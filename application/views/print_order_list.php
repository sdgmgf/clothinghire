<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>新的打单工具</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    
    <style type="text/css">
        tr td.product_cell{
            text-align: center;
            vertical-align:middle;
            height: 100%;
        }
       .order{
            border: 1px solid gray;
            margin-top:2px;
            margin-bottom: 2px;
       }

       .order_head{
            background-color: #cccccc;
       }


      .currentPage{
       font-weight: bold;
       font-size: 120%; 
       }
    </style>
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>  
    <div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
        <div role="tabpanel" class="row tab-product-list tabpanel" >
            <div style="margin: 0 auto;width: 1000px;">
                <label>当前所在仓库：</label>
                <b><?php if(isset($facility_name))echo $facility_name;?></b>
            </div>
            <div class="col-md-12">
                <!-- Nav tabs -->
                <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >

               <?php if (isset($message)) echo "<h3>{$message}</h3>";?>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="onsale">
                        <form id="queryForm" style="width:100%;" method="post" 
                                action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>printOrderList/query">

                         <div style="width:30%;float: left;padding: 0px;">
                                <input type="hidden" name="facility_id" id="facility_id" value="<?php if(isset($facility_id)) echo $facility_id;?>"/>
                                <input type="hidden" name="facility_name" id="facility_name" value="<?php if(isset($facility_name)) echo $facility_name;?>"/>
                                <div style="width: 100%;">
                                    <label for="receive_name"  style="width: 40%;">快递方式：</label>
                                     <select style="width: 35%;"  name="shipping_id" id="shippingSel">
                                                <?php 
                                                    if(!empty($shipping_list['shipping'])) {
                                                        foreach ($shipping_list['shipping'] as $shipping) {
                                                            if($shipping_id == $shipping['shipping_id']) {
                                                                echo "<option value=\"{$shipping['shipping_id']}\" " . (" title=\"{$shipping['shipping_name']}\""). "  selected='true'>{$shipping['shipping_name']}</option>";
                                                            } else{
                                                                echo "<option value=\"{$shipping['shipping_id']}\" " . (" title=\"{$shipping['shipping_name']}\""). ">{$shipping['shipping_name']}</option>";
                                                            }
                                                            
                                                        }
                                                    }
                                                 ?>
                                    </select>
                               </div>
                               <div style="width: 100%;">
                                   <label for="product_name" style="width: 40%;" >商品：</label>
                                   <select  style="width: 50%;"  name="product_id" id="productSel">
                                        <?php
                                            if ($product_list && isset($product_list['result']) && $product_list['result'] == 'ok' && $product_list['product']) {
                                                foreach($product_list['product'] as $product) {
                                                    echo "<option value=\"{$product['product_id']}\" " . (isset($product_id) && $product_id == $product['product_id'] ? " selected='true'" : ""). ">{$product['product_name']}</option>";
                                                }
                                            }
                                         ?>
                                       
                                    </select>
                               </div>
                               
                               <div style="width: 100%;">
                                    <label for="receive_name"  style="width: 40%;">省：</label>
                                    <select  style="width: 35%;"  name="province_id" id="provinceSel">
                                        <option value="all" >全部</option>
                                        <?php
                                            if (isset($province_list)) {
                                                foreach($province_list as $region) {
                                                    echo "<option value=\"{$region['region_id']}\" " . (isset($province_id) && $province_id == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                                }
                                            }
                                         ?>
                                       
                                    </select>
                               </div>
                               <div style="width: 100%;">
                                    <label for="receive_name"  style="width: 40%;">区：</label>
                                    <select style="width: 35%;"  name="district_id" id="districtSel">
                                        <option value="">全部</option>
                                    </select>
                               </div>
                               <div style="width: 100%;">
                                    <label for="out_order_sn" >订单号：</label>
                                    <input type="text" id="out_order_sn" name="out_order_sn">
                                 </div>   
                         </div>
                         <div style="width: 65%;float: left;"> <!--  right div start  -->
                            

                            <div style="width: 100%;float: left"> 
                            <div style="width: 100%;float: left;">  <!-- float left start  -->
                                <div style="width: 100%;">
                                    <label for="receive_name">公司或家庭：</label>
                                    <select  style="width: 35%;" name="address_name" id="address_name">
                                        <option value="">全部</option>
                                        <option value='WORK' <?php if(isset($address_name) && $address_name == 'WORK') echo "selected=\"selected\"";?>>公司</option>
                                        <option value='HOME' <?php if(isset($address_name) && $address_name == 'HOME') echo "selected=\"selected\"";?>>家庭</option>
                                    </select>
                                </div>
                                <div style="width: 100%;">
                                    <label for="receive_name">同城或外围：</label>
                                    <select  style="width: 35%;" name="address_type" id="address_type">
                                        <option value="">全部</option>
                                        <option value='INNER' <?php if(isset($address_type) && $address_type == 'INNER') echo "selected=\"selected\"";?>>同城</option>
                                        <option value='OUTER' <?php if(isset($address_type) && $address_type == 'OUTER') echo "selected=\"selected\"";?>>外围</option>
                                    </select>
                                </div>
                                 <div style="width: 100%;">
                                    <label for="receive_name" >打单数量：</label>
                                    <input type="text" style="width: 50%;" name="order_count" 
                                            <?php if(isset($order_count)){ echo "value='{$order_count}'"; } else {echo "value='100'";} ?>  >
                                 </div>

                                 <div style="width: 100%;">
                                    <label for="receive_name" >市：</label>
                                    <select  style="width: 35%;" name="city_id" id="citySel">
                                        <option value="all" >全部</option>
                                        <?php
                                            if (isset($city_list)) {
                                                foreach($city_list as $region) {
                                                    echo "<option value=\"{$region['region_id']}\" " . (isset($city_id) && $city_id == $region['region_id'] ? " selected='true'" : ""). ">{$region['region_name']}</option>";
                                                }
                                            }
                                         ?>
                                    </select>
                                 </div>
                                 <div id="station_control" style="width: 100%;display: <?php if($shipping_id == "88" || $shipping_id == "87" || $shipping_id = "119"){ echo "block";}else {echo "none";}?>;">
                                    <label for="receive_name" >站点：</label>
                                    <select style="width: 35%;" name="station_no" id="stationSel">
                                        <option value="">全部</option>
                                        <?php 
                                            if(isset($station_list)){
                                                foreach ($station_list as $station){
                                                    if(is_array($station)){
                                                        if($station['station_code'] == $station_no){
                                                            echo "<option value='".$station['station_code']."' selected='true'>".$station['station_name']."</option>";
                                                        }else{
                                                            echo "<option value='".$station['station_code']."'>".$station['station_name']."</option>";
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </select>
                                 </div>
                            </div>     <!--  float left end  -->
                            </div>  <!--  float right end  -->
                         </div>                                 <!-- right div end  -->
                         <div style="width: 100%;float:left;">
                                <div style="width:66%;float:left;text-align: center;">
                                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button> 
                                    <span>&nbsp;</span>
                                    <button type="button" class="btn btn-primary btn-sm"  id="batch_print" <?php if( !isset($order_list) || ! is_array($order_list) || empty($order_list)) echo "style=\"display:none\""?>>生成批拣单</button>
                                </div>
                                <!-- 隐藏的 input  end  -->
                         </div>

                        </form>
        
                        <form id="createBatchForm" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>printOrderList/createBatchPick" method="post">

                        <div class="row  col-sm-10 " style="margin-top: 10px;">
                            <table class="table table-striped table-bordered ">
                                <thead>
                                    <tr>
                                        <th>序号</th>
                                        <th> 快递 </th>
                                        <th> 仓库 </th>
                                        <th> 发货单 </th>
                                        <th> PRODUCT_ID </th>
                                        <th> 商品 </th>
                                        <th> 订单号 </th>
                                        <th>成团时间</th>
                                        <th> 客户名 </th>
                                    </tr>
                                </thead>
                                
                                <?php $i = 0;?>
                                <?php if( isset($order_list) && is_array($order_list))  foreach ($order_list as $key => $order) { ?> 
                                <tbody >
                                    <tr>
                                        <td class="product_cell">
                                            <?php echo ++$i;?>
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $order['shipping_name'] ?>
                                        </td>
                                        <td class="product_cell">
                                            <p> <?php echo $order['facility_name'] ?>  </p>
                                        </td>
                                        <td class="product_cell">
                                            <input type="hidden" name="shipmentIds[]" value="<?php echo $order['shipment_id'] ?>"/><?php echo $order['shipment_id'] ?>
                                        </td>
                                        <td class="product_cell">
                                            <p> <?php echo $order['product_id'] ?>  </p>
                                        </td>
                                        <td class="product_cell">
                                            <p> <?php echo $order['product_name'] ?>  </p>
                                        </td>
                                        
                                        <td class="product_cell">
                                            <?php echo $order['order_sn'] ?>  
                                        </td>
                                        <td class="product_cell">
                                            <?php echo $order['confirm_time'] ?> 
                                        </td>
                                        <td class="product_cell">
                                             <?php echo $order['receive_name'] ?>
                                        </td>
                                    </tr>
                                  
                                </tbody>
                                <?php } ?>

                            </table>
                        </div>
                        <input type="hidden" name="select_product_id" value="<?php if (isset($product_id)) echo $product_id;?>">
                        <input type="hidden" name="select_shipping_id" value="<?php if (isset($shipping_id)) echo $shipping_id;?>">
                        <input type="hidden" name="select_facility_id" value="<?php if (isset($facility_id)) echo $facility_id;?>" >
                        <input type="hidden" name="select_address_name" value="<?php if (isset($address_name)) echo $address_name;?>" >
                        <input type="hidden" name="select_address_type" value="<?php if (isset($address_type)) echo $address_type;?>" >
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="undercarriage">
                         
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script language="JavaScript">
     
var property={
    divId:"demo1",
    needTime:true,
    yearRange:[1970,2030],
    week:['日','一','二','三','四','五','六'],
    month:['一月','二月','三月','四月','五月','六月','七月','八月','九月','十月','十一月','十二月'],
    format:"yyyy-MM-dd hh:mm:00"
};

(function(config){
    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
    config['lock'] = true;
    config['fixed'] = true;
    config['okVal'] = 'Ok';
    config['format'] = 'yyyy-MM-dd HH:mm:ss';
    // [more..]
})($.calendar.setting);


$(document).ready(function(){
    $("#start_time").calendar({btnBar:true,
                               minDate:'2010-05-01', 
                               maxDate:'2022-05-01'});
    $("#end_time").calendar({  btnBar:true,
                               minDate:'#start_time',
                               maxDate:'2022-05-01'});
}) ;  // end document ready function 





$(document).ready(function(){
    var province_id = <?php echo isset($province_id) ? $province_id : 0;?>;
    if (province_id != 0) {
        var city_id = <?php echo isset($city_id) ? $city_id : 0;?>;
        changeCity(province_id, city_id);
    }
    
    $('#provinceSel').change(function () {
         province_id = $("#provinceSel").val();
         changeRegion(province_id, $('#citySel'),0);
    });   
    
    $('#citySel').change(function () {
        var city_id = $("#citySel").val();
        changeRegion(city_id, $("#districtSel"), 3);
    });

    $('#shippingSel').change(function () {
         shipping_id = $("#shippingSel").val();
         facility_id = $("#facility_id").val();
         if(shipping_id == "88"){
            $("#station_control").css("display","block");
          }else {
            $("#station_control").css("display","none");
          }
         changeShippingProduct(facility_id, shipping_id);
    });

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
                    changeRegion(city_id, $("#districtSel"));
                }
            } else {
                $(sel).empty();
                if (region_type == 2) {
                    $("#districtSel").empty();
                }
            }
          });
}

function changeShippingProduct(facility_id,shipping_id) {
    var myurl = $("#WEB_ROOT").val()+"printOrderList/shippingProduct?shipping_id="+shipping_id+"&facility_id="+facility_id;
     $.ajax({
                url: myurl,
                type: 'get',
                dataType: "json", 
                xhrFields: {
                     withCredentials: true
                }
          }).done(function(data){
            if (data != null ) {
                $("#productSel").empty();
                for (var i =0; i < data.length; i++) {
                    var product = data[i];
                    var option = $("<option>").val(product.product_id).text(product.product_name);
                    $("#productSel").append(option);
                }
            } else {
                $("#productSel").empty();
            }
          });
}
    
    $(".date-quick-pick").click(function() {
        var days = $(this).attr("data-days");
        var start_time = new Date();
        var end_time = new Date();
        start_time.setDate(start_time.getDate() - days);
        $("#start_time").val(ChangeDateToString(start_time) + " 00:00:00");
        $("#end_time").val(ChangeDateToString(end_time) + " 00:00:00");
    });
    
    // 将日期类型转换成字符串型格式yyyy-MM-dd 
    function ChangeDateToString(DateIn)
    {
        var Year=0;
        var Month=0;
        var Day=0;
    
        var CurrentDate="";
    
        //初始化时间
        Year      = DateIn.getFullYear();
        Month     = DateIn.getMonth()+1;
        Day       = DateIn.getDate();
    
        CurrentDate = Year + "-";
        if (Month >= 10 )
        {
            CurrentDate = CurrentDate + Month + "-";
        }
        else
        {
            CurrentDate = CurrentDate + "0" + Month + "-";
        }
        if (Day >= 10 )
        {
            CurrentDate = CurrentDate + Day ;
        }
        else
        {
            CurrentDate = CurrentDate + "0" + Day ;
        }
        return CurrentDate;
    }
    //
  // 是查询 还是 下载 excel 
      // 
     $("#query").click(function(){
         $("#queryForm").submit();
     }); 
    
     // 点击下载 excel 按钮 
     $('#batch_print').click(function(){
        $("#createBatchForm").submit();
     }); 
</script>
</body>
</html>
