<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>拼好货WMS</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/order.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/lhgcalendar.css"/>
    <style>
        .row.check_select{
            padding-left: 40px;
            -webkit-user-select:none;
            -moz-user-select:none;
            -ms-user-select:none;
            user-select:none;
        }
        .row.check_select label{
            line-height: 20px;
            text-align: left;
            width: 24%;
        }
    </style>
</head>
<body>
<input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
<br>
<div class="container">
    <div style="width:800px;margin:0 auto;">
        <form style="width:100%;" method="get" action="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>OrderCount/confirmDeliver">
            <div class="row">
                <label for="confirm_start_time" class="col-sm-2 control-label">成团开始时间</label>
                <div class="col-sm-3">
                    <input required="required" autocomplete='off' type="text" class="form-control" name="confirm_start_time" id="confirm_start_time" value="<?php if(isset($confirm_start_time)) echo "{$confirm_start_time}"; ?>">
                </div>
                <label for="confirm_end_time" class="col-sm-2 control-label">成团结束时间</label>
                <div class="col-sm-3">
                    <input required="required" autocomplete='off' type="text" class="form-control" name="confirm_end_time" id="confirm_end_time" value="<?php if(isset($confirm_end_time)) echo "{$confirm_end_time}"; ?>">
                </div>
            </div>
            <br>
            <div class="row check_select">
                <label>
                    <input type="checkbox" id="area_name" name="area_name" value="1"
                        <?php if (isset($area_name)) {
                            echo "checked";
                        } ?>> 大区
                </label>
                <label>
                    <input type="checkbox" id="facility_name"  name="facility_name" value="1"
                        <?php if (isset($facility_name)) {
                            echo "checked";
                        } ?>> 仓库
                </label>
                <label>
                    <input type="checkbox" id="date_of_confirm"  name="date_of_confirm" value="1"
                        <?php if (isset($date_of_confirm)) {
                            echo "checked";
                        } ?>> 成团日期
                </label>
                <label>
                    <input type="checkbox" id="hour_of_confirm"  name="hour_of_confirm" value="1"
                        <?php if (isset($hour_of_confirm)) {
                            echo "checked";
                        } ?>> 成团时间
                </label>
                <label>
                    <input type="checkbox" id="province_name"  name="province_name" value="1"
                        <?php if (isset($province_name)) {
                            echo "checked";
                        } ?>> 省
                </label>
                <label>
                    <input type="checkbox" id="city_name"  name="city_name" value="1"
                        <?php if (isset($city_name)) {
                            echo "checked";
                        } ?>> 市
                </label>
                <label>
                    <input type="checkbox" id="district_name"  name="district_name" value="1"
                        <?php if (isset($district_name)) {
                            echo "checked";
                        } ?>> 区
                </label>
                <label>
                    <input type="checkbox" id="address_name"  name="address_name" value="1"
                        <?php if (isset($address_name)) {
                            echo "checked";
                        } ?>> 公司/家庭
                </label>
                <label>
                    <input type="checkbox" id="product_name"  name="product_name" value="1"
                        <?php if (isset($product_name)) {
                            echo "checked";
                        } ?>> product_name
                </label>
                <label>
                    <input type="checkbox" id="shipping_name"  name="shipping_name" value="1"
                        <?php if (isset($shipping_name)) {
                            echo "checked";
                        } ?>> 快递
                </label>
                <div class="col-sm-3" style="float:right;">
                    <input type="hidden" name="act" id="act" value="query">
                    <button type="button" class="btn btn-primary btn-sm"  id="query"  >搜索 </button>
                    <span>&nbsp;</span>
                    <button type="button" class="btn btn-primary btn-sm"  id="download" >导出</button>
                </div>
                <!-- 隐藏的 input  start  -->
                <input type="hidden"  id="page_current" name="page_current" <?php if(isset($page_current)) echo "value={$page_current}"; ?> />
                <input type="hidden"  id="page_count" name="page_count" <?php if(isset($page_count)) echo "value={$page_count}"; ?> />
                <input type="hidden"  id="page_limit" name="page_limit" <?php if(isset($page_limit)) echo "value={$page_limit}"; ?> />
                <!-- 隐藏的 input  end  -->
            </div>
        </form>
    </div>
