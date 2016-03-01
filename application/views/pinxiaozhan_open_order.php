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
            <input type="text" class="form-control" id="searchInput">
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-primary" id="searchBtn">搜索</button>
        </div>
    </form>
    <div>
        <table class="table table-responsive table-bordered" id="table">
            <thead>
                <tr>
                    <th>快递面单号</th>
                    <th>省</th>
                    <th>市</th>
                    <th>区</th>
                    <th>配送地址</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="tableData">

            </tbody>
        </table>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">

    //搜索获取列表数据
    $('#searchBtn').click(function(){
        var url = $('#WEB_ROOT').val() + 'PinXiaoZhanOpenOrder/getPinXiaoZhanDeatil';
        var params = {
            "tracking_number": $("#searchInput").val().trim()
        };
        $.ajax({
            url: url,
            type: 'get',
            dataType: 'json',
            data: params
        })
        .done(function(e) {
            if(e.error_info){
                alert(e.error_info)
            }else{
                $("#tableData").html("");
                var str = "";
                var Odata = e.data.data;
                str = "<tr><td>"+Odata.tracking_number+"</td><td>"+Odata.province_name+"</td><td>"+Odata.city_name+"</td>"
                    + "<td>"+Odata.district_name+"</td><td>"+Odata.shipping_address+"</td><td>";
                switch(Odata.STATUS){
                    case "0": str += "初始状态</td><td><button type='button' class='btn btn-primary' onclick='signatureConfirmation()'>揽收</button></td></tr>";
                    break;
                    case "1": str += "tms已揽收</td><td>无操作</td></tr>";
                    break;
                    case "2": str += "推送成功</td><td><button type='button' class='btn btn-primary' onclick='signatureConfirmation()'>揽收</button></td></tr>";
                    break;
                    case "3": str += "推送失败</td><td><button type='button' class='btn btn-primary' onclick='signatureConfirmation()'>揽收</button></td></tr>";
                    break;
                    default: str += "未知状态";
                }
                $("#tableData").append(str);
            }
        })
        .fail(function() {
            console.log("error");
        });
    })
    //揽收
    function signatureConfirmation(){
        var url = $('#WEB_ROOT').val() + 'PinXiaoZhanOpenOrder/signatureConfirmation';
        var params = {
            "tracking_number": $("#searchInput").val().trim()
        };
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: params
        })
        .done(function() {
            alert("恭喜您，修改成功");
            window.location.reload();
        })
        .fail(function() {
            console.log("error");
        });
    }

</script>
</body>
</html>