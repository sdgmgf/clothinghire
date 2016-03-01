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
            margin: 30px auto;
        }
        #tableDelete{
            width:1000px;
        }
        .table-responsive{
            margin-top: 30px;
        }
        #districtSel,#keyword{
            width:240px;
            margin-right:30px;
        }
        .table,tr,td,th{
            border:1px solid #e2e2e2;
        }
        #info{
            padding:20px 0;
        }
        .input-append{
            margin-bottom:20px;
        }
        .input-append label{
            margin:0 10px 0 -50px;
        }
        .hidden{
            visibility:hidden;
        }
    </style>
</head>
<body>
<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
<div class="main">
    <div id="info"></div>
    <form role="form" class="form-inline">
        <div class="form-group">
            <select class="form-control" id="districtSel">
                <option value="">请选择区域</option>
            </select>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="请输入关键词" id="keyword">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-info" id="add">添加</button>
        </div>
    </form>
    <div class="table-responsive">
        <table class="table" id="tableAdd">
            <thead>
                <tr>
                    <th>区域</th>
                    <th>区域ID</th>
                    <th>关键词</th>
                </tr>
            </thead>
            <tbody id="addTableData">

            </tbody>
        </table>
        <div class="form-group pull-right"><button type="button" class="btn btn-info" id="upload" disabled="disabled">提交</button></div>
    </div>
    <div class="table-responsive">
        <form class="form-search form-inline">
            <div class="input-append pull-right">
                <label for="match">搜索</label>
                <input type="text" class="search-query form-control" placeholder="请输入您要搜索的关键词" id="match">
            </div>
        </form>
        <table class="table" id="tableDelete">
            <thead>
                <tr>
                    <th>关键词</th>
                    <th>区域</th>
                    <th>添加时间</th>
                    <th>添加人</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="deleteTableData">

            </tbody>
        </table>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/common.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        Info();
        availableDistrict();
        getKeyword();
    });
    //获取station_id
    var station_id = GetRequests().station_id;
    //保存区域和关键词
    var keyColl = {};
    var aDistKeyword = [];
    var isFirst = true;
    //点击添加关键词
    $('#add').click(function(){
        var districtName = $("#districtSel").find("option:selected").text();
        var districtId = $('#districtSel').val();
        var keyword = $.trim($('#keyword').val());
        var checkVal = districtName + keyword;
        if(districtId ==""){
            alert("请先选择区域")
        }else if(keyword == ""){
            alert("请输入关键词")
        }else if(keyColl[checkVal] == checkVal){
            alert("该区域关键词已存在");
        }else{
            addKeyword(districtName,keyword,districtId);
            keyColl[checkVal] = checkVal;
        }
    });
    //获取简略信息
    function Info(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getStationInfo';
        var params = {
            "station_id": station_id
        }
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var infoStr = "";
                var station_info = data.station_info;
                $('#info').html('<b>机构码:</b> '+station_info.station_code+' <b>站点名称: </b> '+station_info.station_name+' <b>地址: </b>'+station_info.province_name
                    +station_info.city_name+station_info.district_name+station_info.station_name);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //获取区域列表
    function availableDistrict(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getAvailableDistricts';
        var params = {
            "station_id": station_id
        };
        $.ajax({
                url: url,
                type: "get",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                var districtStr = "";
                $('#districtSel').html('<option value="">请选择区域</option>');
                $.each(data.district_list,function(i,item){
                    districtStr += '<option value='+ item.district_id +'>'+ item.district_name +'</option>'
                })
                $('#districtSel').append(districtStr);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //添加关键词
    function addKeyword(districtName,keyword,districtId){
            var str = "<tr><td>"+districtName+"</td><td>"+districtId+"</td><td>"+keyword+"</td></tr>";
            $('#addTableData').append(str);
            var oDistKeyword = {};
            oDistKeyword.district_id = districtId;
            oDistKeyword.keyword = keyword;
            aDistKeyword.push(oDistKeyword);
            $('#upload').removeAttr('disabled')
            if(isFirst){
                $('#upload').on("click",function(){
                    submitKeyword(aDistKeyword);
                });
                isFirst = false;
            }

    }
    //提交所添加的添加关键词
    function submitKeyword(aDistKeyword){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/addStationKeyword';
        var params = {
            "station_id": station_id,
            "station_keywords": aDistKeyword
        };
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                if(data.result == "ok"){
                    getKeyword();
                    $('#addTableData').html("");
                    $('#deleteTableData').html('');
                    $('#upload').attr('disabled','disabled');
                    keyColl = {};
                    aDistKeyword = [];
                }else{
                    alert(data.error_info);
                }

            })
            .fail(function() {
                console.log("error");
            });
    }
    //后台获取已有关键词
    function getKeyword(){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/getStationKeyword';
        var params = {
            "station_id": station_id
        }
        $.ajax({
                url: url,
                type: "post",
                dataType: "json",
                data: params
            })
            .done(function(data) {
                $('#deleteTableData').html('');
                var str = '';
                $.each(data.station_keyword_list, function(i,item){
                    str += '<tr class="backendInfo"><td>'+ item.keyword +'</td><td>'+ item.district_name +'</td><td>'+ item.created_time +'</td>'
                        + '<td>'+ item.created_user +'</td><td><button type="button" class="btn btn-link" onclick="deleteKeyword(\''+item.station_keyword_id+'\')">删除</button></td></tr>'
                })
                $('#deleteTableData').append(str);
            })
            .fail(function() {
                console.log("error");
            });
    }
    //搜索关键词
    $(function(){
        //键盘按键弹起时执行
        $('#match').keyup(function(){
            var index = $.trim($('#match').val().toString());//去掉两头空格
            var parent = $('#deleteTableData');
            $('.backendInfo').addClass('hidden');
            //选择包含文本框值的所有项去掉hidden类样式，并把它（们）移到最前面
            $('.backendInfo:contains("' + index + '")').prependTo(parent).removeClass('hidden');
        });
    });
    //删除关键词
    function deleteKeyword(station_keyword_id){
        var url = $('#WEB_ROOT').val() + 'stationKeyword/deleteStationKeyword';
        var arr = [];
        arr.push(station_keyword_id);
        var params = {
            "station_id": station_id,
            "station_keyword_ids": arr
        };
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: params
        })
        .done(function(data) {
            $('#deleteTableData').html('');
            getKeyword();
        })
        .fail(function() {
            console.log("error");
        });
    }
</script>
</body>
</html>