</div>
<br>
<div class="container">
    <table class="table table-striped table-bordered" id="detail_table" style="width:100%;border: 3">
        <thead>
            <tr>
                <?php  $constant_array = array('area_name'=>'大区','facility_name'=>'仓库','date_of_confirm'=>'成团日期','hour_of_confirm'=>'成团时间','province_name'=>'省','city_name'=>'市','district_name'=>'区','address_name'=>'公司/家庭','product_name'=>'product_name','goods_id'=>'goods_id','product_id'=>'product_id','shipping_name'=>'快递','count_of_shipment'=>'订单数');  ?>
                <?php
                if (isset($confirmOrderCountList) && is_array($confirmOrderCountList) && !empty($confirmOrderCountList)) {
                    foreach ($confirmOrderCountList[0] as $key => $value) {
                        echo "<th>".$constant_array[$key]."</th>";
                    }
                }?>
            </tr>
        </thead>
        <?php if( isset($confirmOrderCountList) && is_array($confirmOrderCountList))  foreach ($confirmOrderCountList as $key => $confirmOrderCount) { ?>
            <tbody>
                <tr>
                    <?php
                    foreach($confirmOrderCount as $key=>$v){
                        if ($key=='hour_of_confirm') {
                            echo "<td>".$v." 点</td>";
                        }else{
                            echo "<td>".$v."</td>";
                        }
                    }
                    ?>
                </tr>
            </tbody>
        <?php } ?>
    </table>
</div>
<div class="row">
    <nav style="float: right;margin-top: -7px;">
        <ul class="pagination">
            <li>
                <a href="#"   id="page_prev">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <?php if(isset($page)) echo $page; ?>
            <li>
                <a href="#" id="page_next" >
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
            <li><a href='#'>
                    <?php if(isset($page_count)) echo "共{$page_count}页 &nbsp;";
                    if(isset($record_total))  echo  "共{$record_total}条记录";
                    ?>
                </a></li>
        </ul>
    </nav>
</div>
</body>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/lhgcalendar.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/autocomplete.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        (function(config){
            config['extendDrag'] = true; // 注意，此配置参数只能在这里使用全局配置，在调用窗口的传参数使用无效
            config['lock'] = true;
            config['fixed'] = true;
            config['okVal'] = 'Ok';
            config['format'] = 'yyyy-MM-dd HH:mm:ss';
        })($.calendar.setting);

        $("#confirm_start_time").calendar({btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01'});
        $("#confirm_end_time").calendar({btnBar:true,
            minDate:'2010-05-01',
            maxDate:'2022-05-01'});
    });

    $("#query").click(function(){
        $("#page_current").val("1");
        if(!$("#confirm_start_time").val()){
            alert('请选择成团开始时间');
        }else if(!$("#confirm_end_time").val()){
            alert('请选择成团结束时间');
        }else{
            var checkbox_num = $("input[type='checkbox']").filter(':checked');
            if(checkbox_num.length == 0){
                alert("至少选中一项");
                return false;
            };
            $("#act").val("query");
            $("form").submit();
        }
    });

    // 点击下载 excel 按钮
    $('#download').click(function(){
        $("#act").val("download");
        $("form").submit();
    });

    // 分页
    $('a.page').click(function(){
        var page =$(this).attr('p');
        $("#page_current").val(page);
        $("#act").val("query");
        $("form").submit();
    });

    // 上一页
    $('a#page_prev').click(function(){
        var page = $("#page_current").val();
        if(page != parseInt(page) ) {
            $('#page_current').val(1);
            page = 1;
        }else{
            page = parseInt(page);
            if(page > 1 ){
                page = page - 1;
                $('#page_current').val(page);
                $("#act").val("query");
                $("form").submit();
            }
        }
    });

    // 下一页
    $('a#page_next').click(function(){
        var page = $("#page_current").val();
        page = parseInt(page);
        var page_count = $("#page_count").val();
        page_count = parseInt(page_count);
        if(page < page_count ){
            page = page + 1;
            $("#page_current").val(page);
            $("#act").val("query");
            $("form").submit();
        }
    });

</script>
</html>