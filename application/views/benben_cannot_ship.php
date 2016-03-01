<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>乐微SHOP</title>
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/normalize.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/global.css">
    <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="<?php if(isset($WEB_ROOT))  echo $WEB_ROOT ; ?>assets/css/buttons.dataTables.css">
    <style type="text/css">
        .form-control{
            margin:10px;
        }
        .hidden-table{
            display: none;
        }
        #addTable_wrapper,#addTable{
             max-width: 800px!important;
             padding: 10px;
             margin: 0 auto;
         }
        #addTable_length{
            margin-bottom:10px;
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
    </style>
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container-fluid" style="margin-left: -18px;padding-left: 19px;" >
    <div class="col-md-12">
        <!-- Nav tabs -->
        <input type="hidden" id="WEB_ROOT"  <?php if(isset($WEB_ROOT)) echo "value={$WEB_ROOT}"; ?> >
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- list start -->
            <div class="row col-sm-12">
                <table class="table table-striped table-bordered" id="addTable">
                    <thead>
                        <tr>
                            <th>省</th>
                            <th>市</th>
                            <th>区</th>
                            <th>快递地址</th>
                            <th>不考虑wms地址</th>
                            <th>tms站点匹配结果</th>
                            <th>wms站点匹配结果</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!--  list end -->
        </div>
    </div>
</div>
<script src="http://cdn.bootcss.com/jquery/2.1.3/jquery.min.js"></script>
<script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/dataTables.buttons.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.colVis.js"></script>
<script type="text/javascript" src="<?php if(isset($WEB_ROOT)) echo $WEB_ROOT;?>assets/js/buttons.flash.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        LoadData();
    })
    //输入拣选条件反馈结果
    function LoadData() {
        var tableData = $('#WEB_ROOT').val() + 'PinXiaoZhanOpenOrder/showBenbenCannotship';
        var table = $('#addTable').DataTable( {
            "searching" : false,
            "bSort": false,
            "ordering": false,
            "DeferRender": true,
            "StateSave": true,
            "sAjaxSource": tableData, //动态请求脚本
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
                { "data": "province_name"},
                { "data": "city_name" },
                { "data": "district_name" },
                { "data": "shipping_address" },
                { "data": "ignore_wms_address" },
                { "data": "tms_result" },
                { "data": "wms_result" },
            ],
            "columnDefs": [
            // 增加一列，包括删除和修改，同时将我们需要传递的数据传递到链接中
            {
                "targets": [4], // 目标列位置，下标从0开始
                "data": "ignore_wms_address", // 数据列名
                "render": function(ignore_wms_address) { // 返回自定义内容
                    var str;
                    switch(ignore_wms_address){
                        case "0": str = "考虑";
                            break;
                        case "1": str = "不考虑";
                            break;
                        default: str = "未知状态"
                    }
                    return str;
                }
            }
        ]
        } );
    };
</script>
</body>
</html>