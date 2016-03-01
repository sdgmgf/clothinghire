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
        .main{
            width: 1000px;
            margin: 0 auto;
        }
        .table-responsive{
            margin-top: 30px;
        }
        #citySel{
            width:240px;
            margin-right:30px;
        }
        .table,tr,td,th{
            border:1px solid #e2e2e2;
        }
        #dtlBtn{
            margin-right:10px;
        }
        #addBtn{
            margin-left:600px;
        }
        .mustTip{
            color: red;
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
<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
<div class="main">
    <form role="form" class="form-inline">
        <div class="form-group">
            <select class="form-control" id="citySel">
                <option value="">请选择城市</option>
            </select>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-success" id="addBtn">添加新站点</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="table">
            <thead>
                <tr>
                    <th>机构</th>
                    <th>站点名称</th>
                    <th>站点ID</th>
                    <th>包裹接收地址</th>
                    <th>配送员</th>
                    <th>联系电话</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="tableData">

            </tbody>
        </table>
    </div>
</div>
<!-- modal begin -->
<div class="modal fade" id="region_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" id="from_province_id" name="from_province_id"/>
            <input type="hidden" id="from_shipping_id" name="from_shipping_id"/>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">添加新站点</h4>
            </div>
            <div class="modal-body">
                <p>
                    <label for="shipping_id">快递: <span class="mustTip">*</span></label>
                    <select name="" class="modalCommon" id="shipping_id">
                        <option value="">请选择快递</option>
                    </select>
                </p>
                <p>
                    <label for="station_name">站点名称: <span class="mustTip">*</span></label>
                    <input id="station_name" class="modalCommon" type="text">
                </p>
                <p>
                    <label for="station_code">代码: <span class="mustTip">*</span></label>
                    <input id="station_code" class="modalCommon" type="text">
                </p>
                <p>
                    <label for="province_id">省份: <span class="mustTip">*</span></label>
                    <select name="" class="modalCommon" id="province_id">
                        <option value="">请选择省份</option>
                    </select>
                </p>
                <p>
                    <label for="city_id">城市: <span class="mustTip">*</span></label>
                    <select name="" class="modalCommon" id="city_id">
                        <option value="">请选择城市</option>
                    </select>
                </p>
                <p>
                    <label for="district_id">区域: <span class="mustTip">*</span></label>
                    <select name="" class="modalCommon" id="district_id">
                        <option value="">请选择区域</option>
                    </select>
                </p>
                <p>
                    <label for="shipping_address">详细地址: </label>
                    <input id="shipping_address" class="modalCommon" type="text">
                </p>
                <p>
                    <label for="courier_name">收件人姓名: </label>
                    <input class="modalCommon" id="courier_name" type="text">
                </p>
                <p>
                    <label for="courier_phone">收件人电话: </label>
                    <input class="modalCommon" id="courier_phone" type="text">
                </p>
                <p>
                    <label for="station_id">拼小站站点ID: </label>
                    <input class="modalCommon" id="station_id" type="text">
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
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        mainAvailableCity();
        availableStation();
    });
    //随着城市更改变化显示
    $('#citySel').change(function(){
        availableStation();
    })
    //弹出添加新站点页面
    $('#addBtn').click(function(){
        $("#region_modal").modal("show");
        $('#province_id').html('<option value="">请选择省份</option>');
        $("#district_id").html("<option value=''>请选择区域</option>");
        $('#citySel').html('<option value="">请选择城市</option>');
        availableShipping();
    })
    //快递选项 
    $("#shipping_id").change(function(){
         availableProvince();
         $('#citySel').html('<option value="">请选择城市</option>');
         $("#district_id").html("<option value=''>请选择区域</option>");
    });
    //城市选项
    $("#province_id").change(function(){
        availableCity();
        $("#district_id").html("<option value=''>请选择区域</option>");
    })
    //区域选项
    $("#city_id").change(function(){
        availableDistrict();
        $("#district_id").html("<option value=''>请选择区域</option>");
    })
    //保存新站点
    $('#add_save').click(function(){
        var shipping_id = $('#shipping_id').val();
        var station_name = $('#station_name').val();
        var station_code = $('#station_code').val();
        var province_id = $('#province_id').val();
        var city_id = $('#city_id').val();
        var district_id = $('#district_id').val();
        var shipping_address = $('#shipping_address').val();
        var courier_name = $('#courier_name').val();
        var courier_phone = $('#courier_phone').val();
        var station_id = $('#station_id').val();
        var url = $('#WEB_ROOT').val() + 'stationKeyword/addStation';
        var params = {
            "shipping_id": shipping_id,
            "station_name": station_name,
            "station_code": station_code,
            "province_id": province_id,
            "city_id": city_id,
            "district_id": district_id,
            "shipping_address": shipping_address,
            "courier_name": courier_name,
            "courier_phone": courier_phone,
            "mid":station_id
        };
        if(!shipping_id||!station_name||!station_code||!province_id||!city_id||!district_id){
            alert('带星号必填');
        }else{
            $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                $("#region_modal").modal("hide");
                availableStation();
                $('#shipping_id').val("");
                $('#station_name').val("");
                $('#station_code').val("");
                $('#province_id').val("");
                $('#city_id').val("");
                $('#district_id').val("");
                $('#shipping_address').val("");
                $('#courier_name').val("");
                $('#courier_phone').val("");
                $('#station_id').val("");
            })
            .fail(function() {
                console.log("error");
            });
        }
    })
    //主页面获取城市列表
    function mainAvailableCity(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getMainAvailableCitys';
        $.ajax({
                url: url,
                type: "post",
                dataType: "json"
            })
            .done(function(data) {
                var cityStr = "";
                $('#citySel').html('<option value="">请选择城市</option>');
                $.each(data.city_list,function(i,item){
                    cityStr += '<option value='+ item.city_id +'>'+ item.city_name +'</option>'
                })
                $('#citySel').append(cityStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //获取快递列表
    function availableShipping(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getAvailableShipping';
        params = {
            "is_self" : 1
        }
        $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var shippingStr = "";
                $('#shipping_id').html('<option value="">请选择快递</option>');
                $.each(data.shipping_list,function(i,item){
                    shippingStr += '<option value='+ item.shipping_id +'>'+ item.shipping_name +'</option>'
                })
                $('#shipping_id').append(shippingStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //添加页面获取省份列表
    function availableProvince(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getCoverageRegion';
        var shipping_id = $('#shipping_id').val();
        var params = {
            "parent_id": 1,
            "region_type": 1,
            "shipping_id": shipping_id,
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var provinceStr = "";
                $('#province_id').html('<option value="">请选择省份</option>');
                $.each(data.regions,function(i,item){
                    provinceStr += '<option value='+ item.region_id +'>'+ item.region_name +'</option>'
                })
                $('#province_id').append(provinceStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //添加页面获取城市列表
    function availableCity(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getCoverageRegion';
        var province_id = $('#province_id').val();
        var shipping_id = $('#shipping_id').val();
        var params = {
            "parent_id": province_id,
            "region_type": 2,
            "shipping_id": shipping_id
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var cityStr = "";
                $('#city_id').html('<option value="">请选择城市</option>');
                $.each(data.regions,function(i,item){
                    cityStr += '<option value='+ item.region_id +'>'+ item.region_name +'</option>'
                })
                $('#city_id').append(cityStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //添加页面获取区域列表
    function availableDistrict(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getCoverageRegion';
        var city_id = $('#city_id').val();
        var shipping_id = $("#shipping_id").val();
        var params = {
            "parent_id": city_id,
            "region_type": 3,
            "shipping_id": shipping_id
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var districtStr = "";
                $('#district_id').html('<option value="">请选择区域</option>');
                $.each(data.regions,function(i,item){
                    districtStr += '<option value='+ item.region_id +'>'+ item.region_name +'</option>'
                })
                $('#district_id').append(districtStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //获取站点数据并以表格形式展现
    function availableStation(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getStationList';
        var city_id = $('#citySel').val();
        var params = {
            "city_id": city_id
        };
        $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var stationStr = "";
                $('#tableData').html('');
                $.each(data.station_list,function(i,item){
                    stationStr += '<tr><td>'+ item.station_code +'</td><td>'+ item.station_name +'</td><td>'+item.pin_xiao_dian_mid+'</td>'
                                + '<td>'+ item.province_name +' '+ item.city_name +' '+ item.district_name +' '+ item.station_name +'</td>'
                                + '<td>'+ item.courier_name +'</td><td>'+ item.courier_mobile +'</td><td class="text-center"><a href="stationInfo?station_id='+ item.station_id +'"><button type="button" class="btn btn-primary" id="dtlBtn">详情</button></a>'
                    if(item.status == 'USED'){
                        stationStr += '<a onclick="closeStation(\''+item.station_id+'\')"><button type="button" class="btn btn-danger" id="deleteBtn">关闭</button></a></td></tr>'
                    } else {
                        stationStr += '<a onclick="enableStation(\''+item.station_id+'\')"><button type="button" class="btn btn-success" id="enableBtn">启用</button></a></td></tr>'
                    }
                })
                $('#tableData').append(stationStr);
            })
            .fail(function(data) {
                if(data.error_info){
                        alert(data.error_info);
                    } else{
                        alert("出错");
                }
            });
    }
    //关闭站点
    function closeStation(station_id){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/closeStation';
        var station_id = station_id;
        var params = {
            "station_id": station_id
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                if(data.result && data.result == 'ok'){
                    alert('关闭成功');
                    availableStation();
                } else {
                    if(data.error_info){
                        alert(data.error_info);
                    } else{
                        alert("出错");
                    }
                }
            })
            .fail(function(data) {
                if(data.error_info){
                        alert(data.error_info);
                    } else{
                        alert("出错");
                }
            });
    }
    //启用站点
    function enableStation(station_id){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/enableStation';
        var station_id = station_id;
        var params = {
            "station_id": station_id
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                if(data.result && data.result == 'ok'){
                    alert('启用成功');
                    availableStation();
                } else {
                    if(data.error_info){
                        alert(data.error_info);
                    } else{
                        alert("出错");
                    }
                }
            })
            .fail(function(data) {
                if(data.error_info){
                    alert(data.error_info);
                } else{
                    alert("出错");
                }
        });
    }
</script>
</body>
</html>