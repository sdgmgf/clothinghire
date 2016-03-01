<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.0.0/css/fixedHeader.bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/autocomplete.css">
<style>

</style>
</head>
<body>
    <form action="#" class="form-inline">
        <label>
            仓库：
            <select class="form-control" name="facility_id" id="facility_id">
                <?php 
                if(isset($facility_list)){ 
                    foreach ($facility_list as $key => $val) { ?>
                        <option value="<?php echo $val['facility_id']; ?>" <?php if( isset($facility_id) && $facility_id===$val['facility_id'] ) echo 'selected="selected"'; ?>><?php echo $val['facility_name']; ?></option>
                <?php
                    }    
                 } ?>
            </select>
        </label>
        <label>
            开始时间：<input type="text" class="form-control" name="start_time" id="start_time" value="<?php if(isset($start_time)) echo $start_time; ?>">
        </label>
        <label>
            结束时间：<input type="text" class="form-control" name="end_time" id="end_time" value="<?php if(isset($end_time)) echo $end_time; ?>">
        </label>
        <input type="button" class="btn btn-primary btn-sm" id="query" value="搜索">
    </form>
    <table class="table table-bordered table-condensed">
        <thead>
            <tr>
                <th>pallet_id</th>
                <th>商品名称</th>
                <th>箱规</th>
                <th>数量</th>
                <th>创建人</th>
                <th>创建时间</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>111</td>
                <td>222</td>
                <td>333</td>
                <td>444</td>
                <td>555</td>
                <td>666</td>
            </tr>
        </tbody>
    </table>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="http://cdn.bootcss.com/jquery.form/3.51/jquery.form.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.0.0/js/dataTables.fixedHeader.min.js"></script>
<script>
var WEB_ROOT = "<?php if( isset($WEB_ROOT) ) echo $WEB_ROOT; ?>";
(function(config){
    config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
    config['lock'] = true;
    config['fixed'] = true;
    config['okVal'] = 'Ok';
    config['format'] = 'yyyy-MM-dd';
})($.calendar.setting);

$("#start_time").calendar({btnBar:true,
               minDate:'2010-05-01', 
               maxDate:'2022-05-01'});
$("#end_time").calendar({btnBar:true,
               minDate:'2010-05-01', 
               maxDate:'2022-05-01'});

$('#query').on('click',function(){
    var facility_id = $('#facility_id').val(),
        start_time = $('#start_time').val(),
        end_time = $('#end_time').val(),
        dataArr = [];

    facility_id && dataArr.push('facility_id='+facility_id);
    start_time && dataArr.push('start_time='+start_time);
    end_time && dataArr.push('end_time='+end_time);

    window.location.href = WEB_ROOT+'Pallet/palletList?'+dataArr.join('&');
});

</script>
</body>
</html